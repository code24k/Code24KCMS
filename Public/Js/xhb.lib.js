/**
 * XHB LIB
 * XHB LIB All Rights Reserved. 
 * XHBCallbackParentTable() parent callback
 */
var XHBMessageConf = {
    "XHBMessageConfirm": { isClose: false},
    "XHBMessageToast": { isClose: false},
    "XHBConfirm": { cancel: function(){}, success: function(){}},
}
function XHBInitIFrame(){
    $(".XHB-iframe-main").width($(document).width()-270)
    $(".XHB-iframe-main").height($(document).height()-20)
}
function XHBInitForm(){
    //$(".XHB-form").width($(".admin").width()-20) 
    $(".XHB-form").width($(".XHB-form").parent().width()-20) 
}
function XHBInitUserInfo(){
    $(".XHB-userInfo").width($(".XHB-userInfo").parent().width()-20) 
}
function XHBInitSearch(){
    $(".XHB-search").width($(".admin").width()-20) 
}
function XHBInitTable(){
    $(".XHB-table").width($(".admin").width()-20) 
    console.log($(".XHB-table").width())
    console.log($(".XHB-table .title").width())
}
function XHBTableOperate(_this, ItemID){
    _this.val(_this.val() == "[展开]"?"[收起]":"[展开]")
    var operate = $(".eveOperate"+ItemID)
    if(operate.css("display") == "none"){
            operate.show()
    }else{
            operate.hide()
    }
}
function XHBInitMenuDiv(){
    $(".XHB-menu-div").height($(document).height()-20)
    $(".XHB-menu-div .menu-ui-li-a").click(function(){
            $(".XHB-iframe-main").attr("src", $(this).attr("href"))
            return false
    })
}
function XHBLocationReload(){
    window.location.reload()
}
function XHBLocationHref(url){
    window.location.href=url
}
function XHBSleep(delay) {
    var start = (new Date()).getTime();
    while ((new Date()).getTime() - start < delay) {
      continue;
    }
  }

function XHBMessageConfirm(param){
    var html = []
    html.push("<div class=\"XHB-message-confirm\">")
    html.push("   <div class=\"text\">"+param.message+"</div>")
    html.push("   <div class=\"button\">")
    html.push("           <input type=\"button\" class=\"XHB-button-white\" onclick=\"XHBMessageConfirmClose($(this))\" value=\"确定\" />")
    html.push("   </div>")
    html.push("</div>")
    $("body").append(html.join(""))
    var top = ($(document).height() - $(".XHB-message-confirm").height()) / 2
    var left = ($(document).width() - $(".XHB-message-confirm").width()) / 2
    $(".XHB-message-confirm").css({"top": top, "left": left})
}
function XHBMessageConfirmClose(_this){
    XHBMessageConf.XHBMessageConfirm.isClose = true
    console.log("timer0"+XHBMessageConf.XHBMessageConfirm.isClose)
    _this.parents(".XHB-message-confirm").remove()
}
function XHBMessageConfirmReload(){
    var timer = window.setInterval(function(){
        console.log("timer")
        if(XHBMessageConf.XHBMessageConfirm.isClose){
            clearInterval(timer)
            window.location.reload()
        }
    }, 500) 
}
function XHBMessageConfirmHref(url){
    var timer = window.setInterval(function(){
        console.log("timer")
        if(XHBMessageConf.XHBMessageConfirm.isClose){
            clearInterval(timer)
            XHBLocationHref(url)
        }
    }, 500) 
}

// XHBMessageToast({Message:"Message",Text:"OK"})
function XHBMessageToast(param){
    XHBMessageConf.XHBMessageToast.isClose = false
    $('.XHB-message-toast').remove();
    var html = []
    html.push("<div class=\"XHB-message-toast\">")
    html.push("     <div class=\"container\">")
    html.push("         <div class=\"text\">"+param.Message+"</div>")
    html.push("         <div class=\"button\">")
    html.push("             <input type=\"button\" class=\"XHB-button-green\" onclick=\"XHBMessageToastClose($(this))\" style=\"\" value=\""+param.Text+"\" />")
    html.push("         </div>")
    html.push("   </div>")
    html.push("</div>")
    $("body").append(html.join(""))
    var top = ($(document).height() - $(".XHB-message-toast").height()) / 5
    var left = ($(document).width() - $(".XHB-message-toast").width()) / 2
    $(".XHB-message-toast").css({"top": top, "left": left})
}
function XHBMessageToastAuto(param){
    XHBMessageConf.XHBMessageToast.isClose = false
    var html = []
    html.push("<div class=\"XHB-message-toast\">")
    html.push("   <div class=\"text\">"+param.Message+"</div>")
    html.push("</div>")
    $("body").append(html.join(""))
    var top = ($(document).height() - $(".XHB-message-toast").height()) / 5
    var left = ($(document).width() - $(".XHB-message-toast").width()) / 2
    $(".XHB-message-toast").css({"top": top, "left": left})
    var timer = window.setInterval(function(){
        clearInterval(timer)
        $(".XHB-message-toast").remove();
    }, 1500) 
}
function XHBMessageToastClose(_this){
    XHBMessageConf.XHBMessageToast.isClose = true
    _this.parents(".XHB-message-toast").remove()
}
function XHBMessageToastReload(){
    var timer = window.setInterval(function(){
        console.log("timer")
        if(XHBMessageConf.XHBMessageToast.isClose){
            clearInterval(timer)
            window.location.reload()
        }
    }, 500) 
}
function XHBMessageToastParentReload(){
    var timer = window.setInterval(function(){
        console.log("timer")
        if(XHBMessageConf.XHBMessageToast.isClose){
            clearInterval(timer)
            parent.XHBLocationReload()
        }
    }, 500) 
}
function XHBMessageToastCallbackParentTable(){
    var timer = window.setInterval(function(){
        console.log("timer")
        if(XHBMessageConf.XHBMessageToast.isClose){
            clearInterval(timer)
            parent.XHBCallbackParentTable()
        }
    }, 500) 
}
function XHBMessageToastHref(url){
    var timer = window.setInterval(function(){
        console.log("timer")
        if(XHBMessageConf.XHBMessageToast.isClose){
            clearInterval(timer)
            XHBLocationHref(url)
        }
    }, 500) 
}

