<table id="tableSongs" class="table table-responsive">
	<tr>
		<td>
			<img id="refreshIcon" src="./images/refresh.png" onClick="showSongs();" vspace="10"/>
		</td>
		<td colspan="3">
			<font size="5">{{$filter}}{{$filterName}}</font>
		</td>
		<td>
			<a href="javascript:void(0)" onclick="closeNav()">&times;</a>
		</td>
	</tr>
	<tr>
		<th id="thName">Name
			<img class="tableIcons" src="./images/orderDown.png" onclick="showOrderedSongs('down','name','{{$filter}}','{{$filterName}}');"/>
			<img class="tableIcons" src="./images/orderUp.png" onclick="showOrderedSongs('up','name','{{$filter}}','{{$filterName}}');"/>
		</th>
		<th id="thArtist">Artist
			<img class="tableIcons" src="./images/orderDown.png" onclick="showOrderedSongs('down','artist','{{$filter}}','{{$filterName}}');"/>
			<img class="tableIcons" src="./images/orderUp.png" onclick="showOrderedSongs('up','artist','{{$filter}}','{{$filterName}}');"/>
		</th>
		<th id="thAlbum">Album
			<img class="tableIcons" src="./images/orderDown.png" onclick="showOrderedSongs('down','album','{{$filter}}','{{$filterName}}');"/>
			<img class="tableIcons" src="./images/orderUp.png" onclick="showOrderedSongs('up','album','{{$filter}}','{{$filterName}}');"/>
		</th>
		<th id="thGenre">Genre
			<img class="tableIcons" src="./images/orderDown.png" onclick="showOrderedSongs('down','genre','{{$filter}}','{{$filterName}}');"/>
			<img class="tableIcons" src="./images/orderUp.png" onclick="showOrderedSongs('up','genre','{{$filter}}','{{$filterName}}');"/>
		</th>
		<th id="thLength">Length
			<img class="tableIcons" src="./images/orderDown.png" onclick="showOrderedSongs('down','length','{{$filter}}','{{$filterName}}');"/>
			<img class="tableIcons" src="./images/orderUp.png" onclick="showOrderedSongs('up','length','{{$filter}}','{{$filterName}}');"/>
		</th>
	</tr>

	<?php
		$counter=1;
		$counterHidden=1;
		$totalSongs=0;
	
		foreach($songs as $song){
			$totalSongs++;
		}	
	?>

	@foreach($songs as $song)
		<tr>
			<td id='s{{$counter}}{{$counterHidden}}' hidden title='{{$song->name}}'></td>
			<?php
				$counterHidden++;
			?>	
			<td id='s{{$counter}}{{$counterHidden}}' hidden title="{{$song->artist}}"></td>
			<?php
				$counterHidden++;
			?>	
			<td id='s{{$counter}}{{$counterHidden}}' hidden title="{{$song->album}}"></td>
			<?php
				$counterHidden++;
			?>	
			<td id='s{{$counter}}{{$counterHidden}}' hidden title="{{$song->genre}}"></td>
			<?php
				$counterHidden++;
			?>	
			
			<td id='{{$counter}}' title="{{$totalSongs}}" onclick='playClickedSong("{{$song->name}}","{{$counter}}"); closeNav();'>{{$song->name}}</td>
			<td onclick="showFilteredSongs('artist','{{$song->artist}}')">{{$song->artist}}</td>
			<td onclick="showFilteredSongs('album','{{$song->album}}')">{{$song->album}}</td>
			<td onclick="showFilteredSongs('genre','{{$song->genre}}')">{{$song->genre}}</td>
			<td>{{$song->length}}</td>
			
		</tr>
	<?php
		$counter++;
		$counterHidden=1;
	?>	
	@endforeach
</table>
