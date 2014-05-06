<?php
//include "database.php";

function fin() {

echo '</td>
     </tr>
    </table>
    <p align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">
    <font size="-3" face="Verdana, Arial, Helvetica, sans-serif"><br>
    <br><!--<img src="imagenes/powered.gif">--></font></p>
   </td>
 </tr>
</table>
</body>
</html>';

}

function tipo_escuela($clave_escuela,$con){
  $clave='';
  $tipo='';
  $tipo_esc='';
    $clave=$clave_escuela[0].$clave_escuela[1].$clave_escuela[2].$clave_escuela[3].$clave_escuela[4];
   $sql='select * from claves_escuela where Clave = "'.$clave.'"';
   // echo alerta($sql);
  // echo $sql;
   $result=mysql_query($sql,$con);


    if ($row=mysql_fetch_array($result))
    {
     // echo alerta($row['Tipo_escuela']);
      if ($row['Tipo_escuela'] == 0)
        $tipo_esc='PRE';
      if ($row['Tipo_escuela'] == 1)
        $tipo_esc='PRI';
      if ($row['Tipo_escuela'] == 2)
        $tipo_esc='CEN';
      if ($row['Tipo_escuela'] == 3)
        $tipo_esc='SEC';
      $tipo= $tipo_esc;}
  //echo $tipo;
  return $tipo;
}//funcion tipo escuela

function menu($dominio="/almacen/") {
  echo '
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr valign="top">
    <td width="100%" valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr valign="top" bgcolor="#005577">
          <td width="25%" align="center"><a href="'.$dominio.'productos.php"><font face="arial" size="2" color="#FFFFFF"><b>Productos</b></font></a></td>
          <td width="25%" align="center"><a href="'.$dominio.'familias.php"><font face="arial" size="2" color="#FFFFFF"><b>Familias</b></font></a></td>
          <td width="25%" align="center"><a href="'.$dominio.'agrupadores.php"><font face="arial" size="2" color="#FFFFFF"><b>Agrupadores de familias</b></font></a></td>
          <td width="25%" align="center"><a href="'.$dominio.'seguridad/permisos.php"><font face="arial" size="2" color="#FFFFFF"><b>Permisos</b></font></a></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr valign="top">
    <td width="100%" valign="top"><br>';
}

function finmenu(){
  echo '
    </td>
  </tr>
</table>
  ';
}

function menu_admin(){
  $retorno='
      <table border="0" cellpadding="0" cellspacing="0" width="755" valign="top">
        <tr bgcolor="#F4CCA9" valign="top">
         <td><a href="#" onMouseOut="MM_startTimeout();"
           onMouseOver="MM_showMenu(window.mm_menu_0317211154_0,4,20,null,\'menu_top_r2_c2\');">
           <img name="menu_top_r2_c2" src="imagenes/menu_top_r2_c2.gif" width="100" height="20" border="0" alt=""></a></td>
         <td><a href="#" onMouseOut="MM_startTimeout();"
           onMouseOver="MM_showMenu(window.mm_menu_0317213021_1,3,20,null,\'menu_top_r2_c4\');">
           <img name="menu_top_r2_c4" src="imagenes/menu_top_r2_c4.gif" width="101" height="20" border="0" alt=""></a></td>
         <td><a href="#" onMouseOut="MM_startTimeout();"
           onMouseOver="MM_showMenu(window.mm_menu_0317213405_2,5,20,null,\'menu_top_r2_c6\');">
           <img name="menu_top_r2_c6" src="imagenes/menu_top_r2_c6.gif" width="101" height="20" border="0" alt=""></a></td>
         <td><a href="#" onMouseOut="MM_startTimeout();"
           onMouseOver="MM_showMenu(window.mm_menu_0317213458_3,5,20,null,\'menu_top_r2_c8\');">
           <img name="menu_top_r2_c8" src="imagenes/menu_top_r2_c8.gif" width="101" height="20" border="0" alt=""></a></td>
         <td><a href="#" onMouseOut="MM_startTimeout();"
           onMouseOver="MM_showMenu(window.mm_menu_0317213549_4,5,20,null,\'menu_top_r2_c10\');">
           <img name="menu_top_r2_c10" src="imagenes/menu_top_r2_c10.gif" width="101" height="20" border="0" alt=""></a></td>
<!--         <td rowspan="2"><a href="cerrar.php"><img name="menu_top_r2_c1" src="imagenes/salir.gif" width="58" height="21" border="0" alt=""></a></td> -->
        </tr>
      </table>
      ';
   return $retorno;
}

function formulario_busqueda($forma,$url,$parametros,$ancho) {
  $retorno="
    <form name='$forma' method='post' action='$url'>
      <table border='0' cellspacing='0' cellpadding='0' width='".$ancho."' align='center' valign='top'>
       <tr><td>
        <table  border='0' cellspacing='0' cellpadding='0' width='100%'>
          <tr valign='top'>
            <td width='5' background='imagenes/top_tabla_i_azul.gif'>&nbsp;</td>
             <td align='center' background='imagenes/top_tabla_azul.gif' align='center' colspan='1'>
             <font face='arial' size='2' color='#F0F0F0'><b>Búsqueda</b></font>
             </td>
             <td width='5' background='imagenes/top_tabla_d_azul.gif'>&nbsp;</td>
          </tr>
        </table>
      </td></tr>
          ";
  $j=count($parametros);
  $retorno.= "<tr><td>
         <table border='0' cellspacing='0' cellpadding='0' width='100%'>
          <tr><td width='5' bgcolor='#F0F0F0'>&nbsp;</td>";
  for($i=0;$i<$j;$i++) {
    $retorno.="
          <td bgcolor='#F0F0F0' width='".$parametros[$i]["ancho"]."'>
            <font face='arial' size='2' color='#000000'>".$parametros[$i]["titulo"]."</font><br>
            ".$parametros[$i]["nombre"]."
          </td>
        ";
  }
  $retorno.= "<td bgcolor='#F0F0F0' width='30'><input type='submit' value='Buscar'></td>
          <td width='5' bgcolor='#F0F0F0'>&nbsp;</td></tr>
        </table>
       </td></tr>
     </table>
        <input type='hidden' name='ini' value='0'>
     </form>
  ";
  return $retorno;
}  // Fin formulario_busqueda.

function funcion_chsm($valor) {
 $retorno = '<input type="button" name="" value="'.$valor.'">';
return $retorno;
}

function obtener_bd(){
  $empresa=obten("empresa");
  $almacen=obten("almacen");
  $anio=obten("anio");
  $retorno=$empresa.$almacen.$anio;
  return $retorno;
}

function obtener_bd1(){
  if (isset($_GET["BD"])) {
    $BD=$_GET["BD"];
  }
  else {
    $emp=obten("emp");
    $alm=obten("alm");
    $anio=obten("anio");
    if (strlen($emp)==1) $emp='0'.$emp;
    if (strlen($alm)==1) $alm='0'.$alm;
    $BD=$emp.$alm.$anio;
  }
  return $BD;
}

function resultados_busqueda($sql,$ini,$limite,$con,$params,$size_fuente="-1") {
  $fin=$ini+$limite;
  $resulta=mysql_query($sql);
  $encontrados=mysql_num_rows($resulta);
  if($encontrados<$fin)$fin=$encontrados;

  $inicio="<a href='$_SERVER[PHP_SELF]?ini=0".$params."'><img src='imagenes/inicio.jpg' border='0' alt='Inicio'></a>";
  $anterior="<a href='$_SERVER[PHP_SELF]?ini=".($ini-$limite).$params."'><img src='imagenes/anteriores.gif' border='0' alt='Anteriores'></a>";
  $siguiente="<a href='$_SERVER[PHP_SELF]?ini=".($ini+$limite).$params."'><img src='imagenes/siguientes.gif' border='0' alt='Siguientes'></a>";
  $final="<a href='$_SERVER[PHP_SELF]?ini=".($encontrados-$limite).$params."'><img src='imagenes/final.jpg' border='0' alt='Final'></a>";
  if ($ini==0) $inicio="";
  if (($ini+$limite)>=$encontrados) { $siguiente=""; $final=""; }
  if (($ini-$limite)<0) { $anterior=""; }
  $retorno= "<br>
               <center>
                <font face='verdana' size='$size_fuente' color=''><i><b>$encontrados</b> Resultados Encontrados</i></font>
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <font face='verdana' size='$size_fuente' color=''><i>Mostrando del <b>$ini</b> al <b>$fin</b></i></font>
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 $inicio $anterior $siguiente $final
               </center>";
  $retorno.= "|".$encontrados;
  
  mysql_free_result($resulta);
  return $retorno;
}  // Fin resultados_busqueda.

function obten($cad){
  if(isset($_GET[$cad])){
    $retorno=$_GET[$cad];
  }else{
    if(isset($_POST[$cad])){
      $retorno=$_POST[$cad];
    }else{
      if(isset($_SESSION[$cad])){
        $retorno=$_SESSION[$cad];
      }else{
        $retorno="";
      }
    }
  }
  return $retorno;
}

function obten_save($este){
if(isset($_GET[$este])){
  $aux=$_GET[$este];
}else{
 if(isset($_POST[$este])){
    $aux=$_POST[$este];
  }else{
    if(isset($_SESSION[$este])){
      $aux=$_SESSION[$este];
    }else{
      $aux='';
    }
  }
}
  $_SESSION[$este]=$aux;
  return $aux;
}

// Para modificar cuando la llave es de tipo entero.
function modifica_estos($con,$tabla,$llave,$llave_a_modificar,$cadena){
 $j=count($cadena);
 for($i=0;$i<$j;$i++){
    $sql="UPDATE $tabla set ".$cadena[$i]["campo"]." = '".$cadena[$i]["valor"]."' where $llave = '$llave_a_modificar' ";
  // echo $sql;
    mysql_query($sql, $con);
 }
}  // Fin modifica_estos.

// Para modificar cuando la llave es de tipo caracter.
function modifica_estos2($con,$tabla,$llave,$llave_a_modificar,$cadena){
 $j=count($cadena);
 for($i=0;$i<$j;$i++){
    $sql="UPDATE $tabla set ".$cadena[$i]["campo"]." = '".$cadena[$i]["valor"]."' where $llave like '$llave_a_modificar'";
    mysql_query($sql, $con);
 }
}  // Fin modifica_estos2.

function modifica_estos3($con,$tabla,$llave,$llave2,$llave_a_modificar,$llave_a_mod2,$cadena){
 $j=count($cadena);
 for ($i=0;$i<$j;$i++) {
    $sql="UPDATE $tabla set ".$cadena[$i]["campo"]." = '".$cadena[$i]["valor"]."'
    where $llave like '$llave_a_modificar' and $llave2 = '".$llave_a_mod2."'";
   //echo $sql;
    mysql_query($sql, $con);
 }
}  // Fin modifica_estos3.

function inserta_estos($con,$tabla,$cadena) {
 $j=count($cadena);
 $nombres="";
 $valores="";
 for ($i=0;$i<$j;$i++) {
    $nombres.=trim($cadena[$i]["campo"]).",";
    $valores.="'".trim($cadena[$i]["valor"])."',";
 }
 $nombres=substr($nombres,0,strlen($nombres)-1);
 $valores=substr($valores,0,strlen($valores)-1);

 $sql = "INSERT INTO $tabla ($nombres) VALUES ($valores)";
//echo $sql;
 $Result1 = mysql_query($sql, $con) or die(mysql_error());
}  // Fin función inserta_estos.

function inserta_array($con,$tabla,$campos,$valores,$arreglo) {
  foreach ($arreglo as $value) {
    $sql = "INSERT INTO $tabla ( $campos ) values ( $valores ) " ;
    $Result1 = mysql_query($sql, $con) or die(mysql_error());
  }
}  // Fin función inserta_array.

function define_id_pys($con)
{
 $sql = "select max(id) as auto_inc from tmov_asist_soc" ;
 $result=mysql_query($sql, $con);
 $row=mysql_fetch_array($result);
 return $row;
}


function invierte_fecha($fechita){
    if($fechita!=""){
      if(strpos($fechita,'-')>0){
        $fecha=explode('-',$fechita);
      }else{
        $fecha=explode('/',$fechita);
      }
      $dia=$fecha[2];
      $mes=$fecha[1];
      $anio=$fecha[0];
      $fechita="$dia/$mes/$anio";
    }
  return $fechita;
}

function invierte_fecha_guion($fechita){
    if($fechita!=""){
      if(strpos($fechita,'-')>0){
        $fecha=explode('-',$fechita);
      }else{
        $fecha=explode('/',$fechita);
      }
      $dia=$fecha[2];
      $mes=$fecha[1];
      $anio=$fecha[0];
      $fechita="$dia-$mes-$anio";
    }
  return $fechita;
}

function select_x($nombre,$valor,$parametros,$cadena){
  $retorno='
         <select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>'."\n";
        $opciones=explode("|",$cadena);
        $j=count($opciones);
        for ($i=0;$i<$j;$i++) {
          $opcion=explode("=",$opciones[$i]);
          if($opcion[1]==$valor){$selecciona="selected";}else{$selecciona="";}
          $retorno.= '<option '.$selecciona.' value="'.$opcion[1].'">'.$opcion[0].'</option>'."\n";
        }
    $retorno.='</select>';
  return $retorno;
}


function select_stored_proc($nombre,$valor,$parametros,$resultado,$campo_nombre,$campo_clave,$extra,$long_cadena) {
//esta funcion te enlista los stored procedures sea cuales sean
  $retorno='
         <select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>
          '."\n";
        if ($extra!="")
          {$retorno.= '<option selected value='.$extra.'>'.$extra.'</option>'."\n";}
        while ($row=mysql_fetch_array($resultado)) {
          if ($row["$campo_clave"]==$valor){$selecciona="selected";}else{$selecciona="";}
          if ($long_cadena<=0)
           {$nom_corto=$row["$campo_nombre"];}
          else
           {$nom_corto=substr($row["$campo_nombre"],0,$long_cadena);}
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$row["$campo_clave"].' - '.$nom_corto.'</option>'."\n";
        }
    $retorno.='
         </select>
  ';
  return $retorno;
}


function select_tabla($nombre,$valor,$parametros,$tabla,$campo_nombre,$campo_clave,$con){
  $retorno='
         <select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>
          <option value=""></option>'."\n";
        $sql="select distinct $campo_clave,$campo_nombre from $tabla order by $campo_clave";
        $result = mysql_query($sql, $con) or die(mysql_error());
        while($row=mysql_fetch_array($result)){
          if($row["$campo_clave"]==$valor){$selecciona="selected";}else{$selecciona="";}
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$row["$campo_nombre"].'</option>'."\n";
        }
    $retorno.='
         </select>
  ';
  return $retorno;
}

// Función select_tabla normal.
function select_tabla1($nombre,$valor,$parametros,$tabla,$campo_nombre,$campo_clave,$con,$extra){
  $retorno='
         <select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>
          '."\n";
        $sql="select distinct $campo_clave,$campo_nombre from $tabla order by $campo_clave";
        $result = mysql_query($sql, $con) or die(mysql_error());
        if ($extra!="")
          {$retorno.= '<option selected value="Extra">'.$extra.'</option>'."\n";}
        while($row=mysql_fetch_array($result)){
          if($row["$campo_clave"]==$valor){$selecciona="selected";}else{$selecciona="";}
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$row["$campo_clave"].' - '.$row["$campo_nombre"].'</option>'."\n";
        }
    $retorno.='
         </select>
  ';
  return $retorno;
}

function select_tabla11($nombre,$valor,$parametros,$tabla,$campo_nombre,$campo_clave,$con,$extra){
  $retorno='
         <select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>
          '."\n";
        $sql="select distinct $campo_clave,$campo_nombre from $tabla order by $campo_clave";
        $result = mysql_query($sql, $con) or die(mysql_error());
        while($row=mysql_fetch_array($result)){
          if($row["$campo_clave"]==$valor){$selecciona="selected";}else{$selecciona="";}
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$row["$campo_clave"].' - '.$row["$campo_nombre"].'</option>'."\n";
        }
    $retorno.='
         </select>
  ';
  return $retorno;
}



function select_tabla10($nombre,$valor,$parametros,$tabla,$campo_nombre,$campo_clave,$con,$extra,$long_cadena){
  $retorno='
         <select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>
          '."\n";
        $sql="select distinct $campo_clave,$campo_nombre from $tabla order by $campo_clave";
        $result = mysql_query($sql, $con) or die(mysql_error());
        if ($extra!="")
          {$retorno.= '<option selected value='.$extra.'>'.$extra.'</option>'."\n";}
        while($row=mysql_fetch_array($result)){
          if($row["$campo_clave"]==$valor){$selecciona="selected";}else{$selecciona="";}
          if ($long_cadena<=0)
           {$nom_corto=$row["$campo_nombre"];}
          else
           {$nom_corto=substr($row["$campo_nombre"],0,$long_cadena);}
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$row["$campo_clave"].' - '.$nom_corto.'</option>'."\n";
        }
    $retorno.='
         </select>
  ';
  return $retorno;
}


function select_tabla12($nombre,$valor,$parametros,$tabla,$campo_nombre,$campo_clave,$con,$extra,$long_cadena){
  $retorno='
         <select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>
          '."\n";
        $sql="select $campo_clave,$campo_nombre from $tabla order by $campo_nombre";
        $result = mysql_query($sql, $con) or die(mysql_error());
        if ($extra!="")
          {$retorno.= '<option selected value='.$extra.'>'.$extra.'</option>'."\n";}
        while($row=mysql_fetch_array($result)){
          if($row["$campo_clave"]==$valor){$selecciona="selected";}else{$selecciona="";}
          if ($long_cadena<=0)
           {$nom_corto=$row["$campo_nombre"];}
          else
           {$nom_corto=substr($row["$campo_nombre"],0,$long_cadena);}
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$row["$campo_clave"].' - '.$nom_corto.'</option>'."\n";
        }
    $retorno.='
         </select>
  ';
  return $retorno;


}

// Función select_tabla que no ocupa el campo_clave pues el campo_nombre es igual al campo_clave (creo que no sirve)
function select_tabla2($nombre,$valor,$parametros,$tabla,$campo_clave,$con){
  $retorno='
         <select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>
          <option value=""></option>'."\n";
        $sql="select $campo_clave,$campo_nombre from $tabla order by $campo_clave";
        $result = mysql_query($sql, $con) or die(mysql_error());
        while($row=mysql_fetch_array($result)){
          if($row["$campo_clave"]==$valor){$selecciona="selected";}else{$selecciona="";}
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$row["$campo_nombre"].'</option>'."\n";
        }
    $retorno.='
         </select>
  ';
  return $retorno;
}

// función select_tabla con "distinct"
function select_tabla3($nombre,$valor,$parametros,$tabla,$campo_clave,$con){
  $retorno='
         <select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>
          <option value=""></option>'."\n";
        $sql="select distinct $campo_clave from $tabla order by $campo_clave";
        $result = mysql_query($sql, $con) or die(mysql_error());
        while($row=mysql_fetch_array($result)){
          if($row["$campo_clave"]==$valor){$selecciona="selected";}else{$selecciona="";}
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$row["$campo_clave"].'</option>'."\n";
        }
    $retorno.='
         </select>
  ';
  return $retorno;
}

// Función select_tabla al que se le manda la sentencia sql.
function select_tabla4($nombre,$valor,$parametros,$tabla,$campo_clave,$campo_nombre,$sql,$con){
  $retorno='
         <select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>
          <option value=""></option>'."\n";
//        $sql="select $campo_clave,$campo_nombre from $tabla order by $campo_clave";
        $result = mysql_query($sql, $con) or die(mysql_error());
        while($row=mysql_fetch_array($result)){
          if($row["$campo_clave"]==$valor){$selecciona="selected";}else{$selecciona="";}
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$row["$campo_nombre"].'</option>'."\n";
        }
    $retorno.='
         </select>
  ';
  return $retorno;
}

function select_tabla5($nombre,$valor,$parametros,$tabla,$campo_nombre,$con){
  $retorno='
         <select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>
          <option value=""></option>'."\n";
        $sql="select $campo_nombre from $tabla order by $campo_nombre";
        $result = mysql_query($sql, $con) or die(mysql_error());
        if($campo_nombre==1)
           $imprime="Carga";
        else
           $imprime="Abona";
        while($row=mysql_fetch_array($result)){
          if($row["$campo_nombre"]==$valor){$selecciona="selected";}else{$selecciona="";}
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_nombre"].'">'.$row["$campo_nombre"].'</option>'."\n";
        }
    $retorno.='
         </select>
  ';
  return $retorno;
}
function select_tabla6($nombre,$valor,$parametros,$tabla,$campo_nombre,$campo_clave,$con){
  $retorno='
         <select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>
          <option value=""></option>'."\n";
        $sql="select $campo_clave,$campo_nombre from $tabla order by $campo_clave";
        $result = mysql_query($sql, $con) or die(mysql_error());
        while($row=mysql_fetch_array($result)){
          if($row["$campo_clave"]==$valor){$selecciona="selected";}else{$selecciona="";}
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$row["$campo_clave"].' - '.$row["$campo_nombre"].'</option>'."\n";
        }
    $retorno.='
         </select>
  ';
  return $retorno;
}

function select_sql($nombre,$valor,$parametros,$sql,$campo_nombre,$campo_clave,$con){
  $retorno='
         <select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>
          <option value=""></option>'."\n";
        $result = mysql_query($sql, $con) or die(mysql_error());
        while($row=mysql_fetch_array($result)){
          if($row["$campo_clave"]==$valor){$selecciona="selected";}else{$selecciona="";}
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$row["$campo_nombre"].'</option>'."\n";
        }
    $retorno.='
         </select>
  ';
  return $retorno;
}  // Fin función select_sql.

