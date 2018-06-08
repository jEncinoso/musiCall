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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <title> musiCall</title>
    <script type="text/javascript">
      var token="{{ csrf_token() }}";
    </script>

    <script type="text/javascript" src="{{URL::asset('./js/musiCall.js')}}"></script>

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
          <div class="autoMpHead">
            <div class="input-group-append">          
              <button type="submit"  id="uploadSongsButton" class="btn btn-primary col-12" style="z-index: 0">Upload Songs</button>
            </div>  
          </div>
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
        <div class="mpButtons btn-group btn-group-sm" role="group">
          <button class="btn"><input type="image" class="playImg col ml-3 col sm-3 col-xs-3 " src="./images/back.png" onclick="prevSong();"/></button>
          <button class="btn"><input type="image" class="playImg col ml-3 sm-3 xs-3" id="playIcon"  src="./images/play.png" onclick="playSong();"/></button>
          <button class="btn"><input type="image" class="playImg col ml-3 sm-3 xs-3" src="./images/next.png" onclick="nextSong();"/></button>
          <button class="btn"><input type="image" class="randomImg col ml-3 sm-3 xs-3" id="randomButton" src="./images/random.png" onclick="setRandomMusic();"/></button>
        </div>
      </div>

      <div class="row">
        <hr>
      </div>

      <div class="row nowPlayingRow">
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
        <div id="progress" class="progress">
          <input id="seekbar" type="range" name="rng" min="0" step="0.25" value="0" onchange="mSet()" style="width: 100%">
        </div>
        <div id="timer" class="col-2 currentTime">00:00</div> 
      
        <audio id="mp3" src="" data-song-name="" data-song-track="" data-song-artist="" data-song-album="" data-song-genre="" class="col-md-12" data-song-currentTime=""; onended="nextSong();" preload="metadata" onloadedmetadata="mDur()" ontimeupdate="mPlay()" controls="none" style="display:none;"></audio>

        <script type="text/javascript">
          var mp3=document.getElementById("mp3");
          var timeBar=document.getElementById('seekbar');
          var random=0;

          var mins=0;
          var secs=0;

          var time=0;
          setInterval(function(){
            if(parseInt(Math.floor(mp3.currentTime))>0 && document.getElementById('playIcon').src=="http://localhost/musiCall/public/images/pause.png"){
              length=getSongCurrentTime(mp3);
              mp3.setAttribute("data-song-currentTime", length);
              document.getElementById('timer').innerHTML=length;
            }
          }, 0);
        </script>
    </div>
  </body>
</html>