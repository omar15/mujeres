<?php
session_start();

//Arreglos para los select
$municipio_nacimiento = array();
$municipios_residencia = array();
$localidad = array();
$asentamiento = array();
$vialidad = array();
$vialidad_calle_1 = array();
$vialidad_calle_2 = array();
$vialidad_posterior = array();
$estatus = $db->get('estatus');

include_once($_SESSION['model_path'].'aspirantes.php');  
include_once($_SESSION['model_path'].'cp_sepomex.php');  
include_once($_SESSION['model_path'].'vialidad.php');  

//Obtemos los estados
$sql = 'SELECT CVE_ENT, NOM_ENT from cat_estado';
$estado = $db->query($sql);
array_pop($estado);

//Obtemos los estados de nacimiento
$sql = 'SELECT CVE_ENT, NOM_ENT from cat_estado';     
$estado_nacimiento = $db->query($sql);

//Obtemos los tipos de vialidad
$sql = 'SELECT CVE_TIPO_VIAL, DESCRIPCION from cat_vialidad';
$tipo_via = $db->query($sql);

//Obtenemos municipios (predeterminado los de jalisco)
$sql='SELECT CVE_MUN, NOM_MUN FROM cat_municipio WHERE CVE_ENT = 14';
$municipio_nacimiento = $db->query($sql);

//Municipios de residencia tendrán los de Jalisco
$municipios_residencia = $municipio_nacimiento;

//Obtemos escolaridad
$escolaridad = $db->get('escolaridad');

//Obtemos la ocupación
$ocupacion = $db->get('ocupacion');

//Obtenemos estado civil
$estado_civil = $db->get('estado_civil');

