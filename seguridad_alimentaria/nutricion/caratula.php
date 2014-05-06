<?php
session_start();

//Incluimos cabecera
include('../../inc/header.php' );

//Cargamos modelo de grupo
include_once($_SESSION['model_path'].'grupo.php');  

$municipios_disponibles = Grupo::munAreaArreglo(null,true);

/*
//Obtenemos los ciclos escolares disponibles
$ciclo_escolar = Permiso::ciclosEscolares();

//Obtenemos años del padrón
$axo_padron = Permiso::axosPadron();
*/

//Obtenemos ciclos escolares
$grupo_ciclo_escolar = Grupo::cicloEscolarGrupo();

//Obtenemos Años
$grupo_axo = Grupo::axoGrupo();

$id_municipio = $_POST['id_municipio'];

?>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?>jquery.maskedinput.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?><?php echo $_SESSION['module_name']?>/filtro.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?><?php echo $_SESSION['module_name']?>/valida.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?><?php echo $_SESSION['module_name']?>/combobox.js"></script>
  
<div id="principal">
   <div id="contenido">
      <h2 class="centro">Car&aacute;tula</h2>
      
      <?php if($respuesta > 0){?>
      
      <div class="mensaje"><?php echo $mensaje;?></div>
      
      <?php } ?>
    
      <div align="center">    
      <form id='formCaratula' method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">            
            <table>
            <tr>
              <td><label>Seleccione Municipio</label></td>
              <td>
                <select id="id_municipio" name="id_municipio">
                      <option value=''>Seleccione Municipio</option>
                      <?php foreach($municipios_disponibles as $l): ?>                
                        <option value='<?php echo $l['CVE_MUN'] ?>' <?php echo $selected;?> > 
                          <?php echo $l['NOM_MUN'];?>
                        </option>
                      <?php endforeach; ?>
                </select>
              </td>
            </tr>
            <!--
            <tr>
              <td><label>Ciclo Escolar</label></td>
              <td>
                <select id='ciclo_escolar' name = "ciclo_escolar">
                  <?php /* foreach($grupo_ciclo_escolar as $l): ?>                
                        <option value='<?php echo $l ?>' <?php echo $selected;?> > 
                          <?php echo $l;?>
                        </option>
                      <?php endforeach; */?>
                </select>
              </td>
            </tr>
            -->
            <tr>
              <td><label>A&ntilde;o Padr&oacute;n</label></td>
              <td>
                <select id="axo_padron" name = "axo_padron">
                  <!-- <option value="">Seleccione A&ntilde;o Padr&oacute;n</option> -->
                  <?php foreach($grupo_axo as $l): ?>                
                        <option value='<?php echo $l ?>' <?php echo $selected;?> > 
                          <?php echo $l;?>
                        </option>
                      <?php endforeach; ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input type = 'submit'  id = 'enviar'value = 'Generar Reporte' /></td>
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
