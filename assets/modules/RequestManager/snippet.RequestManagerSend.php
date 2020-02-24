<?
$relative_path = '';
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

$fields = array(
    'date'  => date('Y/m/d'),
    'name' => $data['name'],
    'email' => $data['email'],
    'phone' => $data['phone'],
    'comment' => $data['comment'],
    'file' => $relative_path,
    'status' => 'opened'
);
$modx->db->insert($fields, $modx->getFullTableName('requestmanager_table'));
?>
