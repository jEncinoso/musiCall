<?php
require('./getid3/getid3.php');
ini_set('display_errors',0);

$artist;
$album;
$length;
$genre;

$totalCols = 0;

?>

<?php
	//methods
	function printSongName($FullFileName, $audioType){
		if($audioType == "mp3"){
			if(isset($ThisFileInfo['comments_html']['title'])){
				echo '<td class="title">'.$ThisFileInfo['comments_html']['title'][(count($ThisFileInfo['comments_html']['title'])-1)].'</td>';
			}else if($FullFileName!="") {
				$name=explode('\\',$FullFileName);
				$name=explode(".", $name[count($name)-1]);
				echo '<td class="title">'.$name[0].'</td>';
			}else{
				echo '<td class="title">Unknown Song</td>';
			}
		} else {
			echo '<td class="title">'.$name[0].'</td>';
		}
	}

	function printArtistName($ThisFileInfo){
		if(isset($ThisFileInfo['comments_html']['artist'])){
			echo '<td class="artist">'.$ThisFileInfo['comments_html']['artist'][(count($ThisFileInfo['comments_html']['artist'])-1)].'</td>';
		} else {
			echo '<td class="artist">Unknown Artist</td>';
		}
	}

	function printAlbumName($ThisFileInfo){
		if(isset($ThisFileInfo['comments_html']['album'])){
			echo '<td class="album">'.$ThisFileInfo['comments_html']['album'][(count($ThisFileInfo['comments_html']['album'])-1)].'</td>';
		} else {
			echo '<td class="album">Unknown Album</td>';
		}
	}

	function printGenre($ThisFileInfo){
		if(isset($ThisFileInfo['comments_html']['genre'])){
			echo '<td class="genre">'.$ThisFileInfo['comments_html']['genre'][(count($ThisFileInfo['comments_html']['genre'])-1)].'</td>';
		} else {
			echo '<td class="genre"></td>';
		}
	}

	function printYear($ThisFileInfo){
		if(isset($ThisFileInfo['comments_html']['year'])){
			echo '<td class="year">'.$ThisFileInfo['comments_html']['year'][(count($ThisFileInfo['comments_html']['year'])-1)].'</td>';
		} else {
			echo '<td class="year"></td>';
		}
	}
	
	$getID3 = new getID3;
	
	$files = scandir($DirectoryToScan);
	$totalAudio = 0;
	foreach($files as $file){
		$pos = strrpos($file, '.') + 1;
		$ext = strtolower(substr($file, $pos));

		
		if(($file !="." && $file != "..") && $ext==$audioType){
			$totalAudio++;
			$FullFileName = realpath($DirectoryToScan.'/'.$file);
			
			if (is_file($FullFileName)) {
				set_time_limit(30);
				$ThisFileInfo = $getID3->analyze($FullFileName);
				getid3_lib::CopyTagsToComments($ThisFileInfo);
				echo '<tr data-file="'.$ThisFileInfo['filename'].'">';

				if($title == 'true'){
					printSongName($FullFileName, $audioType);	
				}



				if($genre == 'true'){				
					printGenre($ThisFileInfo);
				}
				
				if($year == 'true'){				
					printYear($ThisFileInfo);
				}
			}
		}
	}
	
	if($totalAudio == 0){
		echo '<tr class="no-mp3s"><td colspan="' . $totalCols . '">Make sure your music directory has mp3 music there.</td></tr>';
	}
		
?>
	</tbody>
</table>