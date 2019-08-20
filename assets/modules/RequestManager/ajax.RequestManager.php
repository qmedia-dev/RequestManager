<?php

if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    return;
}
switch ($_GET['q']) {
    case 'comment':

        $pk = $_POST['pk'];
        $name = $_POST['name'];
        $value = $_POST['value'];
        echo ($_POST);

        die();
        break;

    default:
        die();
        break;
}
