<?php include_once dirname(__DIR__)."/Common/Header.Template.php";?>
<style>
body { background-color: #06091a; }
.admin { width: 100%; float: left;}
</style>
<script type="text/javascript" charset="utf-8" src="/Js/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/Js/ueditor/ueditor.api.js"></script>
<script>
$(function(){
        var ue = UE.getEditor("editor", {
        enableAutoSave: false,
        toolbars: [
                        [
                        'source', '|','bold', 'italic', 'underline', 'strikethrough', '|',
                        'fontfamily', 'fontsize', '|', 'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
                        'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                        'simpleupload', 'insertvideo'
                        ]
                ]
        });
        XHBInitForm()
        $("input[name=\"Submit\"]").click(function(){
                console.log(ue.getContent());
                var param={
                        "ArticleCategoryId": $("select[name=\"ArticleCategoryId\"]").val(),
                        "Id": "<?=$detail["Id"]?>",
                        "Title": $("input[name=\"Title\"]").val(),
                        "Keywords": $("input[name=\"Keywords\"]").val(),
                        "Description": $("textarea[name=\"Description\"]").val(),
                        "CreateTime": $("input[name=\"CreateTime\"]").val(),
                        "Content": ue.getContent(),
                        "Visits": $("input[name=\"Visits\"]").val(),
                        "Status": $("input[name=\"Status\"]:checked").val(),
                }
                $.post("<?=\XHB2\URL($request->GetTranslate(), "Admin-Article-Edit")?>", EncodeJson(param), function(data){
                        var result = DecodeData(data)
                        result.Text = "<?=\XHB2\Translate($request->GetTranslate(), "OK")?>"
                        XHBMessageToast(result)
                        if(result.Code === 0){
                                return
                        }
                })
        })
        const interval = setInterval(() => {
                ue.setContent("<?=$detail["Content"]?>")
                clearInterval(interval)
        }, 1000)
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
                <div class="item"><a href="javascript:void(0);"><?=\XHB2\Translate($request->GetTranslate(), "ArticleManage")?></a></div>
                <div class="split">/</div>
                <div class="item"><a href="javascript:void(0);"><?=\XHB2\Translate($request->GetTranslate(), "ArticleEdit")?></a></div>
        </div>
</div>
<div class="XHB-nav-tab">
        <div class="list">
                <div class="item active">
                        <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-Article-Edit")?>"><?=\XHB2\Translate($request->GetTranslate(), "ArticleEdit")?></a>
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
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "SelectArticleCategory")?></div>
                                <div class="XHB-input-panel">
                                        <select name="ArticleCategoryId" class="XHB-input-select">
                                                <option value="0">{SelectDefault}</option>
                                                <?php if(isset($getListArray) && is_array($getListArray)):?>
                                                <?php foreach($getListArray as $val):?>
                                                        <?php if($detail["ArticleCategoryId"] == $val["Id"]):?>
                                                        <option value="<?=$val["Id"]?>" selected><?=$val["Title"]?></option>
                                                        <?php else:?>
                                                        <option value="<?=$val["Id"]?>"><?=$val["Title"]?></option> 
                                                        <?php endif;?>
                                                <?php endforeach;?>
                                                <?php endif;?>
                                        </select>
                                </div>
                                <div class="XHB-input-mark">
                                        <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-ArticleCategory-Add")?>">
                                                <?=\XHB2\Translate($request->GetTranslate(), "GoAddArticleCategory")?>
                                        </a>
                                </div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ArticleTitle")?></div>
                                <div class="XHB-input-panel">
                                        <input type="text" name="Title" class="XHB-input-text" placeholder="<?=\XHB2\Translate($request->GetTranslate(), "PleaseEnterArticleTitle")?>" value="<?=$detail["Title"]?>" />
                                </div>
                                <div class="XHB-input-mark">*<?=\XHB2\Translate($request->GetTranslate(), "RequiredFields")?></div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ArticleKeywords")?></div>
                                <div class="XHB-input-panel">
                                        <input type="text" name="Keywords" class="XHB-input-text" placeholder="<?=\XHB2\Translate($request->GetTranslate(), "PleaseEnterPageKeywords")?>" value="<?=$detail["Keywords"]?>" />
                                </div>
                                <div class="XHB-input-mark"><?=\XHB2\Translate($request->GetTranslate(), "ArticleKeywordsDesc")?></div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ArticleDescription")?></div>
                                <div class="XHB-input-panel">
                                        <textarea id="textarea" name="Description" class="XHB-input-textarea" style="height: 60px; width:400px;" placeholder="<?=\XHB2\Translate($request->GetTranslate(), "PleaseEnterArticleDescription")?>"><?=$detail["Description"]?></textarea>
                                </div>
                                <div class="XHB-input-mark"><?=\XHB2\Translate($request->GetTranslate(), "ArticleDescriptionDesc")?></div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ArticleCreateTime")?></div>
                                <div class="XHB-input-panel">
                                        <input type="text" name="CreateTime" class="XHB-input-text" placeholder="<?=\XHB2\Translate($request->GetTranslate(), "PleaseEnterArticleCreateTime")?>" value="<?=$detail["CreateTime"]?>" />
                                </div>
                                <div class="XHB-input-mark"><?=\XHB2\Translate($request->GetTranslate(), "ArticleCreateTimeDesc")?></div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ArticleVisits")?></div>
                                <div class="XHB-input-panel">
                                        <input type="text" name="Visits" class="XHB-input-text" placeholder="<?=\XHB2\Translate($request->GetTranslate(), "PleaseEnterArticleVisits")?>" value="<?=$detail["Visits"]?>" />
                                </div>
                                <div class="XHB-input-mark"><?=\XHB2\Translate($request->GetTranslate(), "ArticleVisitsDesc")?></div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ArticleContent")?></div>
                                <div class="XHB-input-panel">
                                        <script id="editor" type="text/plain" style="width:1000px; height:400px;"></script>
                                </div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ArticleStatus")?></div>
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