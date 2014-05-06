<?php
session_start();

//Cargamos modelos
include_once($_SESSION['model_path'].'grupo.php');  
include_once($_SESSION['model_path'].'cp_sepomex.php');  
include_once($_SESSION['model_path'].'vialidad.php');  
include_once($_SESSION['model_path'].'centros_atencion.php');  

  //Arreglos para los select
  $localidad = array();
  $tipo_atencion = array();
  $estatus = array();
  $asentamiento = array();
  $vialidad = array();

  //Obtemos los tipos de vialidad
  $sql = 'SELECT CVE_TIPO_VIAL, DESCRIPCION from cat_vialidad';     
  $tipo_via = $db->query($sql);

  //Si obtenemos los estatus
  $estatus = $db->get('estatus');
       
  //Obtemos los tipos de atencion
  $sql = 'SELECT id, tipo from tipo_centro_atencion';     
  $tipo_atencion = $db->query($sql);

  //Obtenemos los códigos postales
  $codigo = Cp_sepomex::codigosJalisco();

  //Obtenemos municipios disponibles
  $municipios_disponibles = Grupo::munAreaArreglo(null,true);    
    
    //Si editamos el registro
    if(intval($id_edicion)>0){
        
        //Obtenemos el registro del centro de atencion
        $db->where('id',$id_edicion);
        $centro_atencion = $db->get_first('centros_atencion');  
        
        $CVE_EST_MUN_LOC = $centro_atencion['CVE_EST_MUN_LOC'];
        $CODIGO = $centro_atencion['CODIGO'];          
        $CVE_TIPO_VIAL = $centro_atencion['CVE_TIPO_VIAL']; 
        $CVE_VIA = $centro_atencion['CVE_VIA']; 
        $CVE_ENT_MUN = $centro_atencion['CVE_ENT_MUN'];          

        //Obtenemos las localidadades de los centros de atención
        $localidad = Centros_atencion::localidadesCentro($CVE_ENT_MUN);
                       
        //checar en tabla comuinidad
        //$sql = 'SELECT CVE_EST_MUN_LOC, nombre_comunidad FROM `comunidad`';
        //$comunidades = $db->query($sql);
            
        //Obtenemos vialidades y sus tipos
        if($CVE_TIPO_VIAL ){
        
          $tipo_vias =  Vialidad::listaTipoVialidades($CVE_EST_MUN_LOC);
          $vialidades = Vialidad::listaVialidades($CVE_EST_MUN_LOC,$CVE_TIPO_VIAL);

        //Obtenemos asentamiento de Sepomex
        if($CODIGO){
            $asentamiento = Cp_sepomex::listaVialidades($CODIGO);
        }

    }        

  }    
?>

<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?>jquery.maskedinput.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?><?php echo $_SESSION['module_name']?>/filtro.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?><?php echo $_SESSION['module_name']?>/valida.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?><?php echo $_SESSION['module_name']?>/combobox.js"></script>

