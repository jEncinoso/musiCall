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

        function initiate(){
        	showSongs();
        }

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

        function playClickedSong(song, track){
        	document.getElementById('mp3').title=track;
        	document.getElementById('mp3').src="./music/"+song+".mp3";
        	showSongData(track);
        	document.getElementById("playIcon").src="./images/play.png";
        	document.getElementById('mp3').play();
        }

        function playSong(){
        	if(document.getElementById("playIcon").src=="./images/play.png"){
        		alert("jelous");
        		document.getElementById("playIcon").src="./images/pause.png";
        		document.getElementById('mp3').pause();
       		}else{
	        	if(document.getElementById("mp3").title==""){
	        		document.getElementById("mp3").title="1";
	        	}
	        	var actualTrack=document.getElementById("mp3").title;
	        	var song=document.getElementById(actualTrack).innerHTML;
	        	document.getElementById('mp3').src="./music/"+encodeURIComponent(song)+".mp3";
	        	showSongData(actualTrack);
	        	document.getElementById("playIcon").src="./images/play.png";
	        	document.getElementById('mp3').play();
	        }
        }

        function nextSong(){
        	var actualTrack=document.getElementById("mp3").title;
	        actualTrack++;
        	if(document.getElementById(actualTrack)!=null){
	        	var actualTrack=document.getElementById("mp3").title;
	        	actualTrack++;
	        	document.getElementById("mp3").title=actualTrack;
        	}else{
        		actualTrack=1;
	        	document.getElementById("mp3").title=actualTrack;
        	}
        	var song=document.getElementById(parseInt(actualTrack)).innerHTML;
        	document.getElementById('mp3').src="./music/"+encodeURIComponent(song)+".mp3";
        	showSongData(actualTrack);
        	document.getElementById("playIcon").src="./images/play.png";
        	document.getElementById('mp3').play();
        }

        function prevSong(){
        	var actualTrack=document.getElementById("mp3").title;
	        actualTrack--;
        	if(document.getElementById(actualTrack)!=null){
	        	var actualTrack=document.getElementById("mp3").title;
	        	actualTrack--;
	        	document.getElementById("mp3").title=actualTrack;
        	}else{
        		actualTrack=parseInt(document.getElementById("1").title);
	        	document.getElementById("mp3").title=actualTrack;
        	}
        	var song=document.getElementById(parseInt(actualTrack)).innerHTML;
        	document.getElementById('mp3').src="./music/"+encodeURIComponent(song)+".mp3";
        	showSongData(actualTrack);
        	document.getElementById("playIcon").src="./images/play.png";
        	document.getElementById('mp3').play();
        }

        function showSongData(track){
        	document.getElementById("message").innerHTML="";

        	var name=document.getElementById("h"+track+1).title;
        	var artist=document.getElementById("h"+track+2).title;
        	var album=document.getElementById("h"+track+3).title;
        	var genre=document.getElementById("h"+track+4).title;
        	document.getElementById("nowPlaying").innerHTML="<marquee>"+name+" - "+artist+" - "+album+" - "+genre+"</marquee>";
        }

        function setIcon(){
        	if(document.getElementById("playIcon").src=="./images/play.png"){
        		document.getElementById("playIcon").src="./images/pause.png";
        		document.getElementById('mp3').pause();
       		}
        }

    </script>

  	</head>
  	<body onLoad="initiate();">
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
                    <input type="image" class="playImg col ml-3" src="./images/back.png" onClick="prevSong();"/>
                    <input type="image" id="playIcon" class="playImg col ml-3" src="./images/play.png" onClick="playSong();"/>
                  	<input type="image" class="playImg col ml-3" src="./images/next.png" onClick="nextSong();"/>
               	</div>
            </div>

            <div class="row">
           	 	<hr>
           	</div>

            <div class="row">
            	<div id="message">
	                <?php
	                   	if(isset($message)){
	                        echo $message;
	                    }else if(isset($error)){
	                       	echo $error;
	                   	}
	               	?>
	            </div>
               	<br>
               	<div id="nowPlaying" class="col-md-12 col-sm-12 col-xs-12"></div>
            </div>
            <div class="row">
           	 	<hr>
              	<audio id="mp3" title="" src="" class="col-md-12" controls controlsList="nodownload"></audio>

              	<br><br>
            	<!--
            	<div> 
					<button onclick="document.getElementById('mp3').play()">Play</button> 
					<button onclick="document.getElementById('mp3').pause()">Pause</button> 
					<button onclick="document.getElementById('mp3').volume += 0.1">Vol+ </button> 
					<button onclick="document.getElementById('mp3').volume -= 0.1">Vol- </button> 
			  	</div>
				-->
           	</div>
            <div class="row"></div>
        </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 	</body>
</html>