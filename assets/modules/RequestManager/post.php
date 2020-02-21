<?php
$pk = $_POST['pk'];
$name = $_POST['name'];
$value = $_POST['value'];

if (!empty($value)) {
    $modx->logEvent(1, 3, json_encode($_POST, JSON_UNESCAPED_UNICODE), 'Request Manager');
    echo($_POST);
} else {
    $modx->logEvent(1, 1, json_encode($_POST, JSON_UNESCAPED_UNICODE), 'Request Manager');
    header('HTTP/1.0 400 Bad Request', true, 400);
    echo "This field is required!";
}
