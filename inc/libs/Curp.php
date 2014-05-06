<?php
class Curp extends MysqliDb{
    
public static function generar_CURP($appat,$apmat,$nombre,$fecha_nac,$sexo,$estado,$omitirDigitos = false)
{
  $appat=self::apellido_bien($appat);
  $_12=self::primeros_dos($appat);
  if ($apmat=="") {
    $consonante_apmat="X";
    $_3="X";
  } else {
    $apmat=self::apellido_bien($apmat);
    $_3=substr($apmat,0,1);
    $consonante_apmat=self::primer_consonante($apmat);
  }
  $nombre=self::nombre_bien($nombre);
  $_4=substr($nombre,0,1);
  $desbaratada=explode("/",$fecha_nac);
  $dia=$desbaratada[0];
  $mes=$desbaratada[1];
  $anio=substr($desbaratada[2],-2);  // Toma los dos últimos dígitos del año.
  if ($sexo=='HOMBRE') $sexo='H';
  if ($sexo=='MUJER') $sexo='M';
  $estado=self::generar_estado_sin_CURP($estado);
  $consonante_appat=self::primer_consonante($appat);
  $consonante_nombre=self::primer_consonante($nombre);
  $primeras_cuatro=self::valida_altisonantes($_12.$_3.$_4);

  $CURP=$primeras_cuatro.$anio.$mes.$dia.$sexo.$estado.$consonante_appat.
        $consonante_apmat.$consonante_nombre;

  //Si queremos omitir los 2 dígitos finales del curp
  if($omitirDigitos === false){
    $_2digitos=self::generar_digitos($con);  
    $CURP .= $_2digitos;
  }  
  
  $CURP=self::quita_acentos($CURP);

  return $CURP;
}  // Fin generar_CURP.        


private static function apellido_bien($apellido) {
  $apellido_sin_prep="";
  // Aquí se le quitan las preposiciones:
  $palabras=explode(" ",$apellido);
  $j=count($palabras);
  for ($i=0;$i<$j;$i++) {
    if (!self::es_preposicion($palabras[$i]))
      $apellido_sin_prep.=$palabras[$i].' ';
  }  // Fin for.
  
  // Para quitarle el último espacio:
  $lon=strlen($apellido_sin_prep);
  $apellido_sin_prep=substr($apellido_sin_prep,0,$lon-1);
  $apellido_sin_prep=self::quita_caracteres_raros($apellido_sin_prep);
  return $apellido_sin_prep;
}  // Fin funci

private static function valida_altisonantes($palabra) {
  $sql='select palabra_correcta from altisonantes where palabra_mala LIKE ?';
  $params = array($palabra); 
  $result= self::getInstance()->rawQuery($sql,$params);
  
  if ($result != null) {
    return $result["palabra_correcta"];
  }
  else {
    
    return $palabra;
  }
}  // Fin función valida_altisonantes.

private static function es_preposicion($prep) {
  if ($prep=="DA"  or $prep=="DAS" or $prep=="DEL" or $prep=="DER" or $prep=="DI"  or
      $prep=="DIE" or $prep=="DD"  or $prep=="EL"  or $prep=="LA"  or $prep=="LOS" or
      $prep=="LAS" or $prep=="LE"  or $prep=="LES" or $prep=="MAC" or $prep=="VAN" or
      $prep=="VON" or $prep=="I"   or $prep=="DE"  or $prep=="MC")  return true;
  else return false;
}  // Fin función es_proposicion.

private static function nombre_bien($nombre) {
  $nombre_sin_prep="";  $nombre_definitivo="";
  if ($nombre=="MARÍA" or $nombre=="MARIA" or $nombre=="JOSÉ" or $nombre=="JOSE")
    $nombre_bien="X";
  else {
    
    //echo 'entre';
    // Aquí se le quitan las preposiciones:
    $palabras=explode(" ",$nombre);
    $j=count($palabras);
    for ($i=0;$i<$j;$i++) {
      if (!self::es_preposicion($palabras[$i]))
        $nombre_sin_prep.=$palabras[$i].' ';
    }  // Fin for.

    // Aquí se limpian los María y José.
    $palabras=explode(" ",$nombre_sin_prep);
    $j=count($palabras);
    if ( ($palabras[0]=="MARÍA" or $palabras[0]=="MARIA" or $palabras[0]=="JOSÉ" or $palabras[0]=="JOSE") and ($palabras[1]!="") ) {
      for ($i=1;$i<$j;$i++)
        $nombre_definitivo.=$palabras[$i].' ';
    }
    else  $nombre_definitivo=$nombre_sin_prep;



    // Para quitarle el último espacio:
    $lon=strlen($nombre_definitivo);
    $nombre_definitivo=substr($nombre_definitivo,0,$lon-1);
    //echo $nombre_definitivo;
    $nombre_definitivo=self::quita_caracteres_raros($nombre_definitivo);
    
    
    
    return $nombre_definitivo;
  }  // Fin else.
}  // Fin función nombre_bien.

private static function es_letra($letra) {
  if ($letra=='A' or $letra=='Á' or $letra=='B' or $letra=='C' or $letra=='D' or $letra=='E' or
      $letra=='É' or $letra=='F' or $letra=='G' or $letra=='H' or $letra=='I' or $letra=='Í' or
      $letra=='J' or $letra=='K' or $letra=='L' or $letra=='M' or $letra=='N' or $letra=='Ñ' or
      $letra=='O' or $letra=='Ó' or $letra=='P' or $letra=='Q' or $letra=='R' or $letra=='S' or
      $letra=='T' or $letra=='U' or $letra=='Ú' or $letra=='V' or $letra=='W' or $letra=='X' or
      $letra=='Y' or $letra=='Z')
    return true;
  else return false;
}  // Fin función es_letra.

// Reemplaza caracteres raros y los reemplaza por espacio.
private static function quita_caracteres_raros($cosa) {
  //echo "cosa =".$cosa."<br>";
  
  $cosa_limpia="";
  $lon=strlen($cosa);
  for ($i=0;$i<$lon;$i++) {
    $aux=($cosa[$i]);
    //echo "<br>aux=".$aux." ".$i." ";
    $letra=self::es_letra($aux);
    //echo "letra=".$letra;
    if (!$letra) $aux=' ';
    $cosa_limpia.=$aux;
  //
    
  }
  //echo "<br>".$cosa_limpia;
  //exit;// Fin for.
  return $cosa_limpia;
}  // fin función quita_caracteres_raros.

private static function quita_acentos($CURP) {
  $CURP_bien="";
  $lon=strlen($CURP);
  for ($i=0;$i<$lon;$i++) {
    $aux=$CURP[$i];
    if ($aux=='Á') $aux="A";
    if ($aux=='È') $aux="E";
    if ($aux=='Ì') $aux="I";
    if ($aux=='Ò') $aux="O";
    if ($aux=='Ù') $aux="U";
    $CURP_bien.=$aux;
  }  // Fin for.
  return $CURP_bien;
}  // Fin función quita_acentos.
private static function generar_estado_sin_CURP($estado) {
  $sql='select Curp from cat_estado where CVE_ENT = ?';
  $params=array($estado);
  $result= self::getInstance()->rawQuery($sql,$params);
  
  if ($result!=null) {
    
    $result=$result[0];
    
    return $result["Curp"];
  }
  
  else return 0;
}  // Fin función generar_estado_sin_CURP.



private static function primer_consonante($ap_nom) {
  
  // Se toma la primer palabra del ap_nom (apellido o nombre)
  $arreglo=explode(" ",$ap_nom);
  $ap_nom=$arreglo[0];

  /*Determinamos qué posición se regresará; si la primer letra
  es consonante, se regresará la 2da consonante y 
  si la primera es vocal, se regresará la primer consonante
  */
  $num_cons = (self::es_consonante($ap_nom[0]) === true)? 2 : 1;

  //Contador de consonante
  $cont_cons = 0;

  //Recorremos toda la palabra hasta encontrar alguna coincidencia
  for($i = 0; $i <= strlen($ap_nom); $i++){ 

    //Primer letra la convertimos a mayúscula
    $letra=strtoupper($ap_nom[$i]);

    //Validamos si es consonante
    $consonante = self::es_consonante($letra);
    
    //Si es consonante, aumenta contador
    if($consonante === true){
        $cont_cons++;
    }
        
    //Comprobamos que coincida con la posición indicada
    if ($cont_cons === $num_cons){      

      /*Si la letra en cuestión es Ñ, regresamos X, 
      caso contrario regresamos la letra*/
      $cons = ($letra =="Ñ")? 'X' : $letra;

      return $cons;
      
      }
        
  } 

  // Retorna la letra si no se entró en ningún
  return $letra;  
}

private static function generar_digitos() {
  $consecutivo='00';
  //$sql='select CURP from tconsecutivos limit 1';
  $result= self::getInstance()->get_first('tconsecutivos');
  
  if ($result!=null) {
    if ($result["CURP"]=='99') $consecutivo='00';
    else  $consecutivo=$result["CURP"]+1;            // Se lee el último consecutivo y se le suma 1.
    $consecutivo=self::rellena_consecutivo($consecutivo);
  }
  
  $insertData =array('CURP'=>$consecutivo);
  self::getInstance()->where('id',1) 
                     ->update('tconsecutivos',$insertData); // Se actualiza el consecutivo.
  
  return $consecutivo;
}  // fin función generar_digitos.

private static function rellena_consecutivo($consec) {
  $lon=strlen($consec);
  switch ($lon) {
    case 1 : return '0'.$consec;
    case 2 : return $consec;
  }
}  // Fin rellena_consecutivo.


private static function primeros_dos($appat) {
  // Se toma la primer palabra del apellido:
  $arreglo=explode(" ",$appat);
  $appat=$arreglo[0];
  
  $c1=substr($appat,0,1);    // Se toma la primera letra del apellido paterno.
  if ($c1=="Ñ") $c1="X";
  $c2="X";
  $lon=strlen($appat);
  for ($i=1;$i<$lon;$i++) {  // Empieza el for desde 1 y no desde cero para no tomar en cuenta la primer vocal.
    $aux=strtoupper($appat[$i]);
    if ($aux=='A' or $aux=='Á' or $aux=='À') {
      $aux="A";
      $i=$lon;  // Para interrumpir el ciclo for.
    }
    if ($aux=='E' or $aux=='É' or $aux=='È') {
      $aux="E";
      $i=$lon;  // Para interrumpir el ciclo for.
    }
    if ($aux=='I' or $aux=='Í' or $aux=='Ì') {
      $aux="I";
      $i=$lon;  // Para interrumpir el ciclo for.
    }
    if ($aux=='O' or $aux=='Ó' or $aux=='Ò') {
      $aux="O";
      $i=$lon;  // Para interrumpir el ciclo for.
    }
    if ($aux=='U' or $aux=='Ú' or $aux=='Ù') {
      $aux="U";
      $i=$lon;  // Para interrumpir el ciclo for.
    }
    $c2=$aux;
  }  // Fin for.
//  if ($c2=="") $c2="X";
//echo "c1=".$c1."c2".$c2;
//exit;
  return $c1.$c2;
}  // Fin función primeros_dos.

private static function es_consonante($letra) {
  if ($letra=='B' or $letra=='C' or $letra=='D' or $letra=='F' or $letra=='G' or $letra=='H' or
      $letra=='J' or $letra=='K' or $letra=='L' or $letra=='M' or $letra=='N' or $letra=='P' or
      $letra=='Q' or $letra=='R' or $letra=='S' or $letra=='T' or $letra=='V' or $letra=='W' or
      $letra=='X' or $letra=='Y' or $letra=='Z' or $letra=='Ñ')
    return true;
  else return false;
}  // Fin función es_consonante.

}
?>
