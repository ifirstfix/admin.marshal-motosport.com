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
    if($cmd == "product"){
        $sql = "SELECT  PRODUCT_ID
                        , PRODUCT_ROWS
                        , tb_product.PRODUCT_IMG
                        , PRODUCT_NAME_TH
                        , PRODUCT_NAME_EN
                        , PRODUCT_DETAIL_TH
                        , PRODUCT_DETAIL_EN
                        , tb_product.PRODUCT_TYPE_ID
                        , PRODUCT_TYPE_NAME_TH
                        , PRODUCT_TYPE_NAME_EN
                        , PRODUCT_PRICE
                        , tb_product.PRODUCT_STATUS
                        , tb_product.CREATEDATETIME
                        , PRODUCT_TAG
                        , (SELECT MAX(PRODUCT_ROWS) FROM tb_product WHERE tb_product.PRODUCT_STATUS = 'on') AS max_order
                        , PRODUCT_STOCK
                        , PRODUCT_PRICE_SALE
                FROM tb_product
                INNER JOIN tb_product_type ON tb_product.PRODUCT_TYPE_ID = tb_product_type.PRODUCT_TYPE_ID 
                ORDER BY PRODUCT_ROWS";
        $sql_param = array();
        $ds = null;
        $res = $DB->query($ds, $sql, $sql_param, 0, -1, "ASSOC");
        $response['data'] = $ds;
        $response['status'] = true;

    } else if($cmd == "product_type"){
        $sql = "SELECT *, (SELECT MAX(PRODUCT_TYPE_ROWS) FROM tb_product_type WHERE PRODUCT_STATUS = 'on') AS max_order FROM tb_product_type ORDER BY PRODUCT_TYPE_ROWS";
        $sql_param = array();
        $ds = null;
        $res = $DB->query($ds, $sql, $sql_param, 0, -1, "ASSOC");
        $response['data'] = $ds;
        $response['status'] = true;

    } else if ($cmd == "remove"){
        $id    = isset($_POST['id']) ? $_POST['id'] : "";

        $sql = "DELETE FROM tb_product WHERE PRODUCT_ID = @id";
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
        $sql_param['PRODUCT_ID']        = $id;
        $sql_param['PRODUCT_STATUS']    = $active;
        $res = $DB->executeUpdate('tb_product', 1, $sql_param);

        if ($res > 0) {
            $response['status'] = true;
            $response['msg'] = 'Update successfully';
        }else{
            $response['status'] = false;
            $response['msg'] = 'Update unsuccessfully';
        }

    } else if ($cmd == "add_product"){

        $add_product_name_th    = isset($_POST['add_product_name_th']) ? $_POST['add_product_name_th'] : "";
        $add_product_name_en    = isset($_POST['add_product_name_en']) ? $_POST['add_product_name_en'] : "";
        $add_product_price      = isset($_POST['add_product_price']) ? $_POST['add_product_price'] : "";
        $add_product_type       = isset($_POST['add_product_type']) ? $_POST['add_product_type'] : "";
        $add_product_detail_th  = isset($_POST['add_product_detail_th']) ? $_POST['add_product_detail_th'] : "";
        $add_product_detail_en  = isset($_POST['add_product_detail_en']) ? $_POST['add_product_detail_en'] : "";
        $add_product_tag        = isset($_POST['add_product_tag']) ? $_POST['add_product_tag'] : "";
        $add_product_stock      = isset($_POST['add_product_stock']) ? $_POST['add_product_stock'] : "";
        $add_product_price_sale = isset($_POST['add_product_price_sale']) ? $_POST['add_product_price_sale'] : "";
        $add_product_price_sale = ($_POST['add_product_tag'] == 'SALE') ? $add_product_price_sale : 0;
        // $add_product_price_sale = ($add_product_price_sale == '') ? 0 : $add_product_price_sale;

        $FILES_ARRAY = array();
        if(!empty($_FILES["add_product_img"]["name"])) {
            foreach ($_FILES['add_product_img']['name'] as $key => $value) {
                if (!empty($value)) {
                    $file_arr  = array();
                    $file_name = OMImage::uuname()."." . str_replace(" ", "", basename($_FILES['add_product_img']['type'][$key]));
                    $file_arr['file_name'] = $file_name;
                    copy($_FILES["add_product_img"]["tmp_name"][$key], ROOT_DIR . "images/product/" . $file_name);
                    array_push($FILES_ARRAY, $file_arr);
                }
            }
        }
        $JSON_FILE = json_encode($FILES_ARRAY, JSON_UNESCAPED_SLASHES);

        $sql_param = array();
        $new_id = "";
        $sql_param['PRODUCT_NAME_TH']       = $add_product_name_th;
        $sql_param['PRODUCT_NAME_EN']       = $add_product_name_en;
        $sql_param['PRODUCT_TYPE_ID']       = $add_product_type;
        $sql_param['PRODUCT_PRICE']         = number_format($add_product_price, 2, '.', '');
        $sql_param['PRODUCT_PRICE_SALE']    = number_format($add_product_price_sale, 2, '.', '');
        $sql_param['PRODUCT_DETAIL_TH']     = $add_product_detail_th;
        $sql_param['PRODUCT_DETAIL_EN']     = $add_product_detail_en;
        $sql_param['PRODUCT_TAG']           = $add_product_tag;
        $sql_param['PRODUCT_IMG']           = $JSON_FILE;
        $sql_param['PRODUCT_STOCK']         = intval($add_product_stock);
        $res = $DB->executeInsert('tb_product', $sql_param, $new_id);

        if ($res > 0) {
            $sql_upd_last_order = "UPDATE tb_product SET PRODUCT_ROWS = ((SELECT selected_value 
                                    FROM (SELECT MAX(PRODUCT_ROWS) AS selected_value FROM tb_product) AS sub_selected_value) + 1) 
                                    WHERE PRODUCT_ID = ".$new_id;
            $DB->execute($sql_upd_last_order);
            $response['status'] = true;
            $response['msg'] = 'Create successfully';
        }else{
            $response['status'] = false;
            $response['msg'] = 'Create unsuccessfully';  
        }

    } else if ($cmd == "edit_product"){

        if (!empty($_POST['edit_product_id'])){
            $sql_param = array();
            $sql_param['PRODUCT_ID'] = $_POST['edit_product_id'];
            if (!empty($_POST['edit_product_name_th'])) $sql_param['PRODUCT_NAME_TH'] = $_POST['edit_product_name_th'];
            if (!empty($_POST['edit_product_name_en'])) $sql_param['PRODUCT_NAME_EN'] = $_POST['edit_product_name_en'];
            if (!empty($_POST['edit_product_detail_th'])) $sql_param['PRODUCT_DETAIL_TH'] = $_POST['edit_product_detail_th'];
            if (!empty($_POST['edit_product_detail_en'])) $sql_param['PRODUCT_DETAIL_EN'] = $_POST['edit_product_detail_en'];
            if (!empty($_POST['edit_product_price'])) $sql_param['PRODUCT_PRICE'] = $_POST['edit_product_price'];
            if (!empty($_POST['edit_product_tag'])) $sql_param['PRODUCT_TAG'] = $_POST['edit_product_tag'];
            if (!empty($_POST['edit_product_stock'])) $sql_param['PRODUCT_STOCK'] = $_POST['edit_product_stock'];
            $edit_product_price_sale = isset($_POST['edit_product_price_sale']) ? $_POST['edit_product_price_sale'] : "";
            $edit_product_price_sale = ($_POST['edit_product_tag'] == 'SALE') ? number_format($edit_product_price_sale, 2, '.', '') : 0;
            $sql_param['PRODUCT_PRICE_SALE'] = $edit_product_price_sale;
            $FILES_ARRAY = array();
            if(!empty($_FILES["edit_product_img"]["name"])) {
                foreach ($_FILES['edit_product_img']['name'] as $key => $value) {
                    if (!empty($value)) {
                        $file_arr  = array();
                        $file_name = OMImage::uuname()."." . str_replace(" ", "", basename($_FILES['edit_product_img']['type'][$key]));
                        $file_arr['file_name'] = $file_name;
                        copy($_FILES["edit_product_img"]["tmp_name"][$key], ROOT_DIR . "images/product/" . $file_name);
                        array_push($FILES_ARRAY, $file_arr);
                    }
                }
            }

            if(!empty($FILES_ARRAY)){
                $sql_param['PRODUCT_IMG'] = json_encode($FILES_ARRAY, JSON_UNESCAPED_SLASHES);
            }

            $res = $DB->executeUpdate('tb_product', 1, $sql_param);
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

    } else if ($cmd == "add_product_type"){
        $product_type_th   = isset($_POST['product_type_th']) ? $_POST['product_type_th'] : "";
        $product_type_en   = isset($_POST['product_type_en']) ? $_POST['product_type_en'] : "";
        
        $sql_param = array();
        $new_id = "";
        $sql_param['PRODUCT_TYPE_NAME_TH']  = $product_type_th;
        $sql_param['PRODUCT_TYPE_NAME_EN']  = $product_type_en;
        $res = $DB->executeInsert('tb_product_type', $sql_param, $new_id);

        if ($res > 0) {
            $sql_upd_last_order = "UPDATE tb_product_type SET PRODUCT_TYPE_ROWS = ((SELECT selected_value 
                                    FROM (SELECT MAX(PRODUCT_TYPE_ROWS) AS selected_value FROM tb_product_type) AS sub_selected_value) + 1) 
                                    WHERE PRODUCT_TYPE_ID = ".$new_id;
            $DB->execute($sql_upd_last_order);

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
        $sql_param['PRODUCT_TYPE_ID']        = $id;
        $sql_param['PRODUCT_STATUS']    = $active;
        $res = $DB->executeUpdate('tb_product_type', 1, $sql_param);

        if ($res > 0) {
            $response['status'] = true;
            $response['msg'] = 'Update successfully';
        }else{
            $response['status'] = false;
            $response['msg'] = 'Update unsuccessfully';
        }

    } else if ($cmd == "remove_type"){
        $id    = isset($_POST['id']) ? $_POST['id'] : "";
        $sql = "DELETE FROM tb_product_type WHERE PRODUCT_TYPE_ID = @id";
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
            $sql_param['PRODUCT_TYPE_ID'] = $_POST['type_id'];
            if (!empty($_POST['type_th'])) $sql_param['PRODUCT_TYPE_NAME_TH'] = $_POST['type_th'];
            if (!empty($_POST['type_en'])) $sql_param['PRODUCT_TYPE_NAME_EN'] = $_POST['type_en'];
            $res = $DB->executeUpdate('tb_product_type', 1, $sql_param);
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

    } else if ($cmd == "update_order"){
        $id    = isset($_POST['id']) ? $_POST['id'] : "";
        $order_value_old    = isset($_POST['order_value_old']) ? $_POST['order_value_old'] : "";
        $order_value_new    = isset($_POST['order_value_new']) ? $_POST['order_value_new'] : "";

        if ($order_value_old != $order_value_new) {
            if ($order_value_old < $order_value_new) {
                $set = "PRODUCT_TYPE_ROWS = PRODUCT_TYPE_ROWS - 1";
                $where = "PRODUCT_TYPE_ROWS > $order_value_old and PRODUCT_TYPE_ROWS <= $order_value_new";
            } else {
                $set = "PRODUCT_TYPE_ROWS = PRODUCT_TYPE_ROWS + 1";
                $where = "PRODUCT_TYPE_ROWS < $order_value_old and PRODUCT_TYPE_ROWS >= $order_value_new";
            }

            $sql_upd_reorder = "update tb_product_type set $set where $where";
            $DB->execute($sql_upd_reorder);
            $sql_upd_order = "update tb_product_type set PRODUCT_TYPE_ROWS = $order_value_new where PRODUCT_TYPE_ID = $id";
            $res_d = $DB->execute($sql_upd_order);

            if ($res_d > 0) {
                $response['status'] = true;
                $response['msg'] = 'Update successfully';
            }else{
                $response['status'] = false;
                $response['msg'] = 'Update unsuccessfully';
            }
        }

    } else if ($cmd == "update_product_order"){
        $id    = isset($_POST['id']) ? $_POST['id'] : "";
        $order_value_old    = isset($_POST['order_value_old']) ? $_POST['order_value_old'] : "";
        $order_value_new    = isset($_POST['order_value_new']) ? $_POST['order_value_new'] : "";

        if ($order_value_old != $order_value_new) {
            if ($order_value_old < $order_value_new) {
                $set = "PRODUCT_ROWS = PRODUCT_ROWS - 1";
                $where = "PRODUCT_ROWS > $order_value_old and PRODUCT_ROWS <= $order_value_new";
            } else {
                $set = "PRODUCT_ROWS = PRODUCT_ROWS + 1";
                $where = "PRODUCT_ROWS < $order_value_old and PRODUCT_ROWS >= $order_value_new";
            }

            $sql_upd_reorder = "update tb_product set $set where $where";
            $DB->execute($sql_upd_reorder);
            $sql_upd_order = "update tb_product set PRODUCT_ROWS = $order_value_new where PRODUCT_ID = $id";
            $res_d = $DB->execute($sql_upd_order);

            if ($res_d > 0) {
                $response['status'] = true;
                $response['msg'] = 'Update successfully';
            }else{
                $response['status'] = false;
                $response['msg'] = 'Update unsuccessfully';
            }
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