<?php

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
    if ($cmd == "login") {

        $login_username = isset($_POST['login_username']) ? $_POST['login_username'] : "";
        $login_password = isset($_POST['login_password']) ? $_POST['login_password'] : "";

        $sql = "SELECT * FROM tb_employee WHERE EMPLOYEE_USERNAME = @username AND EMPLOYEE_STATUS = true";
        $sql_param = array();
        $sql_param['username'] = $login_username;
        $ds = null;
        $res = $DB->query($ds, $sql, $sql_param, 0, 1, "ASSOC");

        if ($res > 0) {  
            foreach ($ds as $obj) {
                $accounts_id        = $obj['EMPLOYEE_ID'];
                $accounts_user      = $obj['EMPLOYEE_USERNAME'];
                $accounts_pwd       = $obj['EMPLOYEE_PASSWD'];
                $accounts_email     = $obj['EMPLOYEE_EMAIL'];
                $accounts_group     = $obj['EMPLOYEE_SYS_GROUPNAME'];
                $accounts_status    = $obj['EMPLOYEE_STATUS'];
                $accounts_lang      = $obj['EMPLOYEE_LANGUAGEUSER'];
            }

            $isAdmin = ($accounts_group == '1') ? true : false;


            if($accounts_status == true){
                 if(my_decrypt($accounts_pwd, WCMSetting::$ENCRYPT_LOGIN) == $login_password){

                    $_SESSION['loggedin']       = true;
                    $_SESSION['accesstoken']    = genAccessToken($accounts_user);
                    $_SESSION['user_id']        = safeEncrypt($accounts_id, WCMSetting::$ENCRYPT_EMPLOYEE);
                    $_SESSION['last_activity']  = time();
                    $_SESSION['expire_time']    = 86400 * 30;
                    $_SESSION['status']         = true;
                    $_SESSION['user_name']      = $accounts_user;
                    $_SESSION['isAdmin']        = ($accounts_group == '1') ? true : false;
                    $_SESSION['group']          = $accounts_group;
                    $_SESSION['email']          = $accounts_email;
                    $response['status'] = true;
                    $response['msg'] = 'Login successfully';

                }

            }else{
                $response['status'] = false;
                $response['msg'] = 'Username has been banned. ';
                $response['code'] = '400';
            }

        } else {
            $response['status'] = false;
            $response['msg'] = 'Username is incorrect';
            $response['code'] = '500';
        }

    } else if($cmd == "check_logout")  {
        // setcookie("login_session", "", time() - 3600);
        unset($_SESSION['loggedin']);
        unset($_SESSION['accesstoken']);
        unset($_SESSION['user_id']);
        unset($_SESSION['last_activity']);
        unset($_SESSION['expire_time']);
        unset($_SESSION['status']);
        unset($_SESSION['user_name']);
        unset($_SESSION['is_admin']);
        unset($_SESSION['email']);
        unset($_SESSION['group']);
        session_commit();

        $response['status'] = true;
        $response['msg'] = "Logout successfully";
        $response['code'] = '200';

    } 

    // else if($cmd == "forgot_pwd")  {
    //     $user_login = isset($_POST['user_login']) ? $_POST['user_login'] : "";
    //     $sql = "SELECT * FROM USERS WHERE USERNAME = @accounts_user AND EXPIRE_DATETIME > @exp_date AND STATUS = 'Y' ";
    //     $sql_param = array();
    //     $sql_param['accounts_user'] = $user_login;
    //     $sql_param['exp_date'] = $today;
    //     $ds = null;
    //     $res = $DB1->query($ds, $sql, $sql_param, 0, -1, "ASSOC");

    //     if ($res > 0) {  
    //         foreach ($ds as $obj) {
    //             $accounts_id = $obj['USERS_ID'];
    //             $accounts_email = $obj['EMAIL'];
    //             $accounts_user = $obj['USERNAME'];
    //             $accounts_name = $obj['NAME'];
    //             $accounts_pwd = base64_decode($obj['PASSWORD']);
    //             $IsDeveloper = $obj['ROOT_ID'];
    //             $account_status = $obj['STATUS'];
    //             $APPLICATIONS_ID = $obj['APPLICATIONS_ID'];
    //             $Sender_limit = $obj['SENDERNAME_LIMIT'];
    //         }
    //         $key_Char = randomChar(6);
    //         $startDate = time();
    //         if($account_status == "Y"){
               
    //             $vars = array(
    //               '{$data_url_resetpassword}' =>  WEB_META_BASE_URL.'th/forgot-pwd-conf?userid='.safeEncrypt($accounts_id.'||'.$key_Char,'cheese_resetpassword'),
    //             );

    //             require ROOT_DIR . '/controllers/email.php';
    //             $data['message_text_email'] = strtr(base64_decode($email_template_layout), $vars);
    //             $status = Send_email("Forgot Password",$accounts_email,$accounts_user,$data['message_text_email']);
    //             // var_dump($status);
    //             // exit();
    //             if($status == true){
    //                 $sql_param = array();
    //                 $sql_param['USERS_ID']          = $accounts_id;
    //                 $sql_param['REMARK']         = $key_Char;
    //                 $sql_param['UPDATE_DATETIME']   = $today;
    //                 $res = $DB1->executeUpdate('[BULK_SMS].[dbo].[USERS]', 1, $sql_param); 
    //                 if ($res > 0) {
    //                     $response['status'] = true;
    //                     $response['msg'] = '???????????????????????????????????? E-Mail ????????????????????????????????????';
    //                     $response['msg1'] = '???????????????????????????????????? E-mail : '.$accounts_email;
    //                 }else{
    //                     $response['status'] = false;
    //                     $response['msg'] = "??????????????????????????????????????????????????????????????????????????????";
    //                      // $response['msg1'] = '???????????????????????????????????? E-mail :'.$accounts_email;
    //                     $response['msg1'] = '?????????????????? E-mail ???????????????????????????????????????????????????????????????????????? Email ???????????????????????????????????????????????????????????????.';
    //                     // $response['code'] = '400';
    //                 }
    //             }else{
    //                 $response['status'] = false;
    //                 $response['msg'] = "??????????????????????????????????????????????????????????????????????????????";
    //                  // $response['msg1'] = '???????????????????????????????????? E-mail :'.$accounts_email;
    //                 $response['msg1'] = '?????????????????? E-mail ???????????????????????????????????????????????????????????????????????? Email ???????????????????????????????????????????????????????????????.';
    //                 // $response['code'] = '400';
    //             }


    //         }else{
    //             $response['status'] = false;
    //             $response['msg'] = 'Username has been banned. ';
    //             $response['code'] = '400';
    //         }
    //     } else {

    //         $response['status'] = false;
    //         $response['msg'] = 'Username is incorrect.';
    //         $response['code'] = '500';
    //         // $response['error_code'] = $res;
    //     }
    // } 
    // else if($cmd == "forgot_pwd_reset")  {

    //     $password_login = isset($_POST['password_login']) ? $_POST['password_login'] : "";
    //     $passwordconf_login = isset($_POST['passwordconf_login']) ? $_POST['passwordconf_login'] : "";
    //     $userid = isset($_POST['userid']) ? $_POST['userid'] : "";

    //     $uid = safeDecrypt($userid,'cheese_resetpassword');
    //     $data = explode("||", $uid);

    //     $sql = "SELECT * FROM USERS WHERE USERS_ID = @USERS_ID AND REMARK = @REMARK";
    //     $sql_param = array();
    //     $sql_param['USERS_ID'] = $data[0];
    //     $sql_param['REMARK'] = $data[1];
    //     $ds = null;
    //     $res = $DB1->query($ds, $sql, $sql_param, 0, -1, "ASSOC");
    //     //             var_dump($ds);
    //     // exit(); 
    //     if ($res > 0) {
    //         foreach ($ds as $obj) {
    //                 $accounts_id = $obj['USERS_ID'];
    //         }  

    //         if($password_login ==  $passwordconf_login){     
   


    //             $sql_param = array();
    //             $sql_param['USERS_ID']    = $accounts_id;
    //             $sql_param['PASSWORD']    =  base64_encode($password_login);
    //             $sql_param['REMARK']      = null;
    //             $sql_param['UPDATE_DATETIME']   = $today;
    //             $res = $DB1->executeUpdate('[BULK_SMS].[dbo].[USERS]', 1, $sql_param); 
    //              if ($res > 0) {            
    //                 $response['status'] = true;
    //                 $response['msg'] = '??????????????????????????????????????????';
    //                 $response['code'] = '200';
    //             }else{
    //                 $response['status'] = false;
    //                 $response['msg'] = '???????????????????????????????????????????????????';
    //                 $response['code'] = '500';
    //             }
    //         }else{
    //             $response['status'] = false;
    //             $response['msg'] = 'Password ???????????????????????????. ';
    //             $response['code'] = '500';
    //         }
    //     } else {

    //         $response['status'] = false;
    //         $response['msg'] = '????????????????????????????????????????????????????????????';
    //         $response['code'] = '500';
    //         // $response['error_code'] = $res;
    //     }
    // } 

    else {
        $response['status'] = false;
        $response['msg'] = 'no command';
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