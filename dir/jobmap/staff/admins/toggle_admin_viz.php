<?php require_once('../../../private/initialize.php');
require_login();

if(isset($_POST['mode'])) {
$mode=$_POST['mode'];
$admin_id=$_POST['id'] ?? '1';

    if ($mode=='true') //mode simple is true when button is Open
    {
        $str=$db->query("UPDATE admins SET visible='true' WHERE id=$admin_id");
        // $response_result='Hey my button is open!!';
        $success='[Enabled]';
        // echo json_encode(array('response_result'=>$response_result,'success'=>$success));
        echo json_encode(array('success'=>$success));
    }

    else if ($mode=='false')
    {
        $str=$db->query("UPDATE admins SET visible='false' WHERE id=$admin_id");
        // $response_result='Hey my button is closed!!';
        $success='[Disabled]';
        // echo json_encode(array('response_result'=>$response_result,'success'=>$success));
        echo json_encode(array('success'=>$success));

    }
}
 ?>