// Muestra el código con su descripción.
function select_sql1($nombre,$valor,$parametros,$sql,$campo_nombre,$campo_clave,$con) {
  $retorno='
         <select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>
          <option value=""></option>'."\n";
        $result = mysql_query($sql, $con) or die(mysql_error());
        while($row=mysql_fetch_array($result)) {
          if($row["$campo_clave"]==$valor){$selecciona="selected";}else{$selecciona="";}
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$row["$campo_clave"].' - '.$row["$campo_nombre"].'</option>'."\n";
        }
    $retorno.='
         </select>
  ';
  return $retorno;
}  // Fin función select_sql1.

function select_sql2($nombre,$valor,$parametros,$sql,$campo_nombre,$campo_clave,$longitud,$con) {
  $retorno='
         <select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>
          <option value=""></option>'."\n";
        $result = mysql_query($sql, $con) or die(mysql_error());
        while($row=mysql_fetch_array($result)){
          if ($row["$campo_clave"]==$valor) {$selecciona="selected";} else {$selecciona="";}
          if (strlen($row["$campo_nombre"])>$longitud)
            $nom_corto=substr($row["$campo_nombre"],0,$longitud)."...";
          else $nom_corto=$row["$campo_nombre"];
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$nom_corto.'</option>'."\n";
        }
    $retorno.='
         </select>
  ';
  return $retorno;
}  // Fin función select_sql2.

function select_sql3($nombre,$valor,$parametros,$sql,$campo_nombre,$campo_clave,$con){
  $retorno='
         <select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>'."\n";
        $result = mysql_query($sql, $con) or die(mysql_error());
        while($row=mysql_fetch_array($result)){
          if($row["$campo_clave"]==$valor){$selecciona="selected";}else{$selecciona="";}
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$row["$campo_nombre"].'</option>'."\n";
        }
    $retorno.='
         </select>
  ';
  return $retorno;
}  // fin función select_sql3.

function select_sql4($nombre,$valor,$parametros,$sql,$campo_nombre,$campo_clave,$longitud,$con) {
  $retorno='
         <select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>
          <option value="Otro">Otro</option>'."\n";
        $result = mysql_query($sql, $con) or die(mysql_error());
        while ($row=mysql_fetch_array($result)) {
          if ($row["$campo_clave"]==$valor) {$selecciona="selected";} else {$selecciona="";}
          if (strlen($row["$campo_nombre"])>$longitud)
            $nom_corto=substr($row["$campo_nombre"],0,$longitud)."...";
          else $nom_corto=$row["$campo_nombre"];
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$nom_corto.'</option>'."\n";
        }
    $retorno.='
         </select>
  ';
  return $retorno;
}  // Fin función select_sql4.

function select_sql5a($nombre,$valor,$parametros,$sql,$campo_nombre,$campo_nombre2,$campo_clave,$longitud,$con,$aux="") {
  $retorno='<select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>';
       if ($aux=="") $retorno.='<option value=""></option>'."\n";
       else $retorno.='<option value="Todos">Todos</option>'."\n";
        $result = mysql_query($sql, $con) or die(mysql_error());
        while ($row=mysql_fetch_array($result)) {
          if ($row["$campo_clave"]==$valor) {$selecciona="selected";} else {$selecciona="";}
          $texto=$row["$campo_nombre"].' - '.$row["$campo_nombre2"];
          if (strlen($texto)>$longitud)
            $nom_corto=substr($texto,0,$longitud)."...";
          else $nom_corto=$texto;
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$nom_corto.'</option>'."\n";
        }
    $retorno.='</select>';
  return $retorno;
}  // Fin función select_sql5a.

function select_sql5($nombre,$valor,$parametros,$sql,$campo_nombre,$campo_nombre2,$campo_clave,$longitud,$con,$aux="") {
  $retorno='
         <select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>';
          if ($aux <> "")
            $retorno.='<option value="Otro">Otro</option>'."\n";
          else
            $retorno.='<option value=""></option>'."\n";
        $result = mysql_query($sql, $con) or die(mysql_error());
        while($row=mysql_fetch_array($result)){
          if ($row["$campo_clave"]==$valor) {$selecciona="selected";} else {$selecciona="";}
          $texto=$row["$campo_nombre"].' - '.$row["$campo_nombre2"];
          if (strlen($texto)>$longitud)
            $nom_corto=substr($texto,0,$longitud)."...";
          else $nom_corto=$texto;
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$nom_corto.'</option>'."\n";
        }
    $retorno.='</select>';
  return $retorno;
}  // Fin función select_sql5.


function select_sql5_a($nombre,$valor,$parametros,$sql,$campo_nombre,$campo_nombre2,$campo_nombre3,$campo_nombre4,$campo_clave,$longitud,$con,$aux="") {
  $retorno='
         <select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>';
          if ($aux <> "")
            $retorno.='<option value="Otro">Otro</option>'."\n";
          else
            $retorno.='<option value=""></option>'."\n";

        $result = mysql_query($sql, $con) or die(mysql_error());
        while($row=mysql_fetch_array($result)){
          if ($row["$campo_clave"]==$valor) {$selecciona="selected";} else {$selecciona="";}
          $texto=$row["$campo_nombre"].' - '.$row["$campo_nombre2"].' '.$row["$campo_nombre3"].' '.$row["$campo_nombre4"];
          if (strlen($texto)>$longitud)
            $nom_corto=substr($texto,0,$longitud)."...";
          else $nom_corto=$texto;
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$nom_corto.'</option>'."\n";
        }
    $retorno.='</select>';
  return $retorno;
}  // Fin función select_sql5.


function select_sql5_aMPX($nombre,$valor,$parametros,$sql,$campo_nombre,$campo_nombre2,$campo_nombre3,$campo_nombre4,$campo_clave,$longitud,$con,$aux="") {
  $retorno='
        <select name="'.$nombre.'[]" id="'.$nombre.'" '.$parametros.'  MULTIPLE>';
         if ($aux == "")  $retorno.='<option value="Otro">Otro</option>'."\n";
         else $retorno.=''; //'<option value=""></option>'."\n";

        $result = mysql_query($sql, $con) or die(mysql_error());
        while($row=mysql_fetch_array($result)){
          $selecciona="";
          if ($valor!="")
            foreach ($valor as $value)
            if ($row["$campo_clave"]==$value) {$selecciona="selected";}
            
          $texto=$row["$campo_nombre"].' - '.$row["$campo_nombre2"].' '.$row["$campo_nombre3"].' '.$row["$campo_nombre4"];
          if (strlen($texto)>$longitud)
            $nom_corto=substr($texto,0,$longitud)."...";
          else $nom_corto=$texto;
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$nom_corto.'</option>'."\n";
        }
    $retorno.='</select>';
  return $retorno;
}  // Fin función select_sql5.


function select_sql6($nombre,$valor,$parametros,$sql,$campo_nombre,$campo_clave,$longitud,$con) {
  $retorno='
         <select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>
          <option value="Todos">Todos</option>'."\n";
        $result = mysql_query($sql, $con) or die(mysql_error());
        while($row=mysql_fetch_array($result)){
          if ($row["$campo_clave"]==$valor) {$selecciona="selected";} else {$selecciona="";}
          if (strlen($row["$campo_nombre"])>$longitud)
            $nom_corto=substr($row["$campo_nombre"],0,$longitud)."...";
          else $nom_corto=$row["$campo_nombre"];
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$nom_corto.'</option>'."\n";
        }
    $retorno.='
         </select>
  ';
  return $retorno;
}  // Fin función select_sql6.

function select_sql7($nombre,$valor,$parametros,$sql,$campo_nombre,$campo_nombre2,$campo_clave,$longitud,$con) {
  $retorno='
         <select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>
          <option value="Todos">Todos</option>'."\n";
        $result = mysql_query($sql, $con) or die(mysql_error());
        while($row=mysql_fetch_array($result)){
          if ($row["$campo_clave"]==$valor) {$selecciona="selected";} else {$selecciona="";}
          $texto=$row["$campo_nombre"].' - '.$row["$campo_nombre2"];
          if (strlen($texto)>$longitud)
            $nom_corto=substr($texto,0,$longitud)."...";
          else $nom_corto=$texto;
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$nom_corto.'</option>'."\n";
        }
    $retorno.='
         </select>
  ';
  return $retorno;
}  // Fin función select_sql7.

function select_sql8($nombre,$valor,$parametros,$sql,$campo_nombre,$campo_nombre2,$campo_clave,$longitud,$con,$aux="") {
  $retorno='<select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>';
       if ($aux=="") $retorno.='<option value="Otro">Otro / Ninguno</option>'."\n";
       else  $retorno.='<option value="Todos">Todos</option>'."\n";
        $result = mysql_query($sql, $con) or die(mysql_error());
        while ($row=mysql_fetch_array($result)) {
          if ($row["$campo_clave"]==$valor) {$selecciona="selected";} else {$selecciona="";}
          if (strlen($row["$campo_nombre"])>$longitud)
            $nom_corto=substr($row["$campo_nombre"].' - '.$row["$campo_nombre2"],0,$longitud)."...";
          else $nom_corto=$row["$campo_nombre"].' - '.$row["$campo_nombre2"];
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$nom_corto.'</option>'."\n";
        }
    $retorno.='
         </select>
  ';
  return $retorno;
}  // Fin función select_sql8.

function select_sql9($nombre,$valor,$parametros,$sql,$campo,$campo_nombre,$desc2,$descrip1,$descrip2,$campo_clave,$longitud,$con,$aux="") {
  $retorno='<select name="'.$nombre.'" id="'.$nombre.'" '.$parametros.'>';
        if ($aux=="cosita") $retorno.='<option value=""></option>'."\n";
        else
          if ($aux=="") $retorno.='<option value="Otro">Otro</option>'."\n";
          else  $retorno.='<option value="Todos">Todos</option>'."\n";
        $result = mysql_query($sql, $con) or die(mysql_error());
        while ($row=mysql_fetch_array($result)) {
          if ($row["$campo_clave"]==$valor) {$selecciona="selected";} else {$selecciona="";}
          $texto=$row["$campo"];
          if ($row["$campo_nombre"]) $texto.=' - '.$row["$campo_nombre"];
          if ($row["$desc2"]!="") $texto.=' - '.$row["$desc2"];
          if ($row["$descrip1"]) $texto.=' - '.$row["$descrip1"];
          if ($row["$descrip2"]) $texto.=' - '.$row["$descrip2"];
          if (strlen($texto)>$longitud)
            $nom_corto=substr($texto,0,$longitud)."...";
          else $nom_corto=$texto;
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$nom_corto.'</option>'."\n";
        }
    $retorno.='</select>';
  return $retorno;
}  // Fin función select_sql9.

function select_sq10_mpx($nombre,$valor,$parametros,$sql,$campo_nombre,$campo_nombre2,$campo_clave,$longitud,$con,$aux="") {
  $retorno='<select name="'.$nombre.'[]" id="'.$nombre.'" '.$parametros.' MULTIPLE>';
       if ($aux=="") $retorno.='<option value="Otro">Otro / Ninguno</option>'."\n";
       else  $retorno.=''; //'<option value="Todos">Todos</option>'."\n";
        $result = mysql_query($sql, $con) or die(mysql_error());
        while ($row=mysql_fetch_array($result)) {
          $selecciona="";
          if ($valor!="")
            foreach ($valor as $value)
            if ($row["$campo_clave"]==$value) {$selecciona="selected";}
            
          if (strlen($row["$campo_nombre"])>$longitud)
            $nom_corto=substr($row["$campo_nombre"].' - '.$row["$campo_nombre2"],0,$longitud)."...";
          else $nom_corto=$row["$campo_nombre"].' - '.$row["$campo_nombre2"];
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$nom_corto.'</option>'."\n";
        }
    $retorno.='</select>';
  return $retorno;
}  // Fin función select_sql10_mpx.

function select_sql9_mpx($nombre,$valor,$parametros,$sql,$campo,$campo_nombre,$desc2,$descrip1,$descrip2,$campo_clave,$longitud,$con,$aux="") {
  $retorno='<select name="'.$nombre.'[]" id="'.$nombre.'" '.$parametros.'  MULTIPLE>';
        if ($aux=="") $retorno.='<option value="Otro">Otro</option>'."\n";
        else  $retorno.=''; //'<option value="Todos">Todos</option>'."\n";
        $result = mysql_query($sql, $con) or die(mysql_error());
        while ($row=mysql_fetch_array($result)) {
          $selecciona="";
          if ($valor!="")
            foreach ($valor as $value)
            if ($row["$campo_clave"]==$value) {$selecciona="selected";}

          $texto=$row["$campo"];
          if ($row["$campo_nombre"]) $texto.=' - '.$row["$campo_nombre"];
          if ($row["$desc2"]!="") $texto.=' - '.$row["$desc2"];
          if ($row["$descrip1"]) $texto.=' - '.$row["$descrip1"];
          if ($row["$descrip2"]) $texto.=' - '.$row["$descrip2"];
          if (strlen($texto)>$longitud)
            $nom_corto=substr($texto,0,$longitud)."...";
          else
          $nom_corto=$texto;
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$nom_corto.'</option>'."\n";
        }
    $retorno.='</select>';
  return $retorno;
}  // Fin función select_sql9.

function select_sql11($nombre,$valor,$parametros,$sql,$campo_nombre,$campo_nombre2,$campo_clave,$longitud,$con,$aux="") {
  $retorno='<select name="'.$nombre.'[]" id="'.$nombre.'" '.$parametros.' MULTIPLE>';
       if ($aux=="") $retorno.='<option value="Ninguno">Ninguno</option>'."\n";
       else  $retorno.='<option value="Todos">Todos</option>'."\n";
        $result = mysql_query($sql, $con) or die(mysql_error());
        while ($row=mysql_fetch_array($result)) {
//          if ($row["$campo_clave"]==$valor) {$selecciona="selected";} else {$selecciona="";}
          $selecciona="";
          if ($valor!="")
            foreach ($valor as $value)
            if ($row["$campo_clave"]==$value) {$selecciona="selected";}

          if (strlen($row["$campo_nombre"])>$longitud)
            $nom_corto=substr($row["$campo_nombre"].' - '.$row["$campo_nombre2"],0,$longitud)."...";
          else $nom_corto=$row["$campo_nombre"].' - '.$row["$campo_nombre2"];
          $retorno.= '<option '.$selecciona.' value="'.$row["$campo_clave"].'">'.$nom_corto.'</option>'."\n";
        }
    $retorno.='</select>';
  return $retorno;
}  // Fin función select_sql11.

function valida_email($str) {
  $str=trim($str);
  if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $str)) {
    return false;
  }
  return true;
}  // Fin función valida_email.

function envia_email($titulo,$destinatario,$remitente,$mensaje) {
    if(valida_email($destinatario)==true){
       $headers  = "MIME-Version: 1.0\r\n";
       $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
       $headers .= "From: $remitente\r\n";
       $message = $mensaje;
       $to  = $destinatario;
       $subject = $titulo;
       mail($to, $subject, $message, $headers);
       $retorno="simon";
    }else{
      $retorno="nel";
    }
    return $retorno;
}

function mysql_este($sql,$campo,$con){
 $retorno="";
 $result = mysql_query($sql, $con) or die(mysql_error());
 if($row=mysql_fetch_array($result)){
   $retorno=$row[$campo];
 }
 return $retorno;
}

function alerta($texto){
  $retorno="
     <script language=javascript>
       alert ('$texto')
     </script>
  ";
  return $retorno;
}

function alerta_bota($texto,$url){
  $retorno="
     <script language=javascript>
        alert ('$texto')
     </script>
    <META HTTP-EQUIV='Refresh' CONTENT='0;URL=$url'>
  ";
  return $retorno;
}

function tabla_x($titulo,$subtitulos,$parametros,$datos,$acciones,$url,$colors,$bgcolors) {
 $colors=explode("|",$colors);
 $bgcolors=explode("|",$bgcolors);
 $filas=count($datos);
 $columnas=count($datos[0]);

 $color1=$colors[0];
 $color2=$colors[1];
 $retorno = "
        <p align='center'>
              <font color='$color1' size='2' face='Arial, Helvetica, sans-serif'>
                <b>$titulo</b>
              </font>
        </p>

        <table $parametros>
 ";
  if($subtitulos!=""){
    $subtitulos=explode("|",$subtitulos);
    $retorno.="<tr>
                <td width='5' background='".dominio()."imagenes/top_tabla_i.gif'>&nbsp;</td>";
    for($i=0;$i<$columnas;$i++){
       $retorno.="<td align='center' background='".dominio()."imagenes/top_tabla.gif'align='center'>
                    <font face='arial' size='2' color='$color2'><b>$subtitulos[$i]</b></font>
                  </td>";
    }
    $retorno.=" <td width='5' background='".dominio()."imagenes/top_tabla_d.gif'>&nbsp;</td>
               </tr>\n";
  }

 $bgcolor1=$bgcolors[0];
 $bgcolor2=$bgcolors[1];
 $bg=1;
 for($i=0;$i<$filas;$i++){
   if($bg==1){
     $bg=2;$bgcolor=$bgcolor1;
   }else{
     $bg=1;$bgcolor=$bgcolor2;
   }

   $retorno.="<tr>
                 <td width='5' bgcolor='$bgcolor'>&nbsp;</td>";
   for($j=0;$j<$columnas;$j++){
      $retorno.="<td bgcolor='$bgcolor'><font face='arial' size='2' color='#000000'>".$datos[$i][$j]."</font></td>";
   }
   $retorno.="   <td width='5' bgcolor='$bgcolor'>&nbsp;</td>
              </tr>\n";
 }


 $retorno.='
         </table>';

 return $retorno;

}

function tabla_sql($titulo,$datos,$parametros,$sql,$acciones,$url,$colors,$bgcolors,$nombre_tabla,$pie,$tope,$llave,$con,$var_get=""){
 $retorno = "";
 $permiso_iconos="nel";
 if($acciones!=''){
  $acciones=explode("|",$acciones);
  $permiso_iconos="simon";
 }

 $colors=explode("|",$colors);
 $bgcolors=explode("|",$bgcolors);

 $color1=$colors[0];
 $color2=$colors[1];
 if($titulo!="")
 $retorno = "
        <p align='center'>
              <font color='$color1' size='4' face='verdana,Arial, Helvetica, sans-serif'>
                <b>$titulo</b>
              </font>
        </p>";
 $retorno.= "
      <form name='formilla' id='formilla' method='post' action='$url'>
        <table $parametros>
 ";
   $radio_master="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><input type='checkbox' name='dato_master' id='dato_master' onclick='checa(this.form)'></td>";
   $espacio="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><br></td>";

   $iconos_master='';
   $y=0;
   $con_email="nel";
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos_master.=$radio_master;
        if($acciones[$x]=="e")$iconos_master.=$espacio;
        if($acciones[$x]=="m")$iconos_master.=$espacio;
        if($acciones[$x]=="b")$iconos_master.=$espacio;
        if($acciones[$x]=="s")$iconos_master.=$espacio;
     }

    $result=mysql_query($sql);
    $columnas=count($datos);

    $colspan=$columnas+$y;
    $retorno.="<tr valign='top'>
                <td width='5' background='".dominio()."imagenes/top_tabla_i$tope.gif'>&nbsp;</td>\n".$iconos_master;

    for($i=0;$i<$columnas;$i++){
       $retorno.="<td width='".$datos[$i]["ancho"]."' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='$url?order_$nombre_tabla=".$datos[$i]["nombre"].$var_get."'><font face='arial' size='2' color='$color2'><b>".$datos[$i]["titulo"]."</b></font></a>
                  </td>";
    }
    $retorno.=" <td width='5' background='".dominio()."imagenes/top_tabla_d$tope.gif'>&nbsp;</td>
               </tr>\n";
  }

 $bgcolor1=$bgcolors[0];
 $bgcolor2=$bgcolors[1];
 $bg=1;

 $d=0;
 while ($row = mysql_fetch_array($result)){

   if($bg==1){
     $bg=2;$bgcolor=$bgcolor1;
   }else{
     $bg=1;$bgcolor=$bgcolor2;
   }

   $d++;
   $id=$row[$llave];
   $checa="<td width='15' bgcolor='$bgcolor'><input type='checkbox' name='dato$d' id='dato$d' value='$id'></td>";
   $borrar="<td width='15' bgcolor='$bgcolor'><a href='#' onclick=\"confirma('eliminar','este registro','$url?accion=borrar&id=$id'); return false;\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar'></a></td>";
   $editar="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=editar&id=$id'><img src='".dominio()."imagenes/editar.gif' border='0' alt='Editar'></a></td>";
   $mail="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=mail&id=$id'><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email'></a></td>";
   $sin_accion="<td width='15' bgcolor='$bgcolor'><a href='$url&id=$id'><img src='".dominio()."imagenes/accesar.gif' border='0' alt='Accesar'></a></td>";

   $iconos='';
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos.=$checa;
        if($acciones[$x]=="e")$iconos.=$editar;
        if($acciones[$x]=="m"){$iconos.=$mail;$con_email="simon";}
        if($acciones[$x]=="b")$iconos.=$borrar;
        if($acciones[$x]=="s")$iconos.=$sin_accion;
     }
   }

   for($x=0;$x<$columnas;$x++){
     $campo[$x]=$row[$datos[$x]["nombre"]];
   }

   $retorno.="<tr>
                 <td width='5' bgcolor='$bgcolor'>&nbsp;</td>\n".$iconos;
   for($j=0;$j<$columnas;$j++){
      $tipo_dato = mysql_field_type($result,$j);
      $campazo=$campo[$j];
      $campazo=str_replace("
","<br>",$campazo);
      if ($tipo_dato=="date") $campazo=invierte_fecha($campazo);
      if ($tipo_dato=="real") $campazo="$".number_format($campazo,2,".",",");
      $retorno.="<td bgcolor='$bgcolor' align='".$datos[$j]["align"]."'><font face='arial' size='2' color='#000000'>".$campazo."</font></td>\n";
   }
   $retorno.="   <td width='5' bgcolor='$bgcolor'>&nbsp;</td>
              </tr>\n";
 }
 echo' <script language="javascript"> var contador= '.$d.'; </script>';

 if($pie=="con_pie"){
 $retorno.="
           <tr>
            <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
            <td width='15' bgcolor='#FFFFFF' align='right'><img src='".dominio()."imagenes/flecha.gif'></td>
             <td bgcolor='#FFFFFF' colspan='".($colspan-1)."'>
               <font face='verdana,arial' size='1' color='#000000'>
                 A los seleccionados :
               </font>
             ";
 if($con_email=="simon")
     $retorno.="<a href='#' onclick=\"accion_sel('formilla','mail_muchos');\"><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email a seleccionados'></a>";

 $retorno.="    <a href='#' onclick=\"accion_sel('formilla','borrar_muchos');\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar seleccionados'></a>
             </td>
             <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
           </tr>";
 }
 $retorno.="
         </table>
         <input type='hidden' name='accion' id='accion'>
         <input type='hidden' name='estos' id='estos'>
         </form>
         ";

 return $retorno;
}  // tabla_sql.

