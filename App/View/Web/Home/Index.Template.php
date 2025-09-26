<?php include_once dirname(__DIR__)."/Common/Header.Template.php";?>
    
    <div id="productHot">
        <div class="body">
            <div class="gtitle">最新产品</div>
            <div class="con">
                <div>
                    <?php if(is_array($productListNew15) && count($productListNew15)):?>
                    <?php foreach ($productListNew15 as $val):?>
                        <div class="item">
                            <div class="image">
                                <a href="<?=\XHB2\URL($request->GetTranslate(), "Web-Product-Detail-".$val["Id"])?>" target="_blank" title="<?=$val["Title"]?>"><img src="<?=$val["CoverImage"]?>" /></a>
                            </div>
                            <div class="title">
                                <a href="<?=\XHB2\URL($request->GetTranslate(), "Web-Product-Detail-".$val["Id"])?>" target="_blank" title="<?=$val["Title"]?>"><?=$val["Title"]?></a>
                            </div>
                        </div>
                    <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
    
<?php include_once dirname(__DIR__)."/Common/Footer.Template.php";?> 