<?php require_once('../../../private/initialize.php');
require_recruiter_login();

if(isset($_POST['mode'])) {
$mode=$_POST['mode'];
$job_id=$_POST['id'] ?? '1';

    if ($mode=='true') //mode simple is true when button is Open
    {
        $str=$db->query("UPDATE jobs SET visible='true' WHERE id=$job_id");
        // $response_result='Hey my button is open!!';
        $success='[Active]';
        // echo json_encode(array('response_result'=>$response_result,'success'=>$success));
        echo json_encode(array('success'=>$success));
    }

    else if ($mode=='false')
    {
        $str=$db->query("UPDATE jobs SET visible='false' WHERE id=$job_id");
        // $response_result='Hey my button is closed!!';
        $success='[Marked for removal]';
        // echo json_encode(array('response_result'=>$response_result,'success'=>$success));
        echo json_encode(array('success'=>$success));

    }
}
 ?>
