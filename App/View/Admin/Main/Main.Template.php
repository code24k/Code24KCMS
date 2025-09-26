<?php include_once dirname(__DIR__)."/Common/Header.Template.php";?>
<div class="XHB-nav-home">
        <div class="container">
                <div class="home">您的位置</div>
                <div class="item"><a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-Main-Main")?>">系统主界面</a></div>
        </div>
</div>
<div class="XHB-nav-tab">
        <div class="list">
                <div class="item active">
                        <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-Main-Main")?>">系统主界面</a>
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
                $(".eveLogout").click(function(){
                        var param={}
                        $.post("/login/logout", EncodeJson(param), function(data){
                                var result = JSON.parse(decodeString(data))
                                console.log(result)
                                parent.window.location.href = "/login/login"
                        })
                })
        })
        function getDetail(){
                XHBLoadingShow()
                var param={}
                $.post("/admin/storage/accountstring/detail", EncodeJson(param), function(data){
                        XHBLoadingHide()
                        var result = JSON.parse(decodeString(data))
                        console.log(result)
                        if(result.code === 0){
                                XHBMessageToast({message:result.message})
                                return
                        }
                        parent.setName(result.data.Name)
                        $(".eveUser").html(result.data.User)
                        $(".eveName").html(result.data.Name)
                        $(".eveLevel").html(result.data.User=="admin"?"超级管理员":"普通管理员")
                })
        }
</script>
<!-- body -->
<div class="main">
        <div class="XHB-form">
                <div class="title">管理员信息</div>
                <div class="line">
                        <div class="item">
                                <div class="itemTitle" style="width: 100px;">账号</div>
                        </div>
                </div>
        </div>

</div>
<!-- //body -->
 <?php include_once dirname(__DIR__)."/Common/Footer.Template.php";?>