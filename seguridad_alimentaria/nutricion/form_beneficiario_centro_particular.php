<?php
session_start();

//Arreglos para los select
   $tipo_familia = array();
   $vulnerabilidad_f = array();
   $vulnerabilidad = array();
   $expediente = array();
   
//Si obtenemos los estatus
    $estatus = $db->get('estatus');
//Obtemos los tipos de familia
   $sql = 'SELECT * FROM tipo_familia';     
   $tipo_familia=$db->query($sql);
   
//Obtemos los tipos de Vulnerabilidad familiar
   $sql = 'SELECT cod_vulnerabilidad_familiar,descripcion_vulnerabilidad_familiar FROM tvulnerabilidad_familiar';     
   $vulnerabilidad_f=$db->query($sql);
//Obtemos los tipos de Vulnerabilidad 
   $sql = 'SELECT cod_vulnerabilidad, descripcion_vulnerabilidad FROM tcat_vulnerabilidad;';     
   $vulnerabilidad=$db->query($sql); 
   
   $talla_1=null;
   $peso_1=null;
   $fecha_pesaje_1=null;
   
   $talla_2=null;
   $peso_2=null;
   $fecha_pesaje_2=null;
   
   //Si editamos el registro
    if(intval($id_edicion)>0){
        //Obtenemos el registro del centro de atencion
        $db->where('id',$id_edicion);
       $alim_nutricion_extraescolar = $db->get_first('alim_nutricion_extraescolar');
       //obtenemos datos particulares
       $talla_1=$alim_nutricion_extraescolar['talla_1'];
       $peso_1=$alim_nutricion_extraescolar['peso_1'];
       $fecha_pesaje_1=$alim_nutricion_extraescolar['fecha_pesaje_1'];
       
       $talla_2=$alim_nutricion_extraescolar['talla_2'];
       $peso_2=$alim_nutricion_extraescolar['peso_2'];
       $fecha_pesaje_2=$alim_nutricion_extraescolar['fecha_pesaje_2'];
       
       //obtenemos datos del beneficiario
   include_once($_SESSION['model_path'].'beneficiario.php');
  $lista= Beneficiario::expedienteBeneficiario($alim_nutricion_extraescolar['id_beneficiario']);
  $lista = $lista[0];      
             
             include_once("datos_beneficiario.php");     
                
    }    
      
        
?>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?>jquery.maskedinput.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?><?php echo $_SESSION['module_name']?>/filtro.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?><?php echo $_SESSION['module_name']?>/valida.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?><?php echo $_SESSION['module_name']?>/combobox.js"></script>




    
<form id='form_nutricion' method="post" action='save_beneficiario_centro_particular.php'>
<?php //echo 'centro de atencion'.$id_centro_atencion ?>
<tr>
<td>
   <label class="obligatorio">Le recordamos que los campos con asterisco (*) son campos obligatorios</label>
</td>
</tr>



<fieldset>