function tabla_sql5($titulo,$datos,$parametros,$sql,$acciones,$url,$colors,$bgcolors,$nombre_tabla,$pie,$tope,$llave,$con,$var_get=""){
 $retorno = "";
 $permiso_iconos="nel";
 if($acciones!=''){
  $acciones=explode("|",$acciones);
  $permiso_iconos="simon";
 }

 $colors=explode("|",$colors);
 $bgcolors=explode("|",$bgcolors);

 $color1=$colors[0];
 $color2=$colors[1];
 if($titulo!="")
 $retorno = "
        <p align='center'>
              <font color='$color1' size='4' face='verdana,Arial, Helvetica, sans-serif'>
                <b>$titulo</b>
              </font>
        </p>";
 $retorno.= "
      <form name='formilla' id='formilla' method='post' action='$url'>
        <table $parametros>
 ";
   $radio_master="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><input type='checkbox' name='dato_master' id='dato_master' onclick='checa(this.form)'></td>";
   $espacio="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><br></td>";

   $iconos_master='';
   $y=0;
   $con_email="nel";
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos_master.=$radio_master;
        if($acciones[$x]=="e")$iconos_master.=$espacio;
        if($acciones[$x]=="m")$iconos_master.=$espacio;
        if($acciones[$x]=="b")$iconos_master.=$espacio;
     }

    $result=mysql_query($sql);
    $columnas=count($datos);

    $colspan=$columnas+$y;
    $retorno.="<tr valign='top'>
                <td width='5' background='".dominio()."imagenes/top_tabla_i$tope.gif'>&nbsp;</td>\n".$iconos_master;

    for($i=0;$i<$columnas;$i++){
       $retorno.="<td width='".$datos[$i]["ancho"]."' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='$url?order_$nombre_tabla=".$datos[$i]["nombre"].$var_get."'><font face='arial' size='2' color='$color2'><b>".$datos[$i]["titulo"]."</b></font></a>
                  </td>";
    }
    $retorno.=" <td width='5' background='".dominio()."imagenes/top_tabla_d$tope.gif'>&nbsp;</td>
               </tr>\n";
  }

 $bgcolor1=$bgcolors[0];
 $bgcolor2=$bgcolors[1];
 $bg=1;

 $d=0;
 while ($row = mysql_fetch_array($result)){

   if($bg==1){
     $bg=2;$bgcolor=$bgcolor1;
   }else{
     $bg=1;$bgcolor=$bgcolor2;
   }

   $d++;
   $id=$row[$llave];
   $id2=$row["INEGI"];
   $checa="<td width='15' bgcolor='$bgcolor'><input type='checkbox' name='dato$d' id='dato$d' value='$id'></td>";
   $borrar="<td width='15' bgcolor='$bgcolor'><a href='#' onclick=\"confirma('eliminar','este registro','$url?accion=borrar&id=$id'); return false;\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar'></a></td>";
   $editar="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=editar&id=".$id."&id2=".$id2."'><img src='".dominio()."imagenes/editar.gif' border='0' alt='Editar'></a></td>";
   $mail="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=mail&id=$id'><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email'></a></td>";

   $iconos='';
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos.=$checa;
        if($acciones[$x]=="e")$iconos.=$editar;
        if($acciones[$x]=="m"){$iconos.=$mail;$con_email="simon";}
        if($acciones[$x]=="b")$iconos.=$borrar;
     }
   }

   for($x=0;$x<$columnas;$x++){
     $campo[$x]=$row[$datos[$x]["nombre"]];
   }

   $retorno.="<tr>
                 <td width='5' bgcolor='$bgcolor'>&nbsp;</td>\n".$iconos;
   for($j=0;$j<$columnas;$j++){
      $tipo_dato = mysql_field_type($result,$j);
      $campazo=$campo[$j];
      $campazo=str_replace("
","<br>",$campazo);
      if ($tipo_dato=="date") $campazo=invierte_fecha($campazo);
      if ($tipo_dato=="real") $campazo="$".number_format($campazo,2,".",",");
      $retorno.="<td bgcolor='$bgcolor' align='".$datos[$j]["align"]."'><font face='arial' size='2' color='#000000'>".$campazo."</font></td>\n";
   }
   $retorno.="   <td width='5' bgcolor='$bgcolor'>&nbsp;</td>
              </tr>\n";
 }
 echo' <script language="javascript"> var contador= '.$d.'; </script>';

 if($pie=="con_pie"){
 $retorno.="
           <tr>
            <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
            <td width='15' bgcolor='#FFFFFF' align='right'><img src='".dominio()."imagenes/flecha.gif'></td>
             <td bgcolor='#FFFFFF' colspan='".($colspan-1)."'>
               <font face='verdana,arial' size='1' color='#000000'>
                 A los seleccionados :
               </font>
             ";
 if($con_email=="simon")
     $retorno.="<a href='#' onclick=\"accion_sel('formilla','mail_muchos');\"><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email a seleccionados'></a>";

 $retorno.="    <a href='#' onclick=\"accion_sel('formilla','borrar_muchos');\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar seleccionados'></a>
             </td>
             <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
           </tr>";
 }
 $retorno.="
         </table>
         <input type='hidden' name='accion' id='accion'>
         <input type='hidden' name='estos' id='estos'>
         </form>
         ";

 return $retorno;
}  // tabla_sql.

function tabla_sql5_sin_accion($titulo,$datos,$parametros,$sql,$acciones,$url,$colors,$bgcolors,$nombre_tabla,$pie,$tope,$llave,$con,$var_get=""){
 $retorno = "";
 $permiso_iconos="nel";
 if($acciones!=''){
  $acciones=explode("|",$acciones);
  $permiso_iconos="simon";
 }

 $colors=explode("|",$colors);
 $bgcolors=explode("|",$bgcolors);

 $color1=$colors[0];
 $color2=$colors[1];
 if($titulo!="")
 $retorno = "
        <p align='center'>
              <font color='$color1' size='4' face='verdana,Arial, Helvetica, sans-serif'>
                <b>$titulo</b>
              </font>
        </p>";
 $retorno.= "
      <form name='formilla' id='formilla' method='post' action='$url'>
        <table $parametros>
 ";
   $radio_master="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><input type='checkbox' name='dato_master' id='dato_master' onclick='checa(this.form)'></td>";
   $espacio="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><br></td>";

   $iconos_master='';
   $y=0;
   $con_email="nel";
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos_master.=$radio_master;
        if($acciones[$x]=="e")$iconos_master.=$espacio;
        if($acciones[$x]=="m")$iconos_master.=$espacio;
        if($acciones[$x]=="b")$iconos_master.=$espacio;
        if($acciones[$x]=="s")$iconos_master.=$espacio;
     }

    $result=mysql_query($sql);
    $columnas=count($datos);

    $colspan=$columnas+$y;
    $retorno.="<tr valign='top'>
                <td width='5' background='".dominio()."imagenes/top_tabla_i$tope.gif'>&nbsp;</td>\n".$iconos_master;

    for($i=0;$i<$columnas;$i++){
       $retorno.="<td width='".$datos[$i]["ancho"]."' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='$url?order_$nombre_tabla=".$datos[$i]["nombre"].$var_get."'><font face='arial' size='2' color='$color2'><b>".$datos[$i]["titulo"]."</b></font></a>
                  </td>";
    }
    $retorno.=" <td width='5' background='".dominio()."imagenes/top_tabla_d$tope.gif'>&nbsp;</td>
               </tr>\n";
  }

 $bgcolor1=$bgcolors[0];
 $bgcolor2=$bgcolors[1];
 $bg=1;

 $d=0;
 while ($row = mysql_fetch_array($result)){

   if($bg==1){
     $bg=2;$bgcolor=$bgcolor1;
   }else{
     $bg=1;$bgcolor=$bgcolor2;
   }

   $d++;
   $id=$row[$llave];
   $id2=$row["INEGI"];
   $checa="<td width='15' bgcolor='$bgcolor'><input type='checkbox' name='dato$d' id='dato$d' value='$id'></td>";
   $borrar="<td width='15' bgcolor='$bgcolor'><a href='#' onclick=\"confirma('eliminar','este registro','$url?accion=borrar&id=$id'); return false;\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar'></a></td>";
   $editar="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=editar&id=".$id."&id2=".$id2."'><img src='".dominio()."imagenes/editar.gif' border='0' alt='Editar'></a></td>";
   $mail="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=mail&id=$id'><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email'></a></td>";
   $sin_accion="<td width='15' bgcolor='$bgcolor'><a href='".$url."id=".$id."&id2=".$id2."'><img src='".dominio()."imagenes/accesar.gif' border='0' alt='Accesar'></a></td>";
   $iconos='';
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos.=$checa;
        if($acciones[$x]=="e")$iconos.=$editar;
        if($acciones[$x]=="m"){$iconos.=$mail;$con_email="simon";}
        if($acciones[$x]=="b")$iconos.=$borrar;
        if($acciones[$x]=="s")$iconos.=$sin_accion;
     }
   }

   for($x=0;$x<$columnas;$x++){
     $campo[$x]=$row[$datos[$x]["nombre"]];
   }

   $retorno.="<tr>
                 <td width='5' bgcolor='$bgcolor'>&nbsp;</td>\n".$iconos;
   for($j=0;$j<$columnas;$j++){
      $tipo_dato = mysql_field_type($result,$j);
      $campazo=$campo[$j];
      $campazo=str_replace("
","<br>",$campazo);
      if ($tipo_dato=="date") $campazo=invierte_fecha($campazo);
      if ($tipo_dato=="real") $campazo="$".number_format($campazo,2,".",",");
      $retorno.="<td bgcolor='$bgcolor' align='".$datos[$j]["align"]."'><font face='arial' size='2' color='#000000'>".$campazo."</font></td>\n";
   }
   $retorno.="   <td width='5' bgcolor='$bgcolor'>&nbsp;</td>
              </tr>\n";
 }
 echo' <script language="javascript"> var contador= '.$d.'; </script>';

 if($pie=="con_pie"){
 $retorno.="
           <tr>
            <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
            <td width='15' bgcolor='#FFFFFF' align='right'><img src='".dominio()."imagenes/flecha.gif'></td>
             <td bgcolor='#FFFFFF' colspan='".($colspan-1)."'>
               <font face='verdana,arial' size='1' color='#000000'>
                 A los seleccionados :
               </font>
             ";
 if($con_email=="simon")
     $retorno.="<a href='#' onclick=\"accion_sel('formilla','mail_muchos');\"><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email a seleccionados'></a>";

 $retorno.="    <a href='#' onclick=\"accion_sel('formilla','borrar_muchos');\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar seleccionados'></a>
             </td>
             <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
           </tr>";
 }
 $retorno.="
         </table>
         <input type='hidden' name='accion' id='accion'>
         <input type='hidden' name='estos' id='estos'>
         </form>
         ";

 return $retorno;
}  // tabla_sql.


function tabla_sql6($titulo,$datos,$parametros,$sql,$acciones,$url,$url2,$colors,$bgcolors,$nombre_tabla,$pie,$tope,$llave,$con,$var_get=""){
 $retorno = "";
 $permiso_iconos="nel";
 if($acciones!=''){
  $acciones=explode("|",$acciones);
  $permiso_iconos="simon";
 }

 $colors=explode("|",$colors);
 $bgcolors=explode("|",$bgcolors);

 $color1=$colors[0];
 $color2=$colors[1];
 if($titulo!="")
 $retorno = "
        <p align='center'>
              <font color='$color1' size='4' face='verdana,Arial, Helvetica, sans-serif'>
                <b>$titulo</b>
              </font>
        </p>";
 $retorno.= "
      <form name='formilla' id='formilla' method='post' action='$url'>
        <table $parametros>
 ";
   $radio_master="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><input type='checkbox' name='dato_master' id='dato_master' onclick='checa(this.form)'></td>";
   $espacio="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><br></td>";

   $iconos_master='';
   $y=0;
   $con_email="nel";
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos_master.=$radio_master;
        if($acciones[$x]=="e")$iconos_master.=$espacio;
        if($acciones[$x]=="m")$iconos_master.=$espacio;
        if($acciones[$x]=="b")$iconos_master.=$espacio;
     }

    $result=mysql_query($sql);
    $columnas=count($datos);

    $colspan=$columnas+$y;
    $retorno.="<tr valign='top'>
                <td width='5' background='".dominio()."imagenes/top_tabla_i$tope.gif'>&nbsp;</td>\n".$iconos_master;

    for($i=0;$i<$columnas;$i++){
       $retorno.="<td width='".$datos[$i]["ancho"]."' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='$url?order_$nombre_tabla=".$datos[$i]["nombre"].$var_get."'><font face='arial' size='2' color='$color2'><b>".$datos[$i]["titulo"]."</b></font></a>
                  </td>";
    }
    $retorno.=" <td width='5' background='".dominio()."imagenes/top_tabla_d$tope.gif'>&nbsp;</td>
               </tr>\n";
  }

 $bgcolor1=$bgcolors[0];
 $bgcolor2=$bgcolors[1];
 $bg=1;

 $d=0;
 while ($row = mysql_fetch_array($result)){

   if($bg==1){
     $bg=2;$bgcolor=$bgcolor1;
   }else{
     $bg=1;$bgcolor=$bgcolor2;
   }

   $d++;
   $id=$row[$llave];
   $id2=$row["INEGI"];
   $checa="<td width='15' bgcolor='$bgcolor'><input type='checkbox' name='dato$d' id='dato$d' value='$id'></td>";
   $borrar="<td width='15' bgcolor='$bgcolor'><a href='#' onclick=\"confirma('eliminar','este registro','$url?accion=borrar&id=$id'); return false;\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar'></a></td>";
   $editar="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=editar&id=".$id."'><img src='".dominio()."imagenes/editar.gif' border='0' alt='Editar'></a></td>";
   $mail="<td width='15' bgcolor='$bgcolor'><a href='$url2?accion=datos_completos&id=".$id."'><img src='".dominio()."imagenes/accesar.gif' border='0' alt='Accesar'></a></td>";
//   $mail="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=mail&id=$id'><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email'></a></td>";

   $iconos='';
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos.=$checa;
        if($acciones[$x]=="e")$iconos.=$editar;
        if($acciones[$x]=="m"){$iconos.=$mail;$con_email="simon";}
        if($acciones[$x]=="b")$iconos.=$borrar;
     }
   }

   for($x=0;$x<$columnas;$x++){
     $campo[$x]=$row[$datos[$x]["nombre"]];
   }

   $retorno.="<tr>
                 <td width='5' bgcolor='$bgcolor'>&nbsp;</td>\n".$iconos;
   for($j=0;$j<$columnas;$j++){
      $tipo_dato = mysql_field_type($result,$j);
      $campazo=$campo[$j];
      $campazo=str_replace("
","<br>",$campazo);
      if ($tipo_dato=="date") $campazo=invierte_fecha($campazo);
      if ($tipo_dato=="real") $campazo="$".number_format($campazo,2,".",",");
      $retorno.="<td bgcolor='$bgcolor' align='".$datos[$j]["align"]."'><font face='arial' size='2' color='#000000'>".$campazo."</font></td>\n";
   }
   $retorno.="   <td width='5' bgcolor='$bgcolor'>&nbsp;</td>
              </tr>\n";
 }
 echo' <script language="javascript"> var contador= '.$d.'; </script>';

 if($pie=="con_pie"){
// sam $retorno.="
//sam           <tr>
// sam            <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
// sam            <td width='15' bgcolor='#FFFFFF' align='right'><img src='".dominio()."imagenes/flecha.gif'></td>
// sam             <td bgcolor='#FFFFFF' colspan='".($colspan-1)."'>
// sam               <font face='verdana,arial' size='1' color='#000000'>
// sam                 A los seleccionados :
// sam               </font>
// sam             ";
// if($con_email=="simon")
 //    $retorno.="<a href='#' onclick=\"accion_sel('formilla','mail_muchos');\"><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email a seleccionados'></a>";

// sam $retorno.="    <a href='#' onclick=\"accion_sel('formilla','borrar_muchos');\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar seleccionados'></a>
// sam             </td>
// sam             <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
// sam           </tr>";
 }
 $retorno.="
         </table>
         <input type='hidden' name='accion' id='accion'>
         <input type='hidden' name='estos' id='estos'>
         </form>
         ";

 return $retorno;
}  // tabla_sql.





function tabla_sql_estados($titulo,$datos,$parametros,$sql,$acciones,$url,$colors,$bgcolors,$nombre_tabla,$pie,$tope,$llave,$con,$var_get=""){
 $retorno = "";
 $permiso_iconos="nel";
 if($acciones!=''){
  $acciones=explode("|",$acciones);
  $permiso_iconos="simon";
 }

 $colors=explode("|",$colors);
 $bgcolors=explode("|",$bgcolors);

 $color1=$colors[0];
 $color2=$colors[1];
 if($titulo!="")
 $retorno = "
        <p align='center'>
              <font color='$color1' size='4' face='verdana,Arial, Helvetica, sans-serif'>
                <b>$titulo</b>
              </font>
        </p>";
 $retorno.= "
      <form name='formilla' id='formilla' method='post' action='$url'>
        <table $parametros>
 ";
   $radio_master="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><input type='checkbox' name='dato_master' id='dato_master' onclick='checa(this.form)'></td>";
   $espacio="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><br></td>";

   $iconos_master='';
   $y=0;
   $con_email="nel";
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos_master.=$radio_master;
        if($acciones[$x]=="e")$iconos_master.=$espacio;
        if($acciones[$x]=="m")$iconos_master.=$espacio;
        if($acciones[$x]=="b")$iconos_master.=$espacio;
     }

    $result=mysql_query($sql);
    $columnas=count($datos);

    $colspan=$columnas+$y;
    $retorno.="<tr valign='top'>
                <td width='5' background='".dominio()."imagenes/top_tabla_i$tope.gif'>&nbsp;</td>\n".$iconos_master;

    for($i=0;$i<$columnas;$i++){
       $retorno.="<td width='".$datos[$i]["ancho"]."' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='$url?order_$nombre_tabla=".$datos[$i]["nombre"].$var_get."'><font face='arial' size='2' color='$color2'><b>".$datos[$i]["titulo"]."</b></font></a>
                  </td>";
    }

       $retorno.="<td width='200' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='".$url."?order_".$nombre_tabla."=sexo$var_get'><font face='arial' size='2' color='$color2'><b>Sexo</b></font></a>
                  </td>"; // estado nutricional 1
       $retorno.="<td width='200' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='".$url."?order_".$nombre_tabla."=fecha_nac$var_get'><font face='arial' size='2' color='$color2'><b>Edad</b></font></a>
                  </td>"; // estado nutricional 1

       $retorno.="<td width='200' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='".$url."?order_".$nombre_tabla."=Estado1$var_get'><font face='arial' size='2' color='$color2'><b>Estado 1</b></font></a>
                  </td>"; // estado nutricional 1
       $retorno.="<td width='200' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='".$url."?order_".$nombre_tabla."=Estado2$var_get'><font face='arial' size='2' color='$color2'><b>Estado 2</b></font></a>
                  </td>"; // estado nutricional 1
    $retorno.=" <td width='5' background='".dominio()."imagenes/top_tabla_d$tope.gif'>&nbsp;</td>
               </tr>\n";
  }

 $bgcolor1=$bgcolors[0];
 $bgcolor2=$bgcolors[1];
 $bg=1;

 $d=0;
 while ($row = mysql_fetch_array($result)){

   if($bg==1){
     $bg=2;$bgcolor=$bgcolor1;
   }else{
     $bg=1;$bgcolor=$bgcolor2;
   }

   $d++;
   $id=$row[$llave];

   $checa="<td width='15' bgcolor='$bgcolor'><input type='checkbox' name='dato$d' id='dato$d' value='$id'></td>";
   $borrar="<td width='15' bgcolor='$bgcolor'><a href='#' onclick=\"confirma('eliminar','este registro','$url?accion=borrar&id=$id'); return false;\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar'></a></td>";
   $editar="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=editar&id=$id'><img src='".dominio()."imagenes/editar.gif' border='0' alt='Editar'></a></td>";
   $mail="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=mail&id=$id'><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email'></a></td>";

   $iconos='';
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos.=$checa;
        if($acciones[$x]=="e")$iconos.=$editar;
        if($acciones[$x]=="m"){$iconos.=$mail;$con_email="simon";}
        if($acciones[$x]=="b")$iconos.=$borrar;
     }
   }

   for($x=0;$x<$columnas;$x++){
     $campo[$x]=$row[$datos[$x]["nombre"]];
   }

   $retorno.="<tr>
                 <td width='5' bgcolor='$bgcolor'>&nbsp;</td>\n".$iconos;
   for($j=0;$j<$columnas;$j++){
      $tipo_dato = mysql_field_type($result,$j);
      $campazo=$campo[$j];
      $campazo=str_replace("
","<br>",$campazo);
      if ($tipo_dato=="date") $campazo=invierte_fecha($campazo);
      if ($tipo_dato=="real") $campazo="$".number_format($campazo,2,".",",");
      $retorno.="<td bgcolor='$bgcolor' align='".$datos[$j]["align"]."'><font face='arial' size='2' color='#000000'>".$campazo."</font></td>\n";
   }

    $leyenda='';
      if ($row["sexo"]== 0 )$sex='HOMBRE';
      if ($row["sexo"]== 1 )$sex='MUJER';
    // echo invierte_fecha_guion($row["fecha_nac"]);
//           $edad=anios_meses_dias(invierte_fecha($row["fecha_nac"]),date("d/m/Y"));
           $edad=obten_edadb($row["fecha_nac"]);
//      echo $edad;
//      $edad=explode(".",$edad);
      $retorno.="<td bgcolor='$bgcolor' align='center'><font face='arial' size='2' color='#000000'>".$sex."</font></td>\n";
//      $retorno.="<td bgcolor='$bgcolor' align='center'><font face='arial' size='2' color='#000000'>".$edad[0].",".$edad[1]."</font></td>\n";
      $retorno.="<td bgcolor='$bgcolor' align='center'><font face='arial' size='2' color='#000000'>".$edad."</font></td>\n";
      $retorno.="<td bgcolor='$bgcolor' align='center'> <img src='".dominio()."imagenes/".estimador_regleta($con,$row["talla1"],$row["peso1"],$row["sexo"],$leyenda).".gif'></td>\n";
      $retorno.="<td bgcolor='$bgcolor' align='center'> <img src='".dominio()."imagenes/".estimador_regleta($con,$row["talla2"],$row["peso2"],$row["sexo"],$leyenda).".gif'></td>\n";
  // $retorno.="   <td width='5' bgcolor='$bgcolor'>&nbsp;</td>
          //    </tr>\n";
 }
 echo' <script language="javascript"> var contador= '.$d.'; </script>';

 if($pie=="con_pie"){
 $retorno.="
           <tr>
            <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
            <td width='15' bgcolor='#FFFFFF' align='right'><img src='".dominio()."imagenes/flecha.gif'></td>
             <td bgcolor='#FFFFFF' colspan='".($colspan-1)."'>
               <font face='verdana,arial' size='1' color='#000000'>
                 A los seleccionados :
               </font>
             ";
 if($con_email=="simon")
     $retorno.="<a href='#' onclick=\"accion_sel('formilla','mail_muchos');\"><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email a seleccionados'></a>";

 $retorno.="    <a href='#' onclick=\"accion_sel('formilla','borrar_muchos');\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar seleccionados'></a>
             </td>
             <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
           </tr>";
 }
 $retorno.="
         </table>
         <input type='hidden' name='accion' id='accion'>
         <input type='hidden' name='estos' id='estos'>
         </form>
         ";

 return $retorno;
}  // tabla_sql_estados.

