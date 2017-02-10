<?php
	$servername = "localhost";
	$username = "root";
	$password = "admin";
	$dbname = "knygos";

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$bid = filter_input(INPUT_GET,"id",FILTER_VALIDATE_INT);
		
		if ($bid === false) {
			echo "Blogas knygos ID";
			exit;
		}
		
		$stmt = $conn->prepare("SELECT id, pavadinimas, leidimo_metai, autorius, zanras FROM knygos WHERE id=:bid"); 
		$stmt->execute(array(":bid" => $bid));
		$rows = $stmt->fetchAll();
		
		if (count($rows)) {
			$v = $rows[0];
			echo "<td>
					<h2>Pavadinimas: {$v['pavadinimas']}</h2>
					<h2>Leidimo metai: {$v['leidimo_metai']}</h2>
					<h2>Autorius: {$v['autorius']}</h2>
					<h2>Žanras: {$v['zanras']}</h2>
				  </td>";
		}
		else {
			echo "Tokios knygos nėra!";
		}
	}
	catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
?>