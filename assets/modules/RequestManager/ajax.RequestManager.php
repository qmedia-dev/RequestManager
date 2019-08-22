<?php

if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    return;
}
switch ($_GET['q']) {

    case 'request_comment':

        // Изменение комментария к заявке
        //$pk = $_POST['pk'];
        //$name = $_POST['name'];
        //$value = $_POST['value'];
		$modx->db->update(array('employee_comment'=>$_POST['value']),$modx->getFullTableName('requestmanager_table'), 'id IN ('.$_POST['pk'].')');

        // Вывод поступившей инфы в лог админки (для отладки)
        //$modx->logEvent(1, 1, json_encode($_POST['value'], JSON_UNESCAPED_UNICODE), 'request_comment');

        die();
        break;

    case 'request_status':

        // Изменение статуса заявки
        //$pk = $_POST['pk'];
        //$name = $_POST['name'];
        //$value = $_POST['value'];
		$modx->db->update(array('status'=>$_POST['value']),$modx->getFullTableName('requestmanager_table'), 'id IN ('.$_POST['pk'].')');

        // Вывод поступившей инфы в лог админки (для отладки)
       	//$modx->logEvent(1, 1, json_encode($_POST, JSON_UNESCAPED_UNICODE), 'request_status');

        die();
        break;

    default:
        die();
        break;
}
