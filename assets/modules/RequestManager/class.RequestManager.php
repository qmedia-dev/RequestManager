<?php

if (!defined('MODX_BASE_PATH')) {
    die('What are you doing? Get out of here!');
}

class RequestManager
{
    public function __construct($modx, $config)
    {
        $this->modx = $modx;
        $this->config = $config;

        $this->module_id        = (int) $_GET['id'];
        $this->module_url       = 'index.php?a=112&id=' . $this->moduleid;
        $this->base_path        = $this->modx->config['base_url'];
        $this->theme            = $this->modx->config['manager_theme'] ? $this->modx->config['manager_theme'] : 'default';
        $this->jquery_path      = $this->modx->config['mgr_jquery_path'] ? $this->modx->config['mgr_jquery_path'] : 'media/script/jquery/jquery.min.js';
    }

    public function getFileContents($file)
    {
        if (empty($file)) {
            return false;
        } else {
            $file = MODX_BASE_PATH . 'assets/modules/RequestManager/templates/' . $file;
            $contents = file_get_contents($file);
            return $contents;
        }
    }
}
