<table id="tableSongs" class="table table-responsive">
	<tr>
		<th>Name</th><th>Artist</th><th>Album</th><th>Genre</th><th>Length</th>
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
			<td id='h{{$counter}}{{$counterHidden}}' hidden title='{{$song->name}}'></td>
			<?php
				$counterHidden++;
			?>	
			<td id='h{{$counter}}{{$counterHidden}}' hidden title="{{$song->artist}}"></td>
			<?php
				$counterHidden++;
			?>	
			<td id='h{{$counter}}{{$counterHidden}}' hidden title="{{$song->album}}"></td>
			<?php
				$counterHidden++;
			?>	
			<td id='h{{$counter}}{{$counterHidden}}' hidden title="{{$song->genre}}"></td>
			<?php
				$counterHidden++;
			?>	
			
			<td id='{{$counter}}' title="{{$totalSongs}}" onClick='playClickedSong("{{$song->name}}","{{$counter}}"); closeNav();'>{{$song->name}}</td>
			<td>{{$song->artist}}</td>
			<td>{{$song->album}}</td>
			<td>{{$song->genre}}</td>
			<td>{{$song->length}}</td>
		</tr>
	<?php
		$counter++;
		$counterHidden=1;
	?>	
	@endforeach
</table>