<?php include "./databaseconnectie.php" ?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Titel van pagina -->
    <title>Welkom</title>

    <style>
        table, th, td {
        border: 1px solid black;
        }
    </style>

    <!-- Externe css van menubalk (bestand: menu.css) -->
    <link rel="stylesheet" href="menu.css">

</head>
<body>

<!-- Extern html bestand met daarin de menubalk (bestand: manu.html) -->
<?php include "./menu.html" ?>

    <!-- Welkoms bericht -->
    <h1>Hier staan alle gegevens over de aangemelde scholen</h1>

<?php
// Voeg waarde toe aan session
// Kijken of variable bestaat
    if(isset($_GET['createPerson_trigger'])){
        // Kijken of variable waarde heeft
        if (!empty($_GET['school'])) {
            // Data invoeren in database (naam van de school)
            try{
                $db->prepare("INSERT INTO scholen (Naam)
                VALUES (?)")->execute([$_GET['school']]);
                header("Location: scholen.php");
            // opvangen van eventuele error
            }catch (PDOException $e){
                echo "<script> console.log('naam bestaat al in database'); </script>";
            }
        } else{
            echo "<script> console.log('naam mag niet leeg zijn'); </script>";
        }
    }

    // Verwijderen waarde van session
    if(isset($_GET['deleteId'])){
        $db->exec("DELETE FROM scholen WHERE id=".$_GET['deleteId']);
        header("Location: scholen.php");
     }

    // Update waarde van session
    if(isset($_GET['editId'])){
        // // Kijken of variable waarde heeft
        if (!empty($_GET['key']) && !empty($_GET['value'])) {
            try{
            // Kijken of waarde al bestaat (waarde, in tabel)
            $db->prepare("UPDATE scholen SET ".$_GET['key']."='".$_GET['value']."' WHERE ID=".$_GET['editId'])->execute();
            header("Location: scholen.php");
            }
            catch (PDOException $e){
                echo "<script> console.log('naam bestaat al in database ".$e."'); </script>";
            }
        } else{
            echo "<script> console.log('naam mag niet leeg zijn'); </script>";
        }
     }

     $tableBodyData = "";

    foreach($db->query("SELECT * FROM scholen") as $row){

    $tableBodyData .= "
    <tr>
    <td>".$row["ID"]."</td>
    <td> <input name='school' type='text' value='".$row["Naam"]."' onblur='redirectUpdate(".$row["ID"].", ".'"Naam"'.", this);'></td>
    <td> <input name='stad' type='text' value='".$row["stad"]."' onblur='redirectUpdate(".$row["ID"].", ".'"stad"'.", this);'></td>
    <td> <a href='?deleteId=".$row["ID"]."'>Delete</a></td
    </tr>";
}

?>

<table>
<thead>
<tr>
    <td>ID</td>
    <td>School naam</td>
    <td>Action</td>
</tr>
</thead>
<tbody>
<tr>
    <?php
        echo $tableBodyData;
    ?>
</tbody>
<tfoot>
    <tr>
    <form>
        <td colspan="2">
            <input name="school" type="text" placeholder="school naam..." required>
        </td>
        <td>
            <button name="createPerson_trigger" type="submit">Add</button>
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
