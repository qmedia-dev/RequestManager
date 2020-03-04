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
		$this->date = new DateTime();

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

	public function checkFile($str,$name) {
		if(empty($str)) {
			return 'Файл не прикреплён.';
		}
		else {
			$tpl = RequestManager::getFileContents('file_item.html');
			$placeholders = array(
				'file_link'		=> $str
			);
			return $this->modx->parseText($tpl, $placeholders);
		}
	}

	public function getItems()
	{
		$items_select = $this->modx->db->select('*', $this->modx->getFullTableName('requestmanager_table'), '', 'id DESC');
		$items = array();
		while( $row = $this->modx->db->getRow( $items_select ) ) {
			if($row['status'] != 'deleted') {
				$tpl = RequestManager::getFileContents('item.html');
				$placeholders = array(
					'id'				=> $row['id'],
					'date'				=> RequestManager::DateFormat($row['date']),
					'name'				=> $row['name'],
					'email'				=> $row['email'],
					'phone'				=> $row['phone'],
					'comment'			=> $row['comment'],
					'manager_comment'	=> $row['manager_comment'],
					'status'			=> $row['status'],
					'check_file'		=> RequestManager::checkFile($row['file'],$row['name'])
				);
				array_push($items, $this->modx->parseText($tpl, $placeholders));
			}
		}
		$output = implode('',$items);
		return $output;
	}

	public function DateFormat($unix_date,$mask = 'd.m.Y')
	{
		$date = $this->date->createFromFormat('U', $unix_date);

		return $date->format($mask);
	}
}
