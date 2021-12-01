<?php include 'databaseconnectie.php' ?> <!-- connectie maken met database -->
<!DOCTYPE html>
<html lang="nl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Bestellen</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <!-- inluden van de menu bar -->
    <?php include 'Navigatie.html' ?>
<?php

    // $stm = $pdo->prepare("SELECT b.ID, b.Reservering_ID, b.Menuitem_ID, b.Aantal, m.Naam, m.Prijs, b.Geserveerd
    //                       FROM menuitems AS m INNER JOIN bestellingen AS b
    //                       ON m.ID = b.Menuitem_ID
    //                       INNER JOIN reserveringen AS r
    //                       ON b.Reservering_ID = R.ID
    //                       WHERE r.ID =".$_GET['bestelID']);
    // $stm->execute();
    //
    // $row = $stm->fetch()


    $tableBodyData = "";

    foreach ($pdo->query("SELECT b.ID, b.Reservering_ID, b.Menuitem_ID, b.Aantal, m.Naam, m.Prijs, b.Geserveerd
                          FROM menuitems AS m INNER JOIN bestellingen AS b
                          ON m.ID = b.Menuitem_ID
                          INNER JOIN reserveringen AS r
                          ON b.Reservering_ID = R.ID
                          WHERE r.ID =".$_GET['bestelID']) as $row) {
    $tableBodyData .="
    <tr>
      <td>".$row["Reservering_ID"]."</td>
      <td>".$row["ID"]."</td>
      <td>".$row["Naam"]."</td>
      <td>".$row['Aantal']." </td>
      <td>".$row["Prijs"]."</td>
      <td>".$row["Geserveerd"]."</td>
    </tr>";
    }



    ?>
    <br><br>
    <table id="customers">
      <thead>
        <tr>
          <th>Reserverings nummer</th>
          <th>Bestel Nummer</th>
          <th>Naam gerecht</th>
          <!-- <th>Menuitem_ID</th> -->
          <th>Aantal</th>
          <th>Prijs</th>
          <th>Geserveerd</th>
        </tr>
      </thead>
      <tbody>
          <?php
            echo $tableBodyData;
           ?>
      </tbody>
    </table>


  </body>
</html>
