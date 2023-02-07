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
    if($cmd == "employee"){
        $sql = "SELECT * 
                FROM tb_employee 
                INNER JOIN tb_system_group ON tb_employee.EMPLOYEE_SYS_GROUPNAME = tb_system_group.GROUP_ID
                ORDER BY FIELD(GROUP_NAME, 'admin', 'creator', 'product')";
        $sql_param = array();
        $ds = null;
        $res = $DB->query($ds, $sql, $sql_param, 0, -1, "ASSOC");
        $response['data'] = $ds;
        $response['status'] = true;
    } else if ($cmd == "add_employee") {
        if ($_SESSION['isAdmin'] == true) {
            $add_emp_username = isset($_POST['add_emp_username']) ? $_POST['add_emp_username'] : "";
            $sql_check = "SELECT * FROM tb_employee WHERE EMPLOYEE_USERNAME = @username";
            $sql_check_param = array();
            $sql_check_param['username'] = $add_emp_username;
            $ds_check = null;
            $res_check = $DB->query($ds_check, $sql_check, $sql_check_param, 0, 1, "ASSOC");

            if ($res_check == 0) {
                $add_emp_password   = isset($_POST['add_emp_password']) ? $_POST['add_emp_password'] : null;
                $add_emp_email      = isset($_POST['add_emp_email']) ? $_POST['add_emp_email'] : null;
                $add_emp_language   = isset($_POST['add_emp_language']) ? $_POST['add_emp_language'] : null;
                $add_emp_group      = isset($_POST['add_emp_group']) ? $_POST['add_emp_group'] : null;

                $new_id = "";
                $sql_param['EMPLOYEE_PASSWD']           = my_encrypt($add_emp_password, WCMSetting::$ENCRYPT_LOGIN);
                $sql_param['EMPLOYEE_USERNAME']         = $add_emp_username;
                $sql_param['EMPLOYEE_EMAIL']            = $add_emp_email;
                $sql_param['EMPLOYEE_LANGUAGEUSER']     = $add_emp_language;
                $sql_param['EMPLOYEE_SYS_GROUPNAME']    = $add_emp_group;
                $sql_param['EMPLOYEE_EMPCODE']          = genAccessToken($add_emp_username);

                $res = $DB->executeInsert('tb_employee', $sql_param, $new_id);
                if ($res > 0) {
                    $response['status'] = true;
                    $response['msg'] = 'Create employee successfully';
                } else {
                    $response['status'] = false;
                    $response['msg'] = 'Create employee unsuccessfully';  
                }
            } else {
                $response['status'] = false;
                $response['msg'] = "User name already exists";
            }
        } else {
            $response['status'] = false;
            $response['msg'] = 'You are not authorized to add employee.';
        }
    } else if ($cmd == "update_employee"){
        if ($_SESSION['isAdmin'] == true) {
            if (!empty($_POST['edit_e_id']) && !empty($_POST['edit_e_username'])) {
                $sql_check = "SELECT * FROM tb_employee WHERE EMPLOYEE_USERNAME = @username AND EMPLOYEE_ID != @emp_id";
                $sql_check_param = array();
                $sql_check_param['username'] = $_POST['edit_e_username'];
                $sql_check_param['emp_id'] = $_POST['edit_e_id'];
                $ds_check = null;
                $res_check = $DB->query($ds_check, $sql_check, $sql_check_param, 0, 1, "ASSOC");
                if ($res_check == 0) {
                    $edit_e_status = isset($_POST['edit_e_status']) ? $_POST['edit_e_status'] : "";
                    $sql_param = array();
                    $sql_param['EMPLOYEE_ID'] = $_POST['edit_e_id'];
                    $sql_param['EMPLOYEE_USERNAME'] = addslashes($_POST['edit_e_username']);
                    if (isset($_POST['edit_e_password']) && !empty($_POST['edit_e_password'])) {
                        $sql_param['EMPLOYEE_PASSWD'] = my_decrypt($_POST['edit_e_password'], WCMSetting::$ENCRYPT_LOGIN);
                    }
                    if (!empty($_POST['edit_e_language'])) $sql_param['EMPLOYEE_LANGUAGEUSER'] = $_POST['edit_e_language'];
                    if (!empty($_POST['edit_e_email'])) $sql_param['EMPLOYEE_EMAIL'] = $_POST['edit_e_email'];
                    $sql_param['EMPLOYEE_SYS_GROUPNAME'] = $_POST['edit_e_group'];
                    $sql_param['EMPLOYEE_STATUS'] = (isset($_POST['edit_e_status']) == 'on') ? 'true' : 'false';
                    $res = $DB->executeUpdate('tb_employee', 1, $sql_param); 
                    if ($res > 0) {
                        $response['status'] = true;
                        $response['msg'] = 'Update successfully';
                    }else{
                        $response['status'] = false;
                        $response['msg'] = 'Update unsuccessfully';
                    }
                } else {
                    $response['status'] = false;
                    $response['msg'] = "User name already exists";
                }
            } else {
                $response['status'] = false;
                $response['msg'] = 'invalid data';
            }
        } else {
            $response['status'] = false;
            $response['msg'] = 'You are not authorized to edit employee.';
        }
    } else if ($cmd == "remove_employee") {
        if ($_SESSION['isAdmin'] == "Y") {
            if (isset($_POST['emp_id'])) {
                $sql_param = array();
                $sql_param['EMPLOYEE_ID'] = $_POST['emp_id'];
                $sql_param['EMPLOYEE_STATUS'] = "false";
                $res = $DB->executeUpdate('tb_employee', 1, $sql_param);
                if ($res > 0) {
                    $response['status'] = true;
                    $response['msg'] = 'successfully';
                }else{
                    $response['status'] = false;
                    $response['msg'] = 'failed';
                }
            } else {
                $response['status'] = false;
                $response['msg'] = 'invalid data';
            }
        } else {
            $response['status'] = false;
            $response['msg'] = 'You are not authorized to remove employee.';
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