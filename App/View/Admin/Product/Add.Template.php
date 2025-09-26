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
                        "Title": $("input[name=\"Title\"]").val(),
                }
                $.post("<?=\XHB2\URL($request->GetTranslate(), "Admin-Product-Add")?>", EncodeJson(param), function(data){
                        var result = DecodeData(data)
                        result.Text = "<?=\XHB2\Translate($request->GetTranslate(), "OK")?>"
                        XHBMessageToast(result)
                        if(result.Code === 0){
                                return
                        }
                        var url = "<?=\XHB2\URL($request->GetTranslate(), "Admin-Product-Second")?>"
                        url += "-Id@@" + result.Data.Id
                        window.location.href = url
                })
        })
})
</script>

<div class="XHB-nav-home">
        <div class="container">
                <div class="home"><?=\XHB2\Translate($request->GetTranslate(), "YourLocation")?>:</div>
                <div class="item"><a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-Main-Main")?>"><?=\XHB2\Translate($request->GetTranslate(), "SystemMainInterface")?></a></div>
                <div class="split">/</div>
                <div class="item"><a href="javascript:void(0);"><?=\XHB2\Translate($request->GetTranslate(), "ProductManage")?></a></div>
                <div class="split">/</div>
                <div class="item"><a href="javascript:void(0);"><?=\XHB2\Translate($request->GetTranslate(), "ProductAdd")?></a></div>
        </div>
</div>
<div class="XHB-nav-tab">
        <div class="list">
                <div class="item active">
                        <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-Product-Add")?>"><?=\XHB2\Translate($request->GetTranslate(), "ProductAdd")?></a>
                </div>
        </div>
        <div class="bottom"></div>
</div>


<!-- body -->
<div class="admin">
        <div class="XHB-form">
                <div class="title"><?=\XHB2\Translate($request->GetTranslate(), "ProductAdd")?></div>
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
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ProductTitle")?></div>
                                <div class="XHB-input-panel">
                                        <input type="text" name="Title" class="XHB-input-text" placeholder="<?=\XHB2\Translate($request->GetTranslate(), "PleaseEnterProductTitle")?>" />
                                </div>
                                <div class="XHB-input-mark">*<?=\XHB2\Translate($request->GetTranslate(), "RequiredFields")?></div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable" style="width: 200px;">&nbsp;</div>
                                <div class="XHB-input-panel">
                                        <input type="button" name="Submit" class="XHB-button-green" style="width: 150px;" value="<?=\XHB2\Translate($request->GetTranslate(), "ConfirmAndNext")?>" />
                                </div>
                        </div>
                </div>
        </div>
</div>

<!-- //body -->
<?php include_once dirname(__DIR__)."/Common/Footer.Template.php";?>