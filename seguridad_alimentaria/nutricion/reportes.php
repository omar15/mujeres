<?php
session_start();

//Incluimos cabecera
include('../../inc/header.php' );

//Cargamos modelo de grupo
include_once($_SESSION['model_path'].'grupo.php'); 

//Obtenemos municipios disponibles
$municipios_disponibles = Grupo::munAreaArreglo(null,true);

//Obtenemos ciclos escolares
$grupo_ciclo_escolar = Grupo::cicloEscolarGrupo();

//Obtenemos Años
$grupo_axo = Grupo::axoGrupo();

//Guardamos variables
$id_municipio = $_POST['id_municipio'];
$axo_padron = $_POST['axo_padron'];

if($id_municipio != NULL && $axo_padron != NULL){


}

?>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?>jquery.maskedinput.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?><?php echo $_SESSION['module_name']?>/filtro.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?><?php echo $_SESSION['module_name']?>/valida.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?><?php echo $_SESSION['module_name']?>/combobox.js"></script>

<div id="principal">
   <div id="contenido">
    <h1 class="centro">Reportes</h1>
     
    <div align="center">    
      <form id='formReporte' method="post" target="_blank" action="imprimir_reporte.php">            
            <table>
            <tr>
              <td><label>Seleccione Municipio</label></td>
              <td>
                <select id="id_municipio_caratula" name="id_municipio_caratula" class="comunidad">
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
                <select id="axo_padron" name = "axo_padron" class="comunidad">
                  <!-- <option value="">Seleccione A&ntilde;o Padr&oacute;n</option> -->
                  <?php foreach($grupo_axo as $l): ?>                
                        <option value='<?php echo $l ?>' <?php echo $selected;?> > 
                          <?php echo $l;?>
                        </option>
                      <?php endforeach; ?>
                </select>
              </td>
            </tr>
            <tr id="tipo_caratula"></tr>
			      <tr id="com"></tr>
            <tr id="centro"></tr>
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
include($_SESSION['inc_path']. 'footer.php'); 	