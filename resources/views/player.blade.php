<!Doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- own CSS -->
    <link rel="stylesheet" type="text/css" href="./css/style.css">


    <title> musiCall</title>

    <script type="text/javascript">
        var token="{{ csrf_token() }}";

        function showSongs(){
         	var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                        document.getElementById('mpSongs').innerHTML=this.responseText;
                    }
                };

            xhr.open("POST", 'getSongs', true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            var parametros = "_token="+token;
            xhr.send(parametros);   
        }

        function playSong(song){
          document.getElementById('mp3').src="D:\\Users\\musica\\OTROS\\"+song+".mp3";
          document.write(document.getElementById('mp3').src);
        }

    </script>

  	</head>
  	<body onload="showSongs();">
  		<nav class="navbar navbar-expand navbar-light bg-light">
		    <a class="navbar-brand" href="#">
		      	<img src="" width="38" height="38" class="d-inline-block align-top" alt="">MusiCall
		    </a>
		    <div>
		    	<span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Songs</span>
		    	<script>
		      		function openNav() {
		      			document.getElementById("myNav").style.width = "100%";
		      		}
		      		
		      		function closeNav() {
		      			document.getElementById("myNav").style.width = "0%";
	     			}
	     		</script>
	    	</div>
	 	</nav>
  		<div id="myNav" class="overlay " >
		  	<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		 	<div class="overlay-content">
			    <div class="mpSongs" id="mpSongs">
				</div>
		  	</div>
		</div>

    	<div class="container">
                <!-- Content here -->
            <h1 align="center"></h1>

            <div class="row">
				<form method="post" class="col-md-12 col-sm-12 col-xs-12" action="uploadSongs">
                {{ csrf_field() }}
	                <div class="mpHead input-group">
	                    <input type="text" class="form-control" name="mpPath" id="mpPath" placeholder="Music Path" aria-label="Recipient's username" aria-describedby="basic-addon2">
				  		<div class="input-group-append">
			                    <button type="submit" class="btn btn-primary" style="z-index: 0">Upload Songs</button>
						</div>	               	
					</div>
				</form>   
            </div>

            <div class="row">
           	 	<hr>
           	</div>

			<div class="row align-items-center justify-content-center">
                <div class="mpMicrophone">
                   	<input type="image" class="microImg" src="./images/microphone.png"/>
				</div>
            </div>
            <div class="row">
           	 	<hr>
           	</div>

			<div class="row align-items-center justify-content-center">
                <div class="mpButtons">
                    <input type="image" class="playImg col ml-3" src="./images/back.png"/>
                    <input type="image" class="playImg col ml-3" src="./images/play.png"/>
                  	<input type="image" class="playImg col ml-3" src="./images/next.png"/>
               	</div>
            </div>

            <div class="row">
           	 	<hr>
           	</div>

            <div class="row">
                <?php
                   	if(isset($message)){
                        echo $message;
                    }else if(isset($error)){
                       	echo $error;
                   	}
               	?>
            </div>
            <div class="row">
           	 	<hr>
              <audio id="mp3" src="Toto - Africa.mp3" class="col-md-12" controls></audio>
           	</div>
            <div class="row">

            </div>
        </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 	</body>
</html>