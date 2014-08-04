<?php

//Obtenemos datos enviados
$nombres=$_POST['nombres'];
$paterno=$_POST['paterno'];
$materno=$_POST['materno'];
$tipo_salida=$_POST['tipo_salida'];

$arreglo = NULL;

/*
try {
    $client = new SoapClient("https://apps.padronunico.jalisco.gob.mx:8080/WsTisa/WSConsultaPU.svc?wsdl");
   
    //$fcs = $client->__getFunctions();
    $fcs = $client->BuscaBeneficiario(array('user' => 'DIFweb','pw' => '53hn5uch7','apaterno'  => $paterno ,'nombre'  => $nombres ,'amaterno'  =>  $materno));
    

    $salida='<table><tr><td>ID(FPU)</td><td>CURP</td><td>NOMBRE</td><td>APELLIDO PATERNO</td><td>APELLIDO MATERNO</td><td>SEXO</td><td>CALLE</td>
        <td>NUM EXT</td><td>MUNICIPIO</td><td>C.P.</td></tr>';
    foreach($fcs as $key => $value):
            foreach($value as $k => $v):
                if(is_object($v)){
                    foreach($v as $llave => $valor):
                        
                      $salida.='<tr><td>'.$valor->Fpu.'</td><td>'.$valor->Curp.'</td><td>'.$valor->Nombre.'</td><td>'.$valor->Apaterno.'</td><td>'.$valor->Amaterno.'</td>
                      <td>'.$valor->Sexo.'</td><td>'.$valor->Calle.'</td><td>'.$valor->NumExt.'</td><td>'.$valor->NomLocalidad.'</td><td>'.$valor->Cp.'</td>

</tr>';




                        
                    endforeach;
                }

            endforeach;
        endforeach;

    echo ($salida); //Verificar si hay resultado
} catch (Exception $e) {
    trigger_error($e->getMessage(), E_USER_WARNING);
}
*/
?>

<?php
/*
$client = new SoapClient("https://apps.padronunico.jalisco.gob.mx:8080/WsTisa/WSConsultaPU.svc?wsdl");
   
   // $fcs = $client->__getFunctions();
    $fcs = $client->BuscaBeneficiario(array('user' => 'DIFweb','pw' => '53hn5uch7','apaterno'  => $paterno ,'nombre'  => $nombres ,'amaterno'  =>  $materno));
    //PRINT_R($fcs);
    ?>
<?php if($fcs !=null) {  ?>

<fieldset>
<legend>
   <label>Posibles Duplicados</label>  
 </legend>
<div class="lista_coincidencia">
<li class="elemCoincidencia">

<?php  foreach($fcs as $key => $value): ?>
<?php  foreach($value as $k => $v): ?>
<?php  if(is_object($v)){ ?>
                 <?php    foreach($v as $llave => $valor): ?>
                    <a><?php echo $valor->Nombre.' '.$valor->Apaterno.' '.$valor->Amaterno;?></a> 
                    <div>
                    <?php echo $valor->Fpu.'<br/>';?>
                    <?php echo $valor->Curp.'<br/>';?> 
                    <?php echo $valor->Sexo.'<br/>';?>  
                    <?php echo $valor->Calle.' '.$valor->NumExt.' '.$valor->NomLocalidad.' '.$valor->Cp;?>
                    </div>
           <?php endforeach; 
             }
           ?>
       

           <?php endforeach; ?>
           <?php endforeach;?>
       
</li>
 </div>
 </fieldset>
<?php }else{ ?>
    
    <div>
 <?php   echo  '<label class="mensaje">No se encontraron Resultados de la Busqueda</label>' ?>
    </div>
   
    
<?php } */?>
 
<?php
try {
 $client = new SoapClient("https://apps.padronunico.jalisco.gob.mx:8080/WsTisa/WSConsultaPU.svc?wsdl"); 

 $fcs = $client->BuscaBeneficiario(array('user' => 'DIFweb','pw' => '53hn5uch7','apaterno'  => $paterno ,'nombre'  => $nombres ,'amaterno'  =>  $materno));

 $arreglo = is_array( $fcs->BuscaBeneficiarioResult->beneficiarios->Beneficiario2 )
    ? $fcs->BuscaBeneficiarioResult->beneficiarios->Beneficiario2 
    : array( $fcs->BuscaBeneficiarioResult->beneficiarios->Beneficiario2  );
    
} catch (Exception $e) {

  echo '<div class="mensaje error_msg">Hubo un evento al tratar de consultar el servicio web: '.$e->getMessage().'</div>';
}
?>
 

<?php if(count($arreglo) > 1) {?> 
<fieldset>
<legend>
   <label>Posibles Duplicados</label>  
 </legend>
<div class="lista_coincidencia">
<ul>
    <li class="elemCoincidencia">

    <?php  foreach ($arreglo as $valor):?>

    <a><?php echo $valor->Nombre.' '.$valor->Apaterno.' '.$valor->Amaterno; ?></a>

    <div>
      <?php echo $valor->Fpu.'<br/>';?>
      <?php echo $valor->Curp.'<br/>';?>
      <?php echo ($valor->Sexo == 1)?'HOMBRE':'MUJER'.'<br/>';?>
      <?php echo $valor->Calle.' '.$valor->NumExt.' '.$valor->NomLocalidad.' '.$valor->Cp;?>
    </div>

    <?php endforeach; ?>

    </li>
</ul>
</div>
</fieldset>
<?php } ?>