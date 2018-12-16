<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset=utf-8>
		<title>Bulk QR Generation</title>
			<style>
				body { margin:1em; }
				article, aside, figure, footer, header, hgroup, menu, nav, section { 
				display:block;
				}
			</style>
	</head>
	<body>
		<h1>Bulk Generate QR Codes</h1>
		<form action="bulkqr.php" method="post" id="usrform"> 
			<textarea rows="20" cols="128" name="qrs" placeholder="Paste your URLs here - one on each line."><?php
				echo htmlentities($_POST["qrs"]);
			?></textarea><br/>
			<label for="error">Error Correction</label>
			<select name="error">
				<option value="l">Low - up to 7% data loss</option>QR code is trademarked by Denso Wave, Inc.
				<option value="m">Medium - up to 15% data loss</option>
				<option value="q">Quarter - up to 25% data loss</option>
				<option value="h">High - up to 30% data loss</option>
			</select> | 
			<label for="size">Image Size</label>
			<select name="size">
				<option value="100">Smallest - 100*100 pixels</option>
				<option value="200">Small - 200*200 pixels</option>
				<option value="300">Medium - 300*300 pixels</option>
				<option value="400">High - 400*400 pixels</option>
				<option value="500">Massive - 500*500 pixels</option>
			</select> | 
			<input type="submit" value="Generate QR Codes"/> 
		</form>
		<?php 
			$image_size = urlencode($_POST["size"]);
			$error_correction = urlencode($_POST["error"]);
			$border = 1;
			$API_URL = 
				"https://chart.apis.google.com/chart?cht=qr".
				"&chs=".$image_size."x".$image_size.
				"&chld=".$error_correction."|".$border.
				"&chl=";
			
			$qrs = $_POST["qrs"]; 
			
			$tok = strtok($qrs, "\n");
			
			if ($_POST) {
		?>
		<table border="1">
			<tr>
				<th>QR Code</th>
				<th>URL</th>
		<?php
				while ($tok !== false) {
					$url = trim($tok);
					$encoded_url = urlencode($url);
					$escaped_url = htmlentities($url);
					
					echo "<tr>
							<td>
								<a href=\""     . $API_URL . $encoded_url . "\">
									<img src=\"" . $API_URL . $encoded_url . "\" 
									     height=\"$image_size\" width=\"$image_size\" />
								</a>
							</td>
							<td>$escaped_url</td>
						</tr>";
					$tok = strtok("\n");
				}
			}
		?>
		<table>
	</body>	
</html>
