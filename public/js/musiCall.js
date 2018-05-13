
  /**********************************************************/
  /*                    Overlay Methods                      /
  /**********************************************************/

  function openNav() {
    document.getElementById("myNav").style.width = "100%";
  }
             
  function closeNav() {
    document.getElementById("myNav").style.width = "0%";
  }

  $(document).keydown(function(e) {
    if (e.keyCode == 27) {
      closeNav();
    }
  });

  /**********************************************************/
  /*             Song List/Database Methods/AJAX             / 
  /**********************************************************/
  function initiate(){
    checkSongs();
    setTimeout(function(){
      showSongs();
    },1000);
  }

  function checkSongs(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
      }
    };
    xhr.open("POST", 'checkSongs', true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var parameters = "_token="+token;
    xhr.send(parameters);   
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

    setTimeout(function(){ 
      songList = getSongList();
    }, 1000);
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
    }, 300);

    setTimeout(function(){
      setAfterSongName(actualSongName);
    }, 500);
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
  function playClickedSong(track){
    setTimerTo0();
    var trackInfo=trackInfo=document.getElementById('trackInfo');
    var songData = getSongData(track);

    mp3.src = "./music/"+encodeURIComponent(songData[0])+".mp3";

    setSongData(songData);
    showSongData(songData);
    mp3.setAttribute("data-song-track", track);
    document.getElementById("playIcon").src="./images/pause.png";
    mp3.play();
  }

  function playSong(){
    var trackInfo=trackInfo=document.getElementById('trackInfo');
    //set first song of the list as default
    if(mp3.getAttribute("data-song-track")=="" || mp3.getAttribute("data-song-track")==0){
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
    setTimerTo0();
    document.getElementById("playIcon").src="./images/play.png";
    mp3.pause();
    mp3.currentTime=0;
    document.getElementById("nowPlaying").innerHTML="";
  }

  function nextSong(){
    setTimerTo0();
    actualTrack=mp3.getAttribute("data-song-track");    var trackInfo=trackInfo=document.getElementById('trackInfo');

    if(random==1){
      var limit = document.getElementById("1").getAttribute("data-songs-quantity");
      actualTrack= Math.floor((Math.random() * limit) + 1);
    }else{
      actualTrack++;

      if(actualTrack>document.getElementById("1").getAttribute("data-songs-quantity")){
        actualTrack=1;
      }
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
    setTimerTo0();
    var trackInfo=trackInfo=document.getElementById('trackInfo');
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

  function setRandomMusic(){
    if(random==1){
      random=0;
      document.getElementById('randomButton').src="./images/random.png";
    }else{
      random=1;
      document.getElementById('randomButton').src="./images/randomPressed.png";
    }
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
    var genre = songData[3];

    document.getElementById("message").innerHTML="";
    document.getElementById("nowPlaying").innerHTML=
    "<marquee id='trackInfo'>"+name+" - <span onclick=\"showFilteredSongs('artist','"+artist+"'), openNav();\">"+artist+"</span>  - <span onclick=\"showFilteredSongs('album','"+album+"'), openNav();\">"+album+"</span> - <span onclick=\"showFilteredSongs('genre','"+genre+"'), openNav();\">"+genre+"</span></marquee>";
  }

  function setAfterSongName(name){
    for(var i=1;i<=songList.length-1;i++){
      if(name==songList[i][0]){
        mp3.setAttribute("data-song-track", songList[i][4]);
        console.log(songList[i][4]);
        break;
      }else{
        mp3.setAttribute("data-song-track", 0)
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
      var album = document.getElementById(i).getAttribute("data-song-album");
      var genre = document.getElementById(i).getAttribute("data-song-genre");
      var track = document.getElementById(i).getAttribute("data-song-track");
      songList[i] = new Array(name, artist, album, genre, track);
    }
    return songList;
  }

  function setTimerTo0(){
    document.getElementById('timer').innerHTML="00:00";
  }

  function getSongCurrentTime(mp3){
    secs=parseInt(mp3.currentTime);
    mins=parseInt(secs/60);

    if(secs>=60){
      secs=secs-60*mins;
    }

    if(secs<10){
      secs="0"+secs;
    }
    if(mins<10){
      mins="0"+mins;
    }
  
    length=mins+":"+secs;

    return length;
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
        if(final_transcript.includes("play") && final_transcript.length>3){  
          for(var i=1;i<songList.length-1;i++){
            var songTitle = final_transcript.split("play");
            songTitle = songTitle[1].trim();

            if(final_transcript.includes("play") && songList[i][0].includes(songTitle)){  
                track=songList[i][4];
                playClickedSong(track);
                console.log("click");
            }
          
            if(final_transcript.toLowerCase() == "play "+songList[i][1].toLowerCase()){
              showFilteredSongs("artist", songList[i][1]);
              setTimeout(function(){
                playSong();
                console.log("artista");
              },2000);
              break;
            }

            if(final_transcript.toLowerCase() == "play "+songList[i][2].toLowerCase()){
              showFilteredSongs("album", songList[i][2]);
              setTimeout(function(){
                playSong();
                console.log("album");
              },1500);
              break;
            }        

            if(final_transcript.toLowerCase() == "play "+songList[i][3].toLowerCase()){
              showFilteredSongs("genre", songList[i][3]);
              setTimeout(function(){
                playSong();
                console.log("genero");
              },1500);
              break;
            }

            if(final_transcript.toLowerCase() == "play "+songList[i][4].toLowerCase()){
              track=songList[i][4];
              playClickedSong(track);
              console.log("numero");
              break;
            }
          }
        }

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

      speechRs.on("random",function(){ 
        setRandomMusic();
      }); 

    }

    if(language == "Español"){              
      //Español Voice Commands

      speechRs.rec_start('es-ES',function(final_transcript,interim_transcript){
         console.log(final_transcript,interim_transcript);
        if(final_transcript.includes("reproducir") && final_transcript.length>3){  
          for(var i=1;i<songList.length-1;i++){
            var songTitle = final_transcript.split("reproducir");
            songTitle = songTitle[1].trim();

            if(final_transcript.includes("reproducir") && songList[i][0].includes(songTitle)){  
                track=songList[i][4];
                playClickedSong(track);
                console.log("click");
            }
          
            if(final_transcript.toLowerCase() == "reproducir "+songList[i][1].toLowerCase()){
              showFilteredSongs("artist", songList[i][1]);
              setTimeout(function(){
                playSong();
                console.log("artista");
              },1500);
              break;
            }

            if(final_transcript.toLowerCase() == "reproducir "+songList[i][2].toLowerCase()){
              showFilteredSongs("album", songList[i][2]);
              setTimeout(function(){
                playSong();
                console.log("album");
              },1500);
              break;
            }        

            if(final_transcript.toLowerCase() == "reproducir "+songList[i][3].toLowerCase()){
              showFilteredSongs("genre", songList[i][3]);
              setTimeout(function(){
                playSong();
                console.log("genero");
              },1500);
              break;
            }

            if(final_transcript.toLowerCase() == "reproducir "+songList[i][4].toLowerCase()){
              track=songList[i][4];
              playClickedSong(track);
              console.log("numero");
              break;
            }
          }
        }
      });   

      speechRs.on("reproducir",function(){ 
        playSong();
      }); 

      speechRs.on("pausar",function(){ 
        pauseSong();
      }); 

      speechRs.on("parar",function(){ 
        stopSong();
      });

      speechRs.on("siguiente",function(){ 
        nextSong();
      }); 

      speechRs.on("anterior",function(){ 
        prevSong();
      });

      speechRs.on("aleatorio",function(){ 
        setRandomMusic();
      });
      
     
     //https://www.youtube.com/watch?v=BmdZtjxFFlQ
    }
  }

  /**********************************************************/
  /*                  Control Methods                        / 
  /**********************************************************/
  function mDur(){
    timeBar.max= mp3.duration;
  }

  function mPlay(){
    timeBar.value=mp3.currentTime;
  }

  function mSet(){
    mp3.currentTime=timeBar.value;
  }