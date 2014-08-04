<?php
session_start();//Habilitamos uso de variables de sesión
//Incluimos cabecera
include('../../inc/header.php');
//Incluimos modelos a usar
include_once($_SESSION['model_path'].'log_mujeres_avanzando.php');

//Si requerimos obtener totales por fecha
$fecha_creacion = ($_GET['fecha_creacion'] != NULL)? $_GET['fecha_creacion']: NULL;

//Obtenemos totales por caravana
$totalesCar = logMujeresAvanzando::reporte($fecha_creacion);

?>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?>combobox.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?><?php echo $_SESSION['module_name']?>/valida.js"></script>
<script lang="javascript" type="text/javascript" src="<?php echo $_SESSION['js_path'];?>jquery.tablesorter.min.js"></script>
<script type="text/javascript">
$(function() {
    $("table").tablesorter({widgets: ['zebra']});
});
</script>

<div id="principal">

   <div id="contenido">
    <h2 class="centro">Reporte Mujeres Avanzando</h2>

    
    <div class="centro">       
       

    <div>   

    <table id="totales_caravana" class="tablesorter">
    <thead>
        <th>Caravana</th>
        <th>Fecha</th>
        <th>Segura</th>
        <th>Leve</th>
        <th>Moderada</th>
        <th>Severa</th>
        <th>Total</th>        
    </thead>

    <tbody>
    <?php foreach ($totalesCar as $c):?>
        <tr>
            <td><?php echo $c['caravana']; ?></td>
            <td><?php echo $c['fecha_instalacion']; ?></td>
            <td><?php echo $c['segura'];?></td>
            <td><?php echo $c['leve'];?></td>
            <td><?php echo $c['moderada'];?></td>
            <td><?php echo $c['severa'];?></td>
            <td><?php echo $c['total'];?></td>            
        </tr>
    <?php endforeach;?>        
    </tbody>
    </table>    

    <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
        <table>
        <tr>
            <th>Fecha Creaci&oacute;n</th>
            <td>
                <input type="text" id="fecha_creacion" class="fecha" name="fecha_creacion"/>
            </td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" value ="Filtrar"/></td>
        </tr>
        </table>
    </form> 
 </div>
 </div>

</div>
 
<?php 
//Incluimos pie
include($_SESSION['inc_path'].'/footer.php');
?>