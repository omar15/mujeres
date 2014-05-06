<?php
session_start();//Habilitamos uso de variables de sesión
//Incluimos cabecera
include('../../inc/header.php'); 
//Incluimos modelo 'Acción'
include_once($_SESSION['model_path'].'trab_expediente.php');
//Valores de la búsqueda
$nombre=$_GET['nombre'];
$paterno=$_GET['paterno'];
$materno=$_GET['materno'];
$tipo = $_GET['tipo'];
$nombre_completo = '';
$numero_expediente = $_GET['numero_expediente'];
$respuesta=$_GET['r'];
$id_trab_expediente=$_GET['id'];

//Buscamos expedientes por nombre
list($lista,$p) = Trab_expediente::listaTrab_expediente($nombre,
                                                        $paterno,
                                                        $materno,
                                                        $tipo,
                                                        $numero_expediente);

//imprimos respuesta en caso de enviarse
if($respuesta !=null){
    $mensaje = Permiso::mensajeRespuesta($respuesta);

    //Se guardó exitosamente, mostramos la id_dif/curp generada
    if($respuesta == 1){
        
        if($id_trab_expediente > 0){
            list($registro,$pag) = Trab_expediente::listaTrab_expediente(NULL,
                                                                         NULL,
                                                                         NULL,
                                                                         NULL,
                                                                         NULL,
                                                                         $id_trab_expediente);
          //Obtenemos el único registro
          $registro = $registro[0];

          //Obtenemos nombre y número de expediente del registro recién creado o guardado
          $nombre_completo = ($registro['nombre_ben'] != NULL)? $registro['nombres_ben']:$registro['nombres_asp'];
          $numero_expediente = $registro['numero_expediente'];
        }        

        //Armamos mensaje
        $mensaje .= '. '.$nombre_completo.' guardado con el n&uacute;mero de expediente '.
                    $numero_expediente.'. <a href = "edita_trabajo_social.php?id_edicion='.$id_trab_expediente.'">Ver Registro</a> o <a href = "alta_trabajo_social.php">Crear Nuevo</a>.';

    }

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

<!-- buscador -->
<div id="principal">
        <div id="contenido">
          <div class="centro">       
                <div  align="center">
                <form id='formbusqueda' method="get" action='lista_trabajo_social.php'> 
              
                <h2 class="centro">Listado De Trabajo Social</h2>       
                <fieldset>
                <table>
                 <legend>
                   <label>
                     Busqueda Trabajo Social
                   </label>  
                 </legend>
                
                  <label class="obligatorio">Para realizar una busqueda ingrese al menos un nombre y un apellido paterno</label>
              
                <tr>
                  <td>
                    <label for="nombre">Nombre(s)</label>
                  </td>
                  <td>
                    <label for="paterno">Paterno</label>
                  </td>
                  <td>
                    <label for="materno">Materno</label>
                  </td>
                  <td>
                    <label form="numero_expediente">N&uacute;mero de Expediente</label> 
                  </td>
                </tr>
                <tr>
                  <td>
                     <input type = 'text' id = 'nombre' name = 'nombre' class="nombre"/>
                  </td>
                  <td>
                     <input type = 'text' id = 'paterno' name = 'paterno' class="nombre"/>
                  </td>
                   <td>
                     <input type = 'text' id = 'materno' name = 'materno'/>
                  </td>
                  <td>
                     <input type = 'text' id = 'numero_expediente' name = 'numero_expediente'/>
                  </td>
                  <td>
                  Tipo
                    <select id="tipo" name="tipo">
                      <option value="aspirante">Aspirante</option>
                      <option value="beneficiario">Beneficiario</option>
                    </select>
                  </td>
                  <td><input type="submit" id="boton"  value="Buscar" /></td></td>
                </tr>
                </table>
                </fieldset>
                </form>
                </div>
            </div>
<?php if($mensaje != NULL){?>
    
    <div class="mensaje"><?php echo $mensaje;?></div>
            
     <?php } ?>

 
     <div id="page_list" align="center">        
     <p>
        <?php if(array_key_exists('alta_trabajo_social',$central)){ ?>
        <a  id = 'enviar' href="alta_trabajo_social.php">Registrar nuevo expediente</a>
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
        <th>Numero Expediente</th>
        <th>Nombres</th>
        <th>Tipo</th>
        <th>Programa</th>
        <th>Fecha Registro</th>        
        <th>Acciones</th>
    </thead>

    <tbody>
        
        <?php 
        $i = 0;
        foreach($lista as $l): ?>
        
        <tr class="<?php echo (($i%2) == 0) ?'par':'non' ?>">
            <td><?php echo $l['numero_expediente']; ?></td>
            <td class="nombre_asp"><?php echo ($l['nombres_asp'] != NULL)? $l['nombres_asp']: $l['nombres_ben'];?></td>
            <td><?php echo ($l['id_beneficiario'] != NULL)? 'Beneficiario':'Aspirante';?></td>
            <td><?php echo $l['producto_servicio']; ?></td>
            <td><?php echo $l['fecha_registro'];?></td>            
            <td>
             <?php if($l['activo']==1){ ?>
                <?php if(array_key_exists('edita_trabajo_social',$central)){ ?>
            
                <div title="Ver/Editar expediente" class="ui-state-default ui-corner-all lista">                
                    <a class="ui-icon ui-icon-note" href="edita_trabajo_social.php?id_edicion=<?php echo $l['id'];?>&id_aspirante=<?php echo $l['id_aspirante'];?>"></a>
                </div>
                                            
                <?php } ?>
             <?php }?> 
            <?php if(array_key_exists('activa_trabajo_social',$central)){ ?>
                
                <div title="<?php echo ($l['activo'] == 1)? 'Eliminar' : 'Activar' ?>" class="ui-state-default ui-corner-all lista">                
                    <a class="confirmation ui-icon ui-icon-<?php echo ($l['activo'] == 1)? 'closethick' : 'check'  ?>"
                       title="&iquest;Seguro que deseas <?php echo ($l['activo'] == 1)? 'eliminar' : 'activar' ?> eliminar este expediente?<?php /*echo ' '.$l['nombre_centro'];*/ ?> " 
                       href="activa_trabajo_social.php?id_activo=<?php echo $l['id']; ?>"></a>
                </div>
                <?php } ?>
                <?php if($l['activo']==1){ ?>
           <?php if($l['beneficiario'] != null) {?>      
           <?php  if(array_key_exists('alta_apoyo',$central)){ ?>
            
                <div title="Registrar Apoyos Otorgados" class="ui-state-default ui-corner-all lista">                
                    <a class="ui-icon ui-icon-document-b" href="alta_apoyo.php?id_trab_expediente=<?php echo $l['id'];?>&id_beneficiario=<?php echo $l['id_beneficiario'];?>"></a>
                </div>
                                            
                <?php } ?>    
                  <?php } ?>     
                  <?php } ?>   
            
            <?php if($l['activo']==1){ ?>
            <?php if($l['beneficiario'] != null) {?>      
                  <?php if(array_key_exists('lista_apoyo',$central)){ ?>
                <div title="Lista de Apoyos Otorgados Al Beneficiario" class="ui-state-default ui-corner-all lista">
                  <a class="ui-icon ui-icon-circle-triangle-e" href="lista_apoyo.php?id_trab_expediente=<?php echo $l['id']; ?>&id_beneficiario=<?php echo $l['id_beneficiario'];?>"></a>
                </div>
                      <?php } ?>    
                      <?php } ?> 
                       <?php } ?>                     
            </td>
        </tr>
          

        <?php 
        $i++;
        
        endforeach; ?>      
        
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
    