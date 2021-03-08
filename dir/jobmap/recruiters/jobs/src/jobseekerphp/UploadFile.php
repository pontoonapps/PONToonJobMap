<?php
namespace jobseekerphp;

class uploadfile
{



  protected $destination;
  protected $messages = array();
  protected $maxSize = 2048;
  protected $permittedTypes = array (
          'video/mp4',
          'video/webm', // .webm
          //'application/x-mpegURL', // iPhone Index	.m3u8
          //'video/MP2T', // iPhone Segment	.ts
          'video/quicktime', // QuickTime	.mov
          'video/x-msvideo', // A/V Interleave	.avi
          'video/x-ms-wmv' // Windows Media	.wmv
          //'video/3gpp' // Older mobile format .3gp
          //'image/png' //
  );

  protected $newName;
  protected $typeCheckingOn = true;
  protected $notTrusted = array('bin', 'cgi', 'exe', 'js', 'pl', 'php', 'py', 'sh', 'sql', 'txt');
  protected $suffix = '.upload';
  protected $renameDuplicates;

  public function __construct($uploadFolder)
  {
    if (!is_dir($uploadFolder) || !is_writable($uploadFolder)) {
      throw new \Exception("$uploadFolder must be a valid, writable folder.");
    }
    if ($uploadFolder[strlen($uploadFolder)-1] != '/') {
      $uploadFolder .= '/';
    }
    $this->destination = $uploadFolder;
  }

  public function setMaxSize($bytes)
  {
    $serverMax = self::convertToBytes(ini_get('upload_max_filesize'));
    if ($bytes > $serverMax) {
      throw new \Exception('Maximum size cannot exceed server limit for individual files: ' . self::convertFromBytes($serverMax));
    }
    if (is_numeric($bytes) && $bytes > 0) {
        $this->maxSize = $bytes;
    }
  }

  public static function convertToBytes($val)
  {
      $val = trim($val);
      $last = strtolower($val[strlen($val)-1]);
      if (in_array($last, array('g', 'm', 'k'))){
          // Explicit cast to number
          $val = (float) $val;
          switch ($last) {
              case 'g':
                  $val *= 1024;
              case 'm':
                  $val *= 1024;
              case 'k':
                  $val *= 1024;
          }
      }
      return $val;
  }

  public static function convertFromBytes($bytes)
  {
      $bytes /= 1024;
      if ($bytes > 1024) {
          return number_format($bytes/1024, 1) . ' MB';
      } else {
          return number_format($bytes, 1) . ' KB';
      }
  }

  public function allowAllTypes($suffix = null)
  {
    $this->typeCheckingOn = false;
    if (!is_null($suffix)) {
      if (strpos($suffix, '.') === 0 || $suffix == '') {
          $this->suffix = $suffix;
      } else {
          $this->suffix = ".$suffix";
      }
    }
  }

  // public function upload($renameDuplicates = true) // multi file upload
  // {
  //   $this->renameDuplicates = $renameDuplicates;
  //   $uploaded = current($_FILES);
  //   if (is_array($uploaded['name'])) {
  //       foreach ($uploaded['name'] as $key => $value) {
  //           $currentFile['name'] = $uploaded['name'][$key];
  //           $currentFile['type'] = $uploaded['type'][$key];
  //           $currentFile['tmp_name'] = $uploaded['tmp_name'][$key];
  //           $currentFile['error'] = $uploaded['error'][$key];
  //           $currentFile['size'] = $uploaded['size'][$key];
  //           if ($this->checkFile($currentFile)) {
  //               $this->moveFile($currentFile);
  //           }
  //       }
  //   } else {
  //     if ($this->checkFile($uploaded)) {
  //         $this->moveFile($uploaded);
  //     }
  //   }
  // }





  public function upload($renameDuplicates = false) // single file upload
  {
    $this->renameDuplicates = $renameDuplicates;
    $uploaded = current($_FILES);
    if ($this->checkFile($uploaded)) {
        $this->moveFile($uploaded);
    }
  }


  public function getMessages()
  {
    return $this->messages;
  }

  protected function checkFile($file)
  {
    if ($file['error'] != 0) {
        $this->getErrorMessage($file);
        return false;
    }
    if (!$this->checkSize($file)) {
      return false;
    }
    if ($this->typeCheckingOn) {
        if (!$this->checkType($file)) {
            return false;
        }
    }
    $this->checkName($file);
    return true;
  }

