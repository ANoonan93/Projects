<!DOCTYPE html>
<div style="float:top-left" span="6">
	<?php
		$counter=0;
		while ($counter != sizeof($leftBox)) {
			$TableList = "<br><b> Artist:</b></br>".$leftBox[$counter]['artist']
			."<br><b> Song:</b></br>".$leftBox[$counter]['song']
			."<br><b> Comments:</b></br>".$leftBox[$counter]['comment']
			."<br><b> Genre:</b></br>".$leftBox[$counter]['genre'] . "</br>";
			$counter++;
			echo $TableList;
		}
		
	?>
	
</div>