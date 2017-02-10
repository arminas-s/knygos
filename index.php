<HTML>
   <HEAD>
	  <meta content="text/html; charset=utf-8"/>
      <TITLE>
         Knygos
	  </TITLE>
	  <meta name="keywords" content="knygu sarasas, biblioteka"/>
	  <link href="style.css" rel="stylesheet" type="text/css"/>
   </HEAD>
<BODY>
<p><h2 align="center">Knygų sąrašas</h2>

	<table>
		<thead>
			<tr>
				<th><a href="?sort=pavadinimas">Pavadinimas</a></th>
				<th><a href="?sort=leidimo_metai">Leidimo metai</a></th>
				<th><a href="?sort=autorius">Autorius</a></th>
				<th><a href="?sort=zanras">Žanras</a></th>
			</tr>
		</thead>
<?php
	 

	$servername = "localhost";
	$username = "root";
	$password = "admin";
	$dbname = "knygos";

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$cn = filter_input(INPUT_GET,"sort",FILTER_SANITIZE_STRING);
		$stmt = $conn->prepare("SELECT id, pavadinimas, leidimo_metai, autorius, zanras FROM knygos ORDER BY :cn"); 
		$stmt->execute(array(":cn" => $cn));

		// set the resulting array to associative
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
		foreach($stmt->fetchAll() as $v) { 
			echo "<tr>
					 <td><a href='details.php?id={$v['id']}'>{$v['pavadinimas']}</a></td>
					 <td>{$v['leidimo_metai']}</td>
					 <td>{$v['autorius']}</td>
					 <td>{$v['zanras']}</td>
		         </tr>";
		}			 	
	}
	catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
	echo "</table>";
?>
</BODY>
</HTML>