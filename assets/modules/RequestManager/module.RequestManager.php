<?php

if (!defined('MODX_BASE_PATH')) {
    die('What are you doing? Get out of here!');
}

require_once MODX_BASE_PATH . 'assets/modules/RequestManager/class.RequestManager.php';

// TODO: заготовка под будующую конфигурацию (для передачи в Class)
$module_config = array();

//$module_config['property_name'] = $property_name;
// TODO: настроить правильный список свойств
// property_name — тестовое свойство из конфигурации модуля

$module = new RequestManager($modx, $module_config);

// генерируем фронт
$tpl = $module->getFileContents('main.html');

// плейсхолдеры для фронта
$placeholders = array(
    'theme'             => $module->theme,
    'module_id'         => $module->module_id,
    'module_url'        => $module->module_url,
    'jquery_path'       => $module->jquery_path,
    'items_output'    	=> $module->getItems()
);

$output = $modx->parseText($tpl, $placeholders);
echo $output;
