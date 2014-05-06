<?php
session_start();//Habilitamos uso de variables de sesión

if(isset($_POST['id_componente'])){

    //Obtenemos conexión
    include ($_SESSION['inc_path'] . "conecta.php");
    
    //Incluimos modelo de producto_servicio
    include_once($_SESSION['model_path'].'producto_servicio.php');

    /*Obtenemos los productos y servicios disponibles para el beneficiario,
    (Teniendo en cuenta que no pueden registrarse productos y servicios duplicados)*/
    $id_beneficiario = $_POST["id_beneficiario"];    
    $id_componente = $_POST["id_componente"];
    $pys = Producto_servicio::listaPys($id_beneficiario,$id_componente);
    
}else{
    exit;
}
?>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?>/combobox.js"></script>
<select id="id_producto_servicio" class="combobox" name="id_producto_servicio">
    <option value=''>Seleccione Producto/Servicio</option>
        <?php foreach($pys as $p):?>
            <option value='<?php echo $p['id'] ?>'> 
                <?php echo $p['codigo_producto'].' - '.$p['nombre'];?>
            </option>
        <?php endforeach; ?>
</select>        