<?php
 /**
  * Maak een verbinding met de mysql-server en database
  */
  require('config.php');

  $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";

  try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    if ($pdo) {
        // echo "De verbinding is gelukt";
    } else {
        echo "Interne server-error";
    }
  } catch(PDOException $e) {
    echo $e->getMessage();
  }

/**
 * Maak een select query die alle records uit de tabel Persoon haalt
 */
  $sql = "SELECT * FROM DureAuto 
          ORDER BY Prijs DESC";

  // Maak de sql-query gereed om te worden uitgevoerd op de database
  $statement = $pdo->prepare($sql);

  // Voer de sql-query uit op de database
  $statement->execute();

  // Zet het resultaat in een array met daarin de objecten (records uit de tabel Persoon)
  $result = $statement->fetchAll(PDO::FETCH_OBJ);

  // Even checken wat we terugkrijgen
  //    var_dump($result);

  $rows = "";
  foreach ($result as $info) {
    $rows .= "<tr>
                <td>$info->Merk</td>
                <td>$info->Model</td>
                <td>$info->Topsnelhheid</td>
                <td>$info->Prijs</td>
                <td>
                    <a href='delete.php?Id=$info->Id'>
                        <img src='img/b_drop.png' alt='kruis'>
                    </a>
                </td>
              </tr>";
  }
  



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>De vijf duurste auto's ter wereld</h1>
<br>
    <table border='1'>
        <thead>
            <th>Merk</th>
            <th>Model</th>
            <th>Topsnelheid</th>
            <th>Prijs</th>
            <th>Delete</th>
        </thead>
        <tbody>
            <?= $rows; ?>
        </tbody>
    </table>
</body>
</html>

