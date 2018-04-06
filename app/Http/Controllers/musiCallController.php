<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class musiCallController extends Controller{

    public function uploadSongs(Request $request){
        $DirectoryToScan=$request->mpPath;
        if($DirectoryToScan!=""){
            if(is_dir($DirectoryToScan)){
                $songsFullTags=$this->getFullTags($DirectoryToScan);

                /////////////////////////////////////////////////////
                $exists;
                $songsUploaded=0;

                if(count($songsFullTags)>0){
                    for($i=0;$i<count($songsFullTags);$i++){
                        $exists=false;

                        $title=$songsFullTags[$i][0][0];
                        $artist=$songsFullTags[$i][1][0];
                        $album=$songsFullTags[$i][2][0];
                        $genre=$songsFullTags[$i][3][0];
                        $length=$songsFullTags[$i][4][0];
                            
                        $songs=DB::select('SELECT * FROM t_songs;');

                        if(count($songs)>0){   
                            for($j=0;$j<count($songs);$j++){
                                if($title == $songs[$j]->name && $artist == $songs[$j]->artist){
                                    $exists=true;
                                }
                            }
                            if($exists==true){
                                $message=$songsUploaded." new songs uploaded.";
                            }else{
                                DB::insert('INSERT INTO t_songs (name, artist, album, genre, length) VALUES (?,?,?,?,?)',[utf8_encode($title), utf8_encode($artist), utf8_encode($album), utf8_encode($genre), $length]);
                                $songsUploaded++;
                                //Method to move a file from one directory to another. rename(origin/name, destiny/name)
                                copy($DirectoryToScan."\\".$title.".mp3", ".\\music\\".$title.".mp3");
                                //Method to move a file from one directory to another. rename(origin/name, destiny/name)
                                //rename($DirectoryToScan."\\".$title.".mp3", ".\\music\\".$title.".mp3");
                                $message=$songsUploaded." new songs uploaded.";
                            }
                        }else{
                            DB::insert('INSERT INTO t_songs (name, artist, album, genre, length) VALUES (?,?,?,?,?)',[utf8_encode($title), utf8_encode($artist), utf8_encode($album), utf8_encode($genre), $length]);
                            $songsUploaded++;
                            copy($DirectoryToScan."\\".$title.".mp3", ".\\music\\".$title.".mp3");
                            //rename($DirectoryToScan."\\".$title.".mp3", ".\\music\\".$title.".mp3");
                            $message=$songsUploaded." new songs uploaded.";
                        }
                    }
                }else{
                    $message="0 songs found in ".$DirectoryToScan;
                }
                return view('player',['message'=>$message]);
                /////////////////////////////////////////////////////
            }else{
                $error=$DirectoryToScan." is not a folder.";
                return view('player',['error'=>$error]);
            }
        }else{
            $error="Write a music path.";
            return view('player',['error'=>$error]);
        }
    }

    private function getFullTags($DirectoryToScan){
        include(app_path().'/id3/getid3/getid3.php');
        /*
        Your class has been defined in the root namespace, you need to add a \ before the class name. Otherwise php will think it is in the same namespace as the current class, currently App\Http\Controllers.

            You should do something like this:

            $id3 = new getID3 = $id3 = new \getID3
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
                
                $title=array($songNames[$i]);
                array_push($songTags, $title);
                
                if(isset($tags['artist'])){
                    $artist=$tags['artist'];
                    array_push($songTags, $artist);
                }else{
                    $artist=array('unknown artist');
                    array_push($songTags, $artist);
                }

                if(isset($tags['album'])){
                    $album=$tags['album'];
                    array_push($songTags, $album);
                }else{
                    $album=array("unknown album");
                    array_push($songTags, $album);
                }

                if(isset($tags['genre'])){
                    $genre=$tags['genre'];
                    array_push($songTags, $genre);
                }else{
                    $genre=array('unknown genre');
                    array_push($songTags, $genre);
                }

                if(isset($ThisFileInfo["playtime_string"])){
                    $length=array($ThisFileInfo["playtime_string"]);
                    array_push($songTags, $length);
                }else if(isset($ThisFileInfo["playtime_seconds"])){
                    $time=$ThisFileInfo["playtime_seconds"]/60;
                    $mins=(int)$time;
                    $secs=($time-$mins)*60;
                    $secs=(int)$secs;
                    $length=$mins.":".$secs;
                    array_push($songTags, $length);
                }

                array_push($songsFullTags, $songTags);
            }
        }
        return $songsFullTags;
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