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
    if($cmd == "gallery"){
        $sql = "SELECT * FROM tb_gallery";
        $sql_param = array();
        $ds = null;
        $res = $DB->query($ds, $sql, $sql_param, 0, -1, "ASSOC");
        $response['data'] = $ds;
        $response['status'] = true;

    } else if ($cmd == "remove_gallery"){
        $gallery_id    = isset($_POST['gallery_id']) ? $_POST['gallery_id'] : "";

        $sql = "DELETE FROM tb_gallery WHERE GALLERY_ID = @GALLERYID";
        $sql_param = array();
        $sql_param['GALLERYID'] = $gallery_id;
        $res = $DB->execute($sql, $sql_param);

        if ($res > 0) {
            $response['status'] = true;
            $response['msg'] = 'Remove gallery successfully';
        }else{
            $response['status'] = false;
            $response['msg'] = 'Remove gallery unsuccessfully';
        }

    } else if ($cmd == "active_gallery"){
        $gallery_ac_id    = isset($_POST['gallery_ac_id']) ? $_POST['gallery_ac_id'] : "";
        $gallery_active   = isset($_POST['gallery_active']) ? $_POST['gallery_active'] : "";

        $sql_param = array();
        $sql_param['GALLERY_ID']        = $gallery_ac_id;
        $sql_param['GALLERY_STATUS']    = $gallery_active;
        $res = $DB->executeUpdate('tb_gallery', 1, $sql_param);

        if ($res > 0) {
            $response['status'] = true;
            $response['msg'] = 'Update gallery successfully';
        }else{
            $response['status'] = false;
            $response['msg'] = 'Update gallery unsuccessfully';
        }

    } else if ($cmd == "add_gallery"){
        $add_gallery_name     = isset($_POST['add_gallery_name']) ? $_POST['add_gallery_name'] : "";
        $add_gallery_alt      = isset($_POST['add_gallery_alt']) ? $_POST['add_gallery_alt'] : "";

        $image_gallery = null;
        if(!empty($_FILES["add_gallery_img"]["name"])) {
            $image_gallery = date('Ymd').'_'.OMImage::uuname()."." . str_replace(" ", "", basename($_FILES["add_gallery_img"]["type"]));
            copy($_FILES["add_gallery_img"]["tmp_name"], ROOT_DIR . "images/gallery/" . $image_gallery);
        }

        $sql_param = array();
        $new_id = "";
        $sql_param['GALLERY_NAME']  = $add_gallery_name;
        $sql_param['GALLERY_ALT']   = $add_gallery_alt;
        $sql_param['GALLERY_IMAGE'] = $image_gallery;
        $res = $DB->executeInsert('tb_gallery', $sql_param, $new_id);

        if ($res > 0) {
            $response['status'] = true;
            $response['msg'] = 'Create image successfully';
        }else{
            $response['status'] = false;
            $response['msg'] = 'Create image unsuccessfully';  
        }

    } else if ($cmd == "edit_gallery"){
        $sql_param = array();
        $gallery_e_id       = isset($_POST['edit_g_id']) ? $_POST['edit_g_id'] : "";
        $sql_param['GALLERY_ID']        = $gallery_e_id;

        $image_gallery = null;
        if(!empty($_FILES["edit_gallery_img"]["name"])) {
            $image_gallery = date('Ymd').'_'.OMImage::uuname()."." . str_replace(" ", "", basename($_FILES["edit_gallery_img"]["type"]));
            copy($_FILES["edit_gallery_img"]["tmp_name"], ROOT_DIR . "images/gallery/" . $image_gallery);
            $sql_param['GALLERY_IMAGE']       = $image_gallery;
        }
        
        if (!empty($_POST['edit_gallery_name'])) $sql_param['GALLERY_NAME'] = $_POST['edit_gallery_name'];
        if (!empty($_POST['edit_gallery_alt'])) $sql_param['GALLERY_ALT'] = $_POST['edit_gallery_alt'];
        $res = $DB->executeUpdate('tb_gallery', 1, $sql_param);

        if ($res > 0) {
            $response['status'] = true;
            $response['msg'] = 'Update gallery successfully';
        }else{
            $response['status'] = false;
            $response['msg'] = 'Update gallery unsuccessfully';
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