function tabla_sql_estados4($titulo,$datos,$parametros,$sql,$acciones,$url,$colors,$bgcolors,$nombre_tabla,$pie,$tope,$llave,$con,$var_get=""){
 $retorno = "";
 $permiso_iconos="nel";
 if($acciones!=''){
  $acciones=explode("|",$acciones);
  $permiso_iconos="simon";
 }

 $colors=explode("|",$colors);
 $bgcolors=explode("|",$bgcolors);

 $color1=$colors[0];
 $color2=$colors[1];
 if($titulo!="")
 $retorno = "
        <p align='center'>
              <font color='$color1' size='4' face='verdana,Arial, Helvetica, sans-serif'>
                <b>$titulo</b>
              </font>
        </p>";
 $retorno.= "
      <form name='formilla' id='formilla' method='post' action='$url'>
        <table $parametros>
 ";
   $radio_master="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><input type='checkbox' name='dato_master' id='dato_master' onclick='checa(this.form)'></td>";
   $espacio="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><br></td>";

   $iconos_master='';
   $y=0;
   $con_email="nel";
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos_master.=$radio_master;
        if($acciones[$x]=="e")$iconos_master.=$espacio;
        if($acciones[$x]=="m")$iconos_master.=$espacio;
        if($acciones[$x]=="b")$iconos_master.=$espacio;
     }

    $result=mysql_query($sql);
    $columnas=count($datos);

    $colspan=$columnas+$y;
    $retorno.="<tr valign='top'>
                <td width='5' background='".dominio()."imagenes/top_tabla_i$tope.gif'>&nbsp;</td>\n".$iconos_master;

    for($i=0;$i<$columnas;$i++){
       $retorno.="<td width='".$datos[$i]["ancho"]."' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='$url?order_$nombre_tabla=".$datos[$i]["nombre"].$var_get."'><font face='arial' size='2' color='$color2'><b>".$datos[$i]["titulo"]."</b></font></a>
                  </td>";
    }

       $retorno.="<td width='200' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='".$url."?order_".$nombre_tabla."=sexo$var_get'><font face='arial' size='2' color='$color2'><b>Sexo</b></font></a>
                  </td>"; // estado nutricional 1
       $retorno.="<td width='200' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='".$url."?order_".$nombre_tabla."=fecha_nac$var_get'><font face='arial' size='2' color='$color2'><b>Edad</b></font></a>
                  </td>"; // estado nutricional 1

       $retorno.="<td width='200' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='".$url."?order_".$nombre_tabla."=Estado1$var_get'><font face='arial' size='2' color='$color2'><b>Estado 1</b></font></a>
                  </td>"; // estado nutricional 1
       $retorno.="<td width='200' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='".$url."?order_".$nombre_tabla."=Estado2$var_get'><font face='arial' size='2' color='$color2'><b>Estado 2</b></font></a>
                  </td>"; // estado nutricional 1
    $retorno.=" <td width='5' background='".dominio()."imagenes/top_tabla_d$tope.gif'>&nbsp;</td>
               </tr>\n";
  }

 $bgcolor1=$bgcolors[0];
 $bgcolor2=$bgcolors[1];
 $bg=1;

 $d=0;
 while ($row = mysql_fetch_array($result)){

   if($bg==1){
     $bg=2;$bgcolor=$bgcolor1;
   }else{
     $bg=1;$bgcolor=$bgcolor2;
   }

   $d++;
   $id=$row[$llave];

   $checa="<td width='15' bgcolor='$bgcolor'><input type='checkbox' name='dato$d' id3='dato$d' value='$id'></td>";
   $borrar="<td width='15' bgcolor='$bgcolor'><a href='#' onclick=\"confirma('eliminar','este registro','$url?accion=borrar&id3=$id'); return false;\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar'></a></td>";
   $editar="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=editar&id3=".urlencode($id)."'><img src='".dominio()."imagenes/editar.gif' border='0' alt='Editar'></a></td>";
   $mail="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=mail&id3=$id'><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email'></a></td>";

   $iconos='';
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos.=$checa;
        if($acciones[$x]=="e")$iconos.=$editar;
        if($acciones[$x]=="m"){$iconos.=$mail;$con_email="simon";}
        if($acciones[$x]=="b")$iconos.=$borrar;
     }
   }

   for($x=0;$x<$columnas;$x++){
     $campo[$x]=$row[$datos[$x]["nombre"]];
   }

   $retorno.="<tr>
                 <td width='5' bgcolor='$bgcolor'>&nbsp;</td>\n".$iconos;
   for($j=0;$j<$columnas;$j++){
      $tipo_dato = mysql_field_type($result,$j);
      $campazo=$campo[$j];
      $campazo=str_replace("
","<br>",$campazo);
      if ($tipo_dato=="date") $campazo=invierte_fecha($campazo);
      if ($tipo_dato=="real") $campazo="$".number_format($campazo,2,".",",");
      $retorno.="<td bgcolor='$bgcolor' align='".$datos[$j]["align"]."'><font face='arial' size='2' color='#000000'>".$campazo."</font></td>\n";
   }

    $leyenda='';
      if ($row["sexo"]== 0 )$sex='HOMBRE';
      if ($row["sexo"]== 1 )$sex='MUJER';
    // echo invierte_fecha_guion($row["fecha_nac"]);
//           $edad=anios_meses_dias(invierte_fecha($row["fecha_nac"]),date("d/m/Y"));
           $edad=obten_edadb($row["fecha_nac"]);
      //echo $edad;
//      $edad=explode(".",$edad);
      $retorno.="<td bgcolor='$bgcolor' align='center'><font face='arial' size='2' color='#000000'>".$sex."</font></td>\n";
//      $retorno.="<td bgcolor='$bgcolor' align='center'><font face='arial' size='2' color='#000000'>".$edad[0].",".$edad[1]."</font></td>\n";
      $retorno.="<td bgcolor='$bgcolor' align='center'><font face='arial' size='2' color='#000000'>".$edad."</font></td>\n";
      $retorno.="<td bgcolor='$bgcolor' align='center'> <img src='".dominio()."imagenes/".estimador_regleta($con,$row["talla1"],$row["peso1"],$row["sexo"],$leyenda).".png'></td>\n";
      $retorno.="<td bgcolor='$bgcolor' align='center'> <img src='".dominio()."imagenes/".estimador_regleta($con,$row["talla2"],$row["peso2"],$row["sexo"],$leyenda).".png'></td>\n";
  // $retorno.="   <td width='5' bgcolor='$bgcolor'>&nbsp;</td>
          //    </tr>\n";
 }
 echo' <script language="javascript"> var contador= '.$d.'; </script>';

 if($pie=="con_pie"){
 $retorno.="
           <tr>
            <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
            <td width='15' bgcolor='#FFFFFF' align='right'><img src='".dominio()."imagenes/flecha.gif'></td>
             <td bgcolor='#FFFFFF' colspan='".($colspan-1)."'>
               <font face='verdana,arial' size='1' color='#000000'>
                 A los seleccionados :
               </font>
             ";
 if($con_email=="simon")
     $retorno.="<a href='#' onclick=\"accion_sel('formilla','mail_muchos');\"><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email a seleccionados'></a>";

 $retorno.="    <a href='#' onclick=\"accion_sel('formilla','borrar_muchos');\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar seleccionados'></a>
             </td>
             <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
           </tr>";
 }
 $retorno.="
         </table>
         <input type='hidden' name='accion' id='accion'>
         <input type='hidden' name='estos' id='estos'>
         </form>
         ";

 return $retorno;
}  // tabla_sql_estados4.

function tabla_sql_estados2($titulo,$datos,$parametros,$sql,$acciones,$url,$colors,$bgcolors,$nombre_tabla,$pie,$tope,$llave,$con,$var_get=""){
 $retorno = "";
 $permiso_iconos="nel";
 if($acciones!=''){
  $acciones=explode("|",$acciones);
  $permiso_iconos="simon";
 }

 $colors=explode("|",$colors);
 $bgcolors=explode("|",$bgcolors);

 $color1=$colors[0];
 $color2=$colors[1];
 if($titulo!="")
 $retorno = "
        <p align='center'>
              <font color='$color1' size='4' face='verdana,Arial, Helvetica, sans-serif'>
                <b>$titulo</b>
              </font>
        </p>";
 $retorno.= "
      <form name='formilla' id='formilla' method='post' action='$url'>
        <table $parametros>
 ";
   $radio_master="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><input type='checkbox' name='dato_master' id='dato_master' onclick='checa(this.form)'></td>";
   $espacio="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><br></td>";

   $iconos_master='';
   $y=0;
   $con_email="nel";
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos_master.=$radio_master;
        if($acciones[$x]=="e")$iconos_master.=$espacio;
        if($acciones[$x]=="m")$iconos_master.=$espacio;
        if($acciones[$x]=="b")$iconos_master.=$espacio;
     }

    $result=mysql_query($sql);
    $columnas=count($datos);

    $colspan=$columnas+$y;
    $retorno.="<tr valign='top'>
                <td width='5' background='".dominio()."imagenes/top_tabla_i$tope.gif'>&nbsp;</td>\n".$iconos_master;

    for($i=0;$i<$columnas;$i++){
       $retorno.="<td width='".$datos[$i]["ancho"]."' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='$url?order_$nombre_tabla=".$datos[$i]["nombre"].$var_get."'><font face='arial' size='2' color='$color2'><b>".$datos[$i]["titulo"]."</b></font></a>
                  </td>";
    }

       $retorno.="<td width='200' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='".$url."?order_".$nombre_tabla."=Sexo$var_get'><font face='arial' size='2' color='$color2'><b>Sexo</b></font></a>
                  </td>"; // estado nutricional 1
       $retorno.="<td width='200' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='".$url."?order_".$nombre_tabla."=Edad$var_get'><font face='arial' size='2' color='$color2'><b>Edad</b></font></a>
                  </td>"; // estado nutricional 1
        $retorno.="<td width='200' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='".$url."?order_".$nombre_tabla."=Estado1$var_get'><font face='arial' size='2' color='$color2'><b>E 1</b></font></a>
                  </td>"; // estado nutricional 1
       $retorno.="<td width='200' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='".$url."?order_".$nombre_tabla."=Estado2$var_get'><font face='arial' size='2' color='$color2'><b>E 2</b></font></a>
                  </td>"; // estado nutricional 1
	   $retorno.="<td width='200' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='".$url."?order_".$nombre_tabla."=Estado1$var_get'><font face='arial' size='2' color='$color2'><b>E 3</b></font></a>
                  </td>"; // estado nutricional 1
       $retorno.="<td width='200' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='".$url."?order_".$nombre_tabla."=Estado2$var_get'><font face='arial' size='2' color='$color2'><b>E 4</b></font></a>
                  </td>"; // estado nutricional 1
		 $retorno.="<td width='200' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='".$url."?order_".$nombre_tabla."=Estado1$var_get'><font face='arial' size='2' color='$color2'><b>E 5</b></font></a>
                  </td>"; // estado nutricional 1
       $retorno.="<td width='200' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='".$url."?order_".$nombre_tabla."=Estado2$var_get'><font face='arial' size='2' color='$color2'><b>E 6</b></font></a>
                  </td>"; // estado nutricional 1		  

    $retorno.=" <td width='5' background='".dominio()."imagenes/top_tabla_d$tope.gif'>&nbsp;</td>
               </tr>\n";
  }

 $bgcolor1=$bgcolors[0];
 $bgcolor2=$bgcolors[1];
 $bg=1;

 $d=0;
 while ($row = mysql_fetch_array($result)){

   if($bg==1){
     $bg=2;$bgcolor=$bgcolor1;
   }else{
     $bg=1;$bgcolor=$bgcolor2;
   }

   $d++;
   $id=$row[$llave];

   $checa="<td width='15' bgcolor='$bgcolor'><input type='checkbox' name='dato$d' id='dato$d' value='$id'></td>";
   $borrar="<td width='15' bgcolor='$bgcolor'><a href='#' onclick=\"confirma('eliminar','este registro','$url?accion=borrar&id=".urlencode($id)."'); return false;\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar'></a></td>";
   $editar="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=editar&id=".urlencode($id)."'><img src='".dominio()."imagenes/editar.gif' border='0' alt='Editar'></a></td>";
   $mail="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=mail&id=$id'><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email'></a></td>";

   $iconos='';
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos.=$checa;
        if($acciones[$x]=="e")$iconos.=$editar;
        if($acciones[$x]=="m"){$iconos.=$mail;$con_email="simon";}
        if($acciones[$x]=="b")$iconos.=$borrar;
     }
   }

   for($x=0;$x<$columnas;$x++){
     $campo[$x]=$row[$datos[$x]["nombre"]];
   }

   $retorno.="<tr>
                 <td width='5' bgcolor='$bgcolor'>&nbsp;</td>\n".$iconos;
   for($j=0;$j<$columnas;$j++){
      $tipo_dato = mysql_field_type($result,$j);
      $campazo=$campo[$j];
      $campazo=str_replace("
","<br>",$campazo);
      if ($tipo_dato=="date") $campazo=invierte_fecha($campazo);
      if ($tipo_dato=="real") $campazo="$".number_format($campazo,2,".",",");
      $retorno.="<td bgcolor='$bgcolor' align='".$datos[$j]["align"]."'><font face='arial' size='2' color='#000000'>".$campazo."</font></td>\n";
   }

    $leyenda='';
      if ($row["sexo"]== 0 )$sex='HOMBRE';
      if ($row["sexo"]== 1 )$sex='MUJER';
    // echo invierte_fecha_guion($row["fecha_nac"]);
    //       $edad=anios_meses_dias(invierte_fecha($row["fecha_nac"]),date("d/m/Y"));
       $edad=obten_edadb($row["fecha_nac"]);
      //echo $edad;
      //$edad=explode(".",$edad);
      $retorno.="<td bgcolor='$bgcolor' align='center'><font face='arial' size='2' color='#000000'>".$sex."</font></td>\n";
     // $retorno.="<td bgcolor='$bgcolor' align='center'><font face='arial' size='2' color='#000000'>".$edad[0].",".$edad[1]."</font></td>\n";
      $retorno.="<td bgcolor='$bgcolor' align='center'><font face='arial' size='2' color='#000000'>".$edad."</font></td>\n";
	  $retorno.="<td bgcolor='$bgcolor' align='center'> <img src='".dominio()."imagenes/".estimador_pct($con,invierte_fecha($row["fecha_nac"]),invierte_fecha($row["fregistro1"]),$row["sexo"],$row["peso1"],$leyenda).".png'></td>\n";
      $retorno.="<td bgcolor='$bgcolor' align='center'> <img src='".dominio()."imagenes/".estimador_pct($con,invierte_fecha($row["fecha_nac"]),invierte_fecha($row["fregistro2"]),$row["sexo"],$row["peso2"],$leyenda).".png'></td>\n";
	  $retorno.="<td bgcolor='$bgcolor' align='center'> <img src='".dominio()."imagenes/".estimador_pct($con,invierte_fecha($row["fecha_nac"]),invierte_fecha($row["fregistro3"]),$row["sexo"],$row["peso3"],$leyenda).".png'></td>\n";
      $retorno.="<td bgcolor='$bgcolor' align='center'> <img src='".dominio()."imagenes/".estimador_pct($con,invierte_fecha($row["fecha_nac"]),invierte_fecha($row["fregistro4"]),$row["sexo"],$row["peso4"],$leyenda).".png'></td>\n";
	  $retorno.="<td bgcolor='$bgcolor' align='center'> <img src='".dominio()."imagenes/".estimador_pct($con,invierte_fecha($row["fecha_nac"]),invierte_fecha($row["fregistro5"]),$row["sexo"],$row["peso5"],$leyenda).".png'></td>\n";
      $retorno.="<td bgcolor='$bgcolor' align='center'> <img src='".dominio()."imagenes/".estimador_pct($con,invierte_fecha($row["fecha_nac"]),invierte_fecha($row["fregistro6"]),$row["sexo"],$row["peso6"],$leyenda).".png'></td>\n";
  // $retorno.="   <td width='5' bgcolor='$bgcolor'>&nbsp;</td>
          //    </tr>\n";
 }
 echo' <script language="javascript"> var contador= '.$d.'; </script>';

 if($pie=="con_pie"){
 $retorno.="
           <tr>
            <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
            <td width='15' bgcolor='#FFFFFF' align='right'><img src='".dominio()."imagenes/flecha.gif'></td>
             <td bgcolor='#FFFFFF' colspan='".($colspan-1)."'>
               <font face='verdana,arial' size='1' color='#000000'>
                 A los seleccionados :
               </font>
             ";
 if($con_email=="simon")
     $retorno.="<a href='#' onclick=\"accion_sel('formilla','mail_muchos');\"><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email a seleccionados'></a>";

 $retorno.="    <a href='#' onclick=\"accion_sel('formilla','borrar_muchos');\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar seleccionados'></a>
             </td>
             <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
           </tr>";
 }
 $retorno.="
         </table>
         <input type='hidden' name='accion' id='accion'>
         <input type='hidden' name='estos' id='estos'>
         </form>
         ";

 return $retorno;
}  // tabla_sql_estados2.

