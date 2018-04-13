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
			<img class="tableIcons desktop" src="./images/orderDown.png" onclick="showOrderedSongs('down','name','{{$filter}}','{{$filterName}}');"/>
			<img class="tableIcons desktop" src="./images/orderUp.png" onclick="showOrderedSongs('up','name','{{$filter}}','{{$filterName}}');"/>

			<div class="orderArrows">
				<img class="tableIcons" src="./images/orderDown.png" onclick="showOrderedSongs('down','name','{{$filter}}','{{$filterName}}');"/>
				<img class="tableIcons" src="./images/orderUp.png" onclick="showOrderedSongs('up','name','{{$filter}}','{{$filterName}}');"/>
			</div>
		</th>
		<th id="thArtist">Artist
			<img class="tableIcons desktop" src="./images/orderDown.png" onclick="showOrderedSongs('down','name','{{$filter}}','{{$filterName}}');"/>
			<img class="tableIcons desktop" src="./images/orderUp.png" onclick="showOrderedSongs('up','name','{{$filter}}','{{$filterName}}');"/>

			<div class="orderArrows">
				<img class="tableIcons" src="./images/orderDown.png" onclick="showOrderedSongs('down','name','{{$filter}}','{{$filterName}}');"/>
				<img class="tableIcons" src="./images/orderUp.png" onclick="showOrderedSongs('up','name','{{$filter}}','{{$filterName}}');"/>
			</div>
		</th>
		<th id="thAlbum">Album
			<img class="tableIcons desktop" src="./images/orderDown.png" onclick="showOrderedSongs('down','name','{{$filter}}','{{$filterName}}');"/>
			<img class="tableIcons desktop" src="./images/orderUp.png" onclick="showOrderedSongs('up','name','{{$filter}}','{{$filterName}}');"/>

			<div class="orderArrows">
				<img class="tableIcons" src="./images/orderDown.png" onclick="showOrderedSongs('down','name','{{$filter}}','{{$filterName}}');"/>
				<img class="tableIcons" src="./images/orderUp.png" onclick="showOrderedSongs('up','name','{{$filter}}','{{$filterName}}');"/>
			</div>
		</th>
		<th id="thGenre">Genre
			<img class="tableIcons desktop" src="./images/orderDown.png" onclick="showOrderedSongs('down','name','{{$filter}}','{{$filterName}}');"/>
			<img class="tableIcons desktop" src="./images/orderUp.png" onclick="showOrderedSongs('up','name','{{$filter}}','{{$filterName}}');"/>

			<div class="orderArrows">
				<img class="tableIcons" src="./images/orderDown.png" onclick="showOrderedSongs('down','name','{{$filter}}','{{$filterName}}');"/>
				<img class="tableIcons" src="./images/orderUp.png" onclick="showOrderedSongs('up','name','{{$filter}}','{{$filterName}}');"/>
			</div>
		</th>
		<th id="thLength">Length
			<img class="tableIcons desktop" src="./images/orderDown.png" onclick="showOrderedSongs('down','name','{{$filter}}','{{$filterName}}');"/>
			<img class="tableIcons desktop" src="./images/orderUp.png" onclick="showOrderedSongs('up','name','{{$filter}}','{{$filterName}}');"/>

			<div class="orderArrows">
				<img class="tableIcons" src="./images/orderDown.png" onclick="showOrderedSongs('down','name','{{$filter}}','{{$filterName}}');"/>
				<img class="tableIcons" src="./images/orderUp.png" onclick="showOrderedSongs('up','name','{{$filter}}','{{$filterName}}');"/>
			</div>
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
			
			<td class="tdSongs" id='{{$counter}}' title="{{$totalSongs}}" onclick='playClickedSong("{{$song->name}}","{{$counter}}"); closeNav();'>{{$song->name}}</td>
			<td class="tdSongs" onclick="showFilteredSongs('artist','{{$song->artist}}')">{{$song->artist}}</td>
			<td class="tdSongs" onclick="showFilteredSongs('album','{{$song->album}}')">{{$song->album}}</td>
			<td class="tdSongs" onclick="showFilteredSongs('genre','{{$song->genre}}')">{{$song->genre}}</td>
			<td class="tdSongs">{{$song->length}}</td>
			
		</tr>
	<?php
		$counter++;
		$counterHidden=1;
	?>	
	@endforeach
</table>