//Si editamos el registro
if(intval($id_edicion)>0 || intval($id_aspirante)>0){

    if($id_edicion>0){
        //Obtenemos el registro del usuario
        $db->where('id',$id_edicion);
        $beneficiario = $db->get_first('beneficiario');

    }elseif($id_aspirante>0){
        //Obtenemos información precargada del aspirante
        $beneficiario = Aspirantes::infoPrecargada($id_aspirante);
    }

    $CVE_EDO_RES = $beneficiario['CVE_EDO_RES'];
    $id_cat_municipio = $beneficiario['id_cat_municipio'];
    $id_cat_localidad = $beneficiario['id_cat_localidad'];
    $id_cat_estado = $beneficiario['id_cat_estado'];
    $CODIGO = $beneficiario['CODIGO'];
    $CVE_TIPO_VIAL = $beneficiario['CVE_TIPO_VIAL'];
    $CVE_TIPO_VIAL_CALLE1 = $beneficiario['CVE_TIPO_VIAL_CALLE1'];
    $CVE_TIPO_VIAL_CALLE2 = $beneficiario['CVE_TIPO_VIAL_CALLE2'];
    $CVE_TIPO_VIAL_CALLEP = $beneficiario['CVE_TIPO_VIAL_CALLEP'];
    $CVE_EST_MUN_LOC = $beneficiario['CVE_EST_MUN_LOC'];
    $CVE_VIA = $beneficiario['CVE_VIA'];
    $entre_calle1 = $beneficiario['entre_calle1'];
    $entre_calle2 = $beneficiario['entre_calle2'];
    $calle_posterior = $beneficiario['calle_posterior'];

    //$municipios_residencia
    if($CVE_EDO_RES && $CVE_EDO_RES != 14){
        
        $sql = 'SELECT CVE_MUN, NOM_MUN FROM `cat_municipio` where CVE_ENT = ?';
        $params = array($CVE_EDO_RES);
        $municipios_residencia = $db->rawQuery($sql,$params);
    }

    //$municipios_nacimiento
    if($id_cat_estado && $id_cat_estado != 14){
        $sql = 'SELECT CVE_MUN, NOM_MUN FROM `cat_municipio` where CVE_ENT = ?';
        $params = array($id_cat_estado);
        $municipio_nacimiento = $db->rawQuery($sql,$params);
    }

    //Localidad
    if($CVE_EDO_RES && $id_cat_municipio){
        $sql = 'SELECT CVE_LOC, NOM_LOC FROM `cat_localidad` where cve_ent_mun = ?';
        $params = array($CVE_EDO_RES.$id_cat_municipio);
        $localidad = $db->rawQuery($sql,$params);
    }   

    //Obtenemos vialidades
    if($CVE_TIPO_VIAL){

        $tipo_via =  Vialidad::listaTipoVialidades($CVE_EST_MUN_LOC);
        $vialidad = Vialidad::listaVialidades($CVE_EST_MUN_LOC,$CVE_TIPO_VIAL);

        //Obtenemos el tipo vialidad (y sus vialidades) de la vialidad principal        
        $tipo_vialidad=Vialidad::obtenerVia($CVE_VIA);
        $vialidad_calle = Vialidad::listaVialidades($CVE_EST_MUN_LOC,$CVE_TIPO_VIAL);

        //Obtenemos el tipo vialidad (y sus vialidades) de calle1        
        $tipo_vialidad_calle1= Vialidad::obtenerVia($entre_calle1);
        $vialidad_calle_1 = Vialidad::listaVialidades($CVE_EST_MUN_LOC,$CVE_TIPO_VIAL_CALLE1);

        //Obtenemos el tipo vialidad (y sus vialidades) de calle2        
        $tipo_vialidad_calle2= Vialidad::obtenerVia($entre_calle2);
        $vialidad_calle_2 = Vialidad::listaVialidades($CVE_EST_MUN_LOC,$CVE_TIPO_VIAL_CALLE2);

        //Obtenemos el tipo vialidad (y sus vialidades) de calle posterior        
        $tipo_vialidad_calle_posterior= Vialidad::obtenerVia($calle_posterior);
        $vialidad_posterior = Vialidad::listaVialidades($CVE_EST_MUN_LOC,$CVE_TIPO_VIAL_CALLEP);
        
        //Obtenemos asentamiento de Sepomex
        if($CODIGO){
            $asentamiento = Cp_sepomex::listaVialidades($CODIGO);
        }

    }        
	
}
    //Obtenemos los códigos postales
    //$codigo = $db->get('codigos_postales');
    $sql = 'SELECT d_codigo from cp_sepomex where c_estado = 14 GROUP BY d_codigo';
    $codigo = $db->query($sql);

    //Obtemos los paises
    $sql = 'SELECT id, nombre, clave from pais ORDER BY nombre ASC';
    $pais = $db->query($sql);
?>

<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?>jquery.maskedinput.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?><?php echo $_SESSION['module_name']?>/filtro.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?><?php echo $_SESSION['module_name']?>/valida.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?>combobox.js"></script>

<form id='formBen' method="post" action='<?php echo $_SESSION["app_path_p"]; ?>beneficiario/registro/save_beneficiario.php'>
<tr>
 <td>
   <label class="obligatorio">Le recordamos que los campos con asterisco (*) son campos obligatorios</label>
 </td>
</tr>

