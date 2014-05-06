<?php
session_start();//Habilitamos uso de variables de sesión
//Incluimos cabecera
include('../../inc/header.php'); 
//Incluimos modelo 'Acción'
include_once($_SESSION['model_path'].'apoyo_otorgado.php');
$id_trab_expediente=$_GET['id_trab_expediente'];
$id_beneficiario=$_GET['id_beneficiario'];

//Valores de la búsqueda
$nombre=$_GET['nombre'];
$localidad=$_GET['localidad'];
$clave_comunidad=$_GET['clave_comunidad'];
$respuesta=$_GET['r'];

$mensaje = NULL;

//list($lista,$p) = Trab_expediente::listaTrab_expediente($nombre,$localidad,$clave_comunidad);
list($lista,$p) = Apoyo_otorgado::listaApoyos_otorgados($id_trab_expediente);

//imprimos respuesta en caso de enviarse
if($respuesta !=null){
    $mensaje = Permiso::mensajeRespuesta($respuesta);
}

//si la lista nula enviamos mensaje de que no hay registro en la busqueda
if($lista == NULL && count($_GET) > 1){
    //No existen registros con el criterio de búsqueda
    $mensaje = Permiso::mensajeRespuesta(8);
}elseif ($lista == NULL) {
    //No hay registros para mostrar
    $mensaje = Permiso::mensajeRespuesta(17);
}

//Obtenemos acciones del menú
$central = Permiso::arregloMenu(substr(basename(__file__),0,-4),'center'); 
?>

<script lang="javascript" type="text/javascript" src="<?php echo $_SESSION['js_path'];?>jquery.tablesorter.min.js"></script>
<script type="text/javascript">
$(function() {
$("table").tablesorter({widgets: ['zebra']});
});
</script>

<div id="principal">
    <div id="contenido">      
    <?php 
    //Si obtenemos una respuesta o el lista
    if($mensaje != NULL){?>    
    <div class="mensaje"><?php echo $mensaje;?></div>
            
     <?php } ?>
 
    <div id="page_list" align="center">   
    <input style="float: right;" type="button" onclick="javascript:history.back(-1)" value="REGRESAR"   />     
    <h2 class="centro">Listado de Apoyos Otorgados Al Beneficiario</h2> 
    
    <p>
        <?php if(array_key_exists('alta_apoyo',$central)){ ?>
        <a  id = 'enviar' href="alta_apoyo.php?id_trab_expediente=<?php echo $id_trab_expediente;?>&id_beneficiario=<?php echo $id_beneficiario ?>">Registrar nuevo apoyo</a>
        <?php } ?>
    </p>
    <p>
    <?php
    //Si tenemos listado
    if($lista != NULL){                
        // Listado de páginas del paginador
        echo $p->display();
    ?>
    
    </p>
    <table class="tablesorter">
    <thead>
        <th>Fecha Entrega</th>
        <!--<th>Apoyo Solicitado</th>-->
        <th>Producto/Servicio</th>
        <th>Acciones</th>
    </thead>

    <tbody>
        <?php foreach($lista as $l): ?>
        <tr>
            <td><?php echo $l['fecha_entrega']; ?></td>
            <td><?php 
                //echo $l['apoyo_solicitado'];
            echo $l['producto_servicio'];
            ?></td>
            <td>
             <?php if($l['activo']==1){ ?>
                <?php //if(array_key_exists('edita_trabajo_social',$central)){ ?>
            
                <div title="Editar Apoyo Otorgado" class="ui-state-default ui-corner-all lista">                
                    <a class="ui-icon ui-icon-note" href="edita_apoyo.php?id_edicion=<?php echo $l['id'];?>"></a>
                </div>
                                            
                <?php //} ?>
             <?php }?> 
            <?php if(array_key_exists('activa_trabajo_social',$central)){ ?>
                
                <div title="<?php echo ($l['activo'] == 1)? 'Eliminar' : 'Activar' ?>" class="ui-state-default ui-corner-all lista">                
                    <a class="confirmation ui-icon ui-icon-<?php echo ($l['activo'] == 1)? 'closethick' : 'check'  ?>"
                       title="&iquest;Seguro de <?php echo ($l['activo'] == 1)? 'eliminar' : 'activar' ?>  Apoyo Otorgado<?php /*echo ' '.$l['nombre_centro'];*/ ?> " 
                        href="activa_apoyo.php?id_activo=<?php echo $l['id']; ?>&id_trab_expediente=<?php echo $l['id_trab_expediente'];?>"></a>
                </div>
                <?php } ?>
                               
            </td>
        </tr>
        

        <?php endforeach; ?>      
        
    </tbody>
    </table>        
    <?php } ?>
        </div>
        </div>
        </div>
    
    <?php 
//Incluimos pie
include($_SESSION['inc_path'].'/footer.php');
?>      
