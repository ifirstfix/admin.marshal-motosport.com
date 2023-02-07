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
    if ($cmd == "currency"){
        $thb_to_usd    = isset($_POST['thb']) ? $_POST['thb'] : "";
        if(is_numeric($thb_to_usd)){
            $sql_param = array();
            $sql_param['ID'] = 1;
            $sql_param['SETTING_THB_TO_USD'] = number_format($thb_to_usd, 2, '.', '');
            $res = $DB->executeUpdate('tb_setting', 1, $sql_param);
            if ($res > 0) {
                $response['data'] = number_format($thb_to_usd, 2, '.', '');
                $response['status'] = true;
                $response['msg'] = 'Update successfully';
            }else{
                $response['status'] = false;
                $response['msg'] = 'Update unsuccessfully';
            }
        }else{
            $response['status'] = false;
            $response['msg'] = 'Update unsuccessfully';
        }

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