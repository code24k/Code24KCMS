<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?=\XHB2\Translate($request->GetTranslate(), "AdministratorManagementCenter")?></title>
        <meta name="keywords" content="<?=\XHB2\Translate($request->GetTranslate(), "AdministratorManagementCenter")?>">
        <meta name="description" content="<?=\XHB2\Translate($request->GetTranslate(), "AdministratorManagementCenter")?>">
        <link rel="stylesheet" href="/CSS/XHB.lib.css" media="all" />
        <script src="/Js/XHB.lib.js"></script>
        <script src="/Js/base64.lib.js"></script>
        <script src="/Js/jquery-3.2.1.min.js"></script>
        <!--[if lt IE 9]>
            <script src="/Js/html5.min.js'"></script>
        <![endif]-->
    </head>
<body>
    <style>
        body { background-color: #333333; background-image: url(/Image/AdminBG.jpg);}
        .login { width: 500px; padding: 100px; margin: 0px auto;}
        .login .container { width: auto; padding: 20px 100px; margin: 10px auto; background-color: rgba(248, 248, 255, 0.2); box-shadow: 0px 0px 10px #333333; border-radius: 6px; float: left;}
        .login .container .title { width: 100%;  padding: 10px; text-align: center; font-size: 22px; color: #FFFFFF; font-weight: bold; float: left;}
        .login .container .form { width: 100%; float: left;}
        .login .container .form .line { width: 100%; margin-top: 10px; float: left;}
        .login .container .form .line .text {
            width: 300px;
            height: 40px;
            margin-bottom: 5px;
            line-height: 40px;
            margin-bottom: 5px;
            -webkit-transition-property: none;
            transition-property: none;
            background-color: #FFFFFF;
            border: 1px solid #e6e6e6;
            border-style: solid;
            padding-left: 10px;
            border-radius: 2px;
            font-size: 15px;
            outline: none;
        }
        .login .container .copyright { width: 100%; padding: 10px; text-align: center; color: #FFFFFF; font-size: 15px; float: left;}
</style>
<div class="login">
    <div class="container">
        <div class="title"><?=\XHB2\Translate($request->GetTranslate(), "AdministratorManagementCenter")?></div>
        <div class="form">
            <div class="line">
                <input type="text" name="User" class="text" placeholder="<?=\XHB2\Translate($request->GetTranslate(), "EnterAccount")?>" value="" />
            </div>
            <div class="line">
                <input type="password" name="Passwd" class="text" placeholder="<?=\XHB2\Translate($request->GetTranslate(), "EnterPassword")?>" value="" />
            </div>
            <div class="line">
                <input type="button" class="XHB-button-white eveSubmit" style="height: 40px; width: 315px; padding-left: 10px;" value="<?=\XHB2\Translate($request->GetTranslate(), "LogIn")?>" />
            </div>
        </div>
        <div class="copyright">&copy; <?=date("Y");?></div>
    </div>
</div>
<script>
$(function(){
    $(document).keyup(function(event){
        if(event.keyCode === 13){
            $(".eveSubmit").trigger("click")
        }
    })
    $(".eveCancel").click(function(){
        $("input[name=\"User\"]").val("")
        $("input[name=\"Passwd\"]").val("")
    })
    $(".eveSubmit").click(function() {
        XHBLoadingShow()
        var param={
            "User":$("input[name=\"User\"]").val(),
            "Passwd":$("input[name=\"Passwd\"]").val()
        }
        $.post("<?=\XHB2\URL($request->GetTranslate(), "Admin-Login-Index")?>", EncodeJson(param), function(data){
            var result = DecodeData(data)
            if(result.Code === 0){
                XHBLoadingHide()
                XHBMessageToastAuto(result)
                return
            }
            if(result.Data.Token != "")
            {
                localStorage.setItem("Token", result.Data.Token)
                localStorage.setItem("User", param.User)
                window.setTimeout(function(){
                    XHBLoadingHide()
                    window.location.href="<?=\XHB2\URL($request->GetTranslate(), "Admin-Main-Index")?>"
                }, 1000)
            }else{
                XHBLoadingHide()
            }
        })
        return false
    })
})
</script>
</body>
</html>