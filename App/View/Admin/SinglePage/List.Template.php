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
                var url = "<?=\XHB2\URL($request->GetTranslate(), "Admin-SinglePage-List")?>"
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
                <div class="item"><a href="javascript:void(0);"><?=\XHB2\Translate($request->GetTranslate(), "GlobalSettings")?></a></div>
                <div class="split">/</div>
                <div class="item"><a href="javascript:void(0);"><?=\XHB2\Translate($request->GetTranslate(), "BasicSettings")?></a></div>
        </div>
</div>
<div class="XHB-nav-tab">
        <div class="list">
                <div class="item active">
                        <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-GlobalSetting-BaseSetting")?>"><?=\XHB2\Translate($request->GetTranslate(), "BasicSettings")?></a>
                </div>
        </div>
        <div class="bottom"></div>
</div>

<!-- body -->
<div class="admin">
        <div class="XHB-search">
                <div class="title">按条件筛选</div>
                <div class="data">
                        <div class="item">
                                <div class="XHB-input-lable">ID</div>
                                <div class="XHB-input-panel">
                                        <input name="Id" class="XHB-input-text" placeholder="<?=\XHB2\Translate($request->GetTranslate(), "BasicSettings")?>" value="<?=$request->GetParseUrlParam("Id")?>" />
                                </div>
                        </div>
                        <div class="item">
                                <div class="XHB-input-lable"><?=\XHB2\Translate($request->GetTranslate(), "SinglePageTitle")?></div>
                                <div class="XHB-input-panel">
                                        <input name="Title" class="XHB-input-text" placeholder="<?=\XHB2\Translate($request->GetTranslate(), "EnterSinglePageTitle")?>" value="<?=$request->GetParseUrlParam("Title")?>" />
                                </div>
                        </div>
                        <div class="item">
                                <div class="XHB-input-panel">
                                        <input type="button" name="reset" class="XHB-button-green" style="width: 100px;" value="重置">
                                </div>
                                <div class="XHB-input-panel">
                                        <input type="button" name="submit" class="XHB-button-green" style="width: 100px;" value="筛选">
                                </div>
                        </div>
                </div>
        </div>
        <div class="XHB-table">
                <div class="title">
                     <div class="item" style="width: 15%;">ID</div>
                     <div class="item" style="width: 30%;"><?=\XHB2\Translate($request->GetTranslate(), "SinglePageTitle")?></div>
                     <div class="item" style="width: 12%;"><?=\XHB2\Translate($request->GetTranslate(), "SinglePageStatus")?></div>
                     <div class="item" style="width: 12%;"><?=\XHB2\Translate($request->GetTranslate(), "SinglePageUpdateTime")?></div>
                     <div class="item"><?=\XHB2\Translate($request->GetTranslate(), "Operate")?></div>
                </div>
                <?php if(is_array($listData["ItemData"]) && count($listData["ItemData"]) > 0):?>
                <?php foreach($listData["ItemData"] as $val):?>
                <div class="data">
                        <div class="item" style="width: 15%;">
                                <div class="text"><?=$val["Id"]?></div>
                        </div>
                        <div class="item" style="width: 30%;">
                                <div class="text"><?=$val["Title"]?></div>
                        </div>
                        <div class="item" style="width: 12%;">
                                <div class="text"><?=$val["StatusString"]?></div>
                        </div>
                        <div class="item" style="width: 12%;">
                                <div class="text"><?=$val["UpdateTimeString"]?></div>
                        </div>
                        <div class="right">
                                <a href="<?=\XHB2\URL($request->GetTranslate(), "Web-SinglePage-Detail-{$val["Id"]}")?>" target="_blank" class="XHB-button-green-a">查看</a>
                                <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-SinglePage-Delete-{$val["Id"]}")?>" class="XHB-button-green-a">删除</a>
                                <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-SinglePage-Edit-{$val["Id"]}")?>" class="XHB-button-green-a">修改</a>
                        </div>
                </div>
                <?php endforeach;?>
                <?php else:?>
                        <div class="empty"><?=\XHB2\Translate($request->GetTranslate(), "NoData")?></div>
                <?php endif;?>
        </div>
        
        <?php if(is_array($listData["ItemData"]) && count($listData["ItemData"]) > 0):?>
        <div class="XHB-pagenate">
                <div class="container">
                        <a href="<?=$request->AppendUrlParams(["PageCurrtent"=>1])?>" class="page">首页</a>
                        <a href="<?=$request->AppendUrlParams(["PageCurrtent"=>$listData["PageCurrent"]-1])?>" class="page">上一页</a>
                        <a href="<?=$request->AppendUrlParams(["PageCurrtent"=>$listData["PageCurrent"]+1])?>" class="page">下一页</a>
                        <a href="<?=$request->AppendUrlParams(["PageCurrtent"=>$listData["PageTotal"]])?>" class="page">尾页</a>
                        <a href="javascript:void(0)" class="total">当前第 <?=$listData["PageCurrent"]?> 页, 共 <?=$listData["PageTotal"]?> 页</a>
                </div>
        </div>
        <?php endif;?>
</div>

<!-- //body -->
<?php include_once dirname(__DIR__)."/Common/Footer.Template.php";?>