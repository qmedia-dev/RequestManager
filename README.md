# RequestManager

-- _Модуль для Evolution CMS_ --

Менеджер заявок пользователей сайта

## Установка
* скопировать папку _assets_ в корень сайта
* в вызове formlister добавить _`&prepareAfterProcess=SendRequest`_
* содержимое SendRequest:
```php
/*
file - name поля формы, где прикреплён файл
path - name поля формы, куда будет записан относительный путь к скопированному файлу
*/

$relative_path = '';
$files_arr = $FormLister->getFormData('files');
if (isset($files_arr['file']) && $files_arr['file']['error'] === 0) {
	$file_directory = 'assets/files/'; //путь для сохранения прикреплённого файла
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
    'поле_таблицы'  => 'значение_поля_таблицы',
);
$modx->db->insert($fields, $modx->getFullTableName('название_таблицы'));
```
* ...
