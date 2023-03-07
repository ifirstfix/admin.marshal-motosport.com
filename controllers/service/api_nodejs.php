<?php
header("Access-Control-Allow-Origin: *");
use OMCore\OMDb;
// use OMCore\OMMail;
$DB = OMDb::singleton();

$response = array();
$today = date("Y-m-d H:i:s");
$exp = strtotime('+30 days', strtotime($today));
$expires = date('Y-m-d H:i:s', $exp);
$startDate = time();

$cmd = isset($_POST['cmd']) ? $_POST['cmd'] : "";

if ($cmd != "") {

// ---------------------------------------------------------------------------------------------------------------------------
    if ($cmd == "order_list") {

        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : "";
        // $login_password = isset($_POST['login_password']) ? $_POST['login_password'] : "";

        $sql = "SELECT tb_order.* FROM tb_order WHERE tb_order.MEMBER_ID = @user_id";
        $sql_param = array();
        $sql_param['user_id'] = $user_id;
        $ds = null;
        $res = $DB->query($ds, $sql, $sql_param, 0, -1, "ASSOC");

        if ($res > 0) {  
            $list_order = [];
            foreach ($ds as $obj) {
                // var_dump($obj);
                $order = [];
                $order['id'] = $obj['ORDER_ID'];
                $order['number'] = $obj['ORDER_REFID'];
                $order['date'] = $obj['MEMBER_INVOICE_DATE'];
                $order['totalPrice'] = $obj['MEMBER_PROPRICE'];
                $order['status'] = $obj['ORDER_STATUS'];
                $order['name'] = $obj['MEMBER_NAME'];
                $order['phone'] = $obj['MEMBER_PHONE'];
                $order['address'] = $obj['MEMBER_ADDRESS'];
                $order['isPurchase'] = false;
                $order['stepStatus'] = 0;

                $sql_order_detail = "SELECT
                tb_order_detail.*, 
                tb_product.PRODUCT_IMG
            FROM
                tb_order_detail
                INNER JOIN
                tb_product
                ON 
                    tb_order_detail.PRODUCT_ID = tb_product.PRODUCT_ID
            WHERE
                tb_order_detail.ORDER_ID = @ORDER_ID";
                $sql_param_order_detail = array();
                $sql_param_order_detail['ORDER_ID'] = $obj['ORDER_ID'];
                $ds_order_detail = null;
                $res_order_detail = $DB->query($ds_order_detail, $sql_order_detail, $sql_param_order_detail, 0, -1, "ASSOC");
                $order_product_all = array();
                if ($res_order_detail > 0) {  
                    foreach ($ds_order_detail as $obj_order_detail) {
                        // var_dump($obj_order_detail);
                        $PRODUCT_IMG = isset($obj_order_detail['PRODUCT_IMG']) ? $obj_order_detail['PRODUCT_IMG'] : "";
                        $order_product = [];
                        $order_product['name'] = $obj_order_detail['PRODUCT_NAME'];
                        $order_product['alternative'] = $obj_order_detail['PRODUCT_NAME'];
                        $order_product['image'] = ($PRODUCT_IMG == '') ? '' : json_Decode($PRODUCT_IMG)[0] ;
                        $order_product['price'] = $obj_order_detail['PRODUCT_PRICE'];
                        $order_product['quantity'] = $obj_order_detail['ORDER_QTY'];
                        array_push($order_product_all, $order_product);
                    }
                }
                $order['products'] = $order_product_all;
                // $list_order[$obj['ORDER_ID']] = $order;
                array_push($list_order, $order);
            }
            $response['status'] = true;
            $response['data'] = $list_order;
            $response['code'] = '200';
        } else {
            $response['status'] = false;
            $response['msg'] = 'Username is incorrect';
            $response['code'] = '500';
        }
    } else {
        $response['status'] = false;
        $response['msg'] = 'no command list';
        $response['code'] = '500';
    }
// ---------------------------------------------------------------------------------------------------------------------------

} else {
    // error
    $response['status'] = false;
    $response['msg'] = 'no command';
    $response['code'] = '500';
}

echo json_encode($response);

?>