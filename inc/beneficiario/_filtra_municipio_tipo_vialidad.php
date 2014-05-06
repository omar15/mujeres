<?php
session_start();//Habilitamos uso de variables de sesión
//Obtenemos conexión
    
    
    include ($_SESSION['inc_path'] . "conecta.php");
    
    //Obtenemos los municipios
    $CVE_EST_MUN_LOC = $_POST["CVE_EST_MUN_LOC"];    
    $sql = '
        SELECT
        c.CVE_TIPO_VIAL,
        c.DESCRIPCION
        FROM `vialidad` v
        LEFT JOIN cat_vialidad c on v.CVE_TIPO_VIAL = c.CVE_TIPO_VIAL
        where v.CVE_EST_MUN_LOC = ? GROUP BY v.CVE_TIPO_VIAL';
    
    $params = array($CVE_EST_MUN_LOC);
    
    $municipios_tipo_vial = $db->rawQuery($sql,$params);


?>
<select id="CVE_TIPO_VIAL" name="CVE_TIPO_VIAL">
    <option value=''>Seleccione Tipo de Vialidad</option>
       <?php foreach($municipios_tipo_vial as $mtp):?>                 
           <option value='<?php echo $mtp['CVE_TIPO_VIAL'] ?>' > 
       <?php echo $mtp['DESCRIPCION'];?>
           </option>                
       <?php endforeach; ?>
</select>

