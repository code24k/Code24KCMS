<?php
return [
    /**
     * 默认网站打开使用翻译文件
     * 除英文和中文外语言为网友翻译提供，感谢网友的无私付出。
     * 
     * 支持翻译文件参数对照表
     * 英文(English)
     * 简体中文(SimplifiedChinese)
     * 繁体中文(TraditionalChinese)
     */
    "Default" => "English",
    /**
     * 网站支持可选翻译文件
     * 如需修改翻译，请前往/APP/Translate目录找到对应的翻译文件修改即可。
     * 如需新增翻译，新增Name.Translate.php同时将路由的翻译参数更改为Name即可。
     * 例如英文路由/?English-Web-Main-Index，新增翻译访问为/?Name-Web-Main-Index
     * 新增翻译时，请将Name加入下方"Support"数组中以允许路由正常翻译。
     */
    "Support" => ["English", "SimplifiedChinese", "TraditionalChinese"]
];
?>