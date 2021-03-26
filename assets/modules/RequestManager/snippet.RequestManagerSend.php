<?php
$formData = $data;

$fields = array(
	'date'  => date('U'),
	'name' => $formData['your-name'],
	'email' => $formData['your-email'],
	'phone' => $formData['your-phone'],
	'tarif' => $formData['your-tarif'],
	'price' => $formData['event-price'],
	'status' => 'new',
	'manager_comment' => '',
	'person_number' => $formData['person_number'],
	'person_number_link' => $formData['pdf_link'],
	'payment_link' => $formData['payment_link'],
	'counter_fbc' => $formData['counter_fbc'],
	'counter_fbp' => $formData['counter_fbp'],
	'ip_user' => $formData['ip_user']
);

$event_page_id = (int)$data['event-id'];
//$event_title = $modx->getTemplateVar(9, '*', $event_page_id)['value'];
$event_title = $modx->getDocument($event_page_id)['pagetitle'];
$fields['event'] = $event_title;
$fields['event_id'] = $event_page_id;

$modx->db->insert($fields, $modx->getFullTableName('requestmanager_table'));

unset($event);
?>
