<?php

// /**
//  * Performs a search
//  *
//  * This class is used to perform search functions in a MySQL database
//  *
//  * @version 1.0
//  * @author John Morris <support@johnmorrisonline.com>
//  */
class search {
//   /**
//    * MySQLi connection
//    * @access private
//    * @var object
//    */
//   private $mysqli;
//
//   /**
//    * Constructor
//    *
//    * This sets up the class
//    */
//   public function __construct() {
//     // Connect to our database and store in $mysqli property
//     $this->connect();
//   }
//   /**
//    * Database connection
//    *
//    * This connects to our database
//    */
//   private function connect() {
//     $this->mysqli = new mysqli( 'localhost', 'root', 'root', 'snippets' );
//   }
//
//   /**
//    * Search routine
//    *
//    * Performs a search
//    *
//    * @param string $search_term The search term
//    *
//    * @return array/boolen $search_results Array of search results or false
//    */
  function search($search_term) {
    global $db;
    // Sanitize the search term to prevent injection attacks
    $sanitized = h($search_term);

    // Run the query
    $query = $sql ("
      SELECT *
      FROM companies
      WHERE company_name LIKE '%{$sanitized}%'
      OR location LIKE '%{$sanitized}%'
    ");

    // Check results
    if ( ! $query->num_rows ) {
      return false;
    }

    // Loop and fetch objects
    while( $row = $query->fetch_object() ) {
      $rows[] = $row;
    }

    // Build our return result
    $search_results = array(
      'count' => $query->num_rows,
      'results' => $rows,
    );

    return $search_results;
  }
}










// Remove unnecessary words from the search term and return them as an array
function filterSearchKeys($query){
    global $db;
    $query = trim(preg_replace("/(\s+)+/", " ", $query));
    $words = array();
    // expand this list with your words.
    $list = array("in","it","a","the","of","or","I","you","he","me","us","they","she","to","but","that","this","those","then");
    $c = 0;
    foreach(explode(" ", $query) as $key){
        if (in_array($key, $list)){
            continue;
        }
        $words[] = $key;
        if ($c >= 15){
            break;
        }
        $c++;
    }
    return $words;
}

// limit words number of characters
function limitChars($query, $limit = 200){
  global $db;
    return substr($query, 0,$limit);
}

function search($query){
  global $db;
    $query = trim($query);
    if (mb_strlen($query)===0){
        // no need for empty search right?
        return false;
    }
    $query = limitChars($query);

    // Weighing scores
    $scoreFullTitle = 6;
    $scoreTitleKeyword = 5;
    $scoreFullSummary = 5;
    $scoreSummaryKeyword = 4;
    $scoreFullDocument = 4;
    $scoreDocumentKeyword = 3;
    // $scoreCategoryKeyword = 2;
    // $scoreUrlKeyword = 1;

    $keywords = filterSearchKeys($query);
    $escQuery = h($query); // see note above to get db object
    $titleSQL = array();
    $sumSQL = array();
    $docSQL = array();
    // $categorySQL = array();
    // $urlSQL = array();

    /** Matching full occurences **/
    if (count($keywords) > 1){
        $titleSQL[] = "if (company_name LIKE '%".$escQuery."%',{$scoreFullTitle},0)";
        $sumSQL[] = "if (company_desc LIKE '%".$escQuery."%',{$scoreFullSummary},0)";
        $docSQL[] = "if (location LIKE '%".$escQuery."%',{$scoreFullDocument},0)";
    }

    /** Matching Keywords **/
    foreach($keywords as $key){
        $titleSQL[] = "if (company_name LIKE '%".h($key)."%',{$scoreTitleKeyword},0)";
        $sumSQL[] = "if (company_desc LIKE '%".h($key)."%',{$scoreSummaryKeyword},0)";
        $docSQL[] = "if (location LIKE '%".h($key)."%',{$scoreDocumentKeyword},0)";
        // $urlSQL[] = "if (p_url LIKE '%".h($key)."%',{$scoreUrlKeyword},0)";
        // $categorySQL[] = "if ((
        // SELECT count(category.tag_id)
        // FROM category
        // JOIN post_category ON post_category.tag_id = category.tag_id
        // WHERE post_category.post_id = p.post_id
        // AND category.name = '".h($key)."'
        //             ) > 0,{$scoreCategoryKeyword},0)";
    }

    // Just incase it's empty, add 0
    if (empty($titleSQL)){
        $titleSQL[] = 0;
    }
    if (empty($sumSQL)){
        $sumSQL[] = 0;
    }
    if (empty($docSQL)){
        $docSQL[] = 0;
    }
    // if (empty($urlSQL)){
    //     $urlSQL[] = 0;
    // }
    // if (empty($tagSQL)){
    //     $tagSQL[] = 0;
    // }

    $sql = "SELECT c.id,c.company_name,c.company_desc,c.location
            (
                (-- Title score
                ".implode(" + ", $titleSQL)."
                )+
                (-- Summary
                ".implode(" + ", $sumSQL)."
                )+
                (-- document
                ".implode(" + ", $docSQL)."
                )
                -- (-- tag/category
                -- ".implode(" + ", $categorySQL)."
                -- )+
                -- (-- url
                -- ".implode(" + ", $urlSQL)."
                )
            ) as relevance
            FROM companies c
            -- WHERE p.status = 'published'
            HAVING relevance > 0
            ORDER BY relevance DESC
            LIMIT 25";
    $results = mysqli_query($db, $sql);
    if (!$results){
        return false;
    }
    return $results;
}
?>