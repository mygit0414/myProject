function menusel(left_menusel){
	document.getElementById(left_menusel).className="leftmenu-sel";
	document.getElementById(left_menusel).setAttribute("className","leftmenu-sel");
}



function initialize(){
	var map = new BMap.Map("container");          // 创建Map实例
	var point = new BMap.Point(longitude,latitude);  // 创建点坐标
	map.centerAndZoom(point,15);                  // 初始化地图,设置中心点坐标和地图级别。
	map.enableScrollWheelZoom();                  // 启用滚轮放大缩小。
	map.enableKeyboard(); 
	var marker = new BMap.Marker(point);        // 创建标注  
	map.addOverlay(marker);                     // 启用键盘操作。
	var opts = {  
	 width : 200,     // 信息窗口宽度  
	 height: 10,     // 信息窗口高度(最小)  
	 title : mapTitle  // 信息窗口标题  
	}  
	var infoWindow = new BMap.InfoWindow("", opts);  // 创建信息窗口对象  
	map.openInfoWindow(infoWindow, map.getCenter());      // 打开信息窗口  

	map.addEventListener("click", function(e){  
		 //var center = map.getCenter();  
		 //alert("地图中心点变更为：" + center.lng + ", " + center.lat);  
		 //alert(e.point.lng + ", " + e.point.lat);
		document.getElementById("longitude").value=e.point.lng;
		document.getElementById("latitude").value=e.point.lat;
		 map.clearOverlays(); 

		 var point = new BMap.Point(e.point.lng,e.point.lat);  // 创建点坐标
			map.centerAndZoom(point,this.getZoom());            // 初始化地图,设置中心点坐标和地图级别。
			map.enableScrollWheelZoom();                  // 启用滚轮放大缩小。
			map.enableKeyboard(); 
			var marker = new BMap.Marker(point);        // 创建标注  
			map.addOverlay(marker);                     // 启用键盘操作。
		}); 
}

//增加删除上传图片input
var i=1;
function addFileUpload(){
        var input = document.createElement("input");
        input.type = "file";
        input.name = "file[]";
        var fileName = document.createElement("input");
        fileName.type = "text";
        fileName.name = "fileName[]";
        var div = document.createElement("div");
        div.id="fileDiv"+i;
        i++;
        div.innerHTML += "图片名称&nbsp;";
        div.appendChild(fileName);
        div.innerHTML += "&nbsp;";
        div.appendChild(input);
		/*
		var delbtn = document.createElement("input");
		delbtn.type = "button";
        delbtn.value = "删除";
  		delbtn.className="delFile"
  		div.appendChild(delbtn);
  		*/
  		var delFunction  = "<a href=\"javascript:void(delFile('"+div.id+"'))\">删除</a>";
		div.innerHTML += delFunction;
		var br = document.createElement("br");
        div.appendChild(br);
        
        document.getElementById("files").appendChild(div);
        
}

function delFile(divID){
	var div = document.getElementById(divID);
	div.parentNode.removeChild(div);//删除
}

function delPic(picID){
	document.getElementById("delPicID").value+=picID+",";
	var picDIV = document.getElementById("pic"+picID);
	picDIV.parentNode.removeChild(picDIV);   //删除 
}