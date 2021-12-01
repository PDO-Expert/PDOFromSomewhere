<?php include 'databaseconnectie.php' ?> <!-- connectie maken met database -->
<!DOCTYPE html>
<html lang="nl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Drank</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <!-- inluden van de menu bar -->
    <?php include 'Navigatie.html' ?>

    <!-- welkoms bericht/introductie -->
    <h1>Hier vind je alle reserveringen</h1>

    <?php
    if (isset($_GET['createDrank_trigger'])) {
      // kijken of variabele waarde heeft
      if (!empty($_GET['Code_input'])) {
        // gegevens toevoegen
        try {
          $pdo->prepare("INSERT INTO menuitems (Code, Naam, Gerechtsoort_ID)
          VALUES (?,?,?)")->execute([$_GET['Code_input'], $_GET['Naam_input'], $_GET['Gerechtsoort_input']]);
          header("Location: Drank.php");
          // opvangen van eventuele error
        } catch (Exception $e) {
          echo "Bestaat al in database";
        }
      } else {
        echo "Veld mag niet leeg zijn";
      }
    }

    // verwijderen van een reservering
    if (isset($_GET['deleteId'])) {
      $pdo->exec("DELETE FROM menuitems WHERE id=".$_GET['deleteId']);
      header("Location: Drank.php");
    }

    // chekcen of iput getriggered wordt
    if(isset($_GET['editId'])){
         // // Kijken of variable waarde heeft
         if (!empty($_GET['key']) && !empty($_GET['value'])) {
             try{
             // Kijken of waarde al bestaat (waarde, in tabel)
             $pdo->prepare("UPDATE menuitems SET ".$_GET['key']." = '".$_GET['value']."' WHERE ID=".$_GET['editId'])->execute();
             header("Location: Drank.php");
             }
             catch (PDOException $e){
                 echo 'Drank bestaat al in database';
             }
         } else{
             echo 'Veld mag niet leeg zijn';
         }
      }




  // Add options List
  $categorieOptions = getCategories($pdo);


// Add Rows
    $tableBodyData = "";
    foreach ($pdo->query("SELECT m.ID, m.Code, m.Naam as mNaam, m.Gerechtsoort_ID, c.Naam, g.Naam as gNaam
      FROM menuitems AS m INNER JOIN gerechtsoorten AS g
      ON m.Gerechtsoort_ID = g.ID
      INNER JOIN gerechtcategorien AS c
      ON g.Gerechtcategorie_ID = c.ID
      WHERE c.ID = 1") as $row) {

    $tableBodyData .="
    <tr>
      <td>".$row["ID"]."</td>
      <td> <input type='text' name='Code' value='".$row["Code"]."' onblur='redirectUpdate(".$row["ID"].", ".'"Code"'.", this);'></td>
      <td> <input type='text' name='Naam' value='".$row["mNaam"]."' onblur='redirectUpdate(".$row["ID"].", ".'"Naam"'.", this);'></td>
      <td> <select name='Gerechtsoort_input' onblur='redirectUpdate(".$row["ID"].", ".'"Gerechtsoort_ID"'.", this);'> ".getCategories($pdo, $row["Gerechtsoort_ID"])." </select> </td>
      <td> <a class='buttons' href='?deleteId=".$row["ID"]."'>Delete</a></td>
    </tr>";
    }

     function getCategories($pdo, $selected = -1){
       $categorieOptions = "";

        foreach($pdo->query("SELECT gerechtcategorien.ID, gerechtsoorten.Naam ,gerechtsoorten.Code, gerechtsoorten.ID as gerechtcategorien_ID  FROM `gerechtsoorten`
        INNER JOIN gerechtcategorien ON gerechtsoorten.Gerechtcategorie_ID=gerechtcategorien.ID
        WHERE gerechtcategorien.ID = 1") as $row) {
          if($selected >= 0 && $row['gerechtcategorien_ID'] == $selected) $categorieOptions .= '<option selected value='.$row['gerechtcategorien_ID'].'>'.$row['Code'].' - '.$row['Naam'].'</option>';
          else $categorieOptions .= '<option value='.$row['gerechtcategorien_ID'].'>'.$row['Code'].' - '.$row['Naam'].'</option>';
        }


       return $categorieOptions;
     }
     ?>

    <table>
      <thead>
        <tr>
          <td>ID</td>
          <td>Code</td>
          <td>Naam</td>
          <td>categorie</td>
          <td>actie</td>
        </tr>
      </thead>
      <tbody>
          <?php
            echo $tableBodyData;
           ?>
      </tbody>
      <tfoot>
        <tr>
          <form>
            <td colspan="2">
              <input type="text" name="Code_input" placeholder="Code">
            </td>
            <td colspan="1">
              <input type="text" name="Naam_input" placeholder="Naam">
            </td>
            <td colspan="1">
              <select name="Gerechtsoort_input">
                <?php echo $categorieOptions; ?>
              </select>
            </td>
            <td>
              <button type="submit" name="createDrank_trigger">toevoegen</button>
            </td>
          </form>
        </tr>
      </tfoot>
    </table>

    <script>
    function redirectUpdate(elementId, key, e){
      window.location.href = `?editId=${elementId}&key=${key}&value=${e.value}`;
    }
    </script>
  </body>
</html>