<fieldset>
<table>
 <legend>
   <label>Datos de identificaci&oacute;n del Beneficiario</label>  
 </legend>
    <tr>
        <td>
            <label class="obligatorio">*</label> <label for="nombres">Nombre(s)</label>
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
            <input type="hidden" name="id_beneficiario" value="<?php echo $beneficiario['id']; ?>" />
            <input type="hidden" name="id_aspirante" value="<?php echo $id_aspirante; ?>" />
            <input type="hidden" name="id_edicion_exp" value="<?php echo $id_edicion_exp; ?>" />
            <input type="hidden" name="es_curp_generada" value="<?php echo ($beneficiario['es_curp_generada'] == NULL)?'NO':$beneficiario['es_curp_generada']; ?>" />   
            <input type = 'text' id = 'nombres' name = 'nombres' class="nombre arma_curp" value="<?php echo $beneficiario['nombres']; ?>" />
        </td>
        <td>
            <input type = 'text' id = 'paterno' name = 'paterno' class="nombre arma_curp" value="<?php echo $beneficiario['paterno']; ?>" />
        </td>
        <td>
            <input type = 'text' id = 'materno' name = 'materno' class="nombre arma_curp" value="<?php echo $beneficiario['materno']; ?>" />
        </td>
    </tr>

    <tr>
        <td>
            <label class="obligatorio">*</label>
            <label for="CVE_EDO_RES">Estado de Residencia</label>
        </td>

        <td>
            <label class="obligatorio">*</label>
            <label for="id_cat_municipio">Municipio de Residencia</label>
        </td>
    </tr>

    <tr>
        <td>
            <select id="CVE_EDO_RES" name="CVE_EDO_RES">
                <option value=''>Seleccione Estado</option>
                    <?php foreach($estado as $est): 

                       $selected = ($est['CVE_ENT'] == $beneficiario['CVE_EDO_RES'] )? 'selected' : ''; 
                    ?>
                    <option value='<?php echo $est['CVE_ENT'] ?>' <?php echo $selected;?> > 
                        <?php echo $est['NOM_ENT'];?>
                    </option>
                    <?php endforeach; ?>
            </select>
        </td>
        <td colspan="2" id="municipio">

            <select class="combobox" id="id_cat_municipio" name="id_cat_municipio">
                <option value=''>Seleccione Municipio</option>
                    <?php foreach($municipios_residencia as $mu):
                        
                        $selected = ($mu['CVE_MUN'] == $beneficiario['id_cat_municipio'])? 'selected' :'';?>                

                    <option value='<?php echo $mu['CVE_MUN'] ?>' <?php echo $selected;?> > 
                        <?php echo $mu['NOM_MUN'];?>
                    </option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>
    <tr>
      <td>
        <label class="obligatorio">*</label>
        <label for="id_cat_localidad">Localidad</label>
       </td>
    </tr>

    <tr>
      <td  colspan="2"id="localidad">
        <select class="combobox" id="id_cat_localidad" name="id_cat_localidad">
            <option value=''>Seleccione Localidad</option>
            <?php foreach($localidad as $lo): 

            $selected = ($lo['CVE_LOC'] == $beneficiario['id_cat_localidad'])? 'selected': '' ;?>                

                    <option value='<?php echo $lo['CVE_LOC'] ?>' <?php echo $selected;?> > 
                        <?php echo $lo['NOM_LOC'];?>
                    </option>
            <?php endforeach; ?>
        </select>
        </td> 
    </tr>

    <!--
    <tr>
        <tr>
            <td>&nbsp;</td>
            <td id="agrega_link_via" class="new_via"></td>
        </tr>
        <tr>
            <td colspan="3" id="nueva_vialidad" class="new_via"></td>
        </tr>
    </tr>    
    -->

   <tr>
      <td>
        <label class="obligatorio">*</label>
        <label for="CVE_TIPO_VIAL">Tipo De Vialidad </label>        
      </td>
      <td colspan="2">
        <label class="obligatorio">*</label>
        <label for="CVE_VIA">Vialidad</label>
      </td>
      <td id="agrega_link_via" class="new_via"></td>
    </tr>

    <tr>
       <td id="tipo_vialidad">
          <select class="combobox" id="CVE_TIPO_VIAL" name="CVE_TIPO_VIAL">
              <option value=''>Seleccione Tipo de Vialidad</option>
              <?php foreach($tipo_via as $tp): // print_r($tp); //exit;?>                                    
                  <option value='<?php echo $tp['CVE_TIPO_VIAL'] ?>' <?php echo ($tp['CVE_TIPO_VIAL'] == $tipo_vialidad['CVE_TIPO_VIAL'])? 'selected' : '';?> > 
                  <?php echo $tp['DESCRIPCION'];?>
                  </option>
              <?php endforeach; ?>
          </select>
       </td>
       <td colspan="2" id="vialidad">
           <select class="combobox" id="CVE_VIA" name="CVE_VIA">
              <option value=''>Seleccione Vialidad</option>
              <?php foreach($vialidad_calle as $v):?>                
                    <option value='<?php echo $v['CVE_VIA'] ?>' <?php echo ($v['CVE_VIA'] == $beneficiario['CVE_VIA'])? 'selected' : '';?> > 
                    <?php echo $v['NOM_VIA'];?>
                    </option>
              <?php endforeach; ?>
           </select>
        </td> 
    </tr>    

    <tr>
        <td colspan="4" id="nueva_vialidad" class="new_via"></td>
    </tr>

    <tr>
        <td>
            <label class="obligatorio">*</label>
            <label for="num_ext">N&uacute;mero exterior</label>
        </td>
        <td>
            <label for="num_int">N&uacute;mero interior</label>
        </td>
    </tr>

    <tr>
        <td>
            <input type = 'text' class="digits" id = 'num_ext' name = 'num_ext' class="nomnum"value="<?php echo $beneficiario['num_ext']; ?>" />
        </td>
        <td>
            <input type = 'text' id = 'num_int' name = 'num_int' class="nomnum"value="<?php echo $beneficiario['num_int']; ?>" />
        </td>
    </tr>

    <tr>
        <td>
            <label class="obligatorio">ENTRE CALLES:</label>
        </td>
    </tr>

    <tr>
        <td>
            <label for="CVE_TIPO_VIAL_CALLE1">Tipo De Vialidad </label>
        </td>
        <td>
            <label for="entre_calle1">Entre Vialidad</label>
        </td>
        <td id="agrega_link_calle1" class="new_via"></td>
    </tr>

    <tr>
        <td id="tipo_vialidad_calle1" class="filtra_municipio_tipo_vialidad">
            <select  id="CVE_TIPO_VIAL_CALLE1" name="CVE_TIPO_VIAL_CALLE1">
                <option value=''>Seleccione Tipo de vialidad</option>
            <?php foreach($tipo_via as $tp):?>                                      
                <option value='<?php echo $tp['CVE_TIPO_VIAL'] ?>' <?php echo ($tp['CVE_TIPO_VIAL'] == $tipo_vialidad_calle1['CVE_TIPO_VIAL'])? 'selected' : '';?> > 
                <?php echo $tp['DESCRIPCION'];?>
                </option> 
            <?php endforeach; ?>
            </select>
        </td>
        <td id="calle1">
            <select class="combobox" id="entre_calle1" name="entre_calle1">
                <option value=''>Seleccione entre qu&eacute; Vialidad</option>
                <?php foreach($vialidad_calle_1 as $v):?>
                <option value='<?php echo $v['CVE_VIA'] ?>' <?php echo ($v['CVE_VIA'] == $beneficiario['entre_calle1'])? 'selected' : '';?> > 
                <?php echo $v['NOM_VIA'];?>
                </option>
                <?php endforeach;?>
            </select>
        </td>
    </tr>

    <tr>
        <td colspan="4" id="nueva_calle1" class="new_via"></td>
    </tr>

    <tr>
        <td>
            <label for="CVE_TIPO_VIA_CALLE2">Tipo De Vialidad </label>
        </td>
        <td>
            <label for="entre_calle2">y Vialidad</label>
        </td>
        <td id="agrega_link_calle2" class="new_via"></td>
    </tr>

    <tr>
        <td id="tipo_vialidad_calle2" class="filtra_municipio_tipo_vialidad">
            <select  id="CVE_TIPO_VIAL_CALLE2" name="CVE_TIPO_VIAL_CALLE2">
                <option value=''>Seleccione Tipo de Vialidad</option>
                <?php foreach($tipo_via as $tp): ?>
                <option value='<?php echo $tp['CVE_TIPO_VIAL'] ?>' <?php echo ($tp['CVE_TIPO_VIAL'] == $tipo_vialidad_calle2['CVE_TIPO_VIAL'])? 'selected' : '';?> > 
                <?php echo $tp['DESCRIPCION'];?>
                </option>
                <?php endforeach; ?>
            </select>
        </td>
        <td id="calle2">
            <select class="combobox" id="entre_calle2" name="entre_calle2">
                <option value=''>Seleccione la otra Vialidad</option>
                <?php foreach($vialidad_calle_2 as $v):?>                
                <option value='<?php echo $v['CVE_VIA'] ?>' <?php echo ($v['CVE_VIA'] == $beneficiario['entre_calle2'])? 'selected' : '';?> > 
                <?php echo $v['NOM_VIA'];?>
                </option>
                <?php endforeach; ?>                                   
            </select>
        </td>
    </tr>

    <tr>
        <td colspan="4" id="nueva_calle2" class="new_via"></td>
    </tr>

  <tr>
        <td colspan="4" id="nueva_posterior" class="new_via"></td>
    </tr>

    <tr>
      <td>
        <label class="obligatorio">*</label>
        <label for="CODIGO">C&oacute;digo Postal</label>
      </td>
      <td>
        <label class="obligatorio">*</label>
        <label for="id_cp_sepomex">Asentamiento</label>
      </td>
    </tr>

    <tr>
        <td id="cp">
            <select class="combobox" id="CODIGO" name="CODIGO">
                <option value=''>Seleccione C&oacute;digo Postal</option>
                <?php foreach($codigo as $c):
                $selected = ($c['d_codigo'] == $beneficiario['CODIGO'])? "selected":''; ?>                
                <option value='<?php echo $c['d_codigo'] ?>' <?php echo $selected;?> > <?php echo $c['d_codigo'];?></option>
                <?php endforeach; ?>
            </select>
        </td>
        <td colspan="3" id="asen_sepomex">
            <select  id="id_cp_sepomex" name="id_cp_sepomex">
                <option value=''>Seleccione Asentamiento</option>
                <?php foreach($asentamiento as $a): 
                $selected = ($a['id'] == $beneficiario['id_cp_sepomex'])? 'selected' : ''; ?>  
                <option value='<?php echo $a['id'] ?>' <?php echo $selected;?> > <?php echo $a['d_asenta'];?></option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>

    <tr>
        <td>
            <label for="desc_ubicacion">Descripci&oacute;n Ubicaci&oacute;n</label>
        </td>      
    </tr>

    <tr>
      <td>
        <textarea id='desc_ubicacion' name = 'desc_ubicacion' class="nomnum" cols="50" rows="5">
        <?php echo $beneficiario['desc_ubicacion'];?>
        </textarea>
      </td>
    </tr>

    <tr>
       <td>
            <label class="obligatorio">*</label>
            <label for="estado_civil">Estado Civil</label>
      </td>
      <td>
            <label for="correo">Correo</label>
      </td>
      <td>
            <label for="telefono">Tel&eacute;fono</label>
      </td>
    </tr>

    <tr>
      <td>
        <select id="estado_civil" name="id_estado_civil">
            <option value=''>Seleccione Estado Civil</option>
                <?php foreach($estado_civil as $ec): 
                $selected = ($ec['id'] == $beneficiario['id_estado_civil'])? 'selected': '';?>
                <option value='<?php echo $ec['id'] ?>' <?php echo $selected;?> > 
                <?php echo $ec['nombre'];?>
                </option>
                <?php endforeach; ?>
            </select>
      </td>
      <td>
          <input style="text-transform: none;" type = 'text' id = 'correo' name = 'correo' class="email" value="<?php echo $beneficiario['correo']; ?>" />
      </td>
      <td>
          <input type = 'text' id = 'telefono' name = 'telefono' class="tel_casa" value="<?php echo $beneficiario['telefono']; ?>" />
      </td>
    </tr>

    <tr>
      <td>
        <label for="tutor">Nombre del Tutor</label>
      </td>
    </tr>

    <tr>
        <td>
            <input type = 'text' id = 'tutor' name = 'tutor' class="nombre texto_largo" value="<?php echo $beneficiario['tutor']; ?>" />
        </td>        
    </tr>    

    </table>
    </fieldset>

    <fieldset>
    <table>
      <legend>
        <label>Datos de Nacimiento y Acreditaci&oacute;n de Identidad del Beneficiario</label>  
      </legend>
    <tr>
        <td>
            <label class="obligatorio">*</label>
            <label for="fecha_nacimiento">Fecha Nacimiento</label>
        </td>
        <td>
            <label class="obligatorio">*</label>
            <label for="fecha_aproxim">&iquest;Es Fecha Aproximada?</label>            
        </td>
        <td>
            <label class="obligatorio">*</label>
            <label for="genero">Sexo</label>
        </td>
     </tr>
    <tr> 
        <td>
            <input type = 'text' id = 'fecha_nacimiento' class="fecha date arma_curp" name = 'fecha_nacimiento'value="<?php echo $beneficiario['fecha_nacimiento']; ?>" />
            <input type="button"  value="Hoy" id="btnToday"  />
        </td>
        <td>
            <!--
            <select id="fecha_aproxim" name="fecha_aproxim">
                <option value="">Seleccione</option>
                    <option value="SI" <?php /* echo( ($beneficiario['fecha_aproxim'] == 'SI')? 'selected': null); ?> >
                        Es Aproximada
                    </option>
                    <option value="NO" <?php echo( ($beneficiario['fecha_aproxim'] == 'NO')? 'selected': null); */?> >
                        NO
                    </option>                    
            </select>
            -->
            <input type="checkbox" id = "fecha_aproxim" name="fecha_aproxim" value="SI"<?php echo( ($beneficiario['fecha_aproxim'] == 'SI')? 'checked': null); ?>/> Es fecha aproximada <br/>
        </td>
    <td>
        <!--
        <select id="genero" name="genero" class="arma_curp">
            <option value="">Seleccione</option>
            <option value="MUJER" <?php /*echo( ($beneficiario['genero'] == 'MUJER')? 'selected': null); ?> >MUJER</option>
            <option value="HOMBRE" <?php echo( ($beneficiario['genero'] == 'HOMBRE')? 'selected': null); */?> >HOMBRE</option>                    
         </select>  
        -->
         <input type="radio" id="MUJER" name="genero" class="arma_curp"  value="MUJER"<?php echo( ($beneficiario['genero'] == 'MUJER')? 'checked': null); ?>/>MUJER <br />
        <input type="radio" id="HOMBRE" name="genero" class="arma_curp" value="HOMBRE"<?php echo( ($beneficiario['genero'] == 'HOMBRE')? 'checked': null); ?>/>HOMBRE
    </td>

    <tr>
      <td>
        <label class="obligatorio">*</label>
        <label for="id_pais">Pa&iacute;s de Nacimiento</label>
      </td>
      <td>
        <label class="obligatorio">*</label>
        <label for="id_cat_estado">Estado de Nacimiento</label>
      </td>
    </tr>
    <tr>
      <td>
        <select class="combobox arma_curp" id="id_pais" name="id_pais">
            <option value=''>Seleccione Pa&iacute;s</option>
            <?php foreach($pais as $pa): 
            $selected = ($pa['id'] == $beneficiario['id_pais'])? 'selected':''; ?>
            <option value='<?php echo $pa['id'] ?>' <?php echo $selected;?> > 
                <?php echo $pa['nombre'];?>
            </option>
            <?php endforeach; ?>
        </select>
      </td>

      <td id="estado_origen">
        <select class="combobox arma_curp" id="id_cat_estado" name="id_cat_estado">
            <option value=''>Seleccione Estado</option>
            <?php foreach($estado_nacimiento as $est): 
            $selected = ($est['CVE_ENT'] == $beneficiario['id_cat_estado'] )? 'selected': ''; ?>
            <option value='<?php echo $est['CVE_ENT'] ?>' <?php echo $selected;?> > <?php echo $est['NOM_ENT'];?></option>
            <?php endforeach; ?>
            </select>
      </td>
    </tr>
    <tr>
      <td>
        <label class="obligatorio">*</label>
        <label for="id_cat_municipio">Municipio de Nacimiento</label>
      </td>
      <td>
        <label class="obligatorio">*</label>
        <label for="ciudadano_mex">&iquest;Es ciudadano mexicano?</label>
      </td>
    </tr>

    <tr>
        <td id="municipio_nacimiento">
        <select class="combobox arma_curp" id="id_municipio_nacimiento" name="id_municipio_nacimiento">
            <option value=''>Seleccione Municipio Nacimiento</option>
            <?php foreach($municipio_nacimiento as $mu):
            $selected = ($mu['CVE_MUN'] == $beneficiario['id_municipio_nacimiento'])? 'selected' : '';?>
            <option value='<?php echo $mu['CVE_MUN'] ?>' <?php echo $selected;?> > <?php echo $mu['NOM_MUN'];?></option>
            <?php endforeach; ?>
            </select>
        </td>

        <td>
        <!--
            <select id="ciudadano_mex" name="ciudadano_mex">
            <option value=''>Seleccione Opci&oacute;n</option>
            <option value="SI" <?php /* echo( ($beneficiario['ciudadano_mex'] == 'SI')? 'selected': null); ?> >Es ciudadano mexicano</option>
            <option value="NO" <?php echo( ($beneficiario['ciudadano_mex'] == 'NO')? 'selected': null); */?> >NO</option>                    
            </select>
        -->
            <input type="checkbox" id='ciudadano_mex' name="ciudadano_mex" value="SI"<?php  echo( ($beneficiario['ciudadano_mex'] == 'SI')? 'checked': null); ?>/> Es ciudadano M&eacute;xicano <br/>
        </td>
    </tr>

    <tr>
      <td>
       <label for="curp">
            <?php echo ($beneficiario['es_curp_generada'] == 'SI')? 'ID DIF': 'CURP'; ?>
       </label>
     </td>

      <td>
        <label for="ife">IFE</label>
     </td>

     <td>
       <label for="pasaporte">Pasaporte</label>
     </td>
    </tr>

    <tr>
      <td>
        <input type = 'text' id = 'curp' name = 'curp' class="curp" value="<?php echo $beneficiario['curp']; ?>" />
      </td>
      <td>
        <input type = 'text' id = 'ife' name = 'ife'value="<?php echo $beneficiario['ife']; ?>" />
      </td>
      <td>
        <input type = 'text' id = 'pasaporte' name = 'pasaporte' class="nomnum"value="<?php echo $beneficiario['pasaporte']; ?>" />
      </td>   
    </tr>

     <tr>
        <td>
        <a target="_blank" href="http://consultas.curp.gob.mx/CurpSP/">
            Si no conoces tu CURP dar click aqu&iacute;
        </a>
        </td>
     </tr>
    </table>
