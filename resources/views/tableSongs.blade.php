<table id="tableSongs" class="table table-responsive">
	<tr>
		<td>
			<img id="refreshIcon" src="./images/refresh.png" onClick="initiate(); setTimeout(function(){setAfterSongName(mp3.getAttribute('data-song-name'));}, 1000);" vspace="10"/>
		</td>
		<td colspan="3">
			<font size="5">{{$filter}}{{$filterName}}</font>
		</td>
		<td>
			<a href="javascript:void(0)" onclick="closeNav()">&times;</a>
		</td>
	</tr>
	<tr>
		<th id="thName" class="thSongs">Name
			<img class="tableIcons desktop" src="./images/orderDown.png" onclick='showOrderedSongs("down","name","{{$filter}}","{{$filterName}}");'/>
			<img class="tableIcons desktop" src="./images/orderUp.png" onclick='showOrderedSongs("up","name","{{$filter}}","{{$filterName}}");'/>

			<div class="orderArrows">
				<img class="tableIcons" src="./images/orderDown.png" onclick='showOrderedSongs("down","name","{{$filter}}","{{$filterName}}");'/>
				<img class="tableIcons" src="./images/orderUp.png" onclick='showOrderedSongs("up","name","{{$filter}}","{{$filterName}}");'/>
			</div>
		</th>
		<th id="thArtist" class="thSongs">Artist
			<img class="tableIcons desktop" src="./images/orderDown.png" onclick='showOrderedSongs("down","artist","{{$filter}}","{{$filterName}}");'/>
			<img class="tableIcons desktop" src="./images/orderUp.png" onclick='showOrderedSongs("up","artist","{{$filter}}","{{$filterName}}");'/>

			<div class="orderArrows">
				<img class="tableIcons" src="./images/orderDown.png" onclick='showOrderedSongs("down","artist","{{$filter}}","{{$filterName}}");'/>
				<img class="tableIcons" src="./images/orderUp.png" onclick='showOrderedSongs("up","artist","{{$filter}}","{{$filterName}}");'/>
			</div>
		</th>
		<th id="thAlbum" class="thSongs">Album
			<img class="tableIcons desktop" src="./images/orderDown.png" onclick='showOrderedSongs("down","album","{{$filter}}","{{$filterName}}");'/>
			<img class="tableIcons desktop" src="./images/orderUp.png" onclick='showOrderedSongs("up","album","{{$filter}}","{{$filterName}}");'/>

			<div class="orderArrows">
				<img class="tableIcons" src="./images/orderDown.png" onclick='showOrderedSongs("down","album","{{$filter}}","{{$filterName}}");'/>
				<img class="tableIcons" src="./images/orderUp.png" onclick='showOrderedSongs("up","album","{{$filter}}","{{$filterName}}");'/>
			</div>
		</th>
		<th id="thGenre" class="thSongs">Genre
			<img class="tableIcons desktop" src="./images/orderDown.png" onclick='showOrderedSongs("down","genre","{{$filter}}","{{$filterName}}");'/>
			<img class="tableIcons desktop" src="./images/orderUp.png" onclick='showOrderedSongs("up","genre","{{$filter}}","{{$filterName}}");'/>

			<div class="orderArrows">
				<img class="tableIcons" src="./images/orderDown.png" onclick='showOrderedSongs("down","genre","{{$filter}}","{{$filterName}}");'/>
				<img class="tableIcons" src="./images/orderUp.png" onclick='showOrderedSongs("up","genre","{{$filter}}","{{$filterName}}");'/>
			</div>
		</th>
		<th id="thLength" class="thSongs">Length
			<img class="tableIcons desktop" src="./images/orderDown.png" onclick='showOrderedSongs("down","length","{{$filter}}","{{$filterName}}");'/>
			<img class="tableIcons desktop" src="./images/orderUp.png" onclick='showOrderedSongs("up","length","{{$filter}}","{{$filterName}}");'/>

			<div class="orderArrows">
				<img class="tableIcons" src="./images/orderDown.png" onclick='showOrderedSongs("down","length","{{$filter}}","{{$filterName}}");'/>
				<img class="tableIcons" src="./images/orderUp.png" onclick='showOrderedSongs("up","length","{{$filter}}","{{$filterName}}");'/>
			</div>
		</th>
	</tr>

	<?php
		$counter=1;
		$totalSongs=0;
	
		foreach($songs as $song){
			$totalSongs++;
		}	
	?>

	@foreach($songs as $song)
		<tr>	
			<td class="tdSongs" id='{{$counter}}' data-songs-quantity="{{$totalSongs}}" data-song-name="{{$song->name}}" data-song-artist="{{$song->artist}}" data-song-album="{{$song->album}}" data-song-genre="{{$song->genre}}" data-song-track="{{$counter}}" onclick='playClickedSong("{{$song->name}}","{{$song->artist}}","{{$song->album}}", "{{$song->genre}}","{{$counter}}"); closeNav();'>{{$song->name}}</td>
			<td class="tdSongs" onclick='showFilteredSongs("artist","{{$song->artist}}")'>{{$song->artist}}</td>
			<td class="tdSongs" onclick='showFilteredSongs("album","{{$song->album}}")'>{{$song->album}}</td>
			<td class="tdSongs" onclick='showFilteredSongs("genre","{{$song->genre}}")'>{{$song->genre}}</td>
			<td class="tdSongs">{{$song->length}}</td>
			
		</tr>
	<?php
		$counter++;
	?>	
	@endforeach
</table>
