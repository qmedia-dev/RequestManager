<?php

if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    return;
}
switch ($_GET['q']) {
    case 'comment':

        $pk = $_POST['pk'];
        $name = $_POST['name'];
        $value = $_POST['value'];

        if (!empty($value)) {
            echo ($_POST);
        } else {
            header('HTTP/1.0 400 Bad Request', true, 400);
            echo "This field is required!";
        }

        die();
        break;

    default:
        die();
        break;
}