function tabla_sql_estados3($titulo,$datos,$parametros,$sql,$acciones,$url,$colors,$bgcolors,$nombre_tabla,$pie,$tope,$llave,$con,$var_get=""){
 $retorno = "";
 $permiso_iconos="nel";
 if($acciones!=''){
  $acciones=explode("|",$acciones);
  $permiso_iconos="simon";
 }

 $colors=explode("|",$colors);
 $bgcolors=explode("|",$bgcolors);

 $color1=$colors[0];
 $color2=$colors[1];
 if($titulo!="")
 $retorno = "
        <p align='center'>
              <font color='$color1' size='4' face='verdana,Arial, Helvetica, sans-serif'>
                <b>$titulo</b>
              </font>
        </p>";
 $retorno.= "
      <form name='formilla' id='formilla' method='post' action='$url'>
        <table $parametros>
 ";
   $radio_master="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><input type='checkbox' name='dato_master' id='dato_master' onclick='checa(this.form)'></td>";
   $espacio="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><br></td>";

   $iconos_master='';
   $y=0;
   $con_email="nel";
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos_master.=$radio_master;
        if($acciones[$x]=="e")$iconos_master.=$espacio;
        if($acciones[$x]=="m")$iconos_master.=$espacio;
        if($acciones[$x]=="b")$iconos_master.=$espacio;
     }

    $result=mysql_query($sql);
    $columnas=count($datos);

    $colspan=$columnas+$y;
    $retorno.="<tr valign='top'>
                <td width='5' background='".dominio()."imagenes/top_tabla_i$tope.gif'>&nbsp;</td>\n".$iconos_master;

    for($i=0;$i<$columnas;$i++){
       $retorno.="<td width='".$datos[$i]["ancho"]."' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='$url?order_$nombre_tabla=".$datos[$i]["nombre"].$var_get."'><font face='arial' size='2' color='$color2'><b>".$datos[$i]["titulo"]."</b></font></a>
                  </td>";
    }

       $retorno.="<td width='200' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='".$url."?order_".$nombre_tabla."=Sexo$var_get'><font face='arial' size='2' color='$color2'><b>Sexo</b></font></a>
                  </td>"; // estado nutricional 1
       $retorno.="<td width='200' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='".$url."?order_".$nombre_tabla."=Edad$var_get'><font face='arial' size='2' color='$color2'><b>Edad</b></font></a>
                  </td>"; // estado nutricional 1


    $retorno.=" <td width='5' background='".dominio()."imagenes/top_tabla_d$tope.gif'>&nbsp;</td>
               </tr>\n";
  }

 $bgcolor1=$bgcolors[0];
 $bgcolor2=$bgcolors[1];
 $bg=1;

 $d=0;
 while ($row = mysql_fetch_array($result)){

   if($bg==1){
     $bg=2;$bgcolor=$bgcolor1;
   }else{
     $bg=1;$bgcolor=$bgcolor2;
   }

   $d++;
   $id=$row[$llave];

   $checa="<td width='15' bgcolor='$bgcolor'><input type='checkbox' name='dato$d' id3='dato$d' value='$id'></td>";
   $borrar="<td width='15' bgcolor='$bgcolor'><a href='#' onclick=\"confirma('eliminar','este registro','$url?accion=borrar&id3=$id'); return false;\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar'></a></td>";
   $editar="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=editar&id3=$id'><img src='".dominio()."imagenes/editar.gif' border='0' alt='Editar'></a></td>";
   $mail="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=mail&id3=$id'><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email'></a></td>";

   $iconos='';
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos.=$checa;
        if($acciones[$x]=="e")$iconos.=$editar;
        if($acciones[$x]=="m"){$iconos.=$mail;$con_email="simon";}
        if($acciones[$x]=="b")$iconos.=$borrar;
     }
   }

   for($x=0;$x<$columnas;$x++){
     $campo[$x]=$row[$datos[$x]["nombre"]];
   }

   $retorno.="<tr>
                 <td width='5' bgcolor='$bgcolor'>&nbsp;</td>\n".$iconos;
   for($j=0;$j<$columnas;$j++){
      $tipo_dato = mysql_field_type($result,$j);
      $campazo=$campo[$j];
      $campazo=str_replace("
","<br>",$campazo);
      if ($tipo_dato=="date") $campazo=invierte_fecha($campazo);
      if ($tipo_dato=="real") $campazo="$".number_format($campazo,2,".",",");
      $retorno.="<td bgcolor='$bgcolor' align='".$datos[$j]["align"]."'><font face='arial' size='2' color='#000000'>".$campazo."</font></td>\n";
   }

    $leyenda='';
      if ($row["sexo"]== 0 )$sex='HOMBRE';
      if ($row["sexo"]== 1 )$sex='MUJER';
    // echo invierte_fecha_guion($row["fecha_nac"]);
    //       $edad=anios_meses_dias(invierte_fecha($row["fecha_nac"]),date("d/m/Y"));
       $edad=obten_edadb($row["fecha_nac"]);
      //echo $edad;
      //$edad=explode(".",$edad);
      $retorno.="<td bgcolor='$bgcolor' align='center'><font face='arial' size='2' color='#000000'>".$sex."</font></td>\n";
     // $retorno.="<td bgcolor='$bgcolor' align='center'><font face='arial' size='2' color='#000000'>".$edad[0].",".$edad[1]."</font></td>\n";
      $retorno.="<td bgcolor='$bgcolor' align='center'><font face='arial' size='2' color='#000000'>".$edad."</font></td>\n";
  // $retorno.="   <td width='5' bgcolor='$bgcolor'>&nbsp;</td>
          //    </tr>\n";
 }
 echo' <script language="javascript"> var contador= '.$d.'; </script>';

 if($pie=="con_pie"){
 $retorno.="
           <tr>
            <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
            <td width='15' bgcolor='#FFFFFF' align='right'><img src='".dominio()."imagenes/flecha.gif'></td>
             <td bgcolor='#FFFFFF' colspan='".($colspan-1)."'>
               <font face='verdana,arial' size='1' color='#000000'>
                 A los seleccionados :
               </font>
             ";
 if($con_email=="simon")
     $retorno.="<a href='#' onclick=\"accion_sel('formilla','mail_muchos');\"><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email a seleccionados'></a>";

 $retorno.="    <a href='#' onclick=\"accion_sel('formilla','borrar_muchos');\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar seleccionados'></a>
             </td>
             <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
           </tr>";
 }
 $retorno.="
         </table>
         <input type='hidden' name='accion' id='accion'>
         <input type='hidden' name='estos' id='estos'>
         </form>
         ";

 return $retorno;
}  // tabla_sql_estados3.

function tabla_sql_permisos($titulo,$datos,$parametros,$sql,$acciones,$url,$colors,$bgcolors,$nombre_tabla,$pie,$tope,$llave,$con,$var_get=""){
 $retorno = "";
 $permiso_iconos="nel";
 if($acciones!=''){
  $acciones=explode("|",$acciones);
  $permiso_iconos="simon";
 }

 $colors=explode("|",$colors);
 $bgcolors=explode("|",$bgcolors);

 $color1=$colors[0];
 $color2=$colors[1];
 if($titulo!="")
 $retorno = "
        <p align='center'>
              <font color='$color1' size='4' face='verdana,Arial, Helvetica, sans-serif'>
                <b>$titulo</b>
              </font>
        </p>";
 $retorno.= "
      <form name='formilla' id='formilla' method='post' action='$url'>
        <table $parametros>
 ";
   $radio_master="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><input type='checkbox' name='dato_master' id='dato_master' onclick='checa(this.form)'></td>";
   $espacio="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><br></td>";

   $iconos_master='';
   $y=0;
   $con_email="nel";
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos_master.=$radio_master;
        if($acciones[$x]=="e")$iconos_master.=$espacio;
        if($acciones[$x]=="m")$iconos_master.=$espacio;
        if($acciones[$x]=="b")$iconos_master.=$espacio;
     }

    $result=mysql_query($sql);
    $columnas=count($datos);

    $colspan=$columnas+$y;
    $retorno.="<tr valign='top'>
                <td width='5' background='".dominio()."imagenes/top_tabla_i$tope.gif'>&nbsp;</td>\n".$iconos_master;

    for($i=0;$i<$columnas;$i++){
       $retorno.="<td width='".$datos[$i]["ancho"]."' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='$url?order_$nombre_tabla=".$datos[$i]["nombre"].$var_get."'><font face='arial' size='2' color='$color2'><b>".$datos[$i]["titulo"]."</b></font></a>
                  </td>";
    }
    $retorno.=" <td width='5' background='".dominio()."imagenes/top_tabla_d$tope.gif'>&nbsp;</td>
               </tr>\n";
  }

 $bgcolor1=$bgcolors[0];
 $bgcolor2=$bgcolors[1];
 $bg=1;

 $d=0;
 while ($row = mysql_fetch_array($result)){

   if($bg==1){
     $bg=2;$bgcolor=$bgcolor1;
   }else{
     $bg=1;$bgcolor=$bgcolor2;
   }

   $d++;
   $id=$row[$llave];
   $mun=$row["cod_mun"];
//   $url_fix=("log=".$id."&cod_mun=".$mun);
 //  echo
   $checa="<td width='15' bgcolor='$bgcolor'><input type='checkbox' name='dato$d' id='dato$d' value='$id'></td>";
   $borrar="<td width='15' bgcolor='$bgcolor'><a href='#' onclick=\"confirma('eliminar','este registro','$url?accion=borrar&id=$id'); return false;\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar'></a></td>";
   $editar="<td width='15' bgcolor='$bgcolor'><a href='$url?log=".urlencode($id)."&cod_mun=".urlencode($mun)."'><img src='".dominio()."imagenes/editar.gif' border='0' alt='Editar'></a></td>";
   $mail="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=mail&id=$id'><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email'></a></td>";

   $iconos='';
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos.=$checa;
        if($acciones[$x]=="e")$iconos.=$editar;
        if($acciones[$x]=="m"){$iconos.=$mail;$con_email="simon";}
        if($acciones[$x]=="b")$iconos.=$borrar;
     }
   }

   for($x=0;$x<$columnas;$x++){
     $campo[$x]=$row[$datos[$x]["nombre"]];
   }

   $retorno.="<tr>
                 <td width='5' bgcolor='$bgcolor'>&nbsp;</td>\n".$iconos;
   for($j=0;$j<$columnas;$j++){
      $tipo_dato = mysql_field_type($result,$j);
      $campazo=$campo[$j];
      $campazo=str_replace("
","<br>",$campazo);
      if ($tipo_dato=="date") $campazo=invierte_fecha($campazo);
      if ($tipo_dato=="real") $campazo="$".number_format($campazo,2,".",",");
      $retorno.="<td bgcolor='$bgcolor' align='".$datos[$j]["align"]."'><font face='arial' size='2' color='#000000'>".$campazo."</font></td>\n";
   }
   $retorno.="   <td width='5' bgcolor='$bgcolor'>&nbsp;</td>
              </tr>\n";
 }
 echo' <script language="javascript"> var contador= '.$d.'; </script>';

 if($pie=="con_pie"){
 $retorno.="
           <tr>
            <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
            <td width='15' bgcolor='#FFFFFF' align='right'><img src='".dominio()."imagenes/flecha.gif'></td>
             <td bgcolor='#FFFFFF' colspan='".($colspan-1)."'>
               <font face='verdana,arial' size='1' color='#000000'>
                 A los seleccionados :
               </font>
             ";
 if($con_email=="simon")
     $retorno.="<a href='#' onclick=\"accion_sel('formilla','mail_muchos');\"><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email a seleccionados'></a>";

 $retorno.="    <a href='#' onclick=\"accion_sel('formilla','borrar_muchos');\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar seleccionados'></a>
             </td>
             <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
           </tr>";
 }
 $retorno.="
         </table>
         <input type='hidden' name='accion' id='accion'>
         <input type='hidden' name='estos' id='estos'>
         </form>
         ";

 return $retorno;
}  // tabla_sql_permisos.


function tabla_sql_permisos2($titulo,$datos,$parametros,$sql,$acciones,$url,$colors,$bgcolors,$nombre_tabla,$pie,$tope,$llave,$con,$var_get=""){
 $retorno = "";
 $permiso_iconos="nel";
 if($acciones!=''){
  $acciones=explode("|",$acciones);
  $permiso_iconos="simon";
 }

 $colors=explode("|",$colors);
 $bgcolors=explode("|",$bgcolors);

 $color1=$colors[0];
 $color2=$colors[1];
 if($titulo!="")
 $retorno = "
        <p align='center'>
              <font color='$color1' size='4' face='verdana,Arial, Helvetica, sans-serif'>
                <b>$titulo</b>
              </font>
        </p>";
 $retorno.= "
      <form name='formilla' id='formilla' method='post' action='$url'>
        <table $parametros>
 ";
   $radio_master="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><input type='checkbox' name='dato_master' id='dato_master' onclick='checa(this.form)'></td>";
   $espacio="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><br></td>";

   $iconos_master='';
   $y=0;
   $con_email="nel";
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos_master.=$radio_master;
        if($acciones[$x]=="e")$iconos_master.=$espacio;
        if($acciones[$x]=="m")$iconos_master.=$espacio;
        if($acciones[$x]=="b")$iconos_master.=$espacio;
     }

    $result=mysql_query($sql);
    $columnas=count($datos);

    $colspan=$columnas+$y;
    $retorno.="<tr valign='top'>
                <td width='5' background='".dominio()."imagenes/top_tabla_i$tope.gif'>&nbsp;</td>\n".$iconos_master;

    for($i=0;$i<$columnas;$i++){
       $retorno.="<td width='".$datos[$i]["ancho"]."' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='$url?order_$nombre_tabla=".$datos[$i]["nombre"].$var_get."'><font face='arial' size='2' color='$color2'><b>".$datos[$i]["titulo"]."</b></font></a>
                  </td>";
    }
    $retorno.=" <td width='5' background='".dominio()."imagenes/top_tabla_d$tope.gif'>&nbsp;</td>
               </tr>\n";
  }

 $bgcolor1=$bgcolors[0];
 $bgcolor2=$bgcolors[1];
 $bg=1;

 $d=0;
 while ($row = mysql_fetch_array($result)){

   if($bg==1){
     $bg=2;$bgcolor=$bgcolor1;
   }else{
     $bg=1;$bgcolor=$bgcolor2;
   }

   $d++;
   $id=$row[$llave];
   $mun=$row["municipio"];

   
   $checa="<td width='15' bgcolor='$bgcolor'><input type='checkbox' name='dato$d' id='dato$d' value='$id'></td>";

//   $editar="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=abrir_ciclo_usuario&log=".urlencode($id)."&cod_muni=".urlencode($mun)."'><img src='".dominio()."imagenes/editar.gif' border='0' alt='Abrir Ciclo'></a></td>";
   $editar="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=abrir_ciclo_usuario&log=".urlencode($id)."&cod_muni=".urlencode($mun)."'><img src='".dominio()."imagenes/accesar.gif' border='0' alt='Abrir Ciclo'></a></td>";
   $mail="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=cerrar_ciclo_usuario&log=".urlencode($id)."&cod_muni=".urlencode($mun)."'><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Cerrar Ciclo'></a></td>";
   $borrar="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=control_accesos&log=".urlencode($id)."&cod_muni=".urlencode($mun)."'><img src='".dominio()."imagenes/editar.gif' border='0' alt='Eliminar'></a></td>";

   $iconos='';
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos.=$checa;
        if($acciones[$x]=="e")$iconos.=$editar;
        if($acciones[$x]=="m"){$iconos.=$mail;$con_email="simon";}
        if($acciones[$x]=="b")$iconos.=$borrar;
     }
   }

   for($x=0;$x<$columnas;$x++){
     $campo[$x]=$row[$datos[$x]["nombre"]];
   }

   $retorno.="<tr>
                 <td width='5' bgcolor='$bgcolor'>&nbsp;</td>\n".$iconos;
   for($j=0;$j<$columnas;$j++){
      $tipo_dato = mysql_field_type($result,$j);
      $campazo=$campo[$j];
      $campazo=str_replace("
","<br>",$campazo);
      if ($tipo_dato=="date") $campazo=invierte_fecha($campazo);
      if ($tipo_dato=="real") $campazo="$".number_format($campazo,2,".",",");
      $retorno.="<td bgcolor='$bgcolor' align='".$datos[$j]["align"]."'><font face='arial' size='2' color='#000000'>".$campazo."</font></td>\n";
   }
   $retorno.="   <td width='5' bgcolor='$bgcolor'>&nbsp;</td>
              </tr>\n";
 }
 echo' <script language="javascript"> var contador= '.$d.'; </script>';

 if($pie=="con_pie"){
 $retorno.="
           <tr>
            <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
            <td width='15' bgcolor='#FFFFFF' align='right'><img src='".dominio()."imagenes/flecha.gif'></td>
             <td bgcolor='#FFFFFF' colspan='".($colspan-1)."'>
               <font face='verdana,arial' size='1' color='#000000'>
                 A los seleccionados :
               </font>
             ";
 if($con_email=="simon")
     $retorno.="<a href='#' onclick=\"accion_sel('formilla','mail_muchos');\"><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email a seleccionados'></a>";

 $retorno.="    <a href='#' onclick=\"accion_sel('formilla','borrar_muchos');\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar seleccionados'></a>
             </td>
             <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
           </tr>";
 }
 $retorno.="
         </table>
         <input type='hidden' name='accion' id='accion'>
         <input type='hidden' name='estos' id='estos'>
         </form>
         ";

 return $retorno;
}  // tabla_sql_permisos.

function acceso_ciclos($con,$municipio,$log,$ciclo,$programa){
 $sql='select Status from estado_ciclo where ciclo = "'.$ciclo.'" and municipio = "'.$municipio.'" and Login = "'.$log.'" and programa = '.$programa.' ';
//echo $sql;
 $result=mysql_query($sql,$con);
 if ($row=mysql_fetch_array($result)) {
  if ($row["Status"]==1)
  return true;
  else
  return false;
 }
else
  return false;
  }

function tabla_sql3($titulo,$datos,$parametros,$sql,$acciones,$url,$colors,$bgcolors,$nombre_tabla,$pie,$tope,$llave,$con,$var_get=""){
 $retorno = "";
 $permiso_iconos="nel";
 if($acciones!=''){
  $acciones=explode("|",$acciones);
  $permiso_iconos="simon";
 }

 $colors=explode("|",$colors);
 $bgcolors=explode("|",$bgcolors);

 $color1=$colors[0];
 $color2=$colors[1];
 if($titulo!="")
 $retorno = "
        <p align='center'>
              <font color='$color1' size='4' face='verdana,Arial, Helvetica, sans-serif'>
                <b>$titulo</b>
              </font>
        </p>";
 $retorno.= "
      <form name='formilla' id='formilla' method='post' action='$url'>
        <table $parametros>
 ";
   $radio_master="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><input type='checkbox' name='dato_master' id='dato_master' onclick='checa(this.form)'></td>";
   $espacio="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><br></td>";

   $iconos_master='';
   $y=0;
   $con_email="nel";
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos_master.=$radio_master;
        if($acciones[$x]=="e")$iconos_master.=$espacio;
        if($acciones[$x]=="m")$iconos_master.=$espacio;
        if($acciones[$x]=="b")$iconos_master.=$espacio;
     }

    $result=mysql_query($sql);
    $columnas=count($datos);

    $colspan=$columnas+$y;
    $retorno.="<tr valign='top'>
                <td width='5' background='".dominio()."imagenes/top_tabla_i$tope.gif'>&nbsp;</td>\n".$iconos_master;

    for($i=0;$i<$columnas;$i++) {
       $retorno.="<td width='".$datos[$i]["ancho"]."' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='$url?order_$nombre_tabla=".$datos[$i]["nombre"].$var_get."'>
                    <font face='arial' size='2' color='$color2'><b>".$datos[$i]["titulo"]."</b></font></a>
                  </td>";
    }
    $retorno.=" <td width='5' background='".dominio()."imagenes/top_tabla_d$tope.gif'>&nbsp;</td>
               </tr>\n";
  }

 $bgcolor1=$bgcolors[0];
 $bgcolor2=$bgcolors[1];
 $bg=1;

 $d=0;
 while ($row = mysql_fetch_array($result)){

   if($bg==1){
     $bg=2;$bgcolor=$bgcolor1;
   }else{
     $bg=1;$bgcolor=$bgcolor2;
   }

   $d++;
   $id=$row[$llave];

   $checa="<td width='15' bgcolor='$bgcolor'><input type='checkbox' name='dato$d' id='dato$d' value='$id'></td>";
   $borrar="<td width='15' bgcolor='$bgcolor'><a href='#' onclick=\"confirma('eliminar','este registro','$url?accion=borrar&id=$id'); return false;\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar'></a></td>";
   $editar="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=editar&id=$id'><img src='".dominio()."imagenes/editar.gif' border='0' alt='Editar'></a></td>";
   $mail="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=mail&id=$id'><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email'></a></td>";

   $iconos='';
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos.=$checa;
        if($acciones[$x]=="e")$iconos.=$editar;
        if($acciones[$x]=="m"){$iconos.=$mail;$con_email="simon";}
        if($acciones[$x]=="b")$iconos.=$borrar;
     }
   }

   for($x=0;$x<$columnas;$x++){
     $campo[$x]=$row[$datos[$x]["nombre"]];
   }

   $retorno.="<tr>
                 <td width='5' bgcolor='$bgcolor'>&nbsp;</td>\n".$iconos;
   for($j=0;$j<$columnas;$j++){
      $tipo_dato = mysql_field_type($result,$j);
      $p=$j+3;
      $codigo=$row[$p];
      $campazo=$campo[$j];
      $campazo=str_replace("
","<br>",$campazo);
      if ($tipo_dato=="date") $campazo=invierte_fecha($campazo);
      if ($tipo_dato=="real") $campazo="$".number_format($campazo,2,".",",");
      $retorno.="<td bgcolor='$bgcolor' align='".$datos[$j]["align"]."'><font face='arial' size='2' color='#000000'>".$codigo." - ".$campazo."</font></td>\n";
   }
   $retorno.="   <td width='5' bgcolor='$bgcolor'>&nbsp;</td>
              </tr>\n";
 }
 echo' <script language="javascript"> var contador= '.$d.'; </script>';

 if($pie=="con_pie"){
 $retorno.="
           <tr>
            <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
            <td width='15' bgcolor='#FFFFFF' align='right'><img src='".dominio()."imagenes/flecha.gif'></td>
             <td bgcolor='#FFFFFF' colspan='".($colspan-1)."'>
               <font face='verdana,arial' size='1' color='#000000'>
                 A los seleccionados :
               </font>
             ";
 if($con_email=="simon")
     $retorno.="<a href='#' onclick=\"accion_sel('formilla','mail_muchos');\"><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email a seleccionados'></a>";

 $retorno.="    <a href='#' onclick=\"accion_sel('formilla','borrar_muchos');\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar seleccionados'></a>
             </td>
             <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
           </tr>";
 }
 $retorno.="
         </table>
         <input type='hidden' name='accion' id='accion'>
         <input type='hidden' name='estos' id='estos'>
         </form>
         ";

 return $retorno;
}  // tabla_sql3.