<form id='formCent' method="post" action='save_centros_atencion.php'>
	<table>
    <tr>
              <td><label for="CVE_ENT_MUN">Seleccione Municipio <?php echo $CVE_EST_MUN_LOC.' '.$CVE_TIPO_VIAL ?> </label></td>
              <td>
                <select id="CVE_ENT_MUN" name="CVE_ENT_MUN">
                      <option value=''>Seleccione Municipio</option>
                      <?php foreach($municipios_disponibles as $m): 
                       
                       if('14'.$m['CVE_MUN'] == $centro_atencion['CVE_ENT_MUN']){

                            $selected = "selected";

                        }else{

                            $selected = "";

                        }
                      ?> 
                                          
                        <option value='<?php echo '14'.$m['CVE_MUN'] ?>' <?php echo $selected;?> > 
                          <?php echo $m['NOM_MUN'];?>
                        </option>
                      <?php endforeach; ?>
                </select>
              </td>
            </tr>
    <tr>
      <td>
        <label class="obligatorio">*</label><label for="CVE_EST_MUN_LOC">Localidad</label>
     </td>
     <td  colspan="2"id="localidad">

                <select class="combobox" id="CVE_EST_MUN_LOC" name="CVE_EST_MUN_LOC">
 
                    <option value=''>Seleccione Localidad</option>
                
                    <?php 
                    //solo listamos las localidades cuando estemos editando
                    if($localidad !=null){
                    foreach($localidad as $l): 

                       if($l['CVE_EST_MUN_LOC'] == $centro_atencion['CVE_EST_MUN_LOC']){

                            $selected = "selected";

                        }else{

                            $selected = "";

                        }

                    ?>                

                    <option value='<?php echo $l['CVE_EST_MUN_LOC'] ?>' <?php echo $selected;?> >
                      <?php echo $l['localidades'];?>
                    </option>

                    <?php endforeach; 
                    }
                    ?>

                </select>

        </td> 
    </tr>
    <tr>
        <td>
           <label class="obligatorio">*</label><label for="nombre">Nombre del centro de atenci&oacute;n</label>
        </td>
        <td>
            <input type="hidden" name="id_edicion" value="<?php echo $id_edicion; ?>" />
            <input type = 'text' id = 'nombre' name = 'nombre' value="<?php echo $centro_atencion['nombre']; ?>" />
        </td>
   </tr>
   <tr>
      <td>
        <label class="obligatorio">*</label><label for="CVE_TIPO_VIAL">Tipo De Vialidad </label>
      </td>
      <td colspan="3">
        <label class="obligatorio">*</label><label for="CVE_VIA">Vialidad</label>
      </td>
    </tr>
    <tr>
     <td id="tipo_vialidad" >
        <select class="combobox" id="CVE_TIPO_VIAL" name="CVE_TIPO_VIAL">
            <option value=''>Seleccione Tipo de Vialidad</option>
                <?php foreach($tipo_vias as $tp):?>
                <option value='<?php echo $tp['CVE_TIPO_VIAL'] ?>' <?php echo ($tp['CVE_TIPO_VIAL'] == $centro_atencion['CVE_TIPO_VIAL'])? 'selected' : '';?> > 
                    <?php echo $tp['DESCRIPCION'];?>
                </option>                
                <?php endforeach; ?>
            </select>
    </td>
        <td colspan="3" id="vialidad">
            <select class="combobox" id="CVE_VIA" name="CVE_VIA">
                <option value=''>Seleccione Vialidad</option>
                    <?php foreach($vialidades as $v):?>                
                <option value='<?php echo $v['CVE_VIA'] ?>' <?php echo ($v['CVE_VIA'] == $centro_atencion['CVE_VIA'])? 'selected' : '';?> > 
                    <?php echo $v['NOM_VIA'];?>
                </option>
                    <?php endforeach; ?>
            </select>
        </td> 
    </tr>    
    
    <tr>
     <td>
         <label class="obligatorio">*</label><label for="num_ext">N&uacute;mero exterior</label>
     </td>
     <td>
         <label for="num_int">N&uacute;mero interior</label>
     </td>
    </tr>
    
    <tr>
        <td>
            <input type = 'text' class="digits" id = 'num_ext' name = 'num_ext' class="nomnum"value="<?php echo $centro_atencion['num_ext']; ?>" />
        </td>
        <td>
            <input type = 'text' id = 'num_int' name = 'num_int' class="nomnum"value="<?php echo $centro_atencion['num_int']; ?>" />
        </td>
    </tr>
    
    <tr>
        <td>
           <label for="observacion">Observaci&oacute;n</label>
        </td> 
        <td>
           <textarea id='observacion' name = 'observacion' class="nomnum" cols="50" rows="5">
             <?php echo $centro_atencion['observacion']; ?>
           </textarea>
        </td>
    </tr>

    <tr>
      <td>
        <label class="obligatorio">*</label><label for="CODIGO">C&oacute;digo Postal</label>
      </td>          
     <td id="cp">
        <select class="combobox" id="CODIGO" name="CODIGO">
            <option value=''>Seleccione C&oacute;digo Postal</option>
                    <?php foreach($codigo as $c): 
                        if($c['d_codigo'] == $centro_atencion['CODIGO']){
                            $selected = "selected";
                        }else{
                            $selected = "";
                        }
                    ?>                
            <option value='<?php echo $c['d_codigo'] ?>' <?php echo $selected;?> > <?php echo $c['d_codigo'];?></option>
                    <?php endforeach; ?>
            </select>
     </td>     
    </tr>

    <tr>
      <td>
        <label class="obligatorio">*</label><label for="id_cp_sepomex">Asentamiento</label>
      </td>          
      <td colspan="3" id="asen_sepomex">
        <select  id="id_cp_sepomex" name="id_cp_sepomex">
            <option value=''>Seleccione Asentamiento</option>
                    <?php foreach($asentamiento as $a):             
                        if($a['id'] == $centro_atencion['id_cp_sepomex']){
                            $selected = "selected";
                        }else{
                            $selected = "";
                        }
                    ?>
            <option value='<?php echo $a['id'] ?>' <?php echo $selected;?> > <?php echo $a['d_asenta'];?></option>
                    <?php endforeach; ?>
            </select>
      </td>
    </tr>

      <tr>
          <td>
            <label for="telefono">Tel&eacute;fono</label>
          </td>         
          <td>
             <input type = 'text' id = 'telefono' name = 'telefono' class="tel_casa" value="<?php echo $centro_atencion['telefono']; ?>" />
          </td>
      </tr>      
       <tr>
      <td>
        <label class="obligatorio">*</label><label for="id_tipo_atencion">Tipo Del Centro</label>
     </td>
     <td>
        <select  id="id_tipo_centro" name="id_tipo_centro">

                    <option value=''>Seleccione tipo de atenci&oacute;n</option>

                    <?php foreach($tipo_atencion as $ta): 



                        if($ta['id'] == $centro_atencion['tipo_centro']){

                            $selected = "selected";

                        }else{

                            $selected = "";

                        }

                    ?>                

                    <option value='<?php echo $ta['id'] ?>' <?php echo $selected;?> > <?php echo $ta['tipo'];?></option>

                    <?php endforeach; ?>

                </select>
        </td> 
      </tr>
        <tr>
      <?php if($id_edicion > 0) { ?>

       
            <td>
                <label for="activo">Estatus</label>
            </td>
            <td>
                <select id="activo" name="activo">
                    <option value="">Seleccione</option>
                    <?php foreach($estatus as $e){                         
                        if($e['valor'] == $centro_atencion['activo']){
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
	</form>