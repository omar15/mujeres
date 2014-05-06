<?php
session_start();//Habilitamos uso de variables de sesión
//Incluimos cabecera
include('../../inc/header.php'); 
//Incluimos modelo 'Acción'
include_once($_SESSION['model_path'].'centros_atencion.php');

//Valores de la búsqueda
$nombre=$_GET['nombre'];
$localidad=$_GET['localidad'];
$clave_comunidad=$_GET['clave_comunidad'];
$respuesta=$_GET['r'];

//Obtenemos listado de acciones
//Beneficiario:: nombre de la clase beneficiario que esta en el archivo beneficiario 
//list($lista,$p) = Beneficiario::listaAccion($busqueda,$tipo_filtro);
list($lista,$p) = Centros_atencion::listaCentros_atencion($nombre,$localidad,$clave_comunidad);

//imprimos respuesta en caso de enviarse
if($respuesta !=null){
    $mensaje = Permiso::mensajeRespuesta($respuesta);
}

//si la lista nula enviamos mensaje de que no hay registro en la busqueda
if($lista == NULL){
    //No existen registros
    $mensaje = Permiso::mensajeRespuesta(8);
}

//Obtenemos acciones del menú
$central = Permiso::arregloMenu(substr(basename(__file__),0,-4),'center');
//exit;
?>
     <div id="principal">
        <div id="contenido">
            <div class="centro">       
                <div  align="center">
                <form id='formbusqueda' method="get" action='lista_centros_atencion.php'> 
                <input style="float: right;" type="button" onclick="javascript:history.back(-1)" value="REGRESAR"   />
                <h2 class="centro">Listado de Centros de Atenci&oacute;n</h2>       
                <fieldset>
                <table>
                 <legend>
                   <label>
                     Buscar Centro De Atenci&oacute;n
                   </label>  
                 </legend>

                <tr>
                  <td>
                    <label for="nombre">Nombre Del Centro</label>
                  </td>
                  <td>
                    <label for="localidad">Localidad</label>
                  </td>
                  <td>
                    <label for="clave_comunidad">Clave Comunidad</label>
                  </td>
                </tr>
                <tr>
                  <td>
                     <input type = 'text' id = 'nombre' name = 'nombre' class="nombre"/>
                  </td>
                  <td>
                     <input type = 'text' id = 'localidad' name = 'localidad' class="nombre"/>
                  </td>
                   <td>
                     <input type = 'text' id = 'clave_comunidad' name = 'clave_comunidad'/>
                  </td>
                  <td><input type="submit" id="boton"  value="Buscar" /></td></td>
                </tr>
                </table>
                </fieldset>
                </form>
                </div>
            </div>
             
        
        <?php if($respuesta > 0){?>
    
    <div class="mensaje"><?php echo $mensaje;?></div>
            
     <?php } ?>
     
     <div id="page_list" align="center">        
    <p>
        <?php if(array_key_exists('alta_centros_atencion',$central)){ ?>
        <a  id = 'enviar' href="alta_centros_atencion.php">Agregar nuevo centro de atenci&oacute;n</a>
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

    <script lang="javascript" type="text/javascript" src="<?php echo $_SESSION['js_path'];?>jquery.tablesorter.min.js"></script>
    <script type="text/javascript">
    $(function() {
    $("table").tablesorter({widgets: ['zebra']});
    });
    </script>
    
    <table class="tablesorter">
    <thead>
        <th>Localidad</th>
        <th>Clave del Centro</th>
        <th>Nombre del Centro</th>
        <th>Estatus</th>
        <th>Fecha Creado</th>
        <th>Acci&oacute;n</th>
    </thead>

    <tbody>
        <?php foreach($lista as $l): ?>
        <tr>
            <td><?php echo $l['localidad']; ?></td>
            <td><?php echo $l['id'];?></td>
            <td><?php echo $l['nombre_centro'];?></td>
            <td><?php echo $l['estatus'];?></td>
             <td><?php echo $l['fecha_creado'];?></td>
            <td>
             <?php if($l['activo']==1){ ?>
                <?php if(array_key_exists('edita_centros_atencion',$central)){ ?>
            
                <div title="Editar centro de atenci&oacute;n" class="ui-state-default ui-corner-all lista">                
                    <a class="ui-icon ui-icon-note" href="edita_centros_atencion.php?id_edicion=<?php echo $l['id']; ?>"></a>
                </div>
                                            
                <?php } ?>
             <?php }?> 
            <?php if(array_key_exists('activa_centros_atencion',$central)){ ?>
                
                <div title="<?php echo ($l['activo'] == 1)? 'Eliminar' : 'Activar' ?>" class="ui-state-default ui-corner-all lista">                
                    <a class="confirmation ui-icon ui-icon-<?php echo ($l['activo'] == 1)? 'closethick' : 'check'  ?>"
                       title="&iquest;Seguro de <?php echo ($l['activo'] == 1)? 'eliminar' : 'activar' ?> centro de atenci&oacute;n?<?php echo ' '.$l['nombre_centro']; ?> " 
                       href="activa_centros_atencion.php?id_activo=<?php echo $l['id']; ?>"></a>
                </div>
                <?php } ?>
                   <?php if(array_key_exists('lista_beneficiario_centro',$central)){ ?>
                <div title="Lista de beneficiarios pertenecientes al centro de atenci&oacute;n" class="ui-state-default ui-corner-all lista">
                  <a class="ui-icon ui-icon-circle-triangle-e" href="lista_beneficiario_centro.php?id_centro_atencion=<?php echo $l['id']; ?>"></a>
                </div>
                      <?php } ?>
                    <?php if(array_key_exists('alta_beneficiario_centro',$central)){ ?>
                <div title="Alta de un beneficiario al centro de atenci&oacute;n" class="ui-state-default ui-corner-all lista">
                  <a class="ui-icon ui-icon-person" href="alta_beneficiario_centro.php?id_centro_atencion=<?php echo $l['id']; ?>&id_localidad=<?php echo $l['clave_comunidad'];?>"></a>
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

