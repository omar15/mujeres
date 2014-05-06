<?php
session_start();//Habilitamos uso de variables de sesión

if(isset($_POST['cod_programa_g'])){

    //Obtenemos conexión
    include ($_SESSION['inc_path'] . "conecta.php");

    //Incluimos modelo de trelacion_pys
    include_once($_SESSION['model_path'].'trelacion_pys.php');

    //Obtenemos los productos y servicios      
    $cod_programa_g = $_POST["cod_programa_g"];    
    $pys = trelacion_pys::filtraServiciosDisp($cod_programa_g);

}else{
    exit;
}

?>

<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?><?php echo $_SESSION['module_name']?>/combobox.js"></script>
<select id="cod_rpys" class="combobox" name="cod_rpys">
    <option value=''>Seleccione Producto/Servicio</option>
    <?php foreach($pys as $py):?>                
        <option value='<?php echo $py['id'] ?>' <?php echo $selected;?> > <?php echo $py['servicio'];?></option>
    <?php endforeach; ?>
</select>        