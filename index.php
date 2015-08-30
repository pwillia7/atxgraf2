<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>austin-graffiti</title>
	
    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Lato:100,300|Roboto+Slab:100' rel='stylesheet' type='text/css'>
	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<!-- bxSlider CSS file -->
	<link href="assets/css/jquery.bxslider.css" rel="stylesheet" />
				
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>
<?php
?>


<!--   <?php

  $m = new MongoClient();
  $db = $m->graffiti;
  $collection = $db->posts;
  $cursor = $collection->find()->sort(array('timeStamp' => -1));
  ?> -->

	<div id="Container">
		<div id="Header">
			<div id="LogoContainer">
				<span id="Logo">austin-graffiti</span>
			</div>
			<form id="SearchContainer" class="navbar-form form-inline" role="search">
	  			<div class="search-input form-group">
		   		
		   					<input id="SearchBox" type="text" class="form-control input-xlarge" placeholder="Search">
		   					<span id="SearchIcon" class="glyphicon glyphicon-search"></span>
			
		 		</div>
			</form>
		</div> 
		<div id="Main">
			<div class="submitWrap"><a href='submit.php' class="submitB">Submit New Graffiti</a></div>
			<div id="carouselNewWrap" class="carouselWrap">
				<h3>What's New</h3>
				<?php
				$wrapTemplate = '<ul class="carousel carouselNew">';
				$wrapTemplateEnd = '</ul>';
				$itemTemplate = '<li><img src="';
				$itemTemplateEnd = '" alt=""></li>';
				echo $wrapTemplate;
				foreach ($cursor as $document) {
					echo $itemTemplate;
    				echo $document["thumbUrl"] . "\n";
    				echo $itemTemplateEnd;
    			}
    			echo $wrapTemplateEnd;
				?>
			</div>

			<div class="carouselWrap">
				<h3>Most Popular</h3>
				<?php
				$cursor2 = $collection->find()->sort(array('numPVotes' => -1));
				$wrapTemplate = '<ul class="carousel carouselPopular">';
				$wrapTemplateEnd = '</ul>';
				$itemTemplate = '<li><img src="';
				$itemTemplateEnd = '" alt=""></li>';
				echo $wrapTemplate;
				foreach ($cursor2 as $document) {
					echo $itemTemplate;
    				echo $document["thumbUrl"] . "\n";
    				echo $itemTemplateEnd;
    			}
    			echo $wrapTemplateEnd;
    			
				?>
			</div>
			<div id="mapControls"></div>
			<div id="festival-map"></div>
		</div>
	</div>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/main.js"></script>
    <!-- Google Maps -->

    <!-- bxSlider Javascript file -->
	<script src="assets/js/jquery.bxslider.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAZAMhT8iWr710uQm37YfPgezScJ214xu8&sensor=true"></script>
	<script src="/assets/js/infobox.js" type="text/javascript"></script>
	<script>

	
	var postData2 = <?php echo json_encode(iterator_to_array($cursor2));?>

	var postData = <?php echo json_encode(iterator_to_array($cursor));?>

	function merge(a, b) {
	    for(var idx in b) {
	        a[idx] = b[idx];
	    } //done!
	}	
	merge(postData,postData2);
	</script>
	<script type="text/javascript">
var ib = new InfoBox();

//Create the variables that will be used within the map configuration options.
//The latitude and longitude of the center of the map.
var festivalMapCenter = new google.maps.LatLng(30.2500, -97.7500);
//The degree to which the map is zoomed in. This can range from 0 (least zoomed) to 21 and above (most zoomed).
var festivalMapZoom = 12;
//The max and min zoom levels that are allowed.
var festivalMapZoomMax = 20;
var festivalMapZoomMin = 2;

//These options configure the setup of the map. 
var festivalMapOptions = { 
		  center: festivalMapCenter, 
          zoom: festivalMapZoom,
		  //The type of map. In addition to ROADMAP, the other 'premade' map styles are SATELLITE, TERRAIN and HYBRID. 
          mapTypeId: google.maps.MapTypeId.ROADMAP,
		  maxZoom:festivalMapZoomMax,
		  minZoom:festivalMapZoomMin,
		  //Turn off the map controls as we will be adding our own later.
		  panControl: false,
		  mapTypeControl: true
};

//Create the variable for the main map itself.
var festivalMap;

//When the page loads, the line below calls the function below called 'loadFestivalMap' to load up the map.
google.maps.event.addDomListener(window, 'load', loadFestivalMap);