function tabla_sql4($titulo,$datos,$parametros,$sql,$acciones,$url,$colors,$bgcolors,$nombre_tabla,$pie,$tope,$llave,$con,$var_get=""){
 $retorno = "";
 $permiso_iconos="nel";
 if($acciones!=''){
  $acciones=explode("|",$acciones);
  $permiso_iconos="simon";
 }

 $colors=explode("|",$colors);
 $bgcolors=explode("|",$bgcolors);

 $color1=$colors[0];
 $color2=$colors[1];
 if($titulo!="")
 $retorno = "
        <p align='center'>
              <font color='$color1' size='4' face='verdana,Arial, Helvetica, sans-serif'>
                <b>$titulo</b>
              </font>
        </p>";
 $retorno.= "
      <form name='formilla' id='formilla' method='post' action='$url'>
        <table $parametros>
 ";
   $radio_master="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><input type='checkbox' name='dato_master' id='dato_master' onclick='checa(this.form)'></td>";
   $espacio="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><br></td>";

   $iconos_master='';
   $y=0;
   $con_email="nel";
   if ($permiso_iconos=='simon') {
     $y=count($acciones);
     for ($x=0;$x<$y;$x++) {
        if($acciones[$x]=="c")$iconos_master.=$radio_master;
        if($acciones[$x]=="e")$iconos_master.=$espacio;
        if($acciones[$x]=="m")$iconos_master.=$espacio;
        if($acciones[$x]=="b")$iconos_master.=$espacio;
     }

    $result=mysql_query($sql);
    $columnas=count($datos);

    $colspan=$columnas+$y;
    $retorno.="<tr valign='top'>
                <td width='5' background='".dominio()."imagenes/top_tabla_i$tope.gif'>&nbsp;</td>\n".$iconos_master;

    for ($i=0;$i<$columnas;$i++) {
       $retorno.="<td width='".$datos[$i]["ancho"]."' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='$url?order_$nombre_tabla=".$datos[$i]["nombre"].$var_get."'>
                    <font face='arial' size='2' color='$color2'><b>".$datos[$i]["titulo"]."</b></font></a>
                  </td>";
    }
    $retorno.=" <td width='5' background='".dominio()."imagenes/top_tabla_d$tope.gif'>&nbsp;</td>
               </tr>\n";
  }

 $bgcolor1=$bgcolors[0];
 $bgcolor2=$bgcolors[1];
 $bg=1;

 $d=0;
 while ($row = mysql_fetch_array($result)){

   if($bg==1){
     $bg=2;$bgcolor=$bgcolor1;
   }else{
     $bg=1;$bgcolor=$bgcolor2;
   }

   $d++;
   $id=$row[$llave];

   $checa="<td width='15' bgcolor='$bgcolor'><input type='checkbox' name='dato$d' id='dato$d' value='$id'></td>";
   $borrar="<td width='15' bgcolor='$bgcolor'><a href='#' onclick=\"confirma('eliminar','este registro','$url?accion=borrar&id=$id'); return false;\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar'></a></td>";
   $editar="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=editar&id=$id'><img src='".dominio()."imagenes/editar.gif' border='0' alt='Editar'></a></td>";
   $mail="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=mail&id=$id'><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email'></a></td>";

   $iconos='';
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos.=$checa;
        if($acciones[$x]=="e")$iconos.=$editar;
        if($acciones[$x]=="m"){$iconos.=$mail;$con_email="simon";}
        if($acciones[$x]=="b")$iconos.=$borrar;
     }
   }

   for($x=0;$x<$columnas;$x++){
     $campo[$x]=$row[$datos[$x]["nombre"]];
   }

   $retorno.="<tr>
                 <td width='5' bgcolor='$bgcolor'>&nbsp;</td>\n".$iconos;
   for($j=0;$j<$columnas;$j++){
      $tipo_dato = mysql_field_type($result,$j);
      $p=$j+7;
      $codigo=$row[$p];
      $campazo=$campo[$j];
      $campazo=str_replace("
","<br>",$campazo);
      if ($tipo_dato=="date") $campazo=invierte_fecha($campazo);
      if ($tipo_dato=="real") $campazo="$".number_format($campazo,2,".",",");
      $retorno.="<td bgcolor='$bgcolor' align='".$datos[$j]["align"]."'><font face='arial' size='2' color='#000000'>".$codigo." - ".$campazo."</font></td>\n";
   }
   $retorno.="   <td width='5' bgcolor='$bgcolor'>&nbsp;</td>
              </tr>\n";
 }
 echo' <script language="javascript"> var contador= '.$d.'; </script>';

 if($pie=="con_pie"){
 $retorno.="
           <tr>
            <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
            <td width='15' bgcolor='#FFFFFF' align='right'><img src='".dominio()."imagenes/flecha.gif'></td>
             <td bgcolor='#FFFFFF' colspan='".($colspan-1)."'>
               <font face='verdana,arial' size='1' color='#000000'>
                 A los seleccionados :
               </font>
             ";
 if($con_email=="simon")
     $retorno.="<a href='#' onclick=\"accion_sel('formilla','mail_muchos');\"><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email a seleccionados'></a>";

 $retorno.="    <a href='#' onclick=\"accion_sel('formilla','borrar_muchos');\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar seleccionados'></a>
             </td>
             <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
           </tr>";
 }
 $retorno.="
         </table>
         <input type='hidden' name='accion' id='accion'>
         <input type='hidden' name='estos' id='estos'>
         </form>
         ";

 return $retorno;
}  // tabla_sql4.

function tabla_sql_popup($var_get,$datos,$parametros,$sql,$acciones,$url,$colors,$bgcolors,$nombre_tabla,$pie,$tope,$llave,$con,$aux=""){
 $retorno = "";
 $permiso_iconos="nel";
 if($acciones!=''){
  $acciones=explode("|",$acciones);
  $permiso_iconos="simon";
 }

 $colors=explode("|",$colors);
 $bgcolors=explode("|",$bgcolors);

 $color1=$colors[0];
 $color2=$colors[1];

 $retorno.= "
      <form name='formilla' id='formilla' method='post' action='$url'>
        <table $parametros>
 ";
   $radio_master="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><input type='checkbox' name='dato_master' id='dato_master' onclick='checa(this.form)'></td>";
   $espacio="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><br></td>";

   $iconos_master='';
   $y=0;
   $con_email="nel";
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos_master.=$radio_master;
        if($acciones[$x]=="e")$iconos_master.=$espacio;
        if($acciones[$x]=="m")$iconos_master.=$espacio;
        if($acciones[$x]=="b")$iconos_master.=$espacio;
     }

    $result=mysql_query($sql);
    $columnas=count($datos);

    $colspan=$columnas+$y;
    $retorno.="<tr valign='top'>
                <td width='5' background='".dominio()."imagenes/top_tabla_i$tope.gif'>&nbsp;</td>\n".$iconos_master;

    for($i=0;$i<$columnas;$i++){
       $retorno.="<td width='".$datos[$i]["ancho"]."' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='$url?order_$nombre_tabla=".$datos[$i]["nombre"]."".$var_get."'><font face='arial' size='1' color='$color2'><b>".$datos[$i]["titulo"]."</b></font></a>
                  </td>";
    }
    $retorno.=" <td width='5' background='".dominio()."imagenes/top_tabla_d$tope.gif'>&nbsp;</td>
               </tr>\n";
  }

 $bgcolor1=$bgcolors[0];
 $bgcolor2=$bgcolors[1];
 $bg=1;

 $d=0;
 while ($row = mysql_fetch_array($result)){

   if($bg==1){
     $bg=2;$bgcolor=$bgcolor1;
   }else{
     $bg=1;$bgcolor=$bgcolor2;
   }

   $d++;
   $id=$row[$llave];

   $checa="<td width='15' bgcolor='$bgcolor'><input type='checkbox' name='dato$d' id='dato$d' value='$id'></td>";
   $borrar="<td width='15' bgcolor='$bgcolor'><a href='#' onclick=\"confirma('eliminar','este registro','$url?accion=borrar&id=$id'); return false;\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar'></a></td>";
   $editar="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=editar&id=$id'><img src='".dominio()."imagenes/editar.gif' border='0' alt='Editar'></a></td>";
   $mail="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=mail&id=$id'><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email'></a></td>";

   $iconos='';
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos.=$checa;
        if($acciones[$x]=="e")$iconos.=$editar;
        if($acciones[$x]=="m"){$iconos.=$mail;$con_email="simon";}
        if($acciones[$x]=="b")$iconos.=$borrar;
     }
   }

   for($x=0;$x<$columnas;$x++){
     $campo[$x]=$row[$datos[$x]["nombre"]];
   }

   $retorno.="<tr>
                 <td width='5' bgcolor='$bgcolor'>&nbsp;</td>\n".$iconos;
   for($j=0;$j<$columnas;$j++){
      $tipo_dato = mysql_field_type($result,$j);
      $campazo=$campo[$j];
      $campazo=str_replace("
","<br>",$campazo);
      if ($tipo_dato=="date") $campazo=invierte_fecha($campazo);
      if ($tipo_dato=="real") $campazo="$".number_format($campazo,2,".",",");
      $retorno.="<td bgcolor='$bgcolor' align='".$datos[$j]["align"]."'>
      <font face='arial' size='1' color='#000000'><A HREF='$url?".$aux."accion=manda&id=".$row[$llave]."&form=".obten("form").$var_get."'>".$campazo."</font></td>\n";
   }
   $retorno.="   <td width='5' bgcolor='$bgcolor'>&nbsp;</td>
              </tr>\n";
 }
 echo' <script language="javascript"> var contador= '.$d.'; </script>';

 if($pie=="con_pie"){
 $retorno.="
           <tr>
            <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
            <td width='15' bgcolor='#FFFFFF' align='right'><img src='".dominio()."imagenes/flecha.gif'></td>
             <td bgcolor='#FFFFFF' colspan='".($colspan-1)."'>
               <font face='verdana,arial' size='1' color='#000000'>
                 A los seleccionados :
               </font>
             ";
 if($con_email=="simon")
     $retorno.="<a href='#' onclick=\"accion_sel('formilla','mail_muchos');\"><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email a seleccionados'></a>";

 $retorno.="    <a href='#' onclick=\"accion_sel('formilla','borrar_muchos');\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar seleccionados'></a>
             </td>
             <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
           </tr>";
 }
 $retorno.="
         </table>
         <input type='hidden' name='accion' id='accion'>
         <input type='hidden' name='estos' id='estos'>
         </form>
         ";

 return $retorno;
}  // tabla_sql_popup.

function tabla_sql_comp($titulo,$datos,$parametros,$sql,$acciones,$url,$colors,$bgcolors,$nombre_tabla,$pie,$tope,$llave,$con){
 $retorno = "";
 $permiso_iconos="nel";
 if($acciones!=''){
  $acciones=explode("|",$acciones);
  $permiso_iconos="simon";
 }

 $colors=explode("|",$colors);
 $bgcolors=explode("|",$bgcolors);

 $color1=$colors[0];
 $color2=$colors[1];
 if($titulo!="")
 $retorno = "
        <p align='center'>
              <font color='$color1' size='4' face='verdana,Arial, Helvetica, sans-serif'>
                <b>$titulo</b>
              </font>
        </p>";
 $retorno.= "
      <form name='formilla' id='formilla' method='post' action='$url'>
        <table $parametros>
 ";
   $radio_master="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><input type='checkbox' name='dato_master' id='dato_master' onclick='checa(this.form)'></td>";
   $espacio="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><br></td>";

   $iconos_master='';
   $y=0;
   $con_email="nel";
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos_master.=$radio_master;
        if($acciones[$x]=="e")$iconos_master.=$espacio;
        if($acciones[$x]=="m")$iconos_master.=$espacio;
        if($acciones[$x]=="b")$iconos_master.=$espacio;
     }

    $result=mysql_query($sql);
    $columnas=count($datos);

    $colspan=$columnas+$y;
    $retorno.="<tr valign='top'>
                <td width='5' background='".dominio()."imagenes/top_tabla_i$tope.gif'>&nbsp;</td>\n".$iconos_master;

    for($i=0;$i<$columnas;$i++){
       $retorno.="<td width='".$datos[$i]["ancho"]."' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='$url?order_$nombre_tabla=".$datos[$i]["nombre"]."'><font face='arial' size='2' color='$color2'><b>".$datos[$i]["titulo"]."</b></font></a>
                  </td>";
    }
    $retorno.=" <td width='5' background='".dominio()."imagenes/top_tabla_d$tope.gif'>&nbsp;</td>
               </tr>\n";
  }

 $bgcolor1=$bgcolors[0];
 $bgcolor2=$bgcolors[1];
 $bg=1;

 $d=0;
 while ($row = mysql_fetch_array($result)){

   if($bg==1){
     $bg=2;$bgcolor=$bgcolor1;
   }else{
     $bg=1;$bgcolor=$bgcolor2;
   }

   $d++;
   $id=$row[$llave];

   $checa="<td width='15' bgcolor='$bgcolor'><input type='checkbox' name='dato$d' id='dato$d' value='$id'></td>";
   $borrar="<td width='15' bgcolor='$bgcolor'><a href='#' onclick=\"confirma('eliminar','este registro','$url?accion=borrar_componente&id=$id'); return false;\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar'></a></td>";
   $editar="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=editar&id=$id'><img src='".dominio()."imagenes/editar.gif' border='0' alt='Editar'></a></td>";
   $mail="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=mail&id=$id'><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email'></a></td>";

   $iconos='';
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos.=$checa;
        if($acciones[$x]=="e")$iconos.=$editar;
        if($acciones[$x]=="m"){$iconos.=$mail;$con_email="simon";}
        if($acciones[$x]=="b")$iconos.=$borrar;
     }
   }

   for($x=0;$x<$columnas;$x++){
     $campo[$x]=$row[$datos[$x]["nombre"]];
   }

   $retorno.="<tr>
                 <td width='5' bgcolor='$bgcolor'>&nbsp;</td>\n".$iconos;
   for($j=0;$j<$columnas;$j++){
      $tipo_dato = mysql_field_type($result,$j);
      $campazo=$campo[$j];
      $campazo=str_replace("
","<br>",$campazo);

      if ($tipo_dato=="date") $campazo=invierte_fecha($campazo);
            if ($j!="5")
               if ($tipo_dato=="real") $campazo="$".number_format($campazo,2,".",",");
            else
               if ($tipo_dato=="real") $campazo=$campazo;

      $retorno.="<td bgcolor='$bgcolor' align='".$datos[$j]["align"]."'><font face='arial' size='2' color='#000000'>".$campazo."</font></td>\n";
   }
   $retorno.="   <td width='5' bgcolor='$bgcolor'>&nbsp;</td>
              </tr>\n";
 }
 echo' <script language="javascript"> var contador= '.$d.'; </script>';

 if($pie=="con_pie"){
 $retorno.="
           <tr>
            <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
            <td width='15' bgcolor='#FFFFFF' align='right'><img src='".dominio()."imagenes/flecha.gif'></td>
             <td bgcolor='#FFFFFF' colspan='".($colspan-1)."'>
               <font face='verdana,arial' size='1' color='#000000'>
                 A los seleccionados :
               </font>
             ";
 if($con_email=="simon")
     $retorno.="<a href='#' onclick=\"accion_sel('formilla','mail_muchos');\"><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email a seleccionados'></a>";

 $retorno.="    <a href='#' onclick=\"accion_sel('formilla','borrar_muchos_comp');\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar seleccionados'></a>
             </td>
             <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
           </tr>";
 }
 $retorno.="
         </table>
         <input type='hidden' name='accion' id='accion'>
         <input type='hidden' name='estos' id='estos'>
         </form>
         ";

 return $retorno;

}

function tabla_sqla($titulo,$datos,$parametros,$sql,$acciones,$url,$colors,$bgcolors,$nombre_tabla,$pie,$tope,$llave,$con){
 $retorno = "";
 $permiso_iconos="nel";
 if($acciones!=''){
  $acciones=explode("|",$acciones);
  $permiso_iconos="simon";
 }

 $colors=explode("|",$colors);
 $bgcolors=explode("|",$bgcolors);

 $color1=$colors[0];
 $color2=$colors[1];
 if($titulo!="")
 $retorno = "
        <p align='center'>
              <font color='$color1' size='4' face='verdana,Arial, Helvetica, sans-serif'>
                <b>$titulo</b>
              </font>
        </p>";
 $retorno.= "
      <form name='formilla' id='formilla' method='post' action='$url'>
        <table $parametros>
 ";
   $radio_master="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><input type='checkbox' name='dato_master' id='dato_master' onclick='checa(this.form)'></td>";
   $espacio="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><br></td>";

   $iconos_master='';
   $y=0;
   $con_email="nel";
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos_master.=$radio_master;
        if($acciones[$x]=="e")$iconos_master.=$espacio;
        if($acciones[$x]=="m")$iconos_master.=$espacio;
        if($acciones[$x]=="b")$iconos_master.=$espacio;
     }

    $result=mysql_query($sql);
    $columnas=count($datos);

    $colspan=$columnas+$y;
    $retorno.="<tr valign='top'>
                <td width='5' background='".dominio()."imagenes/top_tabla_i$tope.gif'>&nbsp;</td>\n".$iconos_master;

    for($i=0;$i<$columnas;$i++){
       $retorno.="<td width='".$datos[$i]["ancho"]."' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='$url?order_$nombre_tabla=".$datos[$i]["nombre"]."'><font face='arial' size='2' color='$color2'><b>".$datos[$i]["titulo"]."</b></font></a>
                  </td>";
    }
    $retorno.=" <td width='5' background='".dominio()."imagenes/top_tabla_d$tope.gif'>&nbsp;</td>
               </tr>\n";
  }

 $bgcolor1=$bgcolors[0];
 $bgcolor2=$bgcolors[1];
 $bg=1;

 $d=0;
 while ($row = mysql_fetch_array($result)){

   if($bg==1){
     $bg=2;$bgcolor=$bgcolor1;
   }else{
     $bg=1;$bgcolor=$bgcolor2;
   }

   $d++;
   $id=$row[$llave];

   $checa="<td width='15' bgcolor='$bgcolor'><input type='checkbox' name='dato$d' id='dato$d' value='$id'></td>";
   $borrar="<td width='15' bgcolor='$bgcolor'><a href='#' onclick=\"confirma('eliminar','este registro','$url?accion=borrar&id=$id'); return false;\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar'></a></td>";
   $editar="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=editar&id=$id'><img src='".dominio()."imagenes/editar.gif' border='0' alt='Editar'></a></td>";
   $mail="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=mail&id=$id'><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email'></a></td>";

   $iconos='';
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos.=$checa;
        if($acciones[$x]=="e")$iconos.=$editar;
        if($acciones[$x]=="m"){$iconos.=$mail;$con_email="simon";}
        if($acciones[$x]=="b")$iconos.=$borrar;
     }
   }

   for($x=0;$x<$columnas;$x++){
     $campo[$x]=$row[$datos[$x]["nombre"]];
   }

   $retorno.="<tr>
                 <td width='5' bgcolor='$bgcolor'>&nbsp;</td>\n".$iconos;
   for($j=0;$j<$columnas;$j++){
      $tipo_dato = mysql_field_type($result,$j);
      $nombre_campo= mysql_field_name($result,$j);
      $campazo=$campo[$j];
      $campazo=str_replace("
","<br>",$campazo);
      if ($tipo_dato=="date") $campazo=invierte_fecha($campazo);
      if ($tipo_dato=="real") $campazo="$".number_format($campazo,2,".",",");
      if ($campazo=="1" && $nombre_campo=="abona") $campazo="ABONA";
      if ($campazo=="0" && $nombre_campo=="abona") $campazo="CARGA";
      $retorno.="<td bgcolor='$bgcolor' align='".$datos[$j]["align"]."'><font face='arial' size='2' color='#000000'>".$campazo."</font></td>\n";
   }
   $retorno.="   <td width='5' bgcolor='$bgcolor'>&nbsp;</td>
              </tr>\n";
 }
 echo' <script language="javascript"> var contador= '.$d.'; </script>';

 if($pie=="con_pie"){
 $retorno.="
           <tr>
            <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
            <td width='15' bgcolor='#FFFFFF' align='right'><img src='".dominio()."imagenes/flecha.gif'></td>
             <td bgcolor='#FFFFFF' colspan='".($colspan-1)."'>
               <font face='verdana,arial' size='1' color='#000000'>
                 A los seleccionados :
               </font>
             ";
 if($con_email=="simon")
     $retorno.="<a href='#' onclick=\"accion_sel('formilla','mail_muchos');\"><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email a seleccionados'></a>";

 $retorno.="    <a href='#' onclick=\"accion_sel('formilla','borrar_muchos');\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar seleccionados'></a>
             </td>
             <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
           </tr>";
 }
 $retorno.="
         </table>
         <input type='hidden' name='accion' id='accion'>
         <input type='hidden' name='estos' id='estos'>
         </form>
         ";

 return $retorno;

}  // tabla_sqla.

