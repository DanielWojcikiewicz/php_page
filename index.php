<!DOCTYPE html>
<html lang="pl">
	<head>
        <meta charset=utf-8 />
        <meta name="author" content="Daniel Wójcikiewicz"/>
		<title>sezam_logs</title>
        <meta name="description" content="sezam_logs"/>
		<link type='text/css' rel='stylesheet' href='normalize.css'>
        <link type='text/css' rel='stylesheet' href='style.css'>
	</head>
	<body>
		<div id='container'>

			<div id='content'>

				<div id='top_part'>
					<h1>Sezam Logs</h1>
				</div>

				<div id='middle_part'>

					<div id='filters'>
						<form action="/index.php" method=POST>
							<div id='basicfilters'>

								<label class='filter' for="niebieski">niebieski</label>
								<input class='checkmark' type="checkbox" name='niebieski' value="niebieski">

								<label class='filter' for="zielony">zielony</label>
								<input class='checkmark' type="checkbox" name="zielony" value="zielony">

								<label class='filter' for="czerwony">czerwony</label>
								<input class='checkmark' type="checkbox" name="czerwony" value="czerwony"><br>

							</div>

							<input type="text" name="tekst"><br>

							<input type="submit" value="Wyślij">
						</form>
					</div>

					<div id='logs'>

						<?php

							$dbcon = mysqli_connect("localhost","root","","test");
							if (mysqli_connect_errno()) {
								echo "Failed to connect to MySQL:" . mysqli_connect_error();
							} else {
								echo "Działa!";
							}
							if ($_SERVER['REQUEST_METHOD'] === 'POST') {
								$niebieski = isset($_POST['niebieski']) ? $_POST['niebieski'] : '';
								$zielony = isset($_POST['zielony']) ? $_POST['zielony'] : '';
								$czerwony = isset($_POST['czerwony']) ? $_POST['czerwony'] : '';
								$tekst = isset($_POST['tekst']) ? $_POST['tekst'] : '';
							}

							if (isset($niebieski) or isset($zielony) or isset($czerwony)) {
								if ($tekst != "") {
									$sql = "SELECT * FROM faktury WHERE kolor='$niebieski' or kolor='$zielony' or kolor='$czerwony'
									or kolor like '%$tekst%' or rodzaj like '%$tekst%' or opis like '%$tekst%'";
								}
								 else {
									$sql = "SELECT * FROM faktury WHERE kolor='$niebieski' or kolor='$zielony' or kolor='$czerwony'";
								}
							}
							else {
								$sql = "SELECT * FROM faktury";
							}
							 $result = mysqli_query($dbcon, $sql);
							 // or die("Zapytanie niepoprawne");

							if (!mysqli_num_rows($result)==0) {
								echo "To jest tabelka z danymi: <br>";
								echo "<table style='border: 1px solid white;'>
								<thead>
									<tr>
										<td>Kwota</td>
										<td>Nr_faktury</td>
										<td>Opis</td>
									</tr>
								</thead>
								<tbody>";
							while ($row = mysqli_fetch_assoc($result)) {
							 	echo "<tr>";
								echo "<td>".$row['kolor']."</td>";
								echo "<td>".$row['rodzaj']."</td>";
								echo "<td>".$row['opis']."</td>";
								echo "</tr>";
								}
								echo "</tbody></table>";
							}

						?>

					</div>
				</div>
			</div>
		</div>
	</body>
</html>
