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

	public function checkFile($str,$name,$modx) {
		if(empty($str)) {
			return 'Файла нет.';
		}
		else {
			$tpl = RequestManager::getFileContents('file_item.html');
			$placeholders = array(
				'file_link'		=> $str
			);
			return $modx->parseText($tpl, $placeholders);
		}
	}

	public function getItems($modx)
	{
		$items_select = $modx->db->select('*', $modx->getFullTableName('requestmanager_table'), '', 'id DESC');
		while( $row = $modx->db->getRow( $items_select ) ) {
			if($row['status'] != 'deleted') {
				$tpl = RequestManager::getFileContents('item.html');
				$placeholders = array(
					'id'				=> $row['id'],
					'date'				=> $row['date'],
					'name'				=> $row['name'],
					'email'				=> $row['email'],
					'phone'				=> $row['phone'],
					'comment'			=> $row['comment'],
					'manager_comment'	=> $row['manager_comment'],
					'status'			=> $row['status'],
					'check_file'		=> RequestManager::checkFile($row['file'],$row['name'],$modx)
				);
				$items[] = $modx->parseText($tpl, $placeholders);
				$modx->logEvent(1, 1, json_encode($items, JSON_UNESCAPED_UNICODE), 'Request Manager');
			}
		}
		$output = implode('',$items);
		return $output;
	}
}
