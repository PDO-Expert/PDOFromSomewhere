<?php
include "databaseconnectie.php";
?>
<!DOCTYPE html>
<html lang="nl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>producten</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>

    <ul>
      <li><a  href="index.php">Home</a></li>
      <li><a class="active" href="#">Producten</a></li>
    </ul>

    <!-- <form class="" action="" method="post">
      <input type="text" name="Naam" value="">
      <input type="text" name="Omschrijving" value="">
      <input type="text" name="Prijs" value="">
      <input type="text" name="Merk" value="">
    </form> -->

<?php
/*Ik try {
    $db = $db->prepare('SELECT * FROM producten');
    $db->execute();
    $foo = $db->fetchAll();
    print_r($foo);
} catch (Exception $e) {
    print_r($e)
    die("Oh noes! There's an error in the query!");
}*/

// $parameters = array(':ID' => 1);
$stm = $db->prepare('SELECT * FROM producten WHERE ID = 41');
$stm->execute();


while($row = $stm->fetch()){
  echo $row['ID'].'<br>';
  echo $row['naam'].'<br>';
  echo $row['omschrijving'].'<br>';
  echo $row['prijs'].'<br>';
  echo $row['merk_ID'].'<br>';
  echo $row['categorie_ID'].'<br>';
  echo $row['voorraad'].'<br>'
}
 ?>
  </body>
</html>
