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
if(isset($_REQUEST["uusloom"]) && !empty(trim($_REQUEST["nimi"]))){
    global $yhendus;
    $paring=$yhendus->prepare("
INSERT INTO loomad(loomanimi, synniaeg, pilt, varv) VALUES (?,?,?,?)");
    $paring->bind_param("ssss", $_REQUEST["nimi"],$_REQUEST["synd"],
        $_REQUEST["pilt"], $_REQUEST["varv"]);
    $paring->execute();
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Loomade leht </title>
</head>
<body>
<h1>Loomade loend</h1>
<ul>
<?php
global $yhendus;
//andmetabeli kuvamiseks mySQL andmebaasist
$paring=$yhendus->prepare("
SELECT id, loomanimi FROM loomad");
$paring->bind_result($id, $loomanimi);
$paring->execute();
while($paring->fetch()){
    echo "<li><a href='?looma_id=$id'>$loomanimi</a></li>";
}
echo "<a href='?lisa=jah'>Lisa loom</a>";
?>
</ul>
<div id="sisu">
    <?php
    global $yhendus;
    //andmetabeli kuvamiseks mySQL andmebaasist
    if(isset($_REQUEST["looma_id"])) {
        $paring = $yhendus->prepare("
SELECT id, loomanimi, pilt, synniaeg, varv FROM loomad WHERE id=?");
        $paring->bind_result($id, $loomanimi, $pilt, $synniaeg, $varv);
        $paring->bind_param("i", $_REQUEST["looma_id"]);
        $paring->execute();
        //näitame ühe kaupa
        if ($paring->fetch()) {
            echo "<h2>$loomanimi</h2>";
            echo "<span>$synniaeg</span>";
            echo "<img src='$pilt' alt='loomapilt' width='50%'>";
            echo "<a href='?kustuta=$id'>Kustuta</a>";
        }
    }
    ?>
</div>
<?php
if(isset($_REQUEST["lisa"])){
?>
<form action="?" method="post">
    <input type="hidden" name="uusloom" value="jah">
    <input type="text" name="nimi" placeholder="loomanimi">
    <br>
    <input type="date" name="synd" placeholder="sünniaeg">
    <br>
    <input type="text" name="varv" placeholder="värv inglise keeles">
    <br>
    Pilt: <textarea name="pilt" cols="20"></textarea>
    <br>
    <input type="submit" value="Lisa">
</form>
<?php
}
?>


</body>
</html>
