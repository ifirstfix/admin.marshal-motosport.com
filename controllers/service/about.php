<?php

use OMCore\OMDb;
use OMCore\OMImage;
// use OMCore\OMMail;
$DB = OMDb::singleton();
$log = new OMCore\OMLog;

$response = array();
$today = date("Y-m-d H:i:s");
$exp = strtotime('+30 days', strtotime($today));
$expires = date('Y-m-d H:i:s', $exp);

$cmd = isset($_POST['cmd']) ? $_POST['cmd'] : "";

if ($cmd != "") {
    if ($cmd == "update_about"){
        $youtube_url    = isset($_POST['youtube_url']) ? $_POST['youtube_url'] : "";
        $sql_param = array();
        $sql_param['ABOUT_ID']          = 1;
        $sql_param['YOUTUBE_AUTOPLAY']  = (isset($_POST['auto_play']) == 'on') ? '1' : '0';
        $sql_param['YOUTUBE_URL']       = $youtube_url;
        $res = $DB->executeUpdate('tb_about', 1, $sql_param);

        if ($res > 0) {
            $response['status'] = true;
            $response['msg'] = 'Update about successfully';
        }else{
            $response['status'] = false;
            $response['msg'] = 'Update about unsuccessfully';
        }

    }else if ($cmd == "get_about"){
        $sql = "SELECT * FROM tb_about";
        $sql_param = array();
        $ds = null;
        $res = $DB->query($ds, $sql, $sql_param, 0, 1, "ASSOC");
        $response['data'] = $ds[0];
        $response['status'] = true;

    } else {
        $response['status'] = false;
        $response['error_msg'] = 'no command';
        $response['code'] = '500';
    
    }

} else {
    // error
    $response['status'] = false;
    $response['msg'] = 'no command';
    $response['code'] = '500';
}

echo json_encode($response);

?>