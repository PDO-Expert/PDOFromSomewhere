<?php include 'databaseconnectie.php' ?> <!-- connectie maken met database -->
<!DOCTYPE html>
<html lang="nl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Overzicht kok</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <!-- inluden van de menu bar -->
    <?php include 'Navigatie.html' ?>

<h1>Bestelling keuken</h1>
<?php
$tableBodyData = "";

    foreach ($pdo->query("SELECT m.ID, m.Code, m.Naam, m.Gerechtsoort_ID, c.Naam AS Name, b.ID AS bID, b.Geserveerd, r.Tafel
      FROM menuitems AS m INNER JOIN gerechtsoorten AS g
      ON m.Gerechtsoort_ID = g.ID
      INNER JOIN gerechtcategorien AS c
      ON g.Gerechtcategorie_ID = c.ID
      INNER JOIN bestellingen AS b
      ON b.Menuitem_ID = m.ID
      INNER JOIN reserveringen AS r
      ON b.Reservering_ID = r.ID
      WHERE c.ID = 3") as $row) {

    $tableBodyData .="
    <tr>
      <td>".$row["ID"]."</td>
      <td> <input type='text' name='Code' value='".$row["Code"]."' onblur='redirectUpdate(".$row["ID"].", ".'"Code"'.", this);'></td>
      <td> <input type='text' name='Naam' value='".$row["Naam"]."' onblur='redirectUpdate(".$row["ID"].", ".'"Naam"'.", this);'></td>
      <td> <input type='text' name='Naam' value='".$row["bID"]."' onblur='redirectUpdate(".$row["ID"].", ".'"bID"'.", this);'></td>
      <td> <input type='text' name='Naam' value='".$row["Geserveerd"]."' onblur='redirectUpdate(".$row["ID"].", ".'"Geserveerd"'.", this);'></td>
      <td> <input type='text' name='Naam' value='".$row["Tafel"]."' onblur='redirectUpdate(".$row["ID"].", ".'"Tafel"'.", this);'></td>
    </tr>";
    }
     ?>
<br><br>
    <table>
      <thead>
        <tr>
          <td>ID</td>
          <td>Code</td>
          <td>Naam</td>
          <td>Bestel nummer</td>
          <td>Geserveerd</td>
          <td>Tafel nummer</td>
        </tr>
      </thead>
      <tbody>
          <?php
            echo $tableBodyData;
           ?>
      </tbody>
      <tfoot>
        <tr>
        </tr>
      </tfoot>
    </table>


  </body>
</html>
