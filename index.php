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
</head>
<body>
<?php
	echo "<table>";
	echo "<thead><tr><th>Pavadinimas</th><th>Leidimo metai</th><th>Autorius</th><th>Žanras</th></tr></thead>";

	class TableRows extends RecursiveIteratorIterator { 
		function __construct($it) { 
			parent::__construct($it, self::LEAVES_ONLY); 
		}	

		function current() {
			return "<td>" . parent::current(). "</td>";
		}

		function beginChildren() { 
			echo "<tr>"; 
		} 

		function endChildren() { 
			echo "</tr>" . "\n";
		} 
	} 

	$servername = "localhost";
	$username = "root";
	$password = "admin";
	$dbname = "knygos";

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare("SELECT pavadinimas, leidimo_metai, autorius, zanras FROM knygos"); 
		$stmt->execute();

		// set the resulting array to associative
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 

		foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
			echo $v;
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