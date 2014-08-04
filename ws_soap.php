<?php

//$nombres=$_POST['nombres'];
//$paterno=$_POST['paterno'];
//$materno=$_POST['materno'];
$nombres='EUN';
$paterno='LAL';
$materno='GON';
$tipo_salida=$_POST['tipo_salida'];

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

?>





 
 
 
 
 
 
 
 
 