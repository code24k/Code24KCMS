<?php include_once dirname(__DIR__)."/Common/Header.Template.php";?>
<link href="/CSS/product.css" media="all" type="text/css" rel="stylesheet">

<div id="location">
    <div class="body">
        您所在的位置：<a href="/">网站首页</a> &gt;&gt;
        <a href="<?=\XHB2\URL($request->GetTranslate(), "Web-Article-Index")?>">网站首页</a>
    </div>
</div>

<div id="product">
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
            <div class="gtitle">产品</div>
            <div class="con">
                <ul>
                    <?php if(is_array($listData["ItemData"]) && count($listData["ItemData"])):?>
                <?php foreach ($listData["ItemData"] as $val):?>
                    <li>
                        <span class="pic">
                            <a href="<?=\XHB2\URL($request->GetTranslate(), "Web-Product-Detail-".(array_key_exists("Id", $val)?$val["Id"]:""))?>" target="_blank" title="<?=$val["Title"]?>">
                                <img src="<?=$val["CoverImage"]?>" />
                            </a>
                        </span>
                        <span class="name"><a href="<?=\XHB2\URL($request->GetTranslate(), "Web-Product-Detail-".(array_key_exists("Id", $val)?$val["Id"]:""))?>"><?=$val["Title"]?></a></span>
                    </li>
                    <?php endforeach;?>
                    <?php endif;?>
                </ul>
                <div class="pagenate">
                    <div class="container">
                        <a href="<?=$request->AppendUrlParams(["PageCurrtent"=>1])?>" class="page"><?=\XHB2\Translate($request->GetTranslate(), "PageFirst")?></a>
                        <a href="<?=$request->AppendUrlParams(["PageCurrtent"=>$listData["PageCurrent"]-1])?>" class="page">上一页</a>
                        <a href="<?=$request->AppendUrlParams(["PageCurrtent"=>$listData["PageCurrent"]+1])?>" class="page">下一页</a>
                        <a href="<?=$request->AppendUrlParams(["PageCurrtent"=>$listData["PageTotal"]])?>" class="page">尾页</a>
                        <a href="javascript:void(0)" class="total">当前第 <?=$listData["PageCurrent"]?> 页, 共 <?=$listData["PageTotal"]?> 页</a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php include_once dirname(__DIR__)."/Common/Footer.Template.php";?> 