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
    if($cmd == "delivery"){
        $sql = "SELECT * , tb_delivery.CREATEDATETIME, tb_delivery.DELIVERY_TYPE_ID
                FROM tb_delivery
                INNER JOIN tb_delivery_type ON tb_delivery.DELIVERY_TYPE_ID = tb_delivery_type.DELIVERY_TYPE_ID";
        $sql_param = array();
        $ds = null;
        $res = $DB->query($ds, $sql, $sql_param, 0, -1, "ASSOC");
        $response['data'] = $ds;
        $response['status'] = true;

    }else if($cmd == "delivery_type"){
        $sql = "SELECT DELIVERY_TYPE_NAME_TH, DELIVERY_TYPE_NAME_EN, DELIVERY_TYPE_STATUS, DELIVERY_TYPE_ID FROM tb_delivery_type";
        $sql_param = array();
        $ds = null;
        $res = $DB->query($ds, $sql, $sql_param, 0, -1, "ASSOC");
        $response['data'] = $ds;
        $response['status'] = true;

    } else if ($cmd == "remove"){
        $id    = isset($_POST['id']) ? $_POST['id'] : "";

        $sql = "DELETE FROM tb_delivery WHERE DELIVERY_ID = @id";
        $sql_param = array();
        $sql_param['id'] = $id;
        $res = $DB->execute($sql, $sql_param);

        if ($res > 0) {
            $response['status'] = true;
            $response['msg'] = 'Remove successfully';
        }else{
            $response['status'] = false;
            $response['msg'] = 'Remove unsuccessfully';
        }

    } else if ($cmd == "active"){
        $id         = isset($_POST['id']) ? $_POST['id'] : "";
        $active     = isset($_POST['active']) ? $_POST['active'] : "";

        $sql_param = array();
        $sql_param['DELIVERY_ID']        = $id;
        $sql_param['DELIVERY_STATUS']    = $active;
        $res = $DB->executeUpdate('tb_delivery', 1, $sql_param);

        if ($res > 0) {
            $response['status'] = true;
            $response['msg'] = 'Update successfully';
        }else{
            $response['status'] = false;
            $response['msg'] = 'Update unsuccessfully';
        }

    } else if ($cmd == "add_delivery"){
        $add_delivery_name_th   = isset($_POST['add_delivery_name_th']) ? $_POST['add_delivery_name_th'] : "";
        $add_delivery_name_en   = isset($_POST['add_delivery_name_en']) ? $_POST['add_delivery_name_en'] : "";
        $add_delivery_type      = isset($_POST['add_delivery_type']) ? $_POST['add_delivery_type'] : "";
        $add_delivery_price     = isset($_POST['add_delivery_price']) ? $_POST['add_delivery_price'] : "";

        $sql_param = array();
        $new_id = "";
        $sql_param['DELIVERY_NAME_TH']  = $add_delivery_name_th;
        $sql_param['DELIVERY_NAME_EN']  = $add_delivery_name_en;
        $sql_param['DELIVERY_TYPE_ID']  = $add_delivery_type;
        $sql_param['DELIVERY_PRICE']    = number_format($add_delivery_price, 2, '.', '');
        $res = $DB->executeInsert('tb_delivery', $sql_param, $new_id);

        if ($res > 0) {
            $response['status'] = true;
            $response['msg'] = 'Create successfully';
        }else{
            $response['status'] = false;
            $response['msg'] = 'Create unsuccessfully';  
        }

    } else if ($cmd == "edit_delivery"){
        if (!empty($_POST['edit_delivery_id'])){
            $sql_param = array();
            $sql_param['DELIVERY_ID'] = $_POST['edit_delivery_id'];
            if (!empty($_POST['edit_delivery_name_th'])) $sql_param['DELIVERY_NAME_TH'] = $_POST['edit_delivery_name_th'];
            if (!empty($_POST['edit_delivery_name_en'])) $sql_param['DELIVERY_NAME_EN'] = $_POST['edit_delivery_name_en'];
            if (!empty($_POST['edit_delivery_type'])) $sql_param['DELIVERY_TYPE_ID'] = $_POST['edit_delivery_type'];
            if (!empty($_POST['edit_delivery_price'])) $sql_param['DELIVERY_PRICE'] = $_POST['edit_delivery_price'];
            $res = $DB->executeUpdate('tb_delivery', 1, $sql_param);
        }else{
            $res = 1;
        }

        if ($res > 0) {
            $response['status'] = true;
            $response['msg'] = 'Update successfully';
        }else{
            $response['status'] = false;
            $response['msg'] = 'Update unsuccessfully';
        }

    } else if ($cmd == "add_delivery_type"){
        $delivery_type_th   = isset($_POST['delivery_type_th']) ? $_POST['delivery_type_th'] : "";
        $delivery_type_en   = isset($_POST['delivery_type_en']) ? $_POST['delivery_type_en'] : "";

        $sql_param = array();
        $new_id = "";
        $sql_param['DELIVERY_TYPE_NAME_TH']  = $delivery_type_th;
        $sql_param['DELIVERY_TYPE_NAME_EN']  = $delivery_type_en;
        $res = $DB->executeInsert('tb_delivery_type', $sql_param, $new_id);

        if ($res > 0) {
            $response['status'] = true;
            $response['msg'] = 'Create successfully';
        }else{
            $response['status'] = false;
            $response['msg'] = 'Create unsuccessfully';  
        }

    } else if ($cmd == "active_type"){
        $id         = isset($_POST['id']) ? $_POST['id'] : "";
        $active     = isset($_POST['active']) ? $_POST['active'] : "";
        
        $sql_param = array();
        $sql_param['DELIVERY_TYPE_ID']        = $id;
        $sql_param['DELIVERY_TYPE_STATUS']    = $active;
        $res = $DB->executeUpdate('tb_delivery_type', 1, $sql_param);

        if ($res > 0) {
            $response['status'] = true;
            $response['msg'] = 'Update successfully';
        }else{
            $response['status'] = false;
            $response['msg'] = 'Update unsuccessfully';
        }

    } else if ($cmd == "remove_type"){
        $id    = isset($_POST['id']) ? $_POST['id'] : "";
        $sql = "DELETE FROM tb_delivery_type WHERE DELIVERY_TYPE_ID = @id";
        $sql_param = array();
        $sql_param['id'] = $id;
        $res = $DB->execute($sql, $sql_param);

        if ($res > 0) {
            $response['status'] = true;
            $response['msg'] = 'Remove successfully';
        }else{
            $response['status'] = false;
            $response['msg'] = 'Remove unsuccessfully';
        }

    } else if ($cmd == "edit_type"){
        if (!empty($_POST['type_id'])){
            $sql_param = array();
            $sql_param['DELIVERY_TYPE_ID'] = $_POST['type_id'];
            if (!empty($_POST['type_th'])) $sql_param['DELIVERY_TYPE_NAME_TH'] = $_POST['type_th'];
            if (!empty($_POST['type_en'])) $sql_param['DELIVERY_TYPE_NAME_EN'] = $_POST['type_en'];
            $res = $DB->executeUpdate('tb_delivery_type', 1, $sql_param);
        }else{
            $res = 1;
        }

        if ($res > 0) {
            $response['status'] = true;
            $response['msg'] = 'Update successfully';
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