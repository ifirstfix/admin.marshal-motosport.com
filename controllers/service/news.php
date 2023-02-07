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
    if($cmd == "news"){
        $sql = "SELECT * FROM tb_news ORDER BY NEWS_ID DESC";
        $sql_param = array();
        $ds = null;
        $res = $DB->query($ds, $sql, $sql_param, 0, -1, "ASSOC");
        $response['data'] = $ds;
        $response['status'] = true;

    } else if ($cmd == "remove"){
        $id    = isset($_POST['id']) ? $_POST['id'] : "";

        $sql = "DELETE FROM tb_news WHERE NEWS_ID = @id";
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
        $id    = isset($_POST['id']) ? $_POST['id'] : "";
        $active   = isset($_POST['active']) ? $_POST['active'] : "";

        $sql_param = array();
        $sql_param['NEWS_ID']        = $id;
        $sql_param['NEWS_STATUS']    = $active;
        $res = $DB->executeUpdate('tb_news', 1, $sql_param);

        if ($res > 0) {
            $response['status'] = true;
            $response['msg'] = 'Update successfully';
        }else{
            $response['status'] = false;
            $response['msg'] = 'Update unsuccessfully';
        }

    } else if ($cmd == "add_news"){
        $news_public              = isset($_POST['news_public']) ? $_POST['news_public'] : "";
        $add_title_th           = isset($_POST['add_title_th']) ? $_POST['add_title_th'] : "";
        $add_title_en           = isset($_POST['add_title_en']) ? $_POST['add_title_en'] : "";
        $add_news_detail_th     = isset($_POST['add_news_detail_th']) ? $_POST['add_news_detail_th'] : "";
        $add_news_detail_en     = isset($_POST['add_news_detail_en']) ? $_POST['add_news_detail_en'] : "";
        $new_youtube_url        = isset($_POST['new_youtube_url']) ? $_POST['new_youtube_url'] : "";
        $auto_play              = isset($_POST['auto_play']) ? $_POST['auto_play'] : "";
        $auto_play              = ($auto_play == 'on') ? '1' : '0';
        $new_video              = 'https://www.youtube.com/embed/' . $new_youtube_url . '?autoplay=' . $auto_play . '&amp;mute=1';

        $image_news = null;
        if(!empty($_FILES["add_news_img"]["name"])) {
            $image_news = date('Ymd').'_'.OMImage::uuname()."." . str_replace(" ", "", basename($_FILES["add_news_img"]["type"]));
            copy($_FILES["add_news_img"]["tmp_name"], ROOT_DIR . "images/news/" . $image_news);
        }

        $sql_param = array();
        $new_id = "";
        $sql_param['NEWS_NAME_TH']      = $add_title_th;
        $sql_param['NEWS_DETAIL_TH']    = $add_news_detail_th;
        $sql_param['NEWS_IMG']          = $image_news;
        $sql_param['NEWS_VDO']          = $new_video;
        $sql_param['NEWS_VDO_ID']       = $new_youtube_url;
        $sql_param['NEWS_NAME_EN']      = $add_title_en;
        $sql_param['NEWS_DETAIL_EN']    = $add_news_detail_en;
        $sql_param['NEWS_PUBLICDATETIME']  = $news_public;
        $res = $DB->executeInsert('tb_news', $sql_param, $new_id);

        if ($res > 0) {
            $response['status'] = true;
            $response['msg'] = 'Create news successfully';
        }else{
            $response['status'] = false;
            $response['msg'] = 'Create news unsuccessfully';  
        }

    } else if ($cmd == "edit_news"){
        $sql_param = array();
        
        if (!empty($_POST['news_id'])){
            $sql_param['NEWS_ID'] = $_POST['news_id'];

            $image_news = null;
            if(!empty($_FILES["edit_news_img"]["name"])) {
                $image_news = date('Ymd').'_'.OMImage::uuname()."." . str_replace(" ", "", basename($_FILES["edit_news_img"]["type"]));
                copy($_FILES["edit_news_img"]["tmp_name"], ROOT_DIR . "images/news/" . $image_news);
                $sql_param['NEWS_IMG']  = $image_news;
            }

            $auto_play              = (isset($_POST['auto_play']) == 'on') ? '1' : '0';
            $news_video              = 'https://www.youtube.com/embed/' . $_POST['edit_new_youtube_url'] . '?autoplay=' . $auto_play . '&amp;mute=1';

            if (!empty($_POST['edit_title_th'])) $sql_param['NEWS_NAME_TH'] = $_POST['edit_title_th'];
            if (!empty($_POST['edit_title_en'])) $sql_param['NEWS_NAME_EN'] = $_POST['edit_title_en'];
            if (!empty($_POST['edit_new_youtube_url'])) $sql_param['NEWS_VDO_ID'] = $_POST['edit_new_youtube_url'];
            if (!empty($_POST['edit_new_youtube_url'])) $sql_param['NEWS_VDO'] = $news_video;
            if (!empty($_POST['edit_news_detail_th'])) $sql_param['NEWS_DETAIL_TH'] = $_POST['edit_news_detail_th'];
            if (!empty($_POST['edit_news_detail_en'])) $sql_param['NEWS_DETAIL_EN'] = $_POST['edit_news_detail_en'];
            if (!empty($_POST['edit_news_public'])) $sql_param['NEWS_PUBLICDATETIME'] = $_POST['edit_news_public'];
            $res = $DB->executeUpdate('tb_news', 1, $sql_param);
        }else{
            $res = 1;
        }

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