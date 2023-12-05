<?php
$kasutaja='irina';
$serverinimi='localhost';
$parool='kala';
$andmebaas='irina';
$yhendus=new mysqli($serverinimi, $kasutaja, $parool, $andmebaas);
$yhendus->set_charset('UTF8');