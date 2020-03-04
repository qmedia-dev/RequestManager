<?
$relative_path = '';
$formData = $data;

$files_arr = $FormLister->getFormData('files');
if (isset($files_arr['file']) && $files_arr['file']['error'] === 0) {
	$file_directory = 'assets/files/resume/';
	$filename = $FormLister->fs->takeFileName($files_arr['file']['name']);
	$format = $FormLister->fs->takeFileExt($files_arr['file']['name']);
	$filename = $modx->stripAlias($filename).'.'.$format;
	$filename = $FormLister->fs->getInexistantFilename($file_directory.$filename,true);
	if ($FormLister->fs->makeDir($file_directory) && copy($files_arr['file']['tmp_name'],$filename)) {
        $relative_path = $FormLister->fs->relativePath($filename);
        $FormLister->setField('path',$relative_path);
    }
}

$formData['more_info'][] = !empty($formData['domain']) ? 'Адрес сайта: '.$formData['domain'] : '';
$formData['more_info'][] = !empty($formData['comment']) ? 'Комментарий: '.$formData['comment'] : '';

$fields = array(
    'date'  => date('U'),
    'name' => $formData['name'],
    'email' => $formData['email'],
    'phone' => $formData['phone'],
    'comment' => implode('<br>',$formData['more_info']),
    'file' => $relative_path,
    'status' => 'opened'
);

$modx->db->insert($fields, $modx->getFullTableName('requestmanager_table'));
?>
