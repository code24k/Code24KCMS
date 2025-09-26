<!-- 左侧导航区域-->
<div class="XHB-menu-div">
        <div class="menu-title">
                <div class="headerpic"><img src="/Image//HeaderPic.jpg" class="eveHeaderPic" style="cursor: pointer;" /></div>
                <div class="userinfo">
                        <div class="username eveName" style="cursor: pointer;">eveName</div>
                        <div class="logout"><a href="">退出登录</a></div>
                </div>
        </div>
        <div class="menu-ui">
                <div class="menu-ui-li">
                        <div class="menu-ui-li-title">
                                <a href="javascript:void(0)">全局设置</a>
                        </div>
                        <div class="menu-ui-li-item">
                                <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-GlobalSetting-BaseSetting")?>" class="menu-ui-li-a">基础设置</a>
                        </div>
                </div>
                <div class="menu-ui-li">
                        <div class="menu-ui-li-title">
                                <a href="javascript:void(0)">导航管理</a>
                        </div>
                        <div class="menu-ui-li-item">
                                <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-Navigation-List")?>" class="menu-ui-li-a">导航列表</a>
                                <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-Navigation-Add")?>" class="menu-ui-li-a">新增导航</a>
                        </div>
                </div>
                <div class="menu-ui-li">
                        <div class="menu-ui-li-title">
                                <a href="javascript:void(0)">单页管理</a>
                        </div>
                        <div class="menu-ui-li-item">
                                <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-SinglePage-List")?>" class="menu-ui-li-a">单页列表</a>
                                <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-SinglePage-Add")?>" class="menu-ui-li-a">新增单页</a>
                        </div>
                </div>
                <div class="menu-ui-li">
                        <div class="menu-ui-li-title">
                                <a href="javascript:void(0)">文章管理</a>
                        </div>
                        <div class="menu-ui-li-item">
                                <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-ArticleCategory-List")?>" class="menu-ui-li-a">文章类别</a>
                                <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-Article-List")?>" class="menu-ui-li-a">文章列表</a>
                                <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-Article-Add")?>" class="menu-ui-li-a">新增文章</a>
                        </div>
                </div>
                <div class="menu-ui-li">
                        <div class="menu-ui-li-title">
                                <a href="javascript:void(0)">产品管理</a>
                        </div>
                        <div class="menu-ui-li-item">
                                <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-ProductCategory-List")?>" class="menu-ui-li-a">产品类别</a>
                                <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-Product-List")?>" class="menu-ui-li-a">产品列表</a>
                                <a href="<?=\XHB2\URL($request->GetTranslate(), "Admin-Product-Add")?>" class="menu-ui-li-a">新增产品</a>
                        </div>
                </div>
                <!-- <div class="menu-ui-li">
                        <div class="menu-ui-li-title">
                                <a href="javascript:void(0)" class="menu-ui-li-a">充值管理</a>
                        </div>
                        <div class="menu-ui-li-item">
                                <a href="/balance/rechargeadd" class="menu-ui-li-a">会员卡充值</a>
                                <a href="/balance/rechargelist" class="menu-ui-li-a">充值记录</a>
                                <a href="/balance/consumeadd" class="menu-ui-li-a">会员卡消费</a>
                                <a href="/balance/consumelist" class="menu-ui-li-a">消费记录</a>
                        </div>
                </div> -->
                <div class="menu-ui-li">
                        <div class="menu-ui-li-title">
                                &copy;2024-<?=date("Y")?> <br />
                                <a href="https://github.com/code24k" target="_blank">Code24K CMS</a>
                        </div>
                </div>
        </div>
</div>
<script>
$(function(){
        XHBInitMenuDiv()
        $(".eveName").click(function(){
                $(".XHB-iframe-main").attr("src", "/main/main")
        })
        $(".eveHeaderPic").click(function(){
                $(".XHB-iframe-main").attr("src", "/main/main")
        })
})
function setName(name){
        $(".eveName").html(name)
}
</script>