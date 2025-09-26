<?php include_once dirname(__DIR__)."/Common/Header.Template.php";?>
<link href="/CSS/article.css" media="all" type="text/css" rel="stylesheet">

<div id="location">
    <div class="body">
        您所在的位置：<a href="/">网站首页</a> &gt;&gt;
        <a href="<?=\XHB2\URL($request->GetTranslate(), "Web-Product-Index")?>">产品</a> &gt;&gt;
        <a href="<?=\XHB2\URL($request->GetTranslate(), "Web-Product-Detail-".(array_key_exists("Id", $detail)?$detail["Id"]:""))?>" title="<?=array_key_exists("Title", $detail)?$detail["Title"]:""?>">
            <?=array_key_exists("Title", $detail)?$detail["Title"]:""?>
        </a>
    </div>
</div>

<div id="article">
    <div class="body">
        <div class="left">
            <div class="productRecomm">
                 <div class="gtitle">产品分类</div>
                <div class="con">
                    <ul>
                        <?php if(is_array($getListArray) && count($getListArray)):?>
                        <?php foreach ($getListArray as $val):?>
                        <li><a href="<?=\XHB2\URL($request->GetTranslate(), "Web-Article-Detail-".(array_key_exists("Id", $val)?$val["Id"]:""))?>" title="<?=$val["Title"]?>" target="_blank"><?=$val["Title"]?></a></li>
                        <?php endforeach;?>
                        <?php endif;?>
                    </ul>
                </div>
            </div>
            <div class="contact">
                <div class="gtitle">联系我们</div>
                <div class="con">
                    <a href="<?=\XHB2\URL($request->GetTranslate(), "Web-SinglePage-Detail-1000002")?>">
                        <img src="/Image/contactus2.jpg" />
                    </a>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="gtitle"><?=array_key_exists("Title", $detail)?$detail["Title"]:""?></div>
            <div class="con">
                <div class="artTitle">
                    <a href="<?=\XHB2\URL($request->GetTranslate(), "Web-Product-Detail-".(array_key_exists("Id", $detail)?$detail["Id"]:""))?>" title="<?=array_key_exists("Title", $detail)?$detail["Title"]:""?>">
                        <?=array_key_exists("Title", $detail)?$detail["Title"]:""?>
                    </a>
                </div>
                <div class="artContent">
                    <?=array_key_exists("Content", $detail)?$detail["Content"]:""?>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php include_once dirname(__DIR__)."/Common/Footer.Template.php";?> 