<?php include_once dirname(__DIR__)."/Common/Header.Template.php";?>
<style>
body { background-color: #06091a; }
.admin { width: 100%; float: left;}
</style>
<script>
$(function(){
        XHBInitSearch()
        XHBInitTable()
        InitSearch()
})
function InitSearch(){
        $("input[name=\"reset\"]").click(function(){
                $("input[name=\"Id\"]").val("")
                $("input[name=\"Title\"]").val("")
                $("input[name=\"submit\"]").click()
        })
        $("input[name=\"submit\"]").click(function(){
                var url = "<?=\XHB2\URL($request->GetTranslate(), "Admin-Navigation-List")?>"
                url += "-Id@@" + $("input[name=\"Id\"]").val()
                url += "-Title@@" + $("input[name=\"Title\"]").val()
                window.location.href = url
        })
}
</script>

<div class="XHB-nav-home">
        <div class="container">
                <div class="home"><?=\XHB2\Translate($request->GetTranslate(), "YourLocation")?>:</div>
                <div class="item"><a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-Main-Main")?>"><?=\XHB2\Translate($request->GetTranslate(), "SystemMainInterface")?></a></div>
                <div class="split">/</div>
                <div class="item"><a href="javascript:void(0);"><?=\XHB2\Translate($request->GetTranslate(), "NavigationManage")?></a></div>
                <div class="split">/</div>
                <div class="item"><a href="javascript:void(0);"><?=\XHB2\Translate($request->GetTranslate(), "NavigationList")?></a></div>
        </div>
</div>
<div class="XHB-nav-tab">
        <div class="list">
                <div class="item active">
                        <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-Navigation-List")?>"><?=\XHB2\Translate($request->GetTranslate(), "NavigationList")?></a>
                </div>
                <div class="item">
                        <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-Navigation-Add")?>"><?=\XHB2\Translate($request->GetTranslate(), "NavigationAdd")?></a>
                </div>
        </div>
        <div class="bottom"></div>
</div>

<!-- body -->
<div class="admin">
        <div class="XHB-table">
                <div class="title">
                     <div class="item" style="width: 30%;"><?=\XHB2\Translate($request->GetTranslate(), "NavigationTitle")?></div>
                     <div class="item" style="width: 30%;"><?=\XHB2\Translate($request->GetTranslate(), "NavigationLink")?></div>
                     <div class="item" style="width: 12%;"><?=\XHB2\Translate($request->GetTranslate(), "NavigationStatus")?></div>
                     <div class="item" style="width: 12%;"><?=\XHB2\Translate($request->GetTranslate(), "NavigationSort")?></div>
                     <div class="item"><?=\XHB2\Translate($request->GetTranslate(), "Operate")?></div>
                </div>
                <?php if(is_array($listData) && count($listData) > 0):?>
                <?php foreach($listData as $val):?>
                <div class="data">
                        <div class="item" style="width: 30%;">
                                <div class="text"><?=$val["Title"]?></div>
                        </div>
                        <div class="item" style="width: 30%; overflow: hidden;">
                                <div class="text"><?=$val["Link"]?></div>
                        </div>
                        <div class="item" style="width: 12%;">
                                <div class="text"><?=$val["StatusString"]?></div>
                        </div>
                        <div class="item" style="width: 10%;">
                                <div class="text"><?=$val["Sort"]?></div>
                        </div>
                        <div class="right">
                                <a href="<?=$val["Link"]?>" target="_blank" class="XHB-button-green-a">访问</a>
                                <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-Navigation-Delete-{$val["Id"]}")?>" class="XHB-button-green-a">删除</a>
                                <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-Navigation-Edit-{$val["Id"]}")?>" class="XHB-button-green-a">修改</a>
                        </div>
                </div>
                <?php endforeach;?>
                <?php else:?>
                <div class="empty">
                        <?=\XHB2\Translate($request->GetTranslate(), "NoData")?>
                        <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-Navigation-Add")?>"><?=\XHB2\Translate($request->GetTranslate(), "NavigationAdd")?></a>
                </div>
                <?php endif;?>
        </div>
        
</div>

<!-- //body -->
<?php include_once dirname(__DIR__)."/Common/Footer.Template.php";?>