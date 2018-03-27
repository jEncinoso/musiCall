<table id="tableSongs" class="table table-responsive">
	<tr>
		<th>Name</th><th>Artist</th><th>Album</th><th>Genre</th><th>Length</th>
	</tr>
	@foreach($songs as $song)
		<tr>
			<td onClick="playSong('{{$song->name}}');">{{$song->name}}</td>
			<td>{{$song->artist}}</td>
			<td>{{$song->album}}</td>
			<td>{{$song->genre}}</td>
			<td>{{$song->length}}</td>
		</tr>
	@endforeach
</table>
	

	<!-- SUBIR RUTA A LA BASE DE DATOS O MOVER ARCHIVOS AL PROYECTO
		 IMPRIMIR LA RUTA OCULTA EN CADA FILA
		 ONCLICK, REPRODUCIR LA CANCION "RUTA+NOMBRE+.MP3";-->