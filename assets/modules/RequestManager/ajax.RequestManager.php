<?php

if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    return;
}
switch ($_GET['q']) {

    case 'request_comment':
        $modx->db->update(array('manager_comment' => $_POST['value']), $modx->getFullTableName('requestmanager_table'), 'id IN (' . $_POST['pk'] . ')');
        die();
        break;

    case 'request_status':
        $modx->db->update(array('status' => $_POST['value']), $modx->getFullTableName('requestmanager_table'), 'id IN (' . $_POST['pk'] . ')');
		
		// отправка сообщения после оплаты
		if($_POST['value'] === 'paid') {
			$result = $modx->db->query('Select * From '.$modx->getFullTableName('requestmanager_table').' Where id in ('.$_POST['pk'].')');
			while($row = $modx->db->getRow($result)) {
				$data = $row;
			}

			if(!empty($data['email'])) {
				$data['event_description'] = $modx->runSnippet('DocInfo', ['docid' => $data['event_id'], 'field' => 'event_description']);
				$data['event_hashtag'] = $modx->runSnippet('DocInfo', ['docid' => $data['event_id'], 'field' => 'event_hashtag']);
				$data['paid_subject'] = $modx->runSnippet('DocInfo', ['docid' => $data['event_id'], 'field' => 'paid_subject']);
				$data['mail_paid_ccSender'] = $modx->runSnippet('DocInfo', ['docid' => $data['event_id'], 'field' => 'mail_paid_ccSender']);
				
				$param = array(
					'from' => $modx->config['client_from'],
					'to' => $data['email'],
					'subject' => $data['paid_subject'],
					'body' => $modx->parseDocumentSource(
						$modx->parseChunk(
							'NEW_paid--ccSenderTpl',
							$data,
							$prefix = '[+',
							$suffix = '+]'
						)
					)
				);
				$rs = $modx->sendmail($param);
				
				$param['to'] = $modx->config['client_to'];
				$param['subject'] = 'Re: '.$param['subject'];
				$rs = $modx->sendmail($param);
			}
		}
		// end
		
        die();
        break;
	case 'export-csv':
		$filename = 'export-requests_'.date("d.m.y_H.i").'.csv';
		$filepath = MODX_BASE_PATH.'assets/export/'.$filename;
		$filelink = $modx->config['site_url'].'assets/export/'.$filename;
		
        $data_query = $modx->db->select('*', $modx->getFullTableName('requestmanager_table'), '', 'id ASC');
		$fp = fopen($filepath, 'w');

        while ($row = $modx->db->getRow($data_query)){
            fputcsv($fp, $row, ';', '"');
        }
		
        fclose($fp);
        unset($fp);
		
        header("Content-type: application/text; charset=windows-1251");
        header("Content-Disposition: attachment; filename=".$filename);

        $fp = fopen($filepath, "r");
        $fcontent = fread($fp, filesize($filepath));
        fclose($fp);

        if($modx->config['modx_charset'] == "UTF-8"){
            $fcontent = iconv('UTF-8','cp1251',$fcontent);
        }
		
        echo json_encode(array(
			'status' => true,
			'link' => $filelink
		));
		die();
		break;


    default:
        break;
}
