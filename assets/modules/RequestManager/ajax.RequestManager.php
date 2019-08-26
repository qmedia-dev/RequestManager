<?php

if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    return;
}
switch ($_GET['q']) {

    case 'request_comment':
        if(isset($_POST['pk']) && isset($_POST['value'])) {
            $modx->db->update(array('employee_comment'=>$_POST['value']),$modx->getFullTableName('requestmanager_table'), 'id IN ('.$_POST['pk'].')');
        }
        die();
        break;

    case 'request_status':
        if(isset($_POST['pk']) && isset($_POST['value'])) {
            $modx->db->update(array('status'=>$_POST['value']),$modx->getFullTableName('requestmanager_table'), 'id IN ('.$_POST['pk'].')');
        }
        die();
        break;

    default:
        die();
        break;
}
