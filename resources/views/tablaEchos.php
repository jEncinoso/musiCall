	<?php
		foreach($songs as $song){
			echo "<tr>";
				echo "<td onClick='playSong(\"$song->name\");'>".$song->name."</td>";
				echo "<td>".$song->artist."</td>";
				echo "<td>".$song->album."</td>";
				echo "<td>".$song->genre."</td>";
				echo "<td>".$song->length."</td>";
			echo "</tr>";
		}
	?>