// XHBOpen({
//     width: 800,
//     height: 260,
//     title: "abc",
//     content: "/abc"
// })
function XHBOpen(param){
    if(!param.width){ param.width = 800 }
    if(!param.height){ param.height = 600 }
    if(!param.title){ param.title = "" }
    if(!param.content){ param.content = "" }
    var html = []
    html.push("<div class=\"XHB-open\" style=\"width:"+param.width+"px;height:"+param.height+"px;\">")
    html.push("     <div class=\"title\">")
    html.push("             <div class=\"text\">"+param.title+"</div>")
    html.push("             <div class=\"close\" onclick=\"XHBOpenClose($(this))\">[关闭]</div>")
    html.push("     </div>")
    html.push("     <iframe src=\""+param.content+"\"></iframe>")
    html.push("</div>")
    $("body").append(html.join(""))
    var top = ($(document).height()-param.height) / 2
    var left = ($(document).width() - param.width) / 2
    $(".XHB-open").css({"top": top, "left": left})
    $(".XHB-open iframe").height(param.height-$(".XHB-open .title").height())
}
function XHBOpenCallParentCLose(){
    parent.XHBOpenClose2()
}
function XHBOpenCallParentReload(){
    parent.window.location.reload()
}
function XHBOpenClose(_this){
    _this.parents(".XHB-open").remove()
}
function XHBOpenClose2(){
    $(".XHB-open").remove()
}

// XHBConfirm({
//     title: "title",
//     message:"message",
//     cancel: function(){
//         console.log("cancel")
//     },
//     success: function(){
//             console.log("success")
//     }
// })
function XHBConfirm(param){
    if(param.cancel){
        XHBMessageConf.XHBConfirm.cancel = param.cancel
    }
    if(param.success){
        XHBMessageConf.XHBConfirm.success = param.success
    }
    if(!param.title){ param.title = "请确认" }
    if(!param.with){ param.with = 400 }
    if(!param.height){ param.height = 130 }
    if(!param.message){ param.message = "" }
    var html = []
    html.push("<div class=\"XHB-confirm\">")
    html.push("        <div class=\"title\">")
    html.push("                <div class=\"text\">"+param.title+"</div>")
    html.push("        </div>")
    html.push("        <div class=\"message\">")
    html.push("                <div class=\"text\">"+param.message+"</div>")
    html.push("        </div>")
    html.push("        <div class=\"button\">")
    html.push("                <input type=\"button\" class=\"XHB-button-white\" onclick=\"XHBConfirmCancel($(this))\" style=\"width: 120px;\" value=\"取消\" />")
    html.push("                <input type=\"button\" class=\"XHB-button-white\" onclick=\"XHBConfirmSuccess($(this))\" style=\"width: 120px;\" value=\"确认\" />")
    html.push("        </div>")
    html.push("</div>")
    $("body").append(html.join(""))
    $(".XHB-confirm").css({"width": param.width+"px", "height": param.height+"px"})
    var top = ($(document).height() - param.height) / 2
    var left = ($(document).width() - param.with) / 2
    $(".XHB-confirm").css({"top": top, "left": left})
}
function XHBConfirmCancel(_this){
    XHBMessageConf.XHBConfirm.cancel();
    _this.parents(".XHB-confirm").remove()
}
function XHBConfirmCancel2(){
    XHBMessageConf.XHBConfirm.cancel();
    $(".XHB-confirm").remove()
}
function XHBConfirmSuccess(_this){
    XHBMessageConf.XHBConfirm.success();
    XHBConfirmCancel(_this)
}

function XHBLoadingShow(){
    var html = []
    html.push("<div class=\"XHB-loading\">")
    html.push("   <img src=\"/Image/Loading3.gif\" />")
    html.push("</div>")
    $("body").append(html.join(""))
    var top = ($(document).height() - $(".XHB-loading").height()) / 2 - 50
    var left = ($(document).width() - $(".XHB-loading").width()) / 2
    $(".XHB-loading").css({"top": top, "left": left})
}
function XHBLoadingHide(){
    $(".XHB-loading").remove()
}