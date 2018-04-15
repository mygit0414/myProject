/*-----伪selet框------*/
var J_select=function(obj,h){
	var sel=jQuery(obj);
	sel.each(function(){
		var jQuerythis=jQuery(this);
		var span=jQuerythis.find("span"), ul=jQuerythis.find("ul"), input=jQuerythis.find("input"), spanIn=jQuery("<span></span>");
		var w=(span.outerWidth()-ul.outerWidth()>0)?span.outerWidth():span.outerWidth(); //应付神奇的IE6
		var ulw=ul.outerWidth();
		w-ulw>0?ul.width(w-2):ul.width(ulw-2);
		if(ul.innerHeight()-h>0)ul.css({"height":h+"px","overflow-y":"scroll","overflow-x":"hidden"});
		spanIn.css("padding-right","25px")
		span.css({"width":w-32,"padding":"0","background":"none","border":"none","overflow":"hidden"}).wrap(spanIn);
		jQuerythis.find("li").eq(0).addClass("selected");
		jQuerythis.hover(function(){
			ul.css("display","block");
			ul.find("li[selected=selected]").siblings().removeClass("selected").end().addClass("selected");
		},function(){
			ul.css("display","none");
		});
		jQuerythis.find("li").click(function(){
			var v=jQuery(this).attr("val");
			var t=jQuery.trim(jQuery(this).text());
			jQuery(this).siblings().attr("selected","").end().attr("selected","selected");
			input.val(v);
			span.text(t);
			ul.css("display","none");
		}).mouseover(function(){
			jQuery(this).siblings().removeClass("selected").end().addClass("selected");
		})
	})
}

$(function(){  
   // $("tbody>tr:odd").addClass("odd");   //为奇数行添加样式  
   // $("tbody>tr:even").addClass("even"); //为偶数行添加样式  
    $(".cz-box").mouseover(function(){      //鼠标移动的高亮显示  
        $(this).addClass("bg");  
    }).mouseout(function(){  
        $(this).removeClass("bg");  
    });  
});

function menusel(left_menusel){
	document.getElementById(left_menusel).className="leftmenu-sel";
	document.getElementById(left_menusel).setAttribute("className","leftmenu-sel");
}

function currentMenu(currmenu){
	document.getElementById(currmenu).className="current";
	document.getElementById(currmenu).setAttribute("className","current");
}

function getObj(id){
	return document.getElementById(id);
}

String.prototype.trim=function(){
	return this.replace(/(^\s*)|(\s*$)/g,"");
}

/**收藏设为首页**/
//url：要收藏的链接；title：收藏项的名称  
function AddFavorite(url,title)  
{  
   //如果url或者title为空，默认为当前页面url和title。  
   if(!(url&&title))  
   {  
      url=document.URL;  
      title=document.title;  
   }  

   if (document.all)//IE  
   {  
         window.external.addFavorite(url,title);  
   }  
   else if (window.sidebar)//火狐  
   {  
      window.sidebar.addPanel(title, url, "");  
   }  
}  

//url：要设置为首页的链接  
function SetHomepage(url)  
{  
   //如果url为空，默认为当前页面url。  
   if(!url)  
   {  
      url=document.URL;  
   }  

   if (document.all)//IE  
   {  
      document.body.style.behavior = 'url(#default#homepage)';  
      document.body.setHomePage(url);  
   }  
   else if (window.sidebar)//火狐  
   {  
      if (window.netscape)  
      {  
         try  
         {  
            window.netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");  
         }  
         catch (e)  
         {  
            alert("此操作被浏览器拒绝！请在浏览器地址栏输入“about:config”并回车然后将[signed.applets.codebase_principal_support]的值设置为'true',双击即可。");  
         }  
      }  
      var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);  
      prefs.setCharPref('browser.startup.homepage', url);  
   }  
}
/**收藏设为首页 end**/