<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class musiCallController extends Controller{

    public function uploadSongs(Request $request){
        //$DirectoryToScan=$request->mpPath;
        $DirectoryToScan="./music";
        if($DirectoryToScan!=""){
            if(is_dir($DirectoryToScan)){
                $songsFullTags=$this->getFullTags($DirectoryToScan);
                
                $exists;
                $songsUploaded=0;
                if(count($songsFullTags)>0){
                    for($i=0;$i<count($songsFullTags);$i++){

                        $title=$songsFullTags[$i][0];
                        $artist=$songsFullTags[$i][1];
                        $album=$songsFullTags[$i][2];
                        $genre=$songsFullTags[$i][3];
                        $length=$songsFullTags[$i][4];

                        $song=DB::select('SELECT * FROM t_songs WHERE name=? AND artist=?',[$title, $artist]);

                        if(!count($song)>0){
                            if(DB::insert('INSERT INTO t_songs (name, artist, album, genre, length) VALUES (?,?,?,?,?)',[utf8_encode($title), utf8_encode($artist), utf8_encode($album), utf8_encode($genre), $length])==true){

                                //Method to COPY a file from one directory to another. copy(origin/name, destiny/name)
                                //copy($DirectoryToScan."\\".$title.".mp3", ".\\music\\".$title.".mp3");

                                //Method to MOVE a file from one directory to another. rename(origin/name, destiny/name)
                                //rename($DirectoryToScan."\\".$title.".mp3", ".\\music\\".$title.".mp3");  

                                $songsUploaded++;   
                            }
                        }
                    }
                    $message=$songsUploaded." new songs uploaded.";
                }else{
                    $message="0 songs found in ".$DirectoryToScan;
                }
            }else{
                $message=$DirectoryToScan." is not a folder.";
            }
        }else{
            $message="Write a music path.";
        }
        return view('player',['message'=>$message]);
    } 

    private function getFullTags($DirectoryToScan){
        include(app_path().'/id3/getid3/getid3.php');
        /*
        Your class has been defined in the root namespace, you need to add a \ before the class name. Otherwise php will think it is in the same namespace as the current class, currently App\Http\Controllers.

            You should do something like this:

            $id3 = new getID3 | $id3 = new \getID3
        */
        
        $getID3 = new \getID3;

        $files=scandir($DirectoryToScan);

        //array with real path (url);. Ex: [url/name.mp3, url/name.mp3, url/name.mp3, ...]
        $realPath=array(); 

        //array with songNames. Ex: [name, name, name, ...]
        $songNames=array(); 

        //array with tags per song. Ex: [title, artis, album, ...]
        $songTags=array();  

        //array with all songs including tags. Ex: [songTags, songTags, songTags, ...]
        $songsFullTags=array(); 


        for($i=0;$i<count($files);$i++){
            $FullFileName=$DirectoryToScan."/".$files[$i];
            $format=explode(".",$FullFileName);

            $name=explode('/',$FullFileName);

            $name=$name[count($name)-1];

            $name=substr($name,0,strlen($name)-4);
            if($format[count($format)-1] == "mp3"){
                array_push($songNames, $name);          
                array_push($realPath, $FullFileName);
            }
        }

        for($i=0;$i<count($realPath);$i++){
            set_time_limit(30);
            $ThisFileInfo = $getID3->analyze($realPath[$i]);
            if(isset($ThisFileInfo['tags']['id3v2'])){
                $tags=$ThisFileInfo['tags']['id3v2'];
            }else if(isset($ThisFileInfo['tags']['id3v1'])){
                $tags=$ThisFileInfo['tags']['id3v1'];
            }

            $songTags=array();

            if(isset($ThisFileInfo['tags'])){
                
                $title=$songNames[$i];
                array_push($songTags, $title);
                
                if(isset($tags['artist'])){
                    $artist=$tags['artist'][0];

                    array_push($songTags, $artist);
                }else{
                    $artist='unknown artist';
                    array_push($songTags, $artist);
                }

                if(isset($tags['album'])){
                    $album=$tags['album'][0];;
                    array_push($songTags, $album);
                }else{
                    $album="unknown album";
                    array_push($songTags, $album);
                }

                if(isset($tags['genre'])){
                    $genre=$tags['genre'][0];;
                    array_push($songTags, $genre);
                }else{
                    $genre='unknown genre';
                    array_push($songTags, $genre);
                }

                if(isset($ThisFileInfo["playtime_string"])){
                    $length=$ThisFileInfo["playtime_string"];
                    array_push($songTags, $length);
                }else if(isset($ThisFileInfo["playtime_seconds"])){
                    $length=$this->getSongLength($ThisFileInfo["playtime_seconds"]/60);
                    array_push($songTags, $length);
                }

                array_push($songsFullTags, $songTags);
            }
        }
        return $songsFullTags;
    }

    public function checkSongs(){
        $DirectoryToScan="./music";
        $files=scandir($DirectoryToScan);
        $names=array();
        for($i=0;$i<count($files);$i++){
            $name=explode('.',$files[$i]);
            array_push($names, $name[0]);
        }
        $songs=DB::select("SELECT * FROM t_songs;");
        $exists;
        foreach($songs as $song){
            var_dump($song->name);
            for($i=0;$i<count($names);$i++){
                if($song->name == $names[$i]){
                    $exists=true;
                    break;
                }else{
                    $exists=false;
                }
            }
            if($exists==false){
                DB::delete("DELETE FROM t_songs WHERE name=?;",[$song->name]);
            }
        }
    }

    private function getSongLength($time){
        $mins=(int)$time;
        $secs=($time-$mins)*60;
        $secs=(int)$secs;
        $length=$mins.":".$secs;
        return $length;
    }

    public function getSongs(Request $request){
        $songs=DB::select('SELECT * FROM t_songs;');
        return view('tableSongs', ['songs'=>$songs, 'filter'=>"All", 'filterName'=>""]);
    }

    public function getFilteredSong(Request $request){
        $filter=$request->filter;
        $name=$request->name;
        $songs=DB::select('SELECT * FROM t_songs WHERE '.$filter.'=?;',[$name]);
        $filter=strtoupper($filter[0]).substr($filter,1);
        return view('tableSongs', ['songs'=>$songs, 'filter'=>$filter." - ", 'filterName'=>$name]);
    }

    public function getOrderedSongs(Request $request){
        $order=$request->order;
        $field=$request->field;
        $filter=$request->filter;

        if(strpos($filter, "-")>0){
            $filter=explode(" ",$filter);
            $filter=$filter[0];
        }

        $name=$request->name;

        if($order=="up"){
            if($filter!="All"){
                $songs=DB::select('SELECT * FROM t_songs WHERE '.$filter.'=? ORDER BY '.$field.' ASC;',[$name]);
            }else{
                $songs=DB::select('SELECT * FROM t_songs ORDER BY '.$field.' ASC;');
            }
        }else{
            if($filter!="All"){
                $songs=DB::select('SELECT * FROM t_songs WHERE '.$filter.'=? ORDER BY '.$field.' DESC;',[$name]);
            }else{
                $songs=DB::select('SELECT * FROM t_songs ORDER BY '.$field.' DESC;');
            }
        }

        if($filter!="All"){
            return view('tableSongs', ['songs'=>$songs, 'filter'=>$filter." - ", 'filterName'=>$name]);
        }else{
            return view('tableSongs', ['songs'=>$songs, 'filter'=>$filter, 'filterName'=>$name]);
        }
    }
}