</fieldset>

<fieldset>
    <table>
    <legend>
        <label>Datos Generales del Beneficiario</label>
    </legend>

    <tr>
        <td>
            <label class="obligatorio">*</label>
            <label for="escolaridad">Escolaridad</label>
        </td>
        <td>
            <label class="obligatorio">*</label>
            <label for="ocupacion">Ocupaci&oacute;n</label>
        </td>

        <td>
            <label id="lab_homonimo" for="esHomonimo">Es Hom&oacute;nimo</label>
        </td>              
    </tr>    

    <tr>
      <td>
        <select id="escolaridad" name="id_escolaridad">
            <option value=''>Seleccione Escolaridad</option>
            <?php foreach($escolaridad as $esc):            

                $selected = ($esc['id'] == $beneficiario['id_escolaridad'])? "selected" : ""; ?>                
                <option value='<?php echo $esc['id'] ?>' <?php echo $selected;?> > 
                    <?php echo $esc['nombre'];?>
                </option>
            <?php endforeach; ?>
        </select>
      </td>
      <td>
        <select id="ocupacion" name="id_ocupacion">
            <option value=''>Seleccione Ocupaci&oacute;n</option>
            <?php foreach($ocupacion as $o): 
               $selected = ($o['id'] == $beneficiario['id_ocupacion'])? 'selected' : '';?>                
                    <option value='<?php echo $o['id'] ?>' <?php echo $selected;?> > <?php echo $o['nombre'];?></option>
            <?php endforeach; ?>
        </select>

      </td>

      <td>
        <select id='esHomonimo' name = 'esHomonimo'>
            <option value="">Seleccione Opci&oacute;n</option>
            <?php 
                //Si es homónimo ponemos select para verificar si es un homónimo
                if(Permiso::accesoAccion('guardar_homonimo', 'registro', $_SESSION['module_name'])){ ?>
                    <option value="NO">NO</option>
                    <option value="SI">Es Hom&oacute;nimo</option>
                <?php } ?>
        </select>
      </td>
    </tr>

    <tr>
        <td>
            <label class="obligatorio">*</label><label for="indigena">Ind&iacute;gena</label>
        </td>
        <td>
            <label for="comunidad_indigena">Comunidad Ind&iacute;gena</label>
        </td>
        <td>
            <label for="dialecto">Dialecto</label>
        </td>
    </tr>

    <tr>

     <td>
       <!--
       <select id="indigena" name="indigena">
            <option value="">Seleccione</option>
            <option value="SI" <?php /* echo( ($beneficiario['indigena'] == 'SI')? 'selected': null); ?> >SI</option>
            <option value="NO" <?php echo( ($beneficiario['indigena'] == 'NO')? 'selected': null); */?> >NO</option>
       </select>      
       -->
       <input id="indigena" type="checkbox" name="indigena" value="SI"<?php  echo( ($beneficiario['indigena'] == 'SI')? 'checked': null); ?>/> Es Indigena <br/>
    </td>

    <td id="comunidad">
       <?php if(intval($id_edicion > 0 && $beneficiario['indigena'] == 'SI')){  ?>
       <input type = 'text' id = 'comunidad_indigena' name = 'comunidad_indigena' class="nombre" value="<?php echo $beneficiario['comunidad_indigena']; ?>" />
       <?php }  ?>
    </td>

    <td id="dialecto">
        <?php if(intval($id_edicion > 0 && $beneficiario['indigena'] == 'SI')){  ?>
            <input type = 'text' id = 'dialecto' name ='dialecto' class="nombre"value="<?php echo $beneficiario['dialecto']; ?>" />
        <?php }  ?>
    </td>
  </tr>

    <?php if($id_edicion > 0) { ?>
    <tr>
      <td>
        <label for="activo">Estatus</label>
      </td>
    </tr>

    <tr>
     <td>
        <select id="activo" name="activo">
        <option value="">Seleccione</option>
        <?php foreach($estatus as $e): 
        $selected = ($e['valor'] === $beneficiario['activo'])? 'selected' : '' ;?>                
        <option value='<?php echo $e['valor'] ?>' <?php echo $selected;?> > 
        <?php echo $e['nombre'];?>
        </option>
        <?php endforeach; ?>
        </select>
     </td>
    </tr>

    <?php } ?>

    <tr>
        <td id="homonimo" colspan="4" >&nbsp;</td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td colspan="4">
            <input type="submit" value="Guardar" id="guardar" />
        </td>
    </tr>       

  <!-- 
   <tr>
        <td>
            <label for="CVE_ASEN">Asentamiento</label>
        </td>
        <td id="asentamiento">
            <select class="combobox" id="CVE_ASEN" name="CVE_ASEN">
                <option value=''>Seleccione Asentamiento</option>
                <?php /* foreach($asentamiento as $a): 

                   $selected = ($a['CVE_ASEN'] == $beneficiario['CVE_ASEN']) 'selected': ''; ?>                
                    <option value='<?php echo $a['CVE_ASEN'] ?>' <?php echo $selected;?> > 
                        <?php echo $a['nombre_asentamiento'];?>
                    </option>

                    <?php endforeach;*/ ?>

            </select>
        </td>
   </tr>
    -->

    </table>
    </fieldset>
</form>