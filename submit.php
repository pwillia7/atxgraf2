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
		<div style='height: 650px;' id="Main">
		<div id="submitResponse"></div>
			<h1 class='submitTagLine'> submit a new tag </h1>

			<div class="formWrap">
				<form enctype="multipart/form-data" action="submitPost.php" method="POST" id="submitNewPostForm" role="form">
				 <p class="help-block">All text fields are optional</p>
				 <div class="form-group">
				 	<!-- <label for="Name">Name</label> -->
				    <input type="text" class="form-control" name="Name" placeholder="Name">
				 </div>
				 <div class="form-group">
				 	<!-- <label for="Artist">Artist</label> -->
				    <input type="text" class="form-control" name="Artist" placeholder="Artist">
				  </div>
				  <div class="form-group">
				    <!-- <label for="Description">Description</label> -->
				  	<textarea placeholder='Description' name='Description' class="form-control" rows="3"></textarea>
				  </div>
				  <div class="form-group">
				    <label for="Image">Select Image (Photo must have Geo-Location Data)</label>
				    <input name="Image" type="file" id="Image">
				    <p class="help-block"></p>
				  </div>
				  <div class="checkbox">
				    <label>
				      <input name='Exists' type="checkbox"> Does this tag currently exist?
				    </label>
				  </div>
				 <div class="form-group">
    				<input type="email" class="form-control" name="Email" placeholder="Your Email Address">
  				 </div>
				  <button type="submit" id="uploadSubmitButton" class="btn btn-default">Upload</button>
				</form>
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
   	var form = document.getElementById('submitNewPostForm');
    var fileSelect = document.getElementById('Image');
    var uploadButton = document.getElementById('uploadSubmitButton');
    var files = fileSelect.files;
  
    var xhr = new XMLHttpRequest();


    form.onsubmit = function(event) {
     event.preventDefault();

     var formData = new FormData(document.getElementById('submitNewPostForm'));

    // Update button text.
    uploadButton.innerHTML = 'Uploading...';

    // Loop through each of the selected files.
    for (var i = 0; i < files.length; i++) {
      var file = files[i];

      // Check the file type.
      if (!file.type.match('image.*')) {
        continue;
      }

      // Add the file to the request.
      formData.append('photos[]', file, file.name);
    }

    // Open XHR Request
    xhr.open('POST', 'submitPost.php', true);
	// xhr.setRequestHeader("Content-Type","multipart/form-data; boundary=---------------------------275932272513031");
    // Set up a handler for when the request finishes.
    xhr.onload = function () {
      if (xhr.status === 200) {
        // File(s) uploaded.
        uploadButton.innerHTML = 'Upload';
        document.getElementById('submitResponse').innerHTML = xhr.response;
      } else {
        alert('An error occurred!');
      }
      // Send the Data.
    };
    xhr.send(formData);
    
    }
</script>

  </body>
</html>
