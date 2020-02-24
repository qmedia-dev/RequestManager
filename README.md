# RequestManager

-- _Модуль для Evolution CMS_ --

Менеджер заявок пользователей сайта

## Состав пакета

| Компонент             | Тип     | Назначение                                                                                                                                       |
| :-------------------- | :------ | :----------------------------------------------------------------------------------------------------------------------------------------------- |
| RequestManager        | модуль  | Основной модуль для работы с заявками                                                                                                            |
| RequestManagerInstall | плагин  | Проводит автоматическую установку модуля, настрйоку зависимостей и создание нужных таблиц в БД.<br> **Самоудаляется после проведения установки** |
| RequestManagerAjax    | плагин  | Обработчик ajax-запросов внутри модуля Request Manager                                                                                           |
| RequestManagerSend    | сниппет | Обработчик данных, отправляемых через формы, вызванные сниппетом FormLister                                                                      |

## Установка

- установить пакет через личный кабинет Extras
- у обрабатываемых форм в вызове FormLister добавлять _`&prepareAfterProcess=RequestManagerSend`_
