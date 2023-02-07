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
    if ($cmd == "add_banner"){

        $add_banner_name        = isset($_POST['add_banner_name']) ? $_POST['add_banner_name'] : "";
        $add_banner_alt         = isset($_POST['add_banner_alt']) ? $_POST['add_banner_alt'] : "";
        $add_banner_detail_th   = isset($_POST['add_banner_detail_th']) ? $_POST['add_banner_detail_th'] : "";
        $add_banner_detail_en   = isset($_POST['add_banner_detail_en']) ? $_POST['add_banner_detail_en'] : "";

        $image_banner = null;
        if(!empty($_FILES["add_banner_img"]["name"])) {
            $image_banner = date('Ymd').'_'.OMImage::uuname()."." . str_replace(" ", "", basename($_FILES["add_banner_img"]["type"]));
            copy($_FILES["add_banner_img"]["tmp_name"], ROOT_DIR . "images/banner/" . $image_banner);
        }

        $sql_param = array();
        $new_id = "";
        $sql_param['SLIDER_NAME']       = $add_banner_name;
        $sql_param['SLIDER_IMAGE']      = $image_banner;
        $sql_param['SLIDER_ALT']        = $add_banner_alt;
        $sql_param['SLIDER_DETAIL_TH']  = $add_banner_detail_th;
        $sql_param['SLIDER_DETAIL_EN']  = $add_banner_detail_en;
        $res = $DB->executeInsert('tb_slider', $sql_param, $new_id);

        if ($res > 0) {
            $sql_upd_last_order = "UPDATE tb_slider SET SLIDER_ROWS = ((SELECT selected_value 
                                    FROM (SELECT MAX(SLIDER_ROWS) AS selected_value FROM tb_slider) AS sub_selected_value) + 1) 
                                    WHERE SLIDER_ID = ".$new_id;
            $DB->execute($sql_upd_last_order);
            
            $response['status'] = true;
            $response['msg'] = 'Create banner successfully';
        }else{
            $response['status'] = false;
            $response['msg'] = 'Create banner unsuccessfully';  
        }

    } else if ($cmd == "show_banner"){
        $sql = "SELECT *, (SELECT MAX(SLIDER_ROWS) FROM tb_slider WHERE SLIDER_STATUS = 'true') AS max_order FROM tb_slider ORDER BY SLIDER_ROWS";
        $sql_param = array();
        $ds = null;
        $res = $DB->query($ds, $sql, $sql_param, 0, -1, "ASSOC");

        $response['status'] = true;
        $response['data'] = $ds;

    } else if ($cmd == "remove_banner"){
        $banner_id    = isset($_POST['banner_id']) ? $_POST['banner_id'] : "";

        $sql = "DELETE FROM tb_slider WHERE SLIDER_ID = @SLIDER_ID";
        $sql_param = array();
        $sql_param['SLIDER_ID'] = $banner_id;
        $res = $DB->execute($sql, $sql_param);

        if ($res > 0) {
            $response['status'] = true;
            $response['msg'] = 'Remove banner successfully';
        }else{
            $response['status'] = false;
            $response['msg'] = 'Remove banner unsuccessfully';
        }

    } else if ($cmd == "active_banner"){
        $active_banner_id    = isset($_POST['active_banner_id']) ? $_POST['active_banner_id'] : "";
        $active    = isset($_POST['active']) ? $_POST['active'] : "";

        $sql_param = array();
        $sql_param['SLIDER_ID']     = $active_banner_id;
        $sql_param['SLIDER_STATUS'] = $active;
        $res = $DB->executeUpdate('tb_slider', 1, $sql_param);

        if ($res > 0) {
            $response['status'] = true;
            $response['msg'] = 'Update banner successfully';
        }else{
            $response['status'] = false;
            $response['msg'] = 'Update banner unsuccessfully';
        }

    } else if ($cmd == "update_order"){
        $banner_id    = isset($_POST['banner_id']) ? $_POST['banner_id'] : "";
        $banner_order_old    = isset($_POST['banner_order_old']) ? $_POST['banner_order_old'] : "";
        $banner_order_new    = isset($_POST['banner_order_new']) ? $_POST['banner_order_new'] : "";

        if ($banner_order_old != $banner_order_new) {
            if ($banner_order_old < $banner_order_new) {
                $set = "SLIDER_ROWS = SLIDER_ROWS - 1";
                $where = "SLIDER_ROWS > $banner_order_old and SLIDER_ROWS <= $banner_order_new";
            } else {
                $set = "SLIDER_ROWS = SLIDER_ROWS + 1";
                $where = "SLIDER_ROWS < $banner_order_old and SLIDER_ROWS >= $banner_order_new";
            }

            $sql_upd_reorder = "update tb_slider set $set where $where";
            $DB->execute($sql_upd_reorder);
            $sql_upd_order = "update tb_slider set SLIDER_ROWS = $banner_order_new where SLIDER_ID = $banner_id";
            //$sql_param_d = array();
            //$sql_param_d['course_id'] = $edit_c_course_id;
            $res_d = $DB->execute($sql_upd_order);

            if ($res_d > 0) {
                $response['status'] = true;
                $response['msg'] = 'Update banner successfully';
            }else{
                $response['status'] = false;
                $response['msg'] = 'Update banner unsuccessfully';
            }
        }

    } else if ($cmd == "edit_banner"){
        $sql_param = array();
        if (!empty($_POST['edit_banner_id'])){
            $sql_param['SLIDER_ID'] = $_POST['edit_banner_id'];

            $image_banner = null;
            if(!empty($_FILES["edit_banner_img"]["name"])) {
                $image_banner = date('Ymd').'_'.OMImage::uuname()."." . str_replace(" ", "", basename($_FILES["edit_banner_img"]["type"]));
                copy($_FILES["edit_banner_img"]["tmp_name"], ROOT_DIR . "images/banner/" . $image_banner);
                $sql_param['SLIDER_IMAGE']  = $image_banner;
            }

            if (!empty($_POST['edit_banner_name'])) $sql_param['SLIDER_NAME'] = $_POST['edit_banner_name'];
            if (!empty($_POST['edit_banner_alt'])) $sql_param['SLIDER_ALT'] = $_POST['edit_banner_alt'];
            if (!empty($_POST['edit_banner_detail_th'])) $sql_param['SLIDER_DETAIL_TH'] = $_POST['edit_banner_detail_th'];
            if (!empty($_POST['edit_banner_detail_en'])) $sql_param['SLIDER_DETAIL_EN'] = $_POST['edit_banner_detail_en'];
            $res = $DB->executeUpdate('tb_slider', 1, $sql_param);
        }else{
            $res = 1;
        }

        if ($res > 0) {
            $response['status'] = true;
            $response['msg'] = 'Update banner successfully';
        }else{
            $response['status'] = false;
            $response['msg'] = 'Update banner unsuccessfully';
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