  protected function getErrorMessage($file)
  {
    switch ($file['error']) {
      case 1:
      case 2:
          $this->messages[] = $file['name'] . ' is too big: (max:: ' . self::convertFromBytes($this->maxSize) . ').';
          break;
      case 3:
          $this->messages[] = $file['name'] . ' was only partially uploaded.';
          break;
      case 4:
          $this->messages[] = $file['name'] . 'Please select a video file.';
          break;
      default:
          $this->messages[] = 'Sorry, there was a problem uploading ' . $file['name'];
          break;


    }
  }

  protected function checkSize($file)
  {
    if ($file['size'] == 0 ) {
        $this->messages[] = $file['name'] . ' is empty.';
        return false;
    } elseif ($file['size'] > $this->maxSize) {
        $this->messages[] = $file['name'] . ' exceeds the maximum size for a file (' . self::convertFromBytes($this->maxSize) . ').';
        return false;
    } else {
      return true;
    }
  }

  protected function checkType($file)
  {
    if (in_array($file['type'], $this->permittedTypes)) {
      return true;
    } else {
      $this->messages[] = $file['name'] . ' is not a permitted type of file.';
      return false;
    }
  }

  protected function checkName($file) // FILES superGlobal array
  {

    $job_id = $_GET['job_id'];

    $this->newName = null;
    $nospaces = str_replace(' ', '_', $job_id.'_'.$file['name']);


    if ($nospaces != $file['name']) { //i.e. check filename has been changed if it has...
      $this->newName = $nospaces;
    }
    $nameparts = pathinfo($nospaces);
    $extension = isset($nameparts['extension']) ? $nameparts['extension'] : '';


    if(!$this->typeCheckingOn && !empty($this->suffix)) {
        if (in_array($extension, $this->notTrusted) || empty($extension)) {
            $this->newName = $nospaces . $this->suffix;
        }
    }
    if($this->renameDuplicates) {
        $name = isset($this->newName) ? $this->newName : $file['name'];
        $existing = scandir($this->destination);
        if (in_array($name, $existing)) {
            $i = 1;
            do {
                $this->newName = $nameparts['filename'] . '_' . $i++;
                if (!empty($extension)) {
                  $this->newName .= ".$extension";
                }
                if (in_array($existing, $this->notTrusted)) {
                  $this->newName .= $this->suffix;
                }
            } while (in_array($this->newName, $existing));
        }
    }
  }


  protected function moveFile($file)
  {

    $filename = isset($this->newName) ? $this->newName : $file['name'];
    $success = move_uploaded_file($file['tmp_name'], $this->destination . $filename);
    if ($success) {

        // INSERT into job_videos table START //
        if(is_logged_in()){
            $recid = $_SESSION['recruiter_id'];
        }
        else{
        $recid = $_SESSION['recruiter_id'];
        }
        $job_id = $_GET['job_id'];
        $vidDesc = $_REQUEST['video_desc'];

        global $db;
        $sql = "INSERT INTO job_videos ";
        $sql .= "(recruiter_id, job_id, video_desc, video_filename) ";
        $sql .= "VALUES (";
        $sql .= "'" . db_escape($db, $recid) . "',";
        $sql .= "'" . db_escape($db, $job_id) . "',";
        $sql .= "'" . db_escape($db, $vidDesc) . "',";
        $sql .= "'" . db_escape($db, $filename) . "') ";
        $sql .= "ON DUPLICATE KEY UPDATE ";
        $sql .= "video_filename = '" . db_escape($db, $filename) . "'";

        $result = mysqli_query($db, $sql);
        // For INSERT statements, $result is true/false
        if($result) {
          // return true;
          // $result = $file['name'] . ' was uploaded successfully';
          $new_id = mysqli_insert_id($db);
      		// add_answer($cid, $scid, $qid);
          $_SESSION['message'] = 'Your video file  ' . $file['name'] . ' has been added' ;
          // redirect_to(url_for('/jobmap/recruiters/jobs/show_job.php?job_id='.$job_id.''));

          if (!is_null($this->newName)) {
            // $result .= ', and was renamed ' . $this->newName;
            $_SESSION['message'] .= ', and video renamed   ' . $this->newName;
          }
          $result .= '.';
          if(is_logged_in()){
          redirect_to(url_for('/jobmap/staff/jobs/show_job.php?job_id='.$job_id.''));
          }else{
          redirect_to(url_for('/jobmap/recruiters/jobs/show_job.php?job_id='.$job_id.''));
          }
          $this->messages[] = $result;
        } else {
          $this->message[] = 'Could not upload ' . $file['name'];
        } // INSERT failed
          echo mysqli_error($db);
          db_disconnect($db);
        }
        // INSERT into job_videos DB END //

  }

} // Class Ends
