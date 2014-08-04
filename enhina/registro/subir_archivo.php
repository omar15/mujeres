<?php
session_start();//Habilitamos uso de variables de sesión

//Incluimos cabecera
include('../../inc/header.php');

//Variable de respuesta
$respuesta = intval($_GET['r']);
//obtenemos datos de caravana
//Obtemos escolaridad
$db->where ('activo', 1);
$caravana = $db->get('caravana');
//Mensaje respuesta
list($mensaje,$clase) = Permiso::mensajeRespuesta($respuesta);

$totales = (isset($_SESSION['totales']))? $_SESSION['totales'] : NULL ;

unset($_SESSION['totales']);
 
?>
<script lang="javascript" type="text/javascript" src="<?php echo $_SESSION['js_path'];?>jquery.tablesorter.min.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?><?php echo $_SESSION['module_name']?>/valida.js"></script>
<script type="text/javascript">
$(function() {
    $("table").tablesorter({widgets: ['zebra']});
});
</script>
<div id="principal">
   <div id="contenido">
    <div>
    <h2 class="centro">Subir Archivo</h2>
     <input style="float: right;" type="button" onclick="javascript:history.back(-1)" value="REGRESAR"   />
    </div> 
    
    <?php if($respuesta > 0){?>
    
    <div class="mensaje <?php echo $clase; ?>"><?php echo $mensaje;?></div>
    
    <?php } ?>
    
    <?php if($totales != NULL){?>

    <table class="tablesorter">
     <thead>
    <tr>
      <th>
         Descripci&oacute;n
      </th>
      <th>
       Total
      </th>
    </tr>
    </thead>
    <tbody>
      <tr>
      <td>Total Encuestados:</td>
      <td><?php echo $totales['total_encuestados'];?></td>
    </tr>
    <tr>
       <td>Total Encuestas Completas:</td> 
       <td><?php echo $totales['total_enc_completo'];?></td> 
    </tr> 
    <tr>
       <td>Total Encuestas Incompletas:</td> 
       <td><?php echo $totales['total_enc_inc'];?></td>
    </tr> 
    <tr>
      <td>Total de Personas Registradas:</td>
      <td><?php echo $totales['total_familiares'];?></td>
    </tr>
    <tr>
      <td>Total Encuestados en Programa MAC:</td> 
      <td><?php echo $totales['total_prog_mac'];?></td>
    </tr>
    <tr>
      <td>Total Encuestados en Programa MAP:</td>
      <td><?php echo $totales['total_prog_map'];?></td>
    </tr>
    <tr>
       <td>Total Duplicados:</td>
       <td><?php echo $totales['total_duplicados']?></td>
    </tr>
    <tr>
      <td>Total Entrevistas no coinciden:</td>
      <td><?php echo $totales['total_no_coinciden']?></td>
    </tr>
   <tr>
     <td>Total de Encuestados Registrados:</td> 
      <td><?php echo $totales['total_registrados']?></td>
   </tr>
   <tr>
     <td>Total de Grado de Inseguridad Severo:</td> 
      <td><?php echo $totales['total_severa']?></td>
   </tr><tr>
     <td>Total de Grado de Inseguridad Moderado:</td> 
      <td><?php echo $totales['total_moderada']?></td>
   </tr><tr>
     <td>Total de Grado de Inseguridad Leve:</td> 
      <td><?php echo $totales['total_leve']?></td>
   </tr>
   <tr>
     <td>Total de Grado de Inseguridad Seguro:</td> 
      <td><?php echo $totales['total_segura']?></td>
   </tr>
   
   <?php if($totales['total_otra'] > 0){?>
   <tr>
     <td>Total de Otro Grado de Inseguridad:</td> 
      <td><?php echo $totales['total_otra']?></td>
   </tr>
   <?php }?>
    </tbody>
  </table>

    <?php } ?>

	<div align="center">                
       <form action="carga_archivo.php" id="carga_archivo" method="post" enctype="multipart/form-data">
        <table>
          <tr>
            <td>
              <label>
                 Caravana
              </label>
            </td> 
            <td>
            <select class="combobox" id="id_caravana" name="id_caravana">
                <option value=''>Seleccione Caravana</option>
                <?php foreach($caravana as $c):
                $selected = ($c['id'] == $mujeres_avanzando['id_caravana'])? "selected":''; ?>                
                <option value='<?php echo $c['id'] ?>' <?php echo $selected;?> > <?php echo $c['descripcion'];?></option>
                <?php endforeach; ?>
            </select>
            </td>
          </tr> 

            <tr>
            <td><label>Archivo Excel (.xlsx)</label></td>
            
            <td>
             <input type="file" id="file" name="archivo"/>
             <input id="enviar" type="submit" value="Enviar"/>
             </td>
            </tr> 
        </table>
       </form>
        <p>
         Seleccione un archivo .XLSX desde su computadora para importar encuestas ENHINA. Este archivo es proporcionado por el Sistema de Informaci&oacute;n de Inseguridad Alimentaria de DIF Nacional.
        Recuerde que &uacute;nicamente se importar&aacute;n los registros capturados desde Caravanas (MAC) y Puntos Rosas (MAP) que est&eacute;n marcadas como COMPLETAS.                        
         </p>        
      <div id="spinner" style="display:none;">
            La carga del archivo puede tomar algunos minutos. Por favor, sea paciente.
          <img src="<?php echo $_SESSION['css_path'] ?>/img/loader_sug.gif">
      </div>
    </div>
    </div>
</div>

<?php 
//Incluimos pie
include($_SESSION['inc_path'].'/footer.php');
?>