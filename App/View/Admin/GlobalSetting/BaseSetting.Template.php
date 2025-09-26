<?php include_once dirname(__DIR__)."/Common/Header.Template.php";?>
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

<style>
body { background-color: #06091a; }
.admin { width: 100%; float: left;}
</style>
<script>
        $(function(){
                XHBInitForm()
                GetGlobalSetting();
                $("input[name=\"Submit\"]").click(function(){
                        var param={
                                "WebsiteName": $("input[name=\"WebsiteName\"]").val(),
                                "WebsiteKeywords": $("input[name=\"WebsiteKeywords\"]").val(),
                                "WebsiteDescription": $("textarea[name=\"WebsiteDescription\"]").val(),
                                "WebsiteStatus": $("input[name=\"WebsiteStatus\"]:checked").val(),
                        }
                        $.post("<?=\XHB2\URL($request->GetTranslate(), "Admin-GlobalSetting-BaseSetting")?>", EncodeJson(param), function(data){
                                var result = DecodeData(data)
                                XHBMessageToast({"Message":result.Message, "OK":"<?=\XHB2\Translate($request->GetTranslate(), "OK")?>"})
                                if(result.Code === 0){
                                        return
                                }
                                XHBMessageToastReload()
                        })
                })
        })
        function GetGlobalSetting(){
                $.post("<?=\XHB2\URL($request->GetTranslate(), "Admin-GlobalSetting-GetDetail")?>", EncodeJson({}), function(data){
                        var result = DecodeData(data)
                        console.log(result)
                        if(result.Code === 0){
                                XHBMessageToastAuto({Message:result.Message})
                                return
                        }
                        $("input[name=\"WebsiteName\"]").val(result.Data.WebsiteName)
                        $("input[name=\"WebsiteKeywords\"]").val(result.Data.WebsiteKeywords)
                        $("textarea[name=\"WebsiteDescription\"]").val(result.Data.WebsiteDescription)
                        $("input[name=\"WebsiteStatus\"][value=\""+result.Data.WebsiteStatus+"\"]").prop("checked", true);
                })
        }
</script>
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
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "WebsiteName")?></div>
                                <div class="XHB-input-panel">
                                        <input type="text" name="WebsiteName" class="XHB-input-text" placeholder="<?=\XHB2\Translate($request->GetTranslate(), "PleaseEnterWebsiteName")?>" />
                                </div>
                                <div class="XHB-input-mark">*<?=\XHB2\Translate($request->GetTranslate(), "RequiredFields")?></div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "WebsiteKeywords")?></div>
                                <div class="XHB-input-panel">
                                        <input type="text" name="WebsiteKeywords" class="XHB-input-text" placeholder="<?=\XHB2\Translate($request->GetTranslate(), "PleaseEnterWebsiteKeywords")?>" />
                                </div>
                                <div class="XHB-input-mark"><?=\XHB2\Translate($request->GetTranslate(), "PleaseEnterWebsiteKeywordsDesc")?></div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "WebsiteIntroduction")?></div>
                                <div class="XHB-input-panel">
                                        <textarea id="textarea" name="WebsiteDescription" class="XHB-input-textarea" style="height: 60px; width:400px;"></textarea>
                                </div>
                                <div class="XHB-input-mark"><?=\XHB2\Translate($request->GetTranslate(), "WebsiteIntroductionDesc")?></div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "SiteStatus")?></div>
                                <div class="XHB-input-panel">
                                        <label class="XHB-input-radio-signal">
                                                <input type="radio" name="WebsiteStatus" class="XHB-input-radio" value="1" checked /> <?=\XHB2\Translate($request->GetTranslate(), "On")?>
                                        </label>
                                        <label class="XHB-input-radio-signal">
                                                <input type="radio" name="WebsiteStatus" class="XHB-input-radio" value="2" /> <?=\XHB2\Translate($request->GetTranslate(), "Off")?>
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