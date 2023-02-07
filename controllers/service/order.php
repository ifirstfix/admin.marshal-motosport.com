<?php

use OMCore\OMDb;
// use OMCore\OMMail;
$DB = OMDb::singleton();
$log = new OMCore\OMLog;

$response = array();
$today = date("Y-m-d H:i:s");
$exp = strtotime('+30 days', strtotime($today));
$expires = date('Y-m-d H:i:s', $exp);

$cmd = isset($_POST['cmd']) ? $_POST['cmd'] : "";

if ($cmd != "") {
    if($cmd == "order"){
        $sql = "SELECT * FROM tb_order ORDER BY ORDER_DATE DESC";
        $sql_param = array();
        $ds = null;
        $res = $DB->query($ds, $sql, $sql_param, 0, -1, "ASSOC");
        $response['data'] = $ds;
        $response['status'] = true;
    } else if ($cmd == "update_status"){
        $sql_param = array();
        
        if (!empty($_POST['id'])){
            $sql_param['ORDER_ID'] = $_POST['id'];
            if (!empty($_POST['status'])) $sql_param['ORDER_STATUS'] = $_POST['status'];
            $res = $DB->executeUpdate('tb_order', 1, $sql_param);
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

    } else if ($cmd == "product_list"){
        $id    = isset($_POST['id']) ? $_POST['id'] : "";

        $sql = "SELECT tb_order_detail.ORDER_QTY
                            , tb_product.PRODUCT_IMG
                            , tb_order_detail.PRODUCT_PRICE
                            , tb_product_type.PRODUCT_TYPE_NAME_TH
                            , tb_order_detail.PRODUCT_NAME
                FROM tb_order_detail 
                INNER JOIN tb_product ON tb_order_detail.PRODUCT_ID = tb_product.PRODUCT_ID
                INNER JOIN tb_product_type ON tb_order_detail.PRODUCT_TYPE = tb_product_type.PRODUCT_TYPE_ID 
                WHERE ORDER_ID = @order_id";
        $sql_param = array();
        $sql_param['order_id'] = $id;
        $ds = null;
        $res = $DB->query($ds, $sql, $sql_param, 0, -1, "ASSOC");
        $response['data'] = $ds;
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