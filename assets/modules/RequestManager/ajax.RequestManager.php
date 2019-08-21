<?php

if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    return;
}
switch ($_GET['q']) {

    case 'request_comment':

        // Изменение комментария к заявке
        $pk = $_POST['pk'];
        $name = $_POST['name'];
        $value = $_POST['value'];

        // Вывод поступившей инфы в лог админки (для отладки)
        $modx->logEvent(1, 1, json_encode($_POST, JSON_UNESCAPED_UNICODE), 'request_comment');

        die();
        break;

    case 'request_status':

        // Изменение статуса заявки
        $pk = $_POST['pk'];
        $name = $_POST['name'];
        $value = $_POST['value'];

        // Вывод поступившей инфы в лог админки (для отладки)
        $modx->logEvent(1, 1, json_encode($_POST, JSON_UNESCAPED_UNICODE), 'request_status');

        die();
        break;

    default:
        die();
        break;
}
