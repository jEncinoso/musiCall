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
    <script type="text/javascript" src="{{URL::asset('js/rs.speech.js-master/src/rs.speech.js')}}"></script>

    <title> musiCall</title>

    <script type="text/javascript">
        var token="{{ csrf_token() }}";

        /**********************************************************/
        /*                       UI Methods                        / 
        /**********************************************************/
        function openNav() {
          document.getElementById("myNav").style.width = "100%";
        }
             
        function closeNav() {
          document.getElementById("myNav").style.width = "0%";
        }

        /**********************************************************/
        /*               Song List/Database Methods                / 
        /**********************************************************/
        function initiate(){
          showSongs();
          setTimeout(function(){ 
            songList = getSongList();
            console.log(songList);
          }, 1000);
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
          var parameters = "_token="+token;
          xhr.send(parameters);   
        }

        function showFilteredSongs(filter, name){
          var xhr = new XMLHttpRequest();
          xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById('mpSongs').innerHTML=this.responseText;
            }
          };

          var actualSongName = mp3.getAttribute("data-song-name");

          xhr.open("POST", 'getFilteredSong', true);
          xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          var parameters = "_token="+token+"&filter="+filter+"&name="+name;
          xhr.send(parameters); 

            setTimeout(function(){
              songList = getSongList();
              console.log(songList);
            }, 1000);

            setTimeout(function(){
              setAfterSongName(actualSongName);
            }, 1500);
        }

        function showOrderedSongs(order, field, filter, name){
          var xhr = new XMLHttpRequest();
          xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById('mpSongs').innerHTML=this.responseText;
            }
          };

          var actualSongName = mp3.getAttribute("data-song-name");
          
          xhr.open("POST", 'getOrderedSongs', true);
          xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          var parameters = "_token="+token+"&order="+order+"&field="+field+"&filter="+filter+"&name="+name;
          xhr.send(parameters);

            setTimeout(function(){
              songList = getSongList();
              setAfterSongName(actualSongName);
            }, 1000);
        }

        /**********************************************************/
        /*                Methods called by clicking               / 
        /**********************************************************/
        function playClickedSong(song, artist, album, genre, track){
          mp3.setAttribute("data-song-name", song);
          mp3.setAttribute("data-song-artist", artist);
          mp3.setAttribute("data-song-album", song);
          mp3.setAttribute("data-song-genre", artist);
          mp3.setAttribute("data-song-track", track);

          var songData = new Array(song, artist, album, genre);

          mp3.src="./music/"+song+".mp3";
          showSongData(songData);
          document.getElementById("playIcon").src="./images/pause.png";
          mp3.play();
        }

        function playSong(){
          //set first song of the list as default
          if(mp3.getAttribute("data-song-track")==""){
            mp3.setAttribute("data-song-track", "1");
          }

          var currentTime=mp3.currentTime;

          var iconPath=document.getElementById("playIcon").src;
          iconPath=iconPath.split("/");

          if(iconPath[iconPath.length-1]=="play.png"){
            document.getElementById("playIcon").src="./images/pause.png";
            var actualTrack = mp3.getAttribute("data-song-track");
            
            var songData = getSongData(actualTrack);

            mp3.src = "./music/"+encodeURIComponent(songData[0])+".mp3";

            setSongData(songData);

            if(currentTime>0){
              mp3.currentTime=currentTime;
              mp3.play();
              trackInfo.start();
            }else{
              showSongData(songData);
              trackInfo=document.getElementById('trackInfo');
              mp3.play();
            }
          }else if(iconPath[iconPath.length-1]=="pause.png"){
             pauseSong();
          }
        }

        function pauseSong(){
          document.getElementById("playIcon").src="./images/play.png";
          mp3.pause();
          trackInfo.stop();
        }

        function stopSong(){
          document.getElementById("playIcon").src="./images/play.png";
          mp3.pause();
          mp3.currentTime=0;
          document.getElementById("nowPlaying").innerHTML="";
        }

        function nextSong(){
          var actualTrack=mp3.getAttribute("data-song-track");
          actualTrack++;
          if(document.getElementById(actualTrack)==null){
            actualTrack=1;
          }
          mp3.setAttribute("data-song-track", actualTrack);

          var songData = getSongData(actualTrack);

          mp3.src="./music/"+encodeURIComponent(songData[0])+".mp3";
          setSongData(songData);
          
          showSongData(songData);
          trackInfo=document.getElementById('trackInfo');
          document.getElementById("playIcon").src="./images/pause.png";
          mp3.play();
        }

        function prevSong(){
          var actualTrack=mp3.getAttribute("data-song-track");
          actualTrack--;
          if(document.getElementById(actualTrack)==null){
            actualTrack=parseInt(document.getElementById("1").getAttribute("data-songs-quantity"));
          }
          
          mp3.setAttribute("data-song-track", actualTrack);

          var songData = getSongData(actualTrack);

          mp3.src="./music/"+encodeURIComponent(songData[0])+".mp3";
          setSongData(songData);
          
          showSongData(songData);
          trackInfo=document.getElementById('trackInfo');
          document.getElementById("playIcon").src="./images/pause.png";
          mp3.play();
        }

        /**********************************************************/
        /*                   Music Info Methods                    / 
        /**********************************************************/
        function getSongData(actualTrack){
          var name = document.getElementById(actualTrack).getAttribute("data-song-name");
          var artist = document.getElementById(actualTrack).getAttribute("data-song-artist");
          var album = document.getElementById(actualTrack).getAttribute("data-song-album");
          var genre = document.getElementById(actualTrack).getAttribute("data-song-genre");
        
          var songData = new Array(name, artist, album, genre);
          return songData;
        }

        function setSongData(songData){
          mp3.setAttribute("data-song-name", songData[0]);
          mp3.setAttribute("data-song-artist", songData[1]);
          mp3.setAttribute("data-song-album", songData[2]);
          mp3.setAttribute("data-song-genre", songData[3]);
        }

        function showSongData(songData){
          var name = songData[0];
          var artist = songData[1];
          var album = songData[2];
          var  genre = songData[3];

          document.getElementById("message").innerHTML="";
          document.getElementById("nowPlaying").innerHTML=
          "<marquee id='trackInfo'>"+name+" - <span onclick=\"showFilteredSongs('artist','"+artist+"'), openNav();\">"+artist+"</span>  - <span onclick=\"showFilteredSongs('album','"+album+"'), openNav();\">"+album+"</span> - <span onclick=\"showFilteredSongs('genre','"+genre+"'), openNav();\">"+genre+"</span></marquee>";
        }

        function setAfterSongName(name){
          for(var i=1;i<=songList.length-1;i++){
            if(name==songList[i][0]){
              mp3.setAttribute("data-song-track", songList[i][2]);
              break;
            }else{
              mp3.setAttribute("data-song-track", "");
            }
          }
        }

        function getSongList(){
          //var x = document.getElementById("tableSongs").rows[5].innerHTML;
          //alert(x);
          var songList = new Array(parseInt(document.getElementById("1").getAttribute("data-songs-quantity")));
          var length = songList.length;
          for(var i=1;i<=length;i++){
            var name = document.getElementById(i).getAttribute("data-song-name");
            var artist = document.getElementById(i).getAttribute("data-song-artist");
            var track = document.getElementById(i).getAttribute("data-song-track");

            songList[i] = new Array(name, artist, track);
          }
          return songList;
        }

        /**********************************************************/
        /*               Methods called by microphone              / 
        /**********************************************************/
        function recordAction(){
          var language = document.getElementById("selectLanguage").value;
          if(language == "English"){
            //English Voice Commands
            speechRs.rec_start('en-IN',function(final_transcript,interim_transcript){
              console.log(final_transcript,interim_transcript);
            });   

            speechRs.on("play",function(){ 
              playSong();
            }); 

            speechRs.on("pause",function(){ 
              pauseSong();
            }); 

            speechRs.on("stop",function(){ 
              stopSong();
            }); 

            speechRs.on("next",function(){ 
              nextSong();
            }); 

            speechRs.on("back",function(){ 
              prevSong();
            }); 

            /*speechRs.on("play artist",function(){ 
              var name="";
              showFilteredSongs("artist", name);
            }); */

          }else if(language = "Español"){              
            //Español Voice Commands

            speechRs.rec_start('es-ES',function(final_transcript,interim_transcript){
              console.log(final_transcript,interim_transcript);
            });   

            speechRs.on("reproducir",function(){ 
              playSong();
            }); 

            speechRs.on("parar",function(){ 
              pauseSong();
            }); 

            speechRs.on("stop",function(){ 
              stopSong();
            });

            speechRs.on("siguiente",function(){ 
              nextSong();
            }); 

            speechRs.on("canción",function(){ 
              prevSong();
            });

            //https://www.youtube.com/watch?v=BmdZtjxFFlQ
          }
        }
    </script>

  	</head>

  	<body onLoad="initiate();">
  		<nav class="navbar navbar-expand navbar-light bg-light">
		    <!--
          <a class="navbar-brand" href="">
		      </a>
        -->
		    <div>
		    	<span style="font-size:30px;" onclick="openNav()"> <img src="./images/logo.png" width="155" height="70"/></span>
        </div>
        <div class="navbar-nav ml-auto">
          <select id="selectLanguage">
            <option value="English">English</option>
            <option value="Español">Español</option>
          </select> 
        </div>  
	 	  </nav>

  	<div id="myNav" class="overlay" >
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
            <input type="hidden" id="hLanguage" name="language" value="English"/>
				  	<div class="input-group-append">	        
              <button type="submit"  id="uploadSongsButton" class="btn btn-primary" style="z-index: 0">Upload Songs</button>
						</div>	               	
					</div>
				</form>   
      </div>

      <div class="row">
        <hr>
      </div>

			<div class="row align-items-center justify-content-center">
        <div class="mpMicrophone">
          <input type="image" class="microImg" src="./images/microphone.png" onclick="recordAction();"/>
				</div>
      </div>
      <div class="row">
        <hr>
      </div>

			<div class="row align-items-center justify-content-center">
        <div class="mpButtons">
          <input type="image" class="playImg col ml-3" src="./images/back.png" onclick="prevSong();"/>
          <input type="image" id="playIcon" class="playImg col ml-3" src="./images/play.png" onclick="playSong();"/>
          <input type="image" class="playImg col ml-3" src="./images/next.png" onclick="nextSong();"/>
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
	          }
	        ?>
	      </div>
        <br>
        <div id="nowPlaying" class="col-md-12 col-sm-12 col-xs-12">
        </div>
      </div>
           
      <div class="row">
        <hr>
        <audio id="mp3" src="" data-song-name="" data-song-track="" data-song-artist="" data-song-album="" data-song-genre="" class="col-md-12" controls controlsList="nodownload" onended="nextSong();"></audio>
        <script type="text/javascript">
          var mp3=document.getElementById("mp3");
          var trackInfo;
        </script>

        <br><br>
            	<!--
            	  <div> 
        					<button onclick="mp3.play()">Play</button> 
        					<button onclick="mp3.pause()">Pause</button> 
        					<button onclick="mp3.volume += 0.1">Vol+ </button> 
        					<button onclick="mp3.volume -= 0.1">Vol- </button> 
      			  	</div>
      				-->
      </div>
      
      <div class="row">
      </div>

    </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 	</body>
</html>