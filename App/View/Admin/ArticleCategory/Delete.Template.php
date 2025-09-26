<?php include_once dirname(__DIR__)."/Common/Header.Template.php";?>
<style>
body { background-color: #06091a; }
.admin { width: 100%; float: left;}
</style>
<script>
$(function(){
        XHBInitForm()
        $("input[name=\"Submit\"]").click(function(){
                var param={
                        "Id": "<?=$detail["Id"]?>",
                }
                $.post("<?=\XHB2\URL($request->GetTranslate(), "Admin-ArticleCategory-Delete")?>", EncodeJson(param), function(data){
                        var result = DecodeData(data)
                        result.Text = "<?=\XHB2\Translate($request->GetTranslate(), "OK")?>"
                        XHBMessageToast(result)
                        if(result.Code === 0){
                                return
                        }
                        window.location.href=document.referrer
                })
        })
})
</script>

<div class="XHB-nav-home">
        <div class="container">
                <div class="home">
                        <a href="javascript:void(0)" onclick="window.history.back()">[<?=\XHB2\Translate($request->GetTranslate(), "GoBack")?>]</a>
                        <?=\XHB2\Translate($request->GetTranslate(), "YourLocation")?>:
                </div>
                <div class="item"><a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-Main-Main")?>"><?=\XHB2\Translate($request->GetTranslate(), "SystemMainInterface")?></a></div>
                <div class="split">/</div>
                <div class="item"><a href="javascript:void(0);"><?=\XHB2\Translate($request->GetTranslate(), "ArticleCategoryManage")?></a></div>
                <div class="split">/</div>
                <div class="item"><a href="javascript:void(0);"><?=\XHB2\Translate($request->GetTranslate(), "ArticleCategoryDelete")?></a></div>
        </div>
</div>
<div class="XHB-nav-tab">
        <div class="list">
                <div class="item active">
                        <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-ArticleCategory-Delete")?>"><?=\XHB2\Translate($request->GetTranslate(), "ArticleCategoryDelete")?></a>
                </div>
        </div>
        <div class="bottom"></div>
</div>


<!-- body -->
<div class="admin">
        <div class="XHB-form">
                <div class="title"><?=\XHB2\Translate($request->GetTranslate(), "ArticleCategoryDelete")?></div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "CurrentLanguage")?></div>
                                <div class="XHB-input-panel">
                                        <div class="XHB-input-mark"><?=$request->GetTranslate()?></div>
                                </div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ArticleCategoryId")?></div>
                                <div class="XHB-input-panel">
                                        <?=$detail["Id"]?>
                                </div>
                                <div class="XHB-input-mark">&nbsp;</div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ArticleCategoryTitle")?></div>
                                <div class="XHB-input-panel">
                                        <?=$detail["Title"]?>
                                </div>
                                <div class="XHB-input-mark">&nbsp;</div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "DeleteConfirmTitle")?></div>
                                <div class="XHB-input-panel">
                                        <?=\XHB2\Translate($request->GetTranslate(), "DeleteConfirmDesc")?>
                                </div>
                                <div class="XHB-input-mark">&nbsp;</div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable" style="width: 200px;">&nbsp;</div>
                                <div class="XHB-input-panel">
                                        <input type="button" name="Submit" class="XHB-button-green" value="<?=\XHB2\Translate($request->GetTranslate(), "DeleteConfirmSubmit")?>" />
                                </div>
                        </div>
                </div>
        </div>
</div>

<!-- //body -->
<?php include_once dirname(__DIR__)."/Common/Footer.Template.php";?>