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
                        "Title": $("input[name=\"Title\"]").val(),
                        "Keywords": $("input[name=\"Keywords\"]").val(),
                        "Description": $("textarea[name=\"Description\"]").val(),
                        "Status": $("input[name=\"Status\"]:checked").val(),
                }
                $.post("<?=\XHB2\URL($request->GetTranslate(), "Admin-ProductCategory-Edit")?>", EncodeJson(param), function(data){
                        var result = DecodeData(data)
                        result.Text = "<?=\XHB2\Translate($request->GetTranslate(), "OK")?>"
                        XHBMessageToast(result)
                        if(result.Code === 0){
                                return
                        }
                })
        })
})
</script>

<div class="XHB-nav-home">
        <div class="container">
                <div class="home">
                        <a href="javascript:void(0)" onclick="window.location.href=document.referrer">[<?=\XHB2\Translate($request->GetTranslate(), "GoBack")?>]</a>
                        <?=\XHB2\Translate($request->GetTranslate(), "YourLocation")?>:
                </div>
                <div class="item"><a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-Main-Main")?>"><?=\XHB2\Translate($request->GetTranslate(), "SystemMainInterface")?></a></div>
                <div class="split">/</div>
                <div class="item"><a href="javascript:void(0);"><?=\XHB2\Translate($request->GetTranslate(), "ProductCategoryManage")?></a></div>
                <div class="split">/</div>
                <div class="item"><a href="javascript:void(0);"><?=\XHB2\Translate($request->GetTranslate(), "ProductCategoryEdit")?></a></div>
        </div>
</div>
<div class="XHB-nav-tab">
        <div class="list">
                <div class="item active">
                        <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-ProductCategory-Edit")?>"><?=\XHB2\Translate($request->GetTranslate(), "ProductCategoryEdit")?></a>
                </div>
        </div>
        <div class="bottom"></div>
</div>


<!-- body -->
<div class="admin">
        <div class="XHB-form">
                <div class="title"><?=\XHB2\Translate($request->GetTranslate(), "BasicSettings")?></div>
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
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ProductCategoryTitle")?></div>
                                <div class="XHB-input-panel">
                                        <input type="text" name="Title" class="XHB-input-text" placeholder="<?=\XHB2\Translate($request->GetTranslate(), "PleaseEnterProductCategoryTitle")?>" value="<?=$detail["Title"]?>" />
                                </div>
                                <div class="XHB-input-mark">*<?=\XHB2\Translate($request->GetTranslate(), "RequiredFields")?></div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ProductCategoryKeywords")?></div>
                                <div class="XHB-input-panel">
                                        <input type="text" name="Keywords" class="XHB-input-text" placeholder="<?=\XHB2\Translate($request->GetTranslate(), "PleaseEnterPageKeywords")?>" value="<?=$detail["Keywords"]?>" />
                                </div>
                                <div class="XHB-input-mark"><?=\XHB2\Translate($request->GetTranslate(), "ProductCategoryKeywordsDesc")?></div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ProductCategoryDescription")?></div>
                                <div class="XHB-input-panel">
                                        <textarea id="textarea" name="Description" class="XHB-input-textarea" style="height: 60px; width:400px;" placeholder="<?=\XHB2\Translate($request->GetTranslate(), "PleaseEnterProductCategoryDescription")?>"><?=$detail["Description"]?></textarea>
                                </div>
                                <div class="XHB-input-mark"><?=\XHB2\Translate($request->GetTranslate(), "ProductCategoryDescriptionDesc")?></div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ProductCategoryStatus")?></div>
                                <div class="XHB-input-panel">
                                        <label class="XHB-input-radio-signal">
                                                <input type="radio" name="Status" class="XHB-input-radio" value="1" <?php if($detail["Status"]=="1"):?>checked<?php endif;?> /> <?=\XHB2\Translate($request->GetTranslate(), "On")?>
                                        </label>
                                        <label class="XHB-input-radio-signal">
                                                <input type="radio" name="Status" class="XHB-input-radio" value="2" <?php if($detail["Status"]=="2"):?>checked<?php endif;?> /> <?=\XHB2\Translate($request->GetTranslate(), "Off")?>
                                        </label>
                                </div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable" style="width: 200px;">&nbsp;</div>
                                <div class="XHB-input-panel">
                                        <input type="button" name="Submit" class="XHB-button-green" style="width: 150px;" value="<?=\XHB2\Translate($request->GetTranslate(), "OK")?>" />
                                </div>
                        </div>
                </div>
        </div>
</div>

<!-- //body -->
<?php include_once dirname(__DIR__)."/Common/Footer.Template.php";?>