function tabla_sql10($titulo,$datos,$parametros,$sql,$acciones,$url,$colors,$bgcolors,$nombre_tabla,$pie,$tope,$llave,$con,$num_doc){
 $retorno = "";
 $permiso_iconos="nel";
 if($acciones!=''){
  $acciones=explode("|",$acciones);
  $permiso_iconos="simon";
 }

 $colors=explode("|",$colors);
 $bgcolors=explode("|",$bgcolors);

 $color1=$colors[0];
 $color2=$colors[1];
 if($titulo!="")
 $retorno = "
        <p align='center'>
              <font color='$color1' size='4' face='verdana,Arial, Helvetica, sans-serif'>
                <b>$titulo</b>
              </font>
        </p>";
 $retorno.= "
      <form name='formilla' id='formilla' method='post' action='$url'>
        <table $parametros>
 ";
   $radio_master="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><input type='checkbox' name='dato_master' id='dato_master' onclick='checa(this.form)'></td>";
   $espacio="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><br></td>";

   $iconos_master='';
   $y=0;
   $con_email="nel";
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos_master.=$radio_master;
        if($acciones[$x]=="e")$iconos_master.=$espacio;
        if($acciones[$x]=="m")$iconos_master.=$espacio;
        if($acciones[$x]=="b")$iconos_master.=$espacio;
     }

    $result=mysql_query($sql);
    $columnas=count($datos);

    $colspan=$columnas+$y;
    $retorno.="<tr valign='top'>
                <td width='5' background='".dominio()."imagenes/top_tabla_i$tope.gif'>&nbsp;</td>\n".$iconos_master;

    for($i=0;$i<$columnas;$i++){
       $retorno.="<td width='".$datos[$i]["ancho"]."' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <font face='arial' size='2' color='$color2'><b>".$datos[$i]["titulo"]."</b></font>
                  </td>";
    }
    $retorno.=" <td width='5' background='".dominio()."imagenes/top_tabla_d$tope.gif'>&nbsp;</td>
               </tr>\n";
  }

 $bgcolor1=$bgcolors[0];
 $bgcolor2=$bgcolors[1];
 $bg=1;

 $d=0;
 while ($row = mysql_fetch_array($result)) {

   if ($bg==1) {
     $bg=2;$bgcolor=$bgcolor1;
   } else {
     $bg=1;$bgcolor=$bgcolor2;
   }

   $d++;
   $id=$row[$llave];

   $checa="<td width='15' bgcolor='$bgcolor'><input type='checkbox' name='dato$d' id='dato$d' value='$id'></td>";
   $borrar="<td width='15' bgcolor='$bgcolor'><a href='#' onclick=\"confirma('eliminar','este registro','$url?accion=borrarnota&id=$id&num_doc=$num_doc'); return false;\">
    <img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar'></a></td>";
   $editar="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=editar&id=$id'><img src='".dominio()."imagenes/editar.gif' border='0' alt='Editar'></a></td>";
   $mail="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=mail&id=$id'><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email'></a></td>";

   $iconos='';
   if ($permiso_iconos=='simon') {
     $y=count($acciones);
     for ($x=0;$x<$y;$x++) {
        if($acciones[$x]=="c")$iconos.=$checa;
        if($acciones[$x]=="e")$iconos.=$editar;
        if($acciones[$x]=="m"){$iconos.=$mail;$con_email="simon";}
        if($acciones[$x]=="b")$iconos.=$borrar;
     }
   }

   for($x=0;$x<$columnas;$x++){
     $campo[$x]=$row[$datos[$x]["nombre"]];
   }

   $retorno.="<tr>
                 <td width='5' bgcolor='$bgcolor'>&nbsp;</td>\n".$iconos;
   for ($j=0;$j<$columnas;$j++) {
      $tipo_dato = mysql_field_type($result,$j);
      $campazo=$campo[$j];
      $campazo=str_replace("
","<br>",$campazo);
      if ($tipo_dato=="date") $campazo=invierte_fecha($campazo);
      if ($tipo_dato=="real") $campazo="$".number_format($campazo,2,".",",");
      $retorno.="<td bgcolor='$bgcolor' align='".$datos[$j]["align"]."'><font face='arial' size='2' color='#000000'>".$campazo."</font></td>\n";
   }
   $retorno.="   <td width='5' bgcolor='$bgcolor'>&nbsp;</td>
              </tr>\n";
 }
 echo' <script language="javascript"> var contador= '.$d.'; </script>';

 if($pie=="con_pie"){
 $retorno.="
           <tr>
            <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
            <td width='15' bgcolor='#FFFFFF' align='right'><img src='".dominio()."imagenes/flecha.gif'></td>
             <td bgcolor='#FFFFFF' colspan='".($colspan-1)."'>
               <font face='verdana,arial' size='1' color='#000000'>
                 A los seleccionados :
               </font>
             ";
 if($con_email=="simon")
     $retorno.="<a href='#' onclick=\"accion_sel('formilla','mail_muchos');\"><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email a seleccionados'></a>";

 $retorno.="    <a href='#' onclick=\"accion_sel('formilla','borrar_muchos');\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar seleccionados'></a>
             </td>
             <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
           </tr>";
 }
 $retorno.="
         </table>
         <input type='hidden' name='accion' id='accion'>
         <input type='hidden' name='estos' id='estos'>
         </form>
         ";

 return $retorno;
}  // tabla_sql10.


function tabla_sql1($titulo,$datos,$parametros,$sql,$acciones,$url,$colors,$bgcolors,$nombre_tabla,$pie,$tope,$llave1,$llave2,$llave3,$con){
 $retorno = "";
 $permiso_iconos="nel";
 if($acciones!=''){
  $acciones=explode("|",$acciones);
  $permiso_iconos="simon";
 }

 $colors=explode("|",$colors);
 $bgcolors=explode("|",$bgcolors);

 $color1=$colors[0];
 $color2=$colors[1];
 if($titulo!="")
 $retorno = "
        <p align='center'>
              <font color='$color1' size='4' face='verdana,Arial, Helvetica, sans-serif'>
                <b>$titulo</b>
              </font>
        </p>";
 $retorno.= "
      <form name='formilla' id='formilla' method='post' action='$url'>
        <table $parametros>
 ";
   $radio_master="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><input type='checkbox' name='dato_master' id='dato_master' onclick='checa(this.form)'></td>";
   $espacio="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><br></td>";

   $iconos_master='';
   $y=0;
   $con_email="nel";
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos_master.=$radio_master;
        if($acciones[$x]=="e")$iconos_master.=$espacio;
        if($acciones[$x]=="m")$iconos_master.=$espacio;
        if($acciones[$x]=="b")$iconos_master.=$espacio;
     }

    $result=mysql_query($sql);
    $columnas=count($datos);

    $colspan=$columnas+$y;
    $retorno.="<tr valign='top'>
                <td width='5' background='".dominio()."imagenes/top_tabla_i$tope.gif'>&nbsp;</td>\n".$iconos_master;

    for($i=0;$i<$columnas;$i++){
       $retorno.="<td width='".$datos[$i]["ancho"]."' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='$url?order_$nombre_tabla=".$datos[$i]["nombre"]."'><font face='arial' size='2' color='$color2'><b>".$datos[$i]["titulo"]."</b></font></a>
                  </td>";
    }
    $retorno.=" <td width='5' background='".dominio()."imagenes/top_tabla_d$tope.gif'>&nbsp;</td>
               </tr>\n";
  }

 $bgcolor1=$bgcolors[0];
 $bgcolor2=$bgcolors[1];
 $bg=1;

 $d=0;
 while ($row = mysql_fetch_array($result)){

   if($bg==1){
     $bg=2;$bgcolor=$bgcolor1;
   }else{
     $bg=1;$bgcolor=$bgcolor2;
   }

   $d++;
   $id1=$row[$llave1];
   $id2=$row[$llave2];
   $id3=$row[$llave3];

   $checa="<td width='15' bgcolor='$bgcolor'><input type='checkbox' name='dato$d' id='dato$d' value='$id1'></td>";
   $borrar="<td width='15' bgcolor='$bgcolor'><a href='#' onclick=\"confirma('eliminar','este registro','$url?accion=borrar&cod_empresa=$id1&cod_almacen=$id2&anio=$id3'); return false;\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar'></a></td>";
   $editar="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=editar&id=$id1'><img src='".dominio()."imagenes/editar.gif' border='0' alt='Editar'></a></td>";
   $mail="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=mail&id=$id1'><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email'></a></td>";

   $iconos='';
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos.=$checa;
        if($acciones[$x]=="e")$iconos.=$editar;
        if($acciones[$x]=="m"){$iconos.=$mail;$con_email="simon";}
        if($acciones[$x]=="b")$iconos.=$borrar;
     }
   }

   for($x=0;$x<$columnas;$x++){
     $campo[$x]=$row[$datos[$x]["nombre"]];
   }

   $retorno.="<tr>
                 <td width='5' bgcolor='$bgcolor'>&nbsp;</td>\n".$iconos;
   for($j=0;$j<$columnas;$j++){
      $tipo_dato = mysql_field_type($result,$j);
      $campazo=$campo[$j];
      $campazo=str_replace("
","<br>",$campazo);
      if ($tipo_dato=="date") $campazo=invierte_fecha($campazo);
      if ($tipo_dato=="real") $campazo="$".number_format($campazo,2,".",",");
      $retorno.="<td bgcolor='$bgcolor' align='".$datos[$j]["align"]."'><font face='arial' size='2' color='#000000'>".$campazo."</font></td>\n";
   }
   $retorno.="   <td width='5' bgcolor='$bgcolor'>&nbsp;</td>
              </tr>\n";
 }
 echo' <script language="javascript"> var contador= '.$d.'; </script>';

 if($pie=="con_pie"){
 $retorno.="
           <tr>
            <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
            <td width='15' bgcolor='#FFFFFF' align='right'><img src='".dominio()."imagenes/flecha.gif'></td>
             <td bgcolor='#FFFFFF' colspan='".($colspan-1)."'>
               <font face='verdana,arial' size='1' color='#000000'>
                 A los seleccionados :
               </font>
             ";
 if($con_email=="simon")
     $retorno.="<a href='#' onclick=\"accion_sel('formilla','mail_muchos');\"><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email a seleccionados'></a>";

 $retorno.="    <a href='#' onclick=\"accion_sel('formilla','borrar_muchos');\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar seleccionados'></a>
             </td>
             <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
           </tr>";
 }
 $retorno.="
         </table>
         <input type='hidden' name='accion' id='accion'>
         <input type='hidden' name='estos' id='estos'>
         </form>
         ";

 return $retorno;
}  // tabla_sql1

