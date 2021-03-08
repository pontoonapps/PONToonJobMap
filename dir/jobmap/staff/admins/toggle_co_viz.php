<?php require_once('../../../private/initialize.php');
require_login();

if(isset($_POST['mode'])) {
$mode=$_POST['mode'];
$co_id=$_POST['id'] ?? '1';

    if ($mode=='true') //mode simple is true when button is Open
    {
        $str=$db->query("UPDATE companies SET visible='true' WHERE id=$co_id");
        // $response_result='Hey my button is open!!';
        $success='[Enabled]';
        // echo json_encode(array('response_result'=>$response_result,'success'=>$success));
        echo json_encode(array('success'=>$success));
    }

    else if ($mode=='false')
    {
        $str=$db->query("UPDATE companies SET visible='false' WHERE id=$co_id");
        // $response_result='Hey my button is closed!!';
        $success='[Disabled]';
        // echo json_encode(array('response_result'=>$response_result,'success'=>$success));
        echo json_encode(array('success'=>$success));

    }
}
 ?>
