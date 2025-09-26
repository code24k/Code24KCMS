<?php
require_once "../Framework/XHB2Framework.php";
date_default_timezone_set("Asia/Shanghai");
header("Content-type: text/html; charset=utf-8");
$application = new \XHB2\Application();
$configTranslate = \XHB2\Config("Translate");
$application->SetDefaultLanguage(is_array($configTranslate) && array_key_exists("Default", $configTranslate) ? $configTranslate["Default"] : "English");
$application->Run();
?>