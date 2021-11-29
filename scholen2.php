<!-- maken van database connectie -->
<?php include "./databaseconnectie.php" ?>

<!-- Begin html -->
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Link naar FontAwesome voor inladen van icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Titel van pagina -->
    <title>Welkom</title>

    <!-- Externe css van menubalk (bestand: menu.css) -->
    <link rel="stylesheet" href="menu.css">

</head>
<!-- Externe css van menubalk (bestand: menu.css) -->
<body style="background-color: #cccccc;">

<!-- Extern html bestand met daarin de menubalk (bestand: manu.html) -->
<?php include "./menu.html" ?>

    <!-- Welkoms bericht -->
    <h1 class="pixel">Scholen</h1>

<?php 
// Voeg waarde toe aan session
// Kijken of variable bestaat
    if(isset($_GET['.createSchool_trigger'])){
        // Kijken of variable waarde heeft
        if (!empty($_GET['school'])) {
            // Data invoeren in database (naam van de school)
            try{
                // PDO
                $db->prepare("INSERT INTO scholen (Naam)
                VALUES (?)")->execute([$_GET['school']]);
            // opvangen van error als waarde al bestaat in database
            }catch (PDOException $e){
                echo "<script> console.log('naam bestaat al in database'); </script>";
            }
        // error voor als waarde niet is ingevuld
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
        if (!empty($_GET['value'])) {
            try{
            // Kijken of waarde al bestaat (waarde, in tabel)
            $db->prepare("UPDATE scholen SET Naam='".$_GET['value']."' WHERE ID=".$_GET['editId'])->execute();
            header("Location: scholen.php");
            }
            // opvangen van error als waarde al bestaat in database
            catch (PDOException $e){
                echo "<script> console.log('naam bestaat al in database ".$e."'); </script>";
            }
        // error voor als waarde niet is ingevuld
        } else{
            echo "<script> console.log('naam mag niet leeg zijn'); </script>";
        }
     }

    //  data aanroepen uit database, tabel scholen
     $query = "SELECT * FROM scholen";

     // variable begint leeg
     $tableBodyData = "";

     // foreach om elk id op te halen
    foreach($db->query($query) as $row){
    $tableBodyData .= "
    <tr>
    <td> <input name='school' type='text' value='".$row["Naam"]."' onblur='redirectUpdate(".$row["ID"].", this);'></td>
    <td> <a class='icon' href='?deleteId=".$row["ID"]."'><i class='fa fa-trash'></i></a></td
    </tr>";
}
?>

<!-- tabel voor de gegevens uit de database -->
<table class="tableStyle">
    <thead>
        <!-- tabel rij (bovenste rij) -->
        <tr>
            <td>School naam</td>
            <td>Delete</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <!-- foreach om data op te halen uit database (zie $tableBodyData) -->
            <?php
                echo $tableBodyData;
            ?>
    </tbody>
    <tfoot>
        <tr>
            <!-- formulier om naam van school in te voeren -->
            <form>
                <td colspan="1">
                    <input name="school" type="text" placeholder="school naam..." required>
                </td>
                <!-- knop op ingevulde schoolnaam te versturen -->
                <td>
                    <button class="btn"  name=".createSchool_trigger" type="submit">Voeg toe</button>
                </td>
            </form>
        </tr>
    </tfoot>
</table>

<!-- redirect om in  zelfde pagina te kunnen blijven -->
<script>
    function redirectUpdate(elementId, e){
        window.location.href = `?editId=${elementId}&value=${e.value}`;
    }
</script>

</body>
</html>