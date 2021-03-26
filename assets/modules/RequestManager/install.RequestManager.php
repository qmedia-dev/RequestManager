<?php

if (!defined('MODX_BASE_PATH')) {
    die('What are you doing? Get out of here!');
}

/*
@author of original dzhuryn https://github.com/dzhuryn
*/

if ($modx->event->name == 'OnManagerPageInit') {
    $M = $modx->getFullTableName('site_modules');
    $MD = $modx->getFullTableName('site_module_depobj');
    $S = $modx->getFullTableName('site_snippets');
    $P = $modx->getFullTableName('site_plugins');
    $TV = $modx->getFullTableName('site_tmplvars');
    $CATS = $modx->getFullTableName('categories');

    //поиск и обновление модуля
    $value  = $modx->db->getValue($modx->db->select('id', $M, 'name="RequestManager"'));
    $moduleGuid  = $modx->db->getValue($modx->db->select('guid', $M, 'name="RequestManager"'));
    $moduleId =  $value;
    $fields = array('enable_sharedparams' => 1);
    $modx->db->update($fields, $M, 'id = "' . $moduleId . '"');

    // создание таблицы requestmanager_table в БД
    $createSQL = "
    CREATE TABLE IF NOT EXISTS " . $modx->getFullTableName('requestmanager_table') . " (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `date` varchar(255) NOT NULL DEFAULT '',
        `name` varchar(255) NOT NULL DEFAULT '',
        `email` varchar(255) NOT NULL DEFAULT '',
        `phone` varchar(255) NOT NULL DEFAULT '',
        `tarif` varchar(255) NOT NULL DEFAULT '',
        `price` varchar(255) NOT NULL DEFAULT '',
        `status` varchar(255) NOT NULL DEFAULT '',
        `person_number` varchar(255) NOT NULL DEFAULT '',
        `payment_link` varchar(255) NOT NULL DEFAULT '',
        `event` varchar(255) NOT NULL DEFAULT '',
        `event_id` varchar(255) NOT NULL DEFAULT '',
        `counter_fbc` varchar(255) NULL DEFAULT '',
        `counter_fbp` varchar(255) NULL DEFAULT '',
        `ip_user` varchar(255) NOT NULL DEFAULT '',
        `manager_comment` varchar(255) NOT NULL DEFAULT '',
        PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    $modx->db->query($createSQL);

    // добавление связей
    $snippets = array('RequestManagerSend');
    $plugins = array();

    foreach ($snippets as $snippet) {
        $snippetId  = $modx->db->getValue($modx->db->select('id', $S, 'name="' . $snippet . '"'));
        if (empty($snippetId)) {
            continue;
        }
        $value = $modx->db->getValue($modx->db->select('id', $MD, 'resource="' . $snippetId . '" AND module="' . $moduleId . '" AND type=40'));
        if (!empty($value)) {
            continue;
        }

        //запись в site_module_depobj
        $fields = array(
            'module' => $moduleId,
            'resource' => $snippetId,
            'type' => 40
        );
        $modx->db->insert($fields, $MD);
        //добавляем модуль в сниппет
        $fields = array('moduleguid' => $moduleGuid);
        $modx->db->update($fields, $S, 'id = "' . $snippetId . '"');
    }

    foreach ($plugins as $plugin) {
        $pluginId  = $modx->db->getValue($modx->db->select('id', $P, 'name="' . $plugin . '"'));
        if (empty($pluginId)) {
            continue;
        }
        //запись в site_module_depobj
        $value = $modx->db->getValue($modx->db->select('id', $MD, 'resource="' . $pluginId . '" AND module="' . $moduleId . '"  AND type=30'));
        if (!empty($value)) {
            continue;
        }
        $fields = array(
            'module' => $moduleId,
            'resource' => $pluginId,
            'type' => 30
        );
        $modx->db->insert($fields, $MD);
        //добавляем модуль в плагин
        $fields = array('moduleguid' => $moduleGuid);
        $modx->db->update($fields, $P, 'id = "' . $pluginId . '"');
    }

    // ID категории Qmedia
    $module_category = $modx->db->getValue($modx->db->select('id', $CATS, 'category="Qmedia"'));

    //удаляем плагин
    $pluginId  = $modx->db->getValue($modx->db->select('id', $P, 'name="RequestManagerInstall"'));
    if (!empty($pluginId)) {
        $modx->db->delete($P, "id = $pluginId");
        $modx->db->delete($modx->getFullTableName("site_plugin_events"), "pluginid=$pluginId");
    };
}
