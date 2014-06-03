<?php
    function page_garmin_up($data)
    {
?>	

<script type="text/javascript">
    var polyline;
    var flightPath; 

    
    function prototype_ajax_post(data){
                var url = "/commit/upload/garmin/"; 
                
                var map2_bound = map2.getBounds();
    
                var myAjax = new Ajax.Request(  
                    url, 
                    //{method: 'post', parameters: "data=" + data + "&minlat=" + map1_bound.dc + "&maxlat=" + map1_bound.fc + "&minlng=" + map1_bound.hc + "&maxlng=" + map1_bound.jc, onComplete: prototype_response}  
                    {method: 'post', parameters: "data=" + data + "&minlat=" + map2_bound.getSouthWest().jb + "&maxlat=" + map2_bound.getNorthEast().jb + "&minlng=" + map2_bound.getSouthWest().kb + "&maxlng=" + map2_bound.getNorthEast().kb, onComplete: prototype_response}  
                    );  
            }     
        function prototype_response(req){
           //alert(req.responseText); 
        
            var data = eval(req.responseText);
            

            for ( var i = 0; i < data.length; i++ )
            {
                var path2=[];
                var path3=[];
            
                for ( var j = 0; j < data[i].length; j++ )
                {
                    path2.push(new BMap.Point(data[i][j][2], data[i][j][1]));
                    path3.push(new google.maps.LatLng(data[i][j][1], data[i][j][2]));
                }


                polyline = new BMap.Polyline(path2,  
                 {strokeColor:"red", strokeWeight:2, strokeOpacity:0.5}  
                );  
                map1.addOverlay(polyline);

                flightPath = new google.maps.Polyline({
                   path: path3,
                   strokeColor: '#FF0000',
                   strokeOpacity: 1.0,
                   strokeWeight: 2
                 });

                 flightPath.setMap(map2);     
            }
         }  
            
            
	function load()
        {
	    $j("#testMessage")[0].innerHTML="";	
	    var display = new Garmin.DeviceDisplay("garminDisplay", { 
			pathKeyPairsArray: ["http://randyliu.com","0334bb9febbd09085c4a4cc4ce4cba5e"],
			showReadDataElement: true,
			showProgressBar: true,
			showFindDevicesElement: true,
			showFindDevicesButton: false,
			showDeviceButtonsOnLoad: false,
			showDeviceButtonsOnFound: false,
			autoFindDevices: true,
			showDeviceSelectOnLoad: true,
			autoHideUnusedElements: true,
			showReadDataTypesSelect: false,
			readDataType: Garmin.DeviceControl.FILE_TYPES.tcxDir,
			deviceSelectLabel: "Choose Device <br/>",
			readDataButtonText:			"List Activities",
			showCancelReadDataButton:		false,
			lookingForDevices: 'Searching for Device <br/><br/> <img src="images/garmin/ajax-loader.gif"/>',
			uploadsFinished: "Transfer Complete",
			uploadSelectedActivities: true,
			uploadCompressedData: true,    // Turn on data compression by setting to true.
			uploadMaximum: 5, 
			dataFound: "#{tracks} activities found on device",
			showReadDataElementOnDeviceFound: true,
			postActivityHandler: function(activityXml, display) {
                            //$('activity').innerHTML += '<hr/><pre>'+activityXml.escapeHTML()+'</pre>';
                            prototype_ajax_post(encodeURIComponent(activityXml));
			},
                        afterTableInsert : function(index, activity)
                        {
                                //alert(activity.id);
                        }
		});
	}
</script>
<div onclick="load();">click me </div>
<div id="testMessage"></div>
<div id="garminDisplay"></div>
<div id="activity"></div>



<div style="width:603px;height:300px" id="map-canvas"></div>
<div style="width:603px;height:300px" id="map-canvas-g"></div>

<script type="text/javascript">
    var map1 = new BMap.Map("map-canvas", {mapType:BMAP_HYBRID_MAP});                        // 创建Map实例
            map1.centerAndZoom(new BMap.Point(121.552642, 31.215774), 15);     // 初始化地图,设置中心点坐标和地图级别
            map1.addControl(new BMap.NavigationControl());               // 添加平移缩放控件
            map1.addControl(new BMap.ScaleControl());                    // 添加比例尺控件
            map1.addControl(new BMap.OverviewMapControl());              //添加缩略地图控件
            map1.enableScrollWheelZoom();                            //启用滚轮放大缩小
            map1.addControl(new BMap.MapTypeControl());          //添加地图类型控件
            map1.setCurrentCity("上海");          // 设置地图显示的城市 此项是必须设置的
            var map1_bound = map1.getBounds();
             

    var mapOptions = {
            zoom: 15,
            center: new google.maps.LatLng(31.215774, 121.552642),
            mapTypeId: google.maps.MapTypeId.SATELLITE
          };
            var map2 = new google.maps.Map(document.getElementById('map-canvas-g'),
              mapOptions);              
</script>

<?php 
    }
?>
 
