<?php

function conectar($bd="") {
 $servidor="pruebasposeidon";
 $administrador="root";
 $password="chsmtiky";
 $basedatos="siemdif_alimentaria";

  $con = mysql_connect($servidor,$administrador,$password);
  mysql_select_db($basedatos, $con);
  return $con;
}

function dominio(){
  return "/SIEM/ALIMENTARIA/Siemdif_Alimentaria/";
}

function soy(){
  return "_local";
}

?>
