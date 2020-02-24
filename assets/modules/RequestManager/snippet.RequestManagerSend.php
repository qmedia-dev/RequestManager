<?
$relative_path = '';
$files_arr = $FormLister->getFormData('files');
if (isset($files_arr['resume__file']) && $files_arr['resume__file']['error'] === 0) {
	$file_directory = 'assets/files/resume/';
	$filename = $FormLister->fs->takeFileName($files_arr['resume__file']['name']);
	$format = $FormLister->fs->takeFileExt($files_arr['resume__file']['name']);
	$filename = $modx->stripAlias($filename).'.'.$format;
	$filename = $FormLister->fs->getInexistantFilename($file_directory.$filename,true);
	if ($FormLister->fs->makeDir($file_directory) && copy($files_arr['resume__file']['tmp_name'],$filename)) {
        $relative_path = $FormLister->fs->relativePath($filename);
        $FormLister->setField('resume__path',$relative_path);
    }
}

$fields = array(
    'date'  => date('Y/m/d'),
    'city' => $data['resume__city'],
    'vacancy'  => $data['resume__pagetitle'],
    'name' => $data['resume__name'],
    'email' => $data['resume__email'],
    'phone' => $data['resume__phone'],
    'comment' => $data['resume__comment'],
    'file' => $relative_path,
    'employee_comment' => '',
    'status' => 'opened'
);
$modx->db->insert($fields, $modx->getFullTableName('requestmanager_table'));
?>