<table>



 <legend>



   <label>



     Datos Particulares del Beneficiario



   </label>  



 </legend>


     
    <tr>
         <td>
           <label class="obligatorio">*</label> <label for="nombres">Nombre(s) Del Padre o Tutor</label>
         </td>
         <td>
           <label class="obligatorio">*</label><label for="paterno">Apellido Paterno</label>
        </td>
         <td>
          <label for="materno">Apellido Materno</label>
        </td>
    </tr>
   <tr>    
      <td>
            <input type="hidden" name="id_edicion" value="<?php echo $id_edicion; ?>" />
            <input type="hidden" name="id_beneficiario" value="<?php echo $id_beneficiario; ?>" />
            <input type="hidden" name="id_centro_atencion" value="<?php echo $id_centro_atencion; ?>" />
            <input type="hidden" name="id_localidad" value="<?php echo $id_localidad; ?>" />
            <input type = 'text' id = 'nombres' name = 'nombres' class="nombre" value="<?php echo $alim_nutricion_extraescolar['tutor_nombres']; ?>" />
      </td>

        <td>
            <input type = 'text' id = 'paterno' name = 'paterno' class="nombre" value="<?php echo $alim_nutricion_extraescolar['tutor_paterno']; ?>" />
        </td>
       <td>
            <input type = 'text' id = 'materno' name = 'materno' class="nombre"value="<?php echo $alim_nutricion_extraescolar['tutor_materno']; ?>" />
       </td>
   </tr>



      <tr>
           <td>
             <label class="obligatorio">*</label><label for="id_tipo_familia">Tipo familia</label>
          </td>
          <td>
           <label class="obligatorio">*</label><label for="id_vulnerabilidad">Vulnerabilidad del Beneficiario</label>
         </td> 

     </tr>



    <tr>
   <td>
     <select id="id_tipo_familia" name="id_tipo_familia">
         <option value=''>Seleccione el Tipo de Familia</option>
               <?php foreach($tipo_familia as $tf): 
              if($tf['id'] == $alim_nutricion_extraescolar['id_tipo_familia'] ){
                    $selected = "selected";
                     }else{
                      $selected = "";
                       }



                    ?>                
             <option value='<?php echo $tf['id'] ?>' <?php echo $selected;?> > <?php echo $tf['descripcion'];?></option>
          <?php endforeach; ?>
      </select>
     </td>
     <td>
        <select id="id_vulnerabilidad" name="id_vulnerabilidad">
           <option value=''>Seleccione Vulnerabilidad </option>
              <?php foreach($vulnerabilidad as $v): 
                if($v['cod_vulnerabilidad'] == $alim_nutricion_extraescolar['id_vulnerabilidad']){
                       $selected = "selected";
                        }else{
                      $selected = "";
                        }
                   ?>                
                  <option value='<?php echo $v['cod_vulnerabilidad'] ?>' <?php echo $selected;?> > <?php echo $v['descripcion_vulnerabilidad'];?></option>
                 <?php endforeach; ?>
           </select>
      </td>

     
    </tr>
    <tr>
     <td>
           <label class="obligatorio">*</label><label for="id_vulnerabilidad_familia">Vulnerabilidad_familiar</label>
     </td>
    </tr>
  <tr>
      <td>
        <select id="id_vulnerabilidad_familia" name="id_vulnerabilidad_familia">
           <option value=''>Seleccione Vulnerabilidad De La Familia</option>
              <?php foreach($vulnerabilidad_f as $vf): 
                if($vf['cod_vulnerabilidad_familiar'] == $alim_nutricion_extraescolar['id_vulnerabilidad_familia']){
                       $selected = "selected";
                        }else{
                      $selected = "";
                        }
                   ?>                
                  <option value='<?php echo $vf['cod_vulnerabilidad_familiar'] ?>' <?php echo $selected;?> > <?php echo $vf['descripcion_vulnerabilidad_familiar'];?></option>
                 <?php endforeach; ?>
           </select>
      </td>   
   </tr>
   <tr>
     <td>
        <label class="obligatorio">*</label><label for="ingreso">Ingreso Familiar</label>
      </td>
   </tr>
   <tr>
      <td>
       <input type = 'text' id = 'ingreso' name = 'ingreso' value="<?php echo $alim_nutricion_extraescolar['ingreso_familiar']; ?>" />
    </td> 
   </tr>
   </table>
   </fieldset>
   
   <!-- Primera medicion -->
   <fieldset>
   <table>
   <legend>
   <label>
     Primera Medici&oacute;n
   </label>  
 </legend>

   <tr>
     <td>
        <label class="obligatorio">*</label><label for="talla_1">Talla</label>
      </td> 
      <td>
        <label class="obligatorio">*</label><label for="peso_1">Peso</label>
      </td>
      <td>
        <label class="obligatorio">*</label><label for="fecha_pesaje_1">Fecha_pesaje</label>
      </td>
   </tr>
   <tr>
     <td>
       <input type = 'text' id = 'talla_1' name = 'talla_1'  value="<?php echo $alim_nutricion_extraescolar['talla_1']; ?>" />
    </td>
    <td>
       <input type = 'text' id = 'peso_1' name = 'peso_1' value="<?php echo $alim_nutricion_extraescolar['peso_1']; ?>" />
    </td>
    <td>
       <input type = 'text' id = 'fecha_pasaje_1' class="fecha date" name = 'fecha_pesaje_1' value="<?php echo $alim_nutricion_extraescolar['fecha_pesaje_1']; ?>" />
       <input type="button"  value="Hoy" id="btnToday1"  />
    </td>   
   </tr>
   </table>
   </fieldset>
    <?php if($talla_1 !=null && $peso_1 !=null &&  $fecha_pesaje_1 !=null) { ?>
   <!-- Segunda Medicion -->
   <fieldset>
   <table>
   <legend>
   <label>
     Segunda Medici&oacute;n
   </label>  
 </legend>
   <tr>
     <td>
        <label for="talla_2">Talla</label>
      </td> 
      <td>
        <label for="peso_2">Peso</label>
      </td>
      <td>
        <label for="fecha_pesaje_2">Fecha_pesaje</label>
      </td>
   </tr>
   <tr>
     <td>
       <input type = 'text' id = 'talla_2' name = 'talla_2' value="<?php echo $alim_nutricion_extraescolar['talla_2']; ?>" />
    </td>
    <td>
       <input type = 'text' id = 'peso_2' name = 'peso_2'  value="<?php echo $alim_nutricion_extraescolar['peso_2']; ?>" />
    </td>
    <td>
       <input type = 'text' id = 'fecha_pasaje_2' class="fecha date" name = 'fecha_pesaje_2' value="<?php echo $alim_nutricion_extraescolar['fecha_pesaje_2']; ?>" />
       <input type="button"  value="Hoy" id="btnToday2"  />
    </td>   
   </tr>
   </table>
   </fieldset>
   <?php } ?>
    <?php if($talla_2 !=null && $peso_2 !=null &&  $fecha_pesaje_2 !=null) { ?>
   <!-- Tercera medicion -->
   <fieldset>
   <table>
    <legend>
   <label>
     Tercera Medici&oacute;n
   </label>  
 </legend>
   
   <tr>
     <td>
       </label><label for="talla_3">Talla</label>
      </td> 
      <td>
      </label><label for="peso_3">Peso</label>
      </td>
      <td>
       </label><label for="fecha_pesaje_3">Fecha_pesaje</label>
      </td>
   </tr>
   <tr>
     <td>
       <input type = 'text' id = 'talla_3' name = 'talla_3' value="<?php echo $alim_nutricion_extraescolar['talla_3']; ?>" />
    </td>
    <td>
       <input type = 'text' id = 'peso_3' name = 'peso_3' value="<?php echo $alim_nutricion_extraescolar['peso_3']; ?>" />
    </td>
    <td>
       <input type = 'text' id = 'fecha_pasaje_3' class="fecha date" name = 'fecha_pesaje_3' value="<?php echo $alim_nutricion_extraescolar['fecha_pesaje_3']; ?>" />
       <input type="button"  value="Hoy" id="btnToday3"  />
    </td>   
   </tr>
   <?php } ?>
     <tr>
      <?php if($id_edicion > 0) { ?>

       
            <td>
                <label for="activo">Estatus</label>
            </td>
            <td>
                <select id="activo" name="activo">
                    <option value="">Seleccione</option>
                    <?php foreach($estatus as $e){                         
                        if($e['valor'] == $alim_nutricion_extraescolar['activo']){
                            $selected = "selected";
                        }else{
                            $selected = "";
                        }
                    ?>                
                    <option value='<?php echo $e['valor'] ?>' <?php echo $selected;?> > <?php echo $e['nombre'];?></option>
                    <?php } ?>
                </select>
            </td>
              
       <?php } ?>
        
        </tr>
    
      	<tr>
			<td>&nbsp;</td>
			<td><input type = 'submit'  id = 'enviar' value = 'Enviar' /></td>
		</tr>
    
 </table>
</fieldset>




</form>


