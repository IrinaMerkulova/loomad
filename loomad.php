<?php
require ('conf.php');
//looma kustutamine
if(isset($_REQUEST["kustuta"])){
    global $yhendus;
    $paring=$yhendus->prepare("DELETE FROM loomad WHERE id=?");
    $paring->bind_param("i", $_REQUEST["kustuta"]);
    $paring->execute();
}
//looma lisamine andmebaasi tabeli
if(isset($_REQUEST["nimi"]) && !empty(trim($_REQUEST["nimi"]))){
    global $yhendus;
    $paring=$yhendus->prepare("
INSERT INTO loomad(loomanimi, synniaeg, pilt, varv) VALUES (?,?,?,?)");
    $paring->bind_param("ssss", $_REQUEST["nimi"],$_REQUEST["synd"],
        $_REQUEST["pilt"], $_REQUEST["varv"]);
    $paring->execute();
}
// https://meet.google.com/isw-cfnr-het
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Loomad</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<h1>Loomad</h1>
<table border="1" class="zigzag">
    <thead>
    <tr>
        <th class="header">id</th>
        <th class="header">Loomanimi</th>
        <th class="header">Sünniaeg</th>
        <th class="header">Pilt</th>
        <th class="header">Haldus</th>
    </tr>
    </thead>
    <?php
    global $yhendus;
    //andmetabeli kuvamiseks mySQL andmebaasist
    $paring=$yhendus->prepare("
SELECT id, loomanimi, synniaeg, pilt, varv FROM loomad");
    $paring->bind_result($id, $loomanimi, $synniaeg, $pilt, $varv);
    $paring->execute();
    while($paring->fetch()){
        echo " <tbody><tr>";
        echo "<td>$id</td>";
        echo "<td bgcolor='$varv'>$loomanimi</td>";
        echo "<td>$synniaeg</td>";
        echo "<td>
<img src='$pilt' alt='loomapilt' width='50%'></td>";
        echo "<td><a href='?kustuta=$id'>Kustuta</a></td>";
    echo "</tbody>";
    }
    ?>
</table>
<form action="?" method="post">
    <input type="text" name="nimi" placeholder="loomanimi">
    <input type="date" name="synd" placeholder="sünniaeg">
    <input type="text" name="varv" placeholder="värv inglise keeles">
    Pilt: <textarea name="pilt" cols="20"></textarea>
    <input type="submit" value="Lisa">
</form>
</body>
</html>
