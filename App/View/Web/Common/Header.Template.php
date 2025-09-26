<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=\XHB2\Response::Instance()->GetSeoTitle()?></title>
<meta name="keywords" content="<?=\XHB2\Response::Instance()->GetSeoKeywords()?>">
<meta name="description" content="<?=\XHB2\Response::Instance()->GetSeoDescription()?>">
<link href="/CSS/base.css?v=130" media="all" type="text/css" rel="stylesheet">
<link href="/CSS/index.css?v=130" media="all" type="text/css" rel="stylesheet">

</head>

<body>
    <div id="head">
        <div class="body">
                <div class="logo">
                        <a href="/" class="text" title="<?=\XHB2\Response::Instance()->GetWebsiteTitle()?>">
                            <?=\XHB2\Response::Instance()->GetWebsiteTitle()?>
                        </a>
                </div>
                <div class="search">
                    <div class="action">
                        <form method="get" action="">
                        <div class="sinput">
                            <input type="text" name="keywords" value="" placeholder="请输入搜索关键词" />
                        </div>
                        <div class="ssubmit" onclick="submit();">搜索</div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
    <!-- //head -->
    
    <div id="nav">
        <div class="body">
            <ul>
                <?php $navigationModel = new \App\Model\NavigationModel();?>
                <?php $navigationList = $navigationModel->List($request);?>
                <?php if(is_array($navigationList) && count($navigationList)):?>
                <?php foreach($navigationList as $val):?>
                    <li <?php if($val["Link"] == "/"):?>class="li_selected"<?php endif;?>>
                        <a href="<?=$val["Link"]?>"><?=$val["Title"]?></a>
                    </li>
                <?php endforeach;?>
                <?php endif;?>
            </ul>
        </div>
    </div>
    
    <div id="foucs">
        <div id="box">
            <ul id="list">
                <li><a href="#"><img src="/Image//Focus1.png" /></a></li>
            </ul>
        </div>
    </div>