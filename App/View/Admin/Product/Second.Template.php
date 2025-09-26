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
                        "Id": $(".eveProductId").html(),
                        "ProductCategoryId": $("select[name=\"ProductCategoryId\"]").val(),
                        "Title": $("input[name=\"Title\"]").val(),
                        "Keywords": $("input[name=\"Keywords\"]").val(),
                        "Description": $("textarea[name=\"Description\"]").val(),
                        "CreateTime": $("input[name=\"CreateTime\"]").val(),
                        "Visits": $("input[name=\"Visits\"]").val(),
                        "Content": ue.getContent(),
                        "Status": $("input[name=\"Status\"]:checked").val(),
                }
                $.post("<?=\XHB2\URL($request->GetTranslate(), "Admin-Product-Second")?>", EncodeJson(param), function(data){
                        var result = DecodeData(data)
                        result.Text = "<?=\XHB2\Translate($request->GetTranslate(), "OK")?>"
                        XHBMessageToast(result)
                        if(result.Code === 0){
                                return
                        }
                        window.location.href = "<?=\XHB2\URL($request->GetTranslate(), "Admin-Product-List")?>"
                })
        })
        const interval = setInterval(() => {
                ue.setContent($(".eveUEContent").html())
                clearInterval(interval)
        }, 1000)
})
</script>

<div class="eveUEContent" style="display: none;">
        <?=array_key_exists("Content", $detail)?$detail["Content"]:""?>
</div>

<div class="XHB-nav-home">
        <div class="container">
                <div class="home"><?=\XHB2\Translate($request->GetTranslate(), "YourLocation")?>:</div>
                <div class="item"><a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-Main-Main")?>"><?=\XHB2\Translate($request->GetTranslate(), "SystemMainInterface")?></a></div>
                <div class="split">/</div>
                <div class="item"><a href="javascript:void(0);"><?=\XHB2\Translate($request->GetTranslate(), "ProductManage")?></a></div>
                <div class="split">/</div>
                <div class="item"><a href="javascript:void(0);"><?=\XHB2\Translate($request->GetTranslate(), "ProductSecond")?></a></div>
        </div>
</div>
<div class="XHB-nav-tab">
        <div class="list">
                <div class="item active">
                        <a href="#"><?=\XHB2\Translate($request->GetTranslate(), "ProductSecond")?></a>
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
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ProductId")?></div>
                                <div class="XHB-input-panel">
                                        <div class="XHB-input-mark eveProductId"><?=array_key_exists("Id", $detail)?$detail["Id"]:"{NoData}"?></div>
                                </div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ProductTitle")?></div>
                                <div class="XHB-input-panel">
                                        <div class="XHB-input-mark"><?=array_key_exists("Title", $detail)?$detail["Title"]:"{NoData}"?></div>
                                </div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "SelectProductCategory")?></div>
                                <div class="XHB-input-panel">
                                        <select name="ProductCategoryId" class="XHB-input-select">
                                                <option value="0">{SelectDefault}</option>
                                                <?php if(isset($getListArray) && is_array($getListArray)):?>
                                                <?php foreach($getListArray as $val):?>
                                                        <?php if($detail["ProductCategoryId"] == $val["Id"]):?>
                                                        <option value="<?=$val["Id"]?>" selected><?=$val["Title"]?></option>
                                                        <?php else:?>
                                                        <option value="<?=$val["Id"]?>"><?=$val["Title"]?></option> 
                                                        <?php endif;?>
                                                <?php endforeach;?>
                                                <?php endif;?>
                                        </select>
                                </div>
                                <div class="XHB-input-mark">
                                        <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-ProductCategory-Second")?>">
                                                <?=\XHB2\Translate($request->GetTranslate(), "GoSecondProductCategory")?>
                                        </a>
                                </div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ProductKeywords")?></div>
                                <div class="XHB-input-panel">
                                        <input type="text" name="Keywords" class="XHB-input-text" placeholder="<?=\XHB2\Translate($request->GetTranslate(), "PleaseEnterProductKeywords")?>" value="<?=array_key_exists("Keywords", $detail)?$detail["Keywords"]:""?>" />
                                </div>
                                <div class="XHB-input-mark"><?=\XHB2\Translate($request->GetTranslate(), "ProductKeywordsDesc")?></div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ProductDescription")?></div>
                                <div class="XHB-input-panel">
                                        <textarea id="textarea" name="Description" class="XHB-input-textarea" style="height: 60px; width:400px;" placeholder="<?=\XHB2\Translate($request->GetTranslate(), "PleaseEnterProductDescription")?>"><?=array_key_exists("Description", $detail)?$detail["Description"]:""?></textarea>
                                </div>
                                <div class="XHB-input-mark"><?=\XHB2\Translate($request->GetTranslate(), "ProductDescriptionDesc")?></div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ProductCreateTime")?></div>
                                <div class="XHB-input-panel">
                                        <input type="text" name="CreateTime" class="XHB-input-text" placeholder="<?=\XHB2\Translate($request->GetTranslate(), "PleaseEnterProductCreateTime")?>" value="<?=array_key_exists("CreateTime", $detail)?substr($detail["CreateTime"], 0, 10):""?>" />
                                </div>
                                <div class="XHB-input-mark"><?=\XHB2\Translate($request->GetTranslate(), "ProductCreateTimeDesc")?></div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ProductVisits")?></div>
                                <div class="XHB-input-panel">
                                        <input type="text" name="Visits" class="XHB-input-text" placeholder="<?=\XHB2\Translate($request->GetTranslate(), "PleaseEnterProductVisits")?>" value="<?=array_key_exists("Visits", $detail)?$detail["Visits"]:""?>" />
                                </div>
                                <div class="XHB-input-mark"><?=\XHB2\Translate($request->GetTranslate(), "ProductVisitsDesc")?></div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ProductContent")?></div>
                                <div class="XHB-input-panel">
                                        <script id="editor" type="text/plain" style="width:1000px; height:400px;"></script>
                                </div>
                        </div>
                </div>
                <div class="line">
                        <div class="item">
                                <div class="XHB-input-lable-right" style="width: 200px;"><?=\XHB2\Translate($request->GetTranslate(), "ProductStatus")?></div>
                                <div class="XHB-input-panel">
                                        <label class="XHB-input-radio-signal">
                                                <input type="radio" name="Status" class="XHB-input-radio" value="1" <?php if(array_key_exists("Status", $detail) && $detail["Status"]=="1"):?>checked<?php endif;?> /> <?=\XHB2\Translate($request->GetTranslate(), "Show")?>
                                        </label>
                                        <label class="XHB-input-radio-signal">
                                                <input type="radio" name="Status" class="XHB-input-radio" value="2" <?php if(array_key_exists("Status", $detail) && $detail["Status"]=="2"):?>checked<?php endif;?> /> <?=\XHB2\Translate($request->GetTranslate(), "Hidden")?>
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