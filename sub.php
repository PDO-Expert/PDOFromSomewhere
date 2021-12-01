<?php include 'databaseconnectie.php' ?> <!-- connectie maken met database -->
<!DOCTYPE html>
<html lang="nl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Bon</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <!-- inluden van de menu bar -->
    <?php include 'Navigatie.html' ?>
<?php
$totaal = 0;
$totaalprijs = 0;

$tableBodyData = "";

    foreach ($pdo->query("SELECT b.ID, b.Reservering_ID, b.Menuitem_ID, b.Aantal, m.Naam, m.Prijs, b.Geserveerd
                          FROM menuitems AS m INNER JOIN bestellingen AS b
                          ON m.ID = b.Menuitem_ID
                          INNER JOIN reserveringen AS r
                          ON b.Reservering_ID = R.ID
                          WHERE r.ID =".$_GET['bestelID']) as $row) {
    $tableBodyData .="

    <tr>
      <td>".$row["Naam"]."</td>
      <td>".$row['Aantal']." </td>
      <td>".$row["Prijs"]."</td>
    </tr>";
    $aantal = $row['Aantal'];
    $prijs = $row['Prijs'];
    $totaalprijs = $row['Prijs'] * $row['Aantal'];

    $totaal = $totaal + $totaalprijs;

    }


    ?>
    <br><br>
    <table id="customers">
      <thead>
        <tr>
          <th>Naam gerecht</th>
          <!-- <th>Menuitem_ID</th> -->
          <th>Aantal</th>
          <th>Prijs</th>
        </tr>
        <td colspan="3"> <?php  echo "Reserveringsnummer: ".$row["Reservering_ID"].""; ?></td>
      </thead>
      <tbody>
          <?php
            echo $tableBodyData;
           ?>
      </tbody>
      <tfoot>
        <td colspan="3"> <?php  echo "Totaal: € $totaal"; ?></td>
      </tfoot>
    </table>

  </body>
</html>