function tabla_sql2($titulo,$datos,$parametros,$sql,$acciones,$url,$colors,$bgcolors,$nombre_tabla,$pie,$tope,$llave1,$llave2,$con,$var_get=""){
 $retorno = "";
 $permiso_iconos="nel";
 if($acciones!=''){
  $acciones=explode("|",$acciones);
  $permiso_iconos="simon";
 }

 $colors=explode("|",$colors);
 $bgcolors=explode("|",$bgcolors);

 $color1=$colors[0];
 $color2=$colors[1];
 if($titulo!="")
 $retorno = "
        <p align='center'>
              <font color='$color1' size='4' face='verdana,Arial, Helvetica, sans-serif'>
                <b>$titulo</b>
              </font>
        </p>";
 $retorno.= "
      <form name='formilla' id='formilla' method='post' action='$url'>
        <table $parametros>
 ";
   $radio_master="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><input type='checkbox' name='dato_master' id='dato_master' onclick='checa(this.form)'></td>";
   $espacio="<td width='15' background='".dominio()."imagenes/top_tabla$tope.gif'><br></td>";

   $iconos_master='';
   $y=0;
   $con_email="nel";
   if($permiso_iconos=='simon'){
     $y=count($acciones);
     for($x=0;$x<$y;$x++){
        if($acciones[$x]=="c")$iconos_master.=$radio_master;
        if($acciones[$x]=="e")$iconos_master.=$espacio;
        if($acciones[$x]=="m")$iconos_master.=$espacio;
        if($acciones[$x]=="b")$iconos_master.=$espacio;
     }

    $result=mysql_query($sql);
    $columnas=count($datos);

    $colspan=$columnas+$y;
    $retorno.="<tr valign='top'>
                <td width='5' background='".dominio()."imagenes/top_tabla_i$tope.gif'>&nbsp;</td>\n".$iconos_master;

    for($i=0;$i<$columnas;$i++){
       $retorno.="<td width='".$datos[$i]["ancho"]."' align='left' background='".dominio()."imagenes/top_tabla$tope.gif' align='center'>
                    <a href='$url?order_$nombre_tabla=".$datos[$i]["nombre"].$var_get."'><font face='arial' size='2' color='$color2'><b>".$datos[$i]["titulo"]."</b></font></a>
                  </td>";
    }
    $retorno.=" <td width='5' background='".dominio()."imagenes/top_tabla_d$tope.gif'>&nbsp;</td>
               </tr>\n";
  }

 $bgcolor1=$bgcolors[0];
 $bgcolor2=$bgcolors[1];
 $bg=1;

 $d=0;
 while ($row = mysql_fetch_array($result)) {

   if ($bg==1) {
     $bg=2;$bgcolor=$bgcolor1;
   } else {
     $bg=1;$bgcolor=$bgcolor2;
   }

   $d++;
   $id1=$row[$llave1];
   $id2=$row[$llave2];

   $checa="<td width='15' bgcolor='$bgcolor'><input type='checkbox' name='dato$d' id='dato$d' value='$id1'></td>";
   $borrar="<td width='15' bgcolor='$bgcolor'><a href='#' onclick=\"confirma('eliminar','este registro','$url?accion=borrar&login=$id1&cod_mun=$id2'); return false;\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar'></a></td>";
   $editar="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=editar&id=$id1'><img src='".dominio()."imagenes/editar.gif' border='0' alt='Editar'></a></td>";
   $mail="<td width='15' bgcolor='$bgcolor'><a href='$url?accion=mail&id=$id1'><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email'></a></td>";

   $iconos='';
   if ($permiso_iconos=='simon') {
     $y=count($acciones);
     for ($x=0;$x<$y;$x++) {
        if ($acciones[$x]=="c") $iconos.=$checa;
        if ($acciones[$x]=="e") $iconos.=$editar;
        if ($acciones[$x]=="m") {$iconos.=$mail;$con_email="simon";}
        if ($acciones[$x]=="b") $iconos.=$borrar;
     }
   }

   for ($x=0;$x<$columnas;$x++) {
     $campo[$x]=$row[$datos[$x]["nombre"]];
   }

   $retorno.="<tr>
                 <td width='5' bgcolor='$bgcolor'>&nbsp;</td>\n".$iconos;
   for ($j=0;$j<$columnas;$j++) {
      $tipo_dato = mysql_field_type($result,$j);
      $campazo=$campo[$j];
      $campazo=str_replace("
","<br>",$campazo);
      if ($tipo_dato=="date") $campazo=invierte_fecha($campazo);
      if ($tipo_dato=="real") $campazo="$".number_format($campazo,2,".",",");
      $retorno.="<td bgcolor='$bgcolor' align='".$datos[$j]["align"]."'><font face='arial' size='2' color='#000000'>".$campazo."</font></td>\n";
   }
   $retorno.="   <td width='5' bgcolor='$bgcolor'>&nbsp;</td>
              </tr>\n";
 }
 echo' <script language="javascript"> var contador= '.$d.'; </script>';

 if($pie=="con_pie"){
 $retorno.="
           <tr>
            <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
            <td width='15' bgcolor='#FFFFFF' align='right'><img src='".dominio()."imagenes/flecha.gif'></td>
             <td bgcolor='#FFFFFF' colspan='".($colspan-1)."'>
               <font face='verdana,arial' size='1' color='#000000'>
                 A los seleccionados :
               </font>
             ";
 if($con_email=="simon")
     $retorno.="<a href='#' onclick=\"accion_sel('formilla','mail_muchos');\"><img src='".dominio()."imagenes/mail.gif' border='0' alt='Enviar email a seleccionados'></a>";

 $retorno.="    <a href='#' onclick=\"accion_sel('formilla','borrar_muchos');\"><img src='".dominio()."imagenes/eliminar.gif' border='0' alt='Eliminar seleccionados'></a>
             </td>
             <td width='5' bgcolor='#FFFFFF'>&nbsp;</td>
           </tr>";
 }
 $retorno.="
         </table>
         <input type='hidden' name='accion' id='accion'>
         <input type='hidden' name='estos' id='estos'>
         </form>
         ";

 return $retorno;
}  // select tabla_sql2.

function tabla_menu($titulo,$campos,$anchos_celdas,$parametros,$sql,$url,$colors,$bgcolors,$con){
 $colors=explode("|",$colors);
 $bgcolors=explode("|",$bgcolors);

 $color1=$colors[0];
 $color2=$colors[1];
 $retorno = "
  <form name='formilla' method='post' action='$url'>

        <table $parametros>
 ";

    $campos=explode("|",$campos);
    $anchos_celdas=explode("|",$anchos_celdas);
    $columnas=count($campos);

    $titulo=explode("|",$titulo);

    $colspan=$columnas;
    $retorno.="<tr valign='top'>
                <td width='5' background='imagenes/top_tabla_i_azul.gif'>&nbsp;</td>
                <td width='14' background='imagenes/top_tabla_azul.gif'>&nbsp;</td>";

    for($j=0;$j<$columnas;$j++){
      $retorno.="
                <td align='left' background='imagenes/top_tabla_azul.gif' align='left' colspan='$colspan'>
                   <font face='arial' size='2' color='$color2'><b>".$titulo[$j]."</b></font>
                </td>";
    }

    $retorno.=" <td width='5' background='imagenes/top_tabla_d_azul.gif'>&nbsp;</td>
               </tr>\n";

 $bgcolor1=$bgcolors[0];
 $bgcolor2=$bgcolors[1];
 $bg=1;

 $result=mysql_query($sql);

 $d=0;
 while ($row = mysql_fetch_array($result)){

   if($bg==1){
     $bg=2;$bgcolor=$bgcolor1;
   }else{
     $bg=1;$bgcolor=$bgcolor2;
   }

   $d++;
   $log=$row["login"];
   $cod_mun=$row["cod_mun"];

   for($x=0;$x<$columnas;$x++){
     $campo[$x]=$row[$campos[$x]];
   }

   $retorno.="<tr>
                 <td width='5' bgcolor='$bgcolor'>&nbsp;</td>
                 <td width='14' bgcolor='$bgcolor'>
                   <a href='$url?log=$log&cod_mun=$cod_mun'>
                   <img src='imagenes/editar.gif' border='0'></a>
                 </td>\n";
   $ancho[0]["ancho"]="100";
   $ancho[0]["align"]="left";
   $ancho[1]["ancho"]="180";
   $ancho[1]["align"]="left";
   $ancho[2]["ancho"]="370";
   $ancho[2]["align"]="left";
   $ancho[3]["ancho"]="60";
   $ancho[3]["align"]="center";

   for($j=0;$j<$columnas;$j++){
        $retorno.="
                <td  align=".$ancho[$j]["align"]." width=".$ancho[$j]["ancho"]." bgcolor='$bgcolor' colspan='$colspan'>
                   <font face='arial' size='2' color='#000000'>$campo[$j]</font>
                </td>";
   }
   $retorno.="   <td width='5' bgcolor='$bgcolor'>&nbsp;</td>
              </tr>\n";
 }
 $retorno.="
         </table>
         <input type='hidden' name='accion' id='accion'>
         <input type='hidden' name='estos' id='estos'>
       </form>";
 return $retorno;
}

function me_das_permiso($seccion,$tipo="cadena_acceso") {
  $retorno="no";

  $permisos=obten($tipo);
  if($permisos=="")$permisos="|";

  $permisos=explode("-",$permisos);
  $j=count($permisos);

  for($i=0;$i<$j;$i++){
    if($seccion==$permisos[$i]){
      $retorno="si";
      break;
    }
  }
  return $retorno;
}

function tabla_permisos($url,$nombre_tabla,$lista_permisos,$tope){
  $retorno='
             <form action="'.$url.'" method="post">
              <table border="0" align="center" width="300" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0">
                <tr align="center">
                  <td width="5" background="imagenes/top_tabla_i'.$tope.'.gif">&nbsp;</td>
                  <td colspan="2" background="imagenes/top_tabla'.$tope.'.gif">
                    <font face="arial" size="2" color="#FFFFFF"><b>Marque la casilla</b></font>
                  </td>
                  <td width="5" background="imagenes/top_tabla_d'.$tope.'.gif">&nbsp;</td>
                </tr>
                <tr>
                  <td width="5"></td>
                  <td><font face="arial" size="2">Login</font></td>
                  <td align="right"><input name="user" type="checkbox" size="12" maxlength="12"></td>
                  <td width="5"></td>
                </tr>
              </table>
              <p align="center">
               <input type="submit" value="Enviar">
              </p>
             </form>
  ';
  return $retorno;
}

function texto($nombre,$valor,$parametros,$tamanio,$maximo){
  return "<input type='text' value='$valor' name='$nombre' id='$nombre' size='$tamanio' maxlength='$maximo' $parametros>";
}

function contrasenia($nombre,$valor,$parametros,$tamanio,$maximo){
  return "<input type='password' value='$valor' name='$nombre' id='$nombre' size='$tamanio' maxlength='$maximo' $parametros>";
}

function memo($nombre,$valor,$parametros,$filas,$columnas){
  return "<textarea name='$nombre' id='$nombre' cols='$columnas' rows='$filas' $parametros>$valor</textarea>";
}

function radio($nombre,$valor,$parametros,$checa) {
  $checked="";
  if($checa==$valor)$checked="checked";
  return "<input type='radio' value='$valor' name='$nombre' id='$nombre' $parametros $checked>";
}

function checkbox($nombre,$valor,$parametros,$checa){
  $checked="";
  if($checa==$valor)$checked="checked";
  return "<input type='checkbox' value='$valor' name='$nombre' id='$nombre' $parametros $checked>";
}

function fecha($nombre,$valor,$parametros,$tamanio,$maximo,$forma,$aux="") {
  if ($aux!="")  $aux="disabled";
  $retorno='
    <input type="text" value="'.$valor.'" id="'.$nombre.'" name="'.$nombre.'" size="8" maxlength="10" '.$parametros.'/>
    <button id="trigger_'.$nombre.'" '.$aux.'>...</button>
    <script type="text/javascript">//<![CDATA[
      Zapatec.Calendar.setup({
        firstDay          : 1,
        electric          : false,
        inputField        : "'.$nombre.'",
        button            : "trigger_'.$nombre.'",
        ifFormat          : "%d/%m/%Y",
        daFormat          : "%Y/%m/%d"
      });
    //]]></script>';
  return $retorno;
}  // Fin función fecha.

function fecha2($nombre,$valor,$parametros,$tamanio,$maximo,$forma) {
  $retorno = "<input type='text' value='$valor' name='$nombre' id='$nombre' size='$tamanio' maxlength='$maximo' $parametros>";
  if ($parametros!="disabled")
    $retorno.="<a href=\"javascript:show_calendar('$forma.$nombre');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\">";
  $retorno.="<img src='".dominio()."imagenes/calendario.gif' width='24' height='22' border='0'>";
  if ($parametros!="disabled")  $retorno.="</a>";
  return $retorno;
}  // Fin función fecha2.

function cambia_fecha_a_normal($fecha){
    ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
    $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
    return $lafecha;
}

function cambia_fecha_a_mysql($fecha){
    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
    return $lafecha;
}
function log1($mensaje,$con,$tipo,$ventana) {
  /*
    tipo de movimiento
    0) Insertar
    1)Modificar
    2) Borrar
    3)consultar
  */

  $login=$_SESSION['login'];
  $municipio=$_SESSION['municipio'];
  date_default_timezone_set('America/Mexico_City');
  $fecha=date('Y-m-d');
  $mes=date('m');
  $hora=date("H:i: s");
  $sql="INSERT INTO tlog".$mes." ( usuario , fecha , hora , mensaje , municipio,tipo_mov,ventana )
        VALUES (
          '$login', '$fecha', '$hora',  '$mensaje', '$municipio','$tipo','$ventana'
        );";
  mysql_query($sql,$con) or die ("Fallo en el log.");
//  mysql_close($conexion);
}  // Fin función log.

function dias_entre_fechas($fecha1,$fecha2){
//defino fecha 1 fecha inferior
//echo alerta($fecha1);
//echo alerta($fecha2);
$fecha_res=explode("/",$fecha1);
$dia1 =$fecha_res[0];
$mes1 =$fecha_res[1];
$ano1 =$fecha_res[2];



//defino fecha 2  fecha superior
$fecha_res2=explode("/",$fecha2);
// echo alerta(' d/f '.$fecha_res2);
$dia2 =$fecha_res2[0];
$mes2 =$fecha_res2[1];
$ano2 =$fecha_res2[2];

date_default_timezone_set('America/Mexico_City');
//calculo timestam de las dos fechas
$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
$timestamp2 = mktime(4,12,0,$mes2,$dia2,$ano2);

// ECHO $timestamp1,$timestamp2;
 
//resto a una fecha la otra
$segundos_diferencia = $timestamp1 - $timestamp2;
//echo $segundos_diferencia;

//convierto segundos en días
$dias_diferencia = $segundos_diferencia / (60 * 60 * 24);

//obtengo el valor absoulto de los días (quito el posible signo negativo)
$dias_diferencia = abs($dias_diferencia);

//quito los decimales a los días de diferencia
$dias_diferencia = floor($dias_diferencia);

return $dias_diferencia;


}


function dias_entre_fechas2($fecha1, $fecha2)
{
$dia1 = strtok($fecha1, "/");

$mes1 = strtok("/");
$anyo1 = strtok("/");

$dia2 = strtok($fecha2, "/");
$mes2 = strtok("/");
$anyo2 = strtok("/");

$num_dias = 0;
date_default_timezone_set('America/Mexico_City');
if ($anyo1 < $anyo2)
{
$dias_anyo1 = date("z", mktime(0,0,0,12,31,$anyo1)) - date("z", mktime(0,0,0,$mes1,$dia1,$anyo1));
$dias_anyo2 = date("z", mktime(0,0,0,$mes2,$dia2,$anyo2));
$num_dias = $dias_anyo1 + $dias_anyo2;
}
else
$num_dias = date("z", mktime(0,0,0,$mes2,$dia2,$anyo2)) - date("z", mktime(0,0,0,$mes1,$dia1,$anyo1));

return $num_dias;
}

function anios_meses_dias ($fecha1,$fecha2)
{
  $dias=dias_entre_fechas($fecha1,$fecha2);
  $anios=floor($dias/365);
  $meses=fmod($dias,365);
  $meses2=floor($meses/30);
//  $dias=fmod($dias,39);
  $dias=fmod($dias,30.416);

  $total=$anios.".".$meses2.".".$dias;

  return $total;
}

function anios_meses_dias_proalimne ($fecha1,$fecha2)
{
  $dias=dias_entre_fechas($fecha1,$fecha2);
  $anios=floor($dias/365);
  $meses=fmod($dias,365);
  $meses2=floor($meses/30);
  $dias=fmod($dias,30.416);

  $total=$anios.".".$meses2.".".$dias;

  return $total;
}






function funciones_javascript(){
  echo '
    <script language="javascript" type="text/javascript" charset="ISO-8859-1">

function isNumberKey_decimal(evt)
{
var charCode = (evt.which) ? evt.which : event.keyCode
if (charCode > 31 && ((charCode < 48 || charCode > 57) && charCode != 46))
return false;

return true;
}

function isNumberKey(evt)
{
var charCode = (evt.which) ? evt.which : event.keyCode
if (charCode > 31 && ((charCode < 48 || charCode > 57) ))
return false;

return true;
}
    function confirma(accion,este,url) {
      if(confirm(\'¿En verdad desea \'+accion+\' a  \'+este+\'?\'))
        window.location=url;
    }

    function checa(forma) {
      for(i=1;i<=contador;i++){
          este=document.getElementById(\'dato\'+i);
          este.checked=forma.dato_master.checked;
      }
    }

    function accion_sel(formula,operacion) {
     seleccionados=\'\';
      for(i=1;i<=contador;i++){
         este=document.getElementById(\'dato\'+i);
         if(este.checked){
            seleccionados=seleccionados+este.value+\'|\';
         }
      }
      document.getElementById(\'estos\').value=seleccionados;
      aux=document.getElementById(\'estos\').value;
      aux=document.getElementById(\'accion\').value=operacion;

      if(seleccionados!=\'\') {
        if(operacion=="borrar_muchos") {
          if(confirm(\'En verdad desea eliminar a los registros seleccionados \')){
            document.getElementById(formula).submit();
          }
        }else{
            document.getElementById(formula).submit();
        }
      }else{
         alert(\'Debe marcar al menos un registro para ejecutar la acción\');
      }
    }

function Entero(valor,entero) {
  if (entero!="1") {  // Si se tiene que validar un flotante.
      lon=valor.length;
      tecla=valor.substring(lon-1,lon);
      if (tecla!=\'.\') {
          valor = parseFloat(valor);
          if (valor=="0") {   // Si es cero.
            return "0";
          } else {            // Si no fue cero.
            //Compruebo si es un valor numérico
            if (isNaN(valor)) {
               //entonces (no es numero) devuelvo el valor cadena vacia
               return ""
            } else {
               //En caso contrario (Si era un número) devuelvo el valor
               return valor
            }  // Fin else.
          }   // Fin else (si no fue cero).
      }  // Fin if es punto.
      else {
        if (lon>1) {   // Si no es el punto sólo entra a la validación:
          aux=valor.substring(0,lon-1);  // cadena sin el ultimo punto.
          if ((aux.indexOf(\'.\'))>-1)   // Si ya tenía un punto la cadena.
            return aux;   // Se elimina el último punto.
          else            // sino
            return valor // Se regresa la cadena completa.
        } else {       // Si es el pnto sólo se regresa "".
          return "";
        }
      }  // Fin else.
  } else {
    valor = parseInt(valor);
    if (valor=="0") {  // Si el valor es cero.
      return "0";
    } else {           // Si no es cero.
      //Compruebo si es un valor numérico
      if (isNaN(valor)) {
        //entonces (no es numero) devuelvo el valor cadena vacia
        return ""
      }else{
        //En caso contrario (Si era un número) devuelvo el valor
        return valor
      }  // Fin else.
    }  // Fin else (si no fue cero).
  }  // Fin else (Si se tiene que validar un entero).
}  // Fin Entero.

function compruebaEntero(forma,dato,entero) {
   formita=forma.name;
   enteroValidado = Entero(eval(formita+\'.\'+dato).value,entero);
   if (enteroValidado == "") {
      //si era la cadena vacía es que no era válido. Lo aviso
      eval(formita+\'.\'+dato).value=\'\';
   } else {
      eval(formita+\'.\'+dato).value = enteroValidado;
   }  // Fin else.
}  // Fin compruebaValidoEntero.

 function ValidaNumeros(obj){
     obj.value = obj.value.toUpperCase().replace(/([^0-9.])/g,"");
     
     // para validar numeros y letras  ASender.value=ASender.value.toUpperCase().replace(/([^" "0-9A-Z])/g,"");
   }

 function ValidaNumeros2(obj){
   // decimal num=0;
    obj.value = obj.value.toUpperCase().replace(/([^0-9.])/g,"");
     redondo=Math.round(obj.value);
     num = obj.value % 5;
 //    alert(num);
    if ((num == 0.5) || (num == 1.5) || (num == 2.5)|| (num == 3.5)|| (num == 4.5)|| (num == 5.5)|| (num == 6.5)|| (num == 7.5)|| (num == 8.5)|| (num == 9.5)) {
     redondo=redondo-1;
     obj.value=redondo+"."+5;
    }
    else
        obj.value=Math.round(obj.value) ;

    if  (obj.value== 0) obj.value="";
     // para validar numeros y letras  ASender.value=ASender.value.toUpperCase().replace(/([^" "0-9A-Z])/g,"");
   }




 function ValidaEnteros(obj){
     obj.value = obj.value.toUpperCase().replace(/([^0-9])/g,"");
     // para validar numeros y letras  ASender.value=ASender.value.toUpperCase().replace(/([^" "0-9A-Z])/g,"");
   }

function envia_estado_nutricional(numero)
{
      sexo="";
      talla=$("#talla"+numero).val();
      peso=$("#peso"+numero).val();
      curp_dif=$("#curp_dif").val();
      sexo=curp_dif.charAt(10);
      if (sexo.toUpperCase() == "H")
       sexo = 0;
       else
      if (sexo.toUpperCase() == "M")
       sexo = 1;
      $("#destado_nut"+numero).load("muestra_estado_nut.php", {accion:1,talla:talla,peso:peso,sexo:sexo}, function()        {});
   
}
    
  ';
  
  //FUNCIONES JQUERY---------------------------------------------------------
  echo
  '
  $(function ()

  {
     envia_estado_nutricional(1);
     envia_estado_nutricional(2);
  }
  );


  $(document).ready(function()
  {

  $("#talla1").change(function()
    {
       envia_estado_nutricional(1);
   });
  $("#peso1").change(function()
    {
       envia_estado_nutricional(1);
   });

$("#talla2").change(function()
    {
      envia_estado_nutricional(2);
   });
  $("#peso2").change(function()
    {
      envia_estado_nutricional(2);
   });
  $("#curp_dif").change(function()
    {
      envia_estado_nutricional(1);
      envia_estado_nutricional(2);
   });




});



</script>
';

}

function permisos($tope,$url,$lista_permisos,$sql,$con) {
  $result = mysql_query($sql, $con) or die(mysql_error());
  if($row=mysql_fetch_array($result)){
    $log=strtoupper($row["login"]);
    $cod_mun=$row["cod_mun"];
    $municipio=mysql_este("select municipio from tcat_municipios where cod_mun = $cod_mun","municipio",$con);
    $sus_permisos=$row["cadena_acceso"];
  }

  $retorno='
     <form action="'.$url.'" method="post">
      <table border="0" align="center" width="350" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0">
        <tr align="center">
          <td width="5" background="imagenes/top_tabla_i'.$tope.'.gif">&nbsp;</td>
          <td colspan="2" background="imagenes/top_tabla'.$tope.'.gif">
            <font face="arial" size="1" color="#FFFFFF"><b>PERMISOS DE '.$log.'-'.$municipio.'</b></font>
          </td>
          <td width="5" background="imagenes/top_tabla_d'.$tope.'.gif">&nbsp;</td>
        </tr>';

  $cad=explode("|",$lista_permisos);
  $j=count($cad);
  $color1="#DDEEFF";
  $color2="#F6F8FF";
  $color=$color1;
  for($i=0;$i<$j;$i++) {
    if($color==$color2) {
      $color=$color1;
    } else {
      $color=$color2;
    }
    $marcado="";
    $permicillo=explode("=",$cad[$i]);
    if (busca($sus_permisos,$permicillo[1])=="simon") $marcado="checked";
    $retorno.='
        <tr bgcolor="'.$color.'">
          <td width="5"></td>
          <td><font face="arial" size="2">'.$permicillo[0].'</font></td>
          <td align="right"><input name="permiso_'.$i.'" value="'.$permicillo[1].'" type="checkbox" '.$marcado.'></td>

              </p>
          <td width="5"></td>
        </tr>';
  }

  $retorno.='
        <tr bgcolor="#88ccff"">
          <td colspan="4" align="center">
            <br>
            <input type="hidden" name="cantidad_permisos" value="'.$j.'">
            <input type="hidden" name="log" value="'.$log.'">
            <input type="hidden" name="cod_mun" value="'.$cod_mun.'">
            <input type="submit" value="Guardar permisos">
          </td>
        </tr>
      </table>
     </form>
  ';
  return $retorno;
}

function busca($cadena,$este){
  $cad=explode("-",$cadena);
  $j=count($cad);
  $retorno="nel";
  for($i=0;$i<$j;$i++){
    if($este==$cad[$i])$retorno="simon";
  }
  return $retorno;
}

function fechas() {
  echo "
  <script languaje='javascript'>
    function fechas(fecha) {
      if (fecha) {
        borrar = fecha;
        if ((fecha.substr(2,1) == '/') && (fecha.substr(5,1) == '/')) {
          for (i=0; i<10; i++) {	
            if (((fecha.substr(i,1)<'0') || (fecha.substr(i,1)>'9')) && (i != 2) && (i != 5)) {
              borrar = '';
              break;
      			}
          }
	        if (borrar) {
  	        a = fecha.substr(6,4);
	     	    m = fecha.substr(3,2);
    		    d = fecha.substr(0,2);
    		    if((a < 1900) || (a > 2050) || (m < 1) || (m > 12) || (d < 1) || (d > 31))
		          borrar = '';
    		    else {
    		      if((a%4 != 0) && (m == 2) && (d > 28))	
		            borrar = ''; // Año no viciesto y es febrero y el dia es mayor a 28
     			    else {
		            if ((((m == 4) || (m == 6) || (m == 9) || (m==11)) && (d>30)) || ((m==2) && (d>29)))
			            borrar = '';	      				  	
			
	            }  // else
		        } // Fin else.
          } // if (borrar).
        } // if ((caja.substr(2,1) == \"/\") && (caja.substr(5,1) == \"/\"))			    			
	      else
	        borrar = '';
	      if (borrar == '')
	        return(false)
     	  else
      	  return(true)
      } // if (fecha).
    } // Fin función fechas.

function compararfecha3(fecha1,fecha2)
{

String1 = fecha1;
String2 = fecha2;
// alert(String1,String2);
// Si los dias y los meses llegan con un valor menor que 10
// Se concatena un 0 a cada valor dentro del string
if (String1.substring(1,2)=='/') {
String1='0'+String1
}
if (String1.substring(4,5)=='/'){
String1=String1.substring(0,3)+'0'+String1.substring(3,9)
}

if (String2.substring(1,2)=='/') {
String2='0'+String2
}
if (String2.substring(4,5)=='/'){
String2=String2.substring(0,3)+'0'+String2.substring(3,9)
}

dia1=String1.substring(0,2);
mes1=String1.substring(3,5);
anyo1=String1.substring(6,10);
dia2=String2.substring(0,2);
mes2=String2.substring(3,5);
anyo2=String2.substring(6,10);


if (dia1 == '08') // parseInt('08') == 10 base octogonal
dia1 = '8';
if (dia1 == '09') // parseInt('09') == 11 base octogonal
dia1 = '9';
if (mes1 == '08') // parseInt('08') == 10 base octogonal
mes1 = '8';
if (mes1 == '09') // parseInt('09') == 11 base octogonal
mes1 = '9';
if (dia2 == '08') // parseInt('08') == 10 base octogonal
dia2 = '8';
if (dia2 == '09') // parseInt('09') == 11 base octogonal
dia2 = '9';
if (mes2 == '08') // parseInt('08') == 10 base octogonal
mes2 = '8';
if (mes2 == '09') // parseInt('09') == 11 base octogonal
mes2 = '9';

dia1=parseInt(dia1);
dia2=parseInt(dia2);
mes1=parseInt(mes1);
mes2=parseInt(mes2);
anyo1=parseInt(anyo1);
anyo2=parseInt(anyo2);

if (anyo1>anyo2)
{
return false;
}

if ((anyo1==anyo2) && (mes1>mes2))
{
return false;
}
if ((anyo1==anyo2) && (mes1==mes2) && (dia1>dia2))
{
return false;
}

return true;

}


function cambiames(mes){
if (mes == 0) {return '01';}
if (mes == 1) {return '02';}
if (mes == 2) {return '03';}
if (mes == 3) {return '04';}
if (mes == 4) {return '05';}
if (mes == 5) {return '06';}
if (mes == 6) {return '07';}
if (mes == 7) {return '08';}
if (mes == 8) {return '09';}
if (mes == 9) {return '10';}
if (mes == 10) {return '11';}
if (mes == 11) {return '12';}
}



  </script>
  ";
}  // Fin función fechas.

function integridad_referencial($codigo,$campo,$tabla_relacionada,$con) {
  $sql="select $campo from $tabla_relacionada where $campo = '$codigo' ; ";
//echo $sql;
  $result=mysql_query($sql,$con);
  if ($row=mysql_fetch_array($result))
    return true;
  else
    return false;
}  // Fin función integridad referencial.

function obten_edad($dob) {
  // El formato es yy/mm/dd
  list($y,$m,$d)=explode("-",$dob);
  date_default_timezone_set('America/Mexico_City');
//  echo "Año: ".$y.", mes:".$m.", día: ".$d."<br>";
  $hoy=mktime(0,0,0,date("d"),date("m"),date("Y"));
  $cumple=mktime(0,0,0,"$d","$m","$y");
  $age=intval(($hoy-$cumple)/31536000)+1;  // (60*60*24*365)
//  echo "Hoy: ".$hoy.", cumple: ".$cumple.", Age: ".$age."<br>";
  return $age;
}  // Fin función Edad.

// obtiene la edad y meses para el padron de despensas
function obten_edadb($dob) {
  // El formato es yyyy-mm-dd
  list($anonaz,$mesnaz,$dianaz)=explode("-",$dob);
  date_default_timezone_set('America/Mexico_City');
/*  $hoy=mktime(0,0,0,date("d"),date("m"),date("Y"));
  $cumple=mktime(0,0,0,"$dianaz","$mesnaz","$anonaz");
  $edad=intval(($hoy-$cumple)/31536000)+1;  // (60*60*24*365)
  return $edad;  */

  $dia=date("j");
  $mes=date("n");
  $ano=date("Y");

  // Si el mes es el mismo pero el dia inferior aun no ha cumplido años, le quitaremos un año al actual:
  if (($mesnaz == $mes) && ($dianaz > $dia))  $ano=($ano-1);
  // Si el mes es superior al actual tampoco habra cumplido años, por eso le quitamos un año al actual:
  if ($mesnaz > $mes)  $ano=($ano-1);
  // Ya no habria mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad:
  $edad=($ano-$anonaz);


//  if ($edad==0) {
    if ($mes==($mesnaz) and $dia>=$dianaz and $ano==$anonaz) $edad=($dia-$dianaz)." días";

    if ($mes==($mesnaz+1) and $dia<$dianaz)  $edad=$edad.",".((30-$dianaz)+$dia)." días";

    if ($dianaz > $dia) $mesnaz=$mesnaz+1;

    if ($mes<$mesnaz) {
      $meses=(12-($mesnaz-$mes));
      if ($meses!=12)  $edad=$edad.",".$meses;
    }
    if ($mes>$mesnaz) {
      $meses=(12-(12-($mes-$mesnaz)));
      if ($meses!=12)  $edad=$edad.",".$meses;
    }

//  }  // Fin if.
//  if ($edad==-1)  $edad=$dia-$dianaz." días";
  if (($edad==1) and ($mes==$mesnaz) and ($dia<$dianaz))  $edad="11 meses";


  return $edad;
}  // Fin función Edad.

// obtiene la edad y meses para el padron de despensas
function obten_edadanio($dob) {
  // El formato es yyyy-mm-dd
  date_default_timezone_set('America/Mexico_City');
  list($anonaz,$mesnaz,$dianaz)=explode("-",$dob);
  $dia=date("j");
  $mes=date("n");
  $ano=date("Y");
  // Si el mes es el mismo pero el dia inferior aun no ha cumplido años, le quitaremos un año al actual:
  if (($mesnaz == $mes) && ($dianaz > $dia))  $ano=($ano-1);
  // Si el mes es superior al actual tampoco habra cumplido años, por eso le quitamos un año al actual:
  if ($mesnaz > $mes)  $ano=($ano-1);
  // Ya no habria mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad:
  $edad=($ano-$anonaz);

  return $edad;
}  // Fin función Edad.




?>
