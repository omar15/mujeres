<?php
session_start();  

/* Al utilizar ajax y refrescar este formulario
necesitaremos obtener tanto el objeto $db (instancia de conexión)
como el id del beneficiario. Verificamos que, si no están creadas
las variables, las obtendremos*/
if(!isset($db)){

  //Incluimos librería de permiso
  include ($_SESSION['inc_path'] . "conecta.php");

}

//Eliminamos variable de sesión de carrito
//unset($_SESSION['arrayArt']);

//Incluimos librerías
include_once($_SESSION['inc_path'].'libs/Permiso.php');
include_once($_SESSION['inc_path'].'libs/Fechas.php');

//Cargamos modelo de beneficiario_pys
include_once($_SESSION['model_path'].'beneficiario_pys.php');

//Obtenemos id del beneficiario, en caso de no tenerlo previamente
if($id_beneficiario == NULL){
    $id_beneficiario=$_REQUEST['id_beneficiario'];
}

//Obtenemos listado y paginador
list($lista_pys,$p) = Beneficiario_pys::listaPagPysBeneficiario($id_beneficiario);
?>

<script lang="javascript" type="text/javascript" src="<?php echo $_SESSION['js_path'];?>jquery.tablesorter.min.js"></script>
<script type="text/javascript">
$(function() {
    $("table").tablesorter({widgets: ['zebra']});
});
</script>

    <?php
    //Si tenemos listado
    if($lista_pys != NULL){                

        // Listado de páginas del paginador
        echo $p->display();
    ?>
    </p>

    <table class="tablesorter">
    <thead>
        <th>Programa</th>
        <th>Producto/Servicio</th>
        <th>Fecha Asignado</th>
        <th>Fecha Alta</th>
        <th>A&ntilde;o</th>
        <th>Estado Actual</th>
        <th>Acci&oacute;n</th>
    </thead>
    <tbody>

        <?php foreach($lista_pys as $l): ?>
        <tr>
            <td><?php echo $l['nombre_componente']; ?></td>
            <td><?php echo $l['nombre_pys']; ?></td>
            <td><?php echo Fechas::fechalarga($l['fecha_asignado']); ?></td>
            <td><?php echo Fechas::fechalarga($l['fecha_creado']); ?></td>
            <td><?php echo substr($l['fecha_creado'],0,4);?></td>
            <td><?php echo ($l['activo'] == 1)? 'Activo' : 'Baja'; ?></td>
            <td>
            <?php  
            //Verificamos si tiene permiso de activar/desactivar servicio
            if(Permiso::accesoAccion('activa_servicio_beneficiario_pys', 'reg_pys_beneficiario', 'productos_servicios')){ ?>                                  
                <div title="<?php echo ($l['activo'] == 1)? 'Eliminar' : 'Activar' ?>" class="ui-state-default ui-corner-all lista">                
                    <a class="confirmation ui-icon ui-icon-<?php echo ($l['activo'] == 1)? 'closethick' : 'check'  ?>"
                       title="&iquest;Seguro de <?php echo ($l['activo'] == 1)? 'eliminar' : 'activar' ?> servicio?" 
                       href="activa_servicio_beneficiario_pys.php?id_beneficiario_pys=<?php echo $l['id']; ?>"></a>
                </div>

                <?php }else{
                    //echo 'NO';
                    }  ?>
            </td>
        </tr>
        <?php endforeach; ?>      
    </tbody>
    </table> 

     <?php }else{ ?>

    <div class="mensaje">
      No tiene servicios asignados
    </div>

<?php } ?>