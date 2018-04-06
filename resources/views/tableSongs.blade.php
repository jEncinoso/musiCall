<table id="tableSongs" class="table table-responsive">
	<tr>
		<td >
			<img id="refreshIcon" src="./images/refresh.png" onClick="showSongs();" vspace="10"/>
		</td>
		<td colspan="4">
			<font size="5">{{$filter}}{{$filterName}}</font>
		</td>
	</tr>
	<tr>
		<th>Name
			<img class="tableIcons" src="./images/orderDown.png" onClick="showOrderedSongs('down','name','{{$filter}}','{{$filterName}}');"/>
			<img class="tableIcons" src="./images/orderUp.png" onClick="showOrderedSongs('up','name','{{$filter}}','{{$filterName}}');"/>
		</th>
		<th>Artist
			<img class="tableIcons" src="./images/orderDown.png" onClick="showOrderedSongs('down','artist','{{$filter}}','{{$filterName}}');"/>
			<img class="tableIcons" src="./images/orderUp.png" onClick="showOrderedSongs('up','artist','{{$filter}}','{{$filterName}}');"/>
		</th>
		<th>Album
			<img class="tableIcons" src="./images/orderDown.png" onClick="showOrderedSongs('down','album','{{$filter}}','{{$filterName}}');"/>
			<img class="tableIcons" src="./images/orderUp.png" onClick="showOrderedSongs('up','album','{{$filter}}','{{$filterName}}');"/>
		</th>
		<th>Genre
			<img class="tableIcons" src="./images/orderDown.png" onClick="showOrderedSongs('down','genre','{{$filter}}','{{$filterName}}');"/>
			<img class="tableIcons" src="./images/orderUp.png" onClick="showOrderedSongs('up','genre','{{$filter}}','{{$filterName}}');"/>
		</th>
		<th>Length
			<img class="tableIcons" src="./images/orderDown.png" onClick="showOrderedSongs('down','length','{{$filter}}','{{$filterName}}');"/>
			<img class="tableIcons" src="./images/orderUp.png" onClick="showOrderedSongs('up','length','{{$filter}}','{{$filterName}}');"/>
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
			
			<td id='{{$counter}}' title="{{$totalSongs}}" onClick='playClickedSong("{{$song->name}}","{{$counter}}"); closeNav();'>{{$song->name}}</td>
			<td onClick="showFilteredSongs('artist','{{$song->artist}}')">{{$song->artist}}</td>
			<td onClick="showFilteredSongs('album','{{$song->album}}')">{{$song->album}}</td>
			<td onClick="showFilteredSongs('genre','{{$song->genre}}')">{{$song->genre}}</td>
			<td>{{$song->length}}</td>
			
		</tr>
	<?php
		$counter++;
		$counterHidden=1;
	?>	
	@endforeach
</table>