//THE MAIN FUNCTION THAT IS CALLED WHEN THE WEB PAGE LOADS --------------------------------------------------------------------------------
function loadFestivalMap() {

	
//The empty map variable ('festivalMap') was created above. The line below creates the map, assigning it to this variable. The line below also loads the map into the div with the id 'festival-map' (see code within the 'body' tags below), and applies the 'festivalMapOptions' (above) to configure this map. 
festivalMap = new google.maps.Map(document.getElementById("festival-map"), festivalMapOptions);	


//Calls the function below to load up all the map markers.
loadMapMarkers();

}



//Function that loads the map markers.
function loadMapMarkers (){

	function createMapMarker(post){
		var post = postData[Object.keys(postData)[i]];
			var markerShape = {
			 	coord: [12,4,216,22,212,74,157,70,184,111,125,67,6,56],
				type: 'poly'
			};

			var markerIcon = {
			 url: post.thumbUrl,
			 scaledSize: new google.maps.Size(100, 50),
			 origin: new google.maps.Point(0, 0),
			 anchor: new google.maps.Point(0, 0)
			};

			var xcoord = post.Coord.substr(0,post.Coord.indexOf(','));
			var ycoord = post.Coord.substr(post.Coord.indexOf(',')+1);
			var markerPosition = new google.maps.LatLng(xcoord, ycoord);
			var postStatus = post.current === true ?('active<br><span id="takenDown">taken down?</span>'):('inactive');
		
			var marker = new google.maps.Marker({
			 //uses the position set above.
			 position: markerPosition,
			 //adds the marker to the map.
			 map: festivalMap,
			 title: post.name,
			 //assigns the icon image set above to the marker.
			 icon: markerIcon,
			 //assigns the icon shape set above to the marker.
			 shape: markerShape,
			 //sets the z-index of the map marker.
			 zIndex:107,
			 //markers html content
			 content: '<span id="ibContentContainer" class="pop_up_box_text">' + 
			 			'<h3>'+ post.name +'</h3> ' +
			 			'<img class="mainContentImg" src="'+ post.imageUrl +'" />' +
			 			'<div class="mapInfoContainer">' +
			 			'<div class="mapInfoContainerLinks">' +
			 				'<div class="postStatus">Status: ' + postStatus +
			 				'</div>' +
			 				'<div id="inappropriateFlag"><span>report image</span></div></div>' +
			 				'<div class="postDetails">' +
			 					'<span class="postArtist">Artist: '+ post.artist +'</span>' +
			 					'<span class="postDescription">'+ post.description +'</span></div>' +
			 				'<div class="postVotingContainer">' +
			 				'<span style="display: none;">' + post._id.$id + '</span>' +
			 				'<button id="pVoteButton" type="button" class="btn btn-default btn-s">' +
			 					'<span class="glyphicon glyphicon-arrow-up"></span></button>' +
			 				'<button id="nVoteButton" type="button" class="btn btn-default btn-s">' +
			 					'<span class="glyphicon glyphicon-arrow-down"></span></button></div></span>'
			});

			var pop_up_info = "border: 0px solid black; background-color: #ffffff; padding:15px; margin-top: 8px; border-radius:10px; -moz-border-radius: 10px; -webkit-border-radius: 10px; box-shadow: 1px 1px #888;";

			var boxText = document.createElement("div");
			boxText.style.cssText = pop_up_info;
			boxText.innerHTML = marker.content;
			
			var infoboxOptions = {
			 content: boxText
			 ,disableAutoPan: false
			 ,maxWidth: 0
			 ,pixelOffset: new google.maps.Size(-200, -100)
			 ,zIndex: null
			 ,boxStyle: {
			 	background: "url('infobox/pop_up_box_top_arrow.png') no-repeat"
			 	,opacity: 1
			 	,width: "60%"
			 	,margin: "-20px 0px 0px 0px"

			 	}
			 ,closeBoxMargin: "-6px -10px 0px 2px"
			 ,closeBoxURL: "assets/img/remove-icon.png"
			 ,infoBoxClearance: new google.maps.Size(1, 1)
			 ,isHidden: false
			 ,pane: "floatPane"
			 ,enableEventPropagation: false
			};


			// click listener for markers
			google.maps.event.addListener(marker, "click", function (e) {
				festivalMap.set('scrollwheel',false);
				ib.close();

				ib.setOptions(infoboxOptions);
				 //Open the Glastonbury info box.
				 ib.open(festivalMap, this);
				 //Changes the z-index property of the marker to make the marker appear on top of other markers.
				 //this.setZIndex(google.maps.Marker.MAX_ZINDEX + 1);
				 //Zooms the map.
				 setZoomWhenMarkerClicked();
				 //Sets the Glastonbury marker to be the center of the map.
				 festivalMap.setCenter(marker.getPosition());
			
				 ib.addListener("domready", function() {

				 	google.maps.event.addDomListener(document.getElementById('takenDown'),"click",function(e){
			 		var id = post._id.$id;
					var xhr = new XMLHttpRequest()	
					var formData = new FormData();
				   	formData.append('postid',id);
				   	xhr.open('POST', '../../takedownvote.php', true);
				   	xhr.onload = function () {
				      if (xhr.status === 200) {
				      	//do vote recieved
				      } else {
				        alert('An error occurred!');
				      }
				      // Send the Data.
				    };
				    xhr.send(formData);
					});

					google.maps.event.addDomListener(document.getElementById('inappropriateFlag'),"click",function(e){
			 		var id = post._id.$id;
					var xhr = new XMLHttpRequest()	
					var formData = new FormData();
				   	formData.append('postid',id);
				   	xhr.open('POST', '../../inappvote.php', true);
				   	xhr.onload = function () {
				      if (xhr.status === 200) {
				      	//do vote recieved
				      } else {
				        alert('An error occurred!');
				      }
				      // Send the Data.
				    };
				    xhr.send(formData);
					});

				 	google.maps.event.addDomListener(document.getElementById('pVoteButton'),"click",function(e){
				 		var id = post._id.$id;
						var xhr = new XMLHttpRequest()	
						var formData = new FormData();
					   	formData.append('postid',id);
					   	xhr.open('POST', '../../pvote.php', true);
					   	xhr.onload = function () {
					      if (xhr.status === 200) {
					      	//do vote recieved
					      } else {
					        alert('An error occurred!');
					      }
					      // Send the Data.
					    };
					    xhr.send(formData);
					});
					google.maps.event.addDomListener(document.getElementById('nVoteButton'),"click",function(e){
						console.log('voting');
				 		var id = post._id.$id;
						var xhr = new XMLHttpRequest()	
						var formData = new FormData();
					   	formData.append('postid',id);
					   	xhr.open('POST', '../../nvote.php', true);
					   	xhr.onload = function () {
					      if (xhr.status === 200) {

					      	//do vote recieved
					      } else {
					        alert('An error occurred!');
					      }
					      // Send the Data.
					    };
					   
					});
					
				 });
					 
				 
			
			});
			google.maps.event.addListener(ib,'closeclick',function(){
			   festivalMap.set('scrollwheel',true);
			});
			//click listener for carousels
			var thumbs = $('.carousel').find('img[src*="'+post.thumbUrl+'"]');
			for(var j = 0; j < thumbs.length; j++){
				var thumb = thumbs[j].parentNode;
				google.maps.event.addDomListener(thumb, "click", function (e) {
				festivalMap.set('scrollwheel',false);
				ib.close();

				ib.setOptions(infoboxOptions);
			 //Open the Glastonbury info box.
			 ib.open(festivalMap, marker);
			 //Changes the z-index property of the marker to make the marker appear on top of other markers.
		//	 this.setZIndex(google.maps.Marker.MAX_ZINDEX + 1);
			 //Zooms the map.
			 setZoomWhenMarkerClicked();
			 //Sets the Glastonbury marker to be the center of the map.
			 festivalMap.setCenter(marker.getPosition());

			 ib.addListener("domready", function() {
			 	google.maps.event.addDomListener(document.getElementById('pVoteButton'),"click",function(e){
			 		var id = post._id.$id;
					var xhr = new XMLHttpRequest()	
					var formData = new FormData();
				   	formData.append('postid',id);
				   	xhr.open('POST', '../../pvote.php', true);
				   	xhr.onload = function () {
				      if (xhr.status === 200) {
				        // File(s) uploaded.
				        console.log('vote received!')
				      } else {
				        alert('An error occurred!');
				      }
				      // Send the Data.
				    };
				    xhr.send(formData);
				});
				google.maps.event.addDomListener(document.getElementById('nVoteButton'),"click",function(e){
			 		var id = post._id.$id;
					var xhr = new XMLHttpRequest()	
					var formData = new FormData();
				   	formData.append('postid',id);
				   	xhr.open('POST', '../../nvote.php', true);
				   	xhr.onload = function () {
				      if (xhr.status === 200) {
				      	//do vote recieved
				      } else {
				        alert('An error occurred!');
				      }
				      // Send the Data.
				    };
				    xhr.send(formData);
				});
			 });
			});

			}
			

		}
		for(var i = 0; i < Object.keys(postData).length; i++){
			var ab = postData[Object.keys(postData)[i]];
			createMapMarker(ab);

			
}


}
		


	 

function setZoomWhenMarkerClicked(){
var currentZoom = festivalMap.getZoom();
 if (currentZoom < 12){
 festivalMap.setZoom(12);
 }
}








</script>


  </body>
</html>
