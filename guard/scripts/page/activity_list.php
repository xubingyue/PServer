<?php
    function page_activity_list($data)
    {
?>



<div style="width:603px;height:300px" id="map_container"></div>
<script>
    var map = new soso.maps.Map(document.getElementById("map_container"), {
        // 地图的中心地理坐标。
        center: new soso.maps.LatLng(31.2141465, 121.5462615),
        zoom:15,
        scaleControl:true,
        mapTypeControl:true,
        navigationControl:true
    });
    
    
      var path1=[
        new soso.maps.LatLng(31.2141465, 121.5462615),
        new soso.maps.LatLng(31.2141532, 121.5462495),
        new soso.maps.LatLng(31.2141777, 121.5461907)
    ];

    var polyline = new soso.maps.Polyline({
        path: path1,
        strokeColor: '#ff0000',
        strokeWeight: 5,
        editable:false,
        map: map
    });

</script>
<?php 
    }
?>
 
