<?php include_once dirname(__DIR__)."/Common/Header.Template.php";?>
<style>
body { background-color: #666666;}
</style>
<div style="width: 100%; height: 100%; overflow: hidden; background-image: url(/Image/BodyBG.gif); float: left;">
        <?php include_once dirname(__DIR__)."/Common/Menu.Template.php";?>
        <iframe class="XHB-iframe-main" src="<?=\XHB2\URL($request->GetTranslate(), "Admin-Main-Main")?>"></iframe>
</div>
<script>
$(function(){
        initWindow()
        XHBInitIFrame()
        // initSignCheck()
})
function initSignCheck(){
        $.post("/session/sign/check", EncodeJson({}), function(data){
                var result = JSON.parse(decodeString(data))
                if(result.code === 0){
                        layer.msg(result.message)
                        window.setTimeout(function(){
                                window.location.href='/login/index'
                        }, 1000)
                        return
                }else{
                        console.log("success check")
                }
        })
}
function initWindow(){
        $(window).resize(function(){
                XHBInitIFrame()
        })
}
</script>
<?php include_once dirname(__DIR__)."/Common/Footer.Template.php";?>