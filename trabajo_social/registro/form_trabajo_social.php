<?php
session_start();
//Elimniamos carrito en caso de existir
unset($_SESSION['arrayCarro']);
//Cargamos libreria permiso
include_once($_SESSION['inc_path'].'libs/Permiso.php');
include_once($_SESSION['inc_path'].'libs/Fechas.php');
include_once($_SESSION['model_path'].'cp_sepomex.php');  
include_once($_SESSION['model_path'].'vialidad.php');  
include_once($_SESSION['model_path'].'aspirantes.php');  
include_once($_SESSION['model_path'].'trab_exp_beneficiario.php');  
include_once($_SESSION['model_path'].'trab_pys_exp.php'); 
include_once($_SESSION['model_path'].'trab_expediente.php');  
include_once($_SESSION['model_path'].'producto_servicio.php');
include_once($_SESSION['model_path'].'apoyo_otorgado.php');

//Obtenemos los estatus
$estatus = $db->get('estatus');

//Obtenemos los tipos de apoyo
$tipo_apoyo = $db->get('trab_tipo_apoyo_solicitado');

//Obtemos los estados
$sql = 'SELECT CVE_ENT, NOM_ENT from cat_estado';
$estado = $db->query($sql);
array_pop($estado);

//Obtenemos municipios (predeterminado los de jalisco)
$sql='SELECT CVE_MUN, NOM_MUN FROM cat_municipio WHERE CVE_ENT = 14';
$municipio_nacimiento = $db->query($sql);

//Obtenemos los códigos postales
//$codigo = $db->get('codigos_postales');
$sql = 'SELECT d_codigo from cp_sepomex where c_estado = 14 GROUP BY d_codigo';
$codigo = $db->query($sql);

//Municipios de residencia tendrán los de Jalisco
$municipios_residencia = $municipio_nacimiento;

//Llenamos arreglos
$axo_padron = Permiso::axosPadron();
$meses = Fechas::meses();

//Obtenemos Arreglos
$sql = 'SELECT id, nombre from trab_instancia ';
$lista_instancia = $db->query($sql);
$lista_condicion = array('SEGUIMIENTO','CERRADO','ABIERTO');
$sql = 'SELECT id, codigo, nombre from trab_problematica ';
$lista_problematica = $db->query($sql);
$sql = 'SELECT id, nombre from trab_enfermedad ';
$lista_enfermedad = $db->query($sql);
$sql = 'SELECT id, nombre from trab_tipo_discapacidad ';
$lista_discapacidad = $db->query($sql);
$sql = 'SELECT id, nombre from trab_tipo_apoyo_solicitado ';
$lista_apoyo = $db->query($sql);
$sql = 'SELECT id, nombre from trab_motivo_cierre ';
$lista_cierre = $db->query($sql);
$sql = 'SELECT id, nombre from trab_atencion_medica ';
$lista_medica = $db->query($sql);

//Si editamos el registro bloqueamos el campo de año y mes
$disabled = null;

 //Obtenemos listado de beneficiarios

      //Si es beneficiario, mostramos los programas que puede seleccionar        

  //Obtemos los productos y servicios de Trabajo Social
  $programa = Producto_servicio::listaPys(null,null,18); 


//Si editamos el registro
if(intval($id_edicion)>0 || intval($id_aspirante)>0){
    
    //Arreglos donde guardaremos los datos
    $aspirantes = array();
    $trab_expediente = array();
    
    if($id_edicion > 0){
      $disabled = 'disabled';  
    }
     
    //Obtenemos información del expediente (de existir)    
    if($id_edicion > 0){
      $db->where('id',$id_edicion);
      $trab_expediente = $db->get_first('trab_expediente'); 
      $id_producto_servicio = $trab_expediente['id_producto_servicio'];

      //Obtenemos información referente al trabajo 
      $db->where('id_producto_servicio',$id_producto_servicio)
         ->where('id_trab_expediente',$id_edicion)
         ->where('activo',1);
      $trab_pys_exp = $db->getOne('trab_pys_exp');

      //Obtenemos información referente al trabajo 
      $db->where('id_trab_expediente',$id_edicion);
      $listaPys = $db->get('trab_pys_exp');
      
      /*
      echo 'trab_pys_exp: ';
      print_r($trab_pys_exp);
      */
      
      /*
      echo '<br>listaPys: ';
      print_r($listaPys);
      */

      $id_beneficiario = $trab_expediente['id_beneficiario'];
      $id_aspirante = $trab_expediente['id_aspirante'];
    }
     
    //Obtenemos información del aspirante (de existir)
    if($id_aspirante){
      $db->where('id',$id_aspirante);
      $aspirantes = $db->get_first('aspirantes');
      $id_beneficiario = $aspirantes['id_beneficiario'];       
    }    
        
    //Datos para llenar formulario y editarlos
    $CVE_EDO_RES = $aspirantes['CVE_EDO_RES'];
    $CVE_TIPO_VIAL = $aspirantes['CVE_TIPO_VIAL'];
    $id_cat_estado = $aspirantes['id_cat_estado'];
    $id_cat_municipio = $aspirantes['id_cat_municipio'];
    $id_cat_localidad = $aspirantes['id_cat_localidad'];
    $CVE_EST_MUN_LOC = $aspirantes['CVE_EST_MUN_LOC'];
    $CODIGO = $aspirantes['CODIGO'];
    $CVE_VIA = $aspirantes['CVE_VIA'];
    
    //Obtenemos municipio de nacimiento
    if($id_cat_estado && $id_cat_estado != 14){
        $sql = 'SELECT CVE_MUN, NOM_MUN FROM `cat_municipio` where CVE_ENT = ?';
        $params = array($id_cat_estado);
        $municipio_nacimiento = $db->rawQuery($sql,$params);
    }

    //Obtenemos localidad
    if($CVE_EDO_RES && $id_cat_municipio){
        $sql = 'SELECT CVE_LOC, NOM_LOC FROM `cat_localidad` where CVE_ENT_MUN = ?';
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
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?>combobox.js"></script>

<form id='formtb' method="post" action='save_trabajo_social.php'>
<fieldset class="expediente">
    <div>
      <legend>
         <label>
            Expediente Trabajo Social
           
         </label>
      </legend>       
      <?php if($id_beneficiario){ ?>
      
        <div>
          <label class="obligatorio">*</label>
          <label for="id_producto_servicio">Programas de Trabajo Social</label>
          <select  id="id_producto_servicio" class="condicion" name="id_producto_servicio" >
            <option value=''>Seleccione Programa</option>
            <?php foreach($programa as $p): ?>
              <option value='<?php echo $p['id'] ?>' <?php echo ($p['id'] == $trab_pys_exp['id_producto_servicio'])? 'selected': '' ;?> > 
                  <?php echo $p['codigo_producto'].'-'.$p['nombre'];?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
       
      
        <div>
          <label class="obligatorio">*</label>
          <label for="justificacion">Justificaci&oacute;n</label>          
          <textarea id='justificacion' name = 'justificacion' cols="50" rows="5">
            <?php echo $trab_pys_exp['justificacion']; ?>
          </textarea>
        </div> 
       
      <?php } ?>
          
        <div>
          <label class="obligatorio">*</label>
          <label for="id_tipo_apoyo_solicitado">Apoyo Requerido por Aspirante/Beneficiario</label>

          <select  id="id_tipo_apoyo_solicitado" name="id_tipo_apoyo_solicitado" class="datos_aspirante">
            <option value=''>Seleccione Apoyo Solicitado</option>
            <?php foreach($tipo_apoyo as $t): 
              $selected = ($t['id'] == $trab_expediente['id_tipo_apoyo_solicitado'])? 'selected' : ''; ?>  
              <option value='<?php echo $t['id'] ?>' <?php echo $selected;?> > <?php echo $t['nombre'];?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div>
          <label class="obligatorio">*</label>
          <label for="mes">Mes</label>
          <select id="mes" name="mes" <?php echo $disabled ?> >
              <option value=''>Seleccione Mes</option>
              <?php foreach ($meses as $key => $value): ?>
              <option value='<?php echo $key?>' <?php echo ($key == $trab_expediente['mes'])? 'selected' : '';?> >
                <?php echo $value?>
              </option>
              <?php endforeach; ?> 
           </select>
           <?php if ($disabled != null) { ?>
          <input type="hidden" id='mes' name="mes" value="<?php echo $trab_expediente['mes'];?>" />  
          <?php } ?>
        </div>
         <div>
           <label class="obligatorio">*</label>
           <label for="ano">A&ntilde;o</label> 
           <select id="axo_padron" name="axo_padron" <?php echo $disabled ?>>
              <option value=''>Seleccione A&ntilde;o</option>
              <?php foreach ($axo_padron as $key => $value): ?>                                                               
                <option value='<?php echo $value?>' <?php echo ($value == $trab_expediente['axo'])? 'selected':'' ;?> >
                  <?php echo $value?>
                </option>
                <?php endforeach; ?>    
           </select>
           <?php if ($disabled != null) { ?>
           <input type="hidden" id='axo_padron' name="axo_padron" value="<?php echo $trab_expediente['axo'];?>" />  
           <?php } ?>
         </div>                         
    </div>
</fieldset>

<?php   
  //En caso de tener un expediente
  if($id_trab_expediente > 0){

      //Obtenemos listado de beneficiario(s) ligados al expediente
      list($lista,$p) = Trab_pys_exp::listadoHistorial($id_trab_expediente);

      //Mostramos listado historico de programas
      include ($_SESSION['inc_path'] . "trabajo_social/listado_trabajos_exp.php");

  }
?>

<fieldset  class="datos_registro">
    <div>
      <legend>
        <label>Datos de Registro</label>  
      </legend>
	
      <div>
          <label class="obligatorio">*</label>
          <label for="fecha_recibido">Fecha Recibido</label>
      </div>
       <div>
          <label class="obligatorio">*</label>
          <label for="fecha_registro">Fecha Registro</label>
      </div>
      <div>
          <?php if(isset($trab_expediente['numero_expediente'])){?>
          <label for="numero_expediente">
            N&uacute;mero expediente:<?php echo $trab_expediente['numero_expediente']; ?>
          </label>
          <?php } ?>            
      </div>
      
      
       <div>
            <input type="hidden" id='id_beneficiario' name="id_beneficiario" value="<?php echo $id_beneficiario;?>" />      
            <input type="hidden" id="id_aspirante" name="id_aspirante" value="<?php echo $id_aspirante;?>" />      
            <input type="hidden" id="id_edicion" name="id_edicion" value="<?php echo $id_edicion; ?>" />
            <input type='text' id = 'fecha_recibido' class="fecha" name = 'fecha_recibido'value="<?php echo $trab_expediente['fecha_recibido']; ?>" />
            <input type="button"  value="Hoy" id="btnToday"  />
       </div>
       <div>
            <input type = 'text' id = 'fecha_registro' class="fecha" name = 'fecha_registro'value="<?php echo $trab_expediente['fecha_registro']; ?>" />
            <input type="button"  value="Hoy" id="btnToday1"  />
       </div>
      
   
   
     <div>
     <?php if($id_beneficiario == NULL){?>
       <input type="checkbox" id = "valido" name="valido" value="SI"<?php echo( ($trab_expediente['valido'] == 'SI')? 'checked': null); ?>/> <label for="valido">En Proceso De Validaci&oacute;n</label> <br/>
      <?php } ?>
     </div>
   
   	</div>
 </fieldset>
 
   <?php if($id_beneficiario == NULL){?>
  <fieldset class="datos_identificacion">

    <div id="aspirantes_duplicados"></div>
    <div id="beneficiarios_duplicados"></div>
    <div>
        <legend><label>Datos de identificaci&oacute;n del aspirante</label></legend>

        <div>
          <label class="obligatorio">*</label><label for="nombres">Nombre(s)</label>
          <input type = 'text' id = 'nombres' name = 'nombres' class="cambia_asp" value="<?php echo $aspirantes['nombres']; ?>" />
        </div>

        <div>
          <label for="paterno">Apellido Paterno</label>
          <input type = 'text' id = 'paterno' name = 'paterno' class="cambia_asp" value="<?php echo $aspirantes['paterno']; ?>" />
        </div>

        <div>
          <label for="materno">Apellido Materno</label>
          <input type = 'text' id = 'materno' name = 'materno' class="cambia_asp" value="<?php echo $aspirantes['materno']; ?>" />
        </div>

        <div>
          <label for="CVE_EDO_RES">Estado de Residencia</label>
          <select id="CVE_EDO_RES" name="CVE_EDO_RES" class="datos_aspirante">
            <option value=''>Seleccione Estado</option>
            <?php foreach($estado as $est): 

              $selected = ($est['CVE_ENT'] == $aspirantes['CVE_EDO_RES'] )? 'selected' : ''; 
            ?>
            <option value='<?php echo $est['CVE_ENT'] ?>' <?php echo $selected;?> >
            <?php echo $est['NOM_ENT'];?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>
        
        <div>
          <label for="id_cat_municipio">Municipio de Residencia</label>
        </div>
        <div id="municipio">
        <select class="combobox datos_aspirante" id="id_cat_municipio" name="id_cat_municipio">
          <option value=''>Seleccione Municipio</option>
          <?php foreach($municipios_residencia as $mu):
            $selected = ($mu['CVE_MUN'] == $aspirantes['id_cat_municipio'])? 'selected' :'';?>                

                    <option value='<?php echo $mu['CVE_MUN'] ?>' <?php echo $selected;?> > 
                        <?php echo $mu['NOM_MUN'];?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
          <label class="obligatorio">*</label><label for="genero">Sexo</label>
          <input type="radio" id='MUJER' name="genero" value="MUJER" class="datos_aspirante"
          <?php echo (($aspirantes['genero']=='MUJER')?'checked':null);?> />MUJER<br />
          <input type="radio" id='HOMBRE' name="genero" value="HOMBRE" class="datos_aspirante"
          <?php echo (($aspirantes['genero']=='HOMBRE')?'checked':null);?> />HOMBRE<br />
        </div>
      
        <div>
          <label for="id_cat_localidad">Localidad</label>
        </div>    
        <div id="localidad">
        <select class="combobox datos_aspirante" id="id_cat_localidad" name="id_cat_localidad">
            <option value=''>Seleccione Localidad</option>
            <?php foreach($localidad as $lo): 

            $selected = ($lo['CVE_LOC'] == $aspirantes['id_cat_localidad'])? 'selected': '' ;?>                

                    <option value='<?php echo $lo['CVE_LOC'] ?>' <?php echo $selected;?> > 
                        <?php echo $lo['NOM_LOC'];?>
                    </option>
            <?php endforeach; ?>
        </select>
        </div> 
    
    
        <div>
          <label for="CVE_TIPO_VIAL">Tipo De Vialidad </label>        
        </div>
        <div id="tipo_vialidad">
            <select class="combobox datos_aspirante domicilio" id="CVE_TIPO_VIAL" name="CVE_TIPO_VIAL">
                <option value=''>Seleccione Tipo de Vialidad</option>
                <?php foreach($tipo_via as $tp): // print_r($tp); //exit;?>                                    
                    <option value='<?php echo $tp['CVE_TIPO_VIAL'] ?>' <?php echo ($tp['CVE_TIPO_VIAL'] == $tipo_vialidad['CVE_TIPO_VIAL'])? 'selected' : '';?> > 
                    <?php echo $tp['DESCRIPCION'];?>
                    </option>
                <?php endforeach; ?>
            </select>
         </div>
         <div>       
            <label for="CVE_VIA">Vialidad</label>
         </div>
         <div id="agrega_link_via" class="new_via"></div>
         <div id="vialidad">
             <select class="combobox datos_aspirante domicilio oculta_select" id="CVE_VIA" name="CVE_VIA">
                <option value=''>Seleccione Vialidad</option>
                <?php foreach($vialidad_calle as $v):?>                
                      <option value='<?php echo $v['CVE_VIA'] ?>' <?php echo ($v['CVE_VIA'] == $aspirantes['CVE_VIA'])? 'selected' : '';?> > 
                      <?php echo $v['NOM_VIA'];?>
                      </option>
                <?php endforeach; ?>
             </select>
         </div> 

         <div id="nueva_vialidad" class="new_via"></div>
      
         <div>
            <label for="num_ext">N&uacute;mero exterior</label>
            <input type = 'text' class="digits datos_aspirante domicilio" id = 'num_ext' name = 'num_ext' class="nomnum" value="<?php echo $aspirantes['num_ext']; ?>" />
         </div>
         <div>
            <label for="num_int">N&uacute;mero interior</label>
            <input type = 'text' id = 'num_int' name = 'num_int' class="nomnum datos_aspirante"value="<?php echo $aspirantes['num_int']; ?>" />
         </div>       
    
         <div id="domicilio_duplicado"></div>
         <div id="domicilio_beneficiario"></div>
    
         <div>        
            <label for="CODIGO">C&oacute;digo Postal</label>
         </div>
         <div id="cp">
            <select class="combobox datos_aspirante oculta_select" id="CODIGO" name="CODIGO">
            <option value=''>Seleccione C&oacute;digo Postal</option>
            <?php foreach($codigo as $c):
            $selected = ($c['d_codigo'] == $aspirantes['CODIGO'])? "selected":''; ?>                
            <option value='<?php echo $c['d_codigo'] ?>' <?php echo $selected;?> > <?php echo $c['d_codigo'];?></option>
            <?php endforeach; ?>
            </select>
         </div>

         <div>
            <label for="id_cp_sepomex">Asentamiento</label>
         </div>

         <div id="asen_sepomex">
            <select  id="id_cp_sepomex" name="id_cp_sepomex" class="datos_aspirante">
            <option value=''>Seleccione Asentamiento</option>
            <?php foreach($asentamiento as $a): 
              $selected = ($a['id'] == $aspirantes['id_cp_sepomex'])? 'selected' : ''; ?>  
              <option value='<?php echo $a['id'] ?>' <?php echo $selected;?> > <?php echo $a['d_asenta'];?></option>
            <?php endforeach; ?>
            </select>
         </div>        
            
          <?php if(intval($id_aspirante)>0 && $id_beneficiario == NULL){?>
          <div class="cuadroInfo">        
          <label>
            &Eacute;sta persona a&uacute;n no ha sido registrada como beneficiario de DIF Jalisco 
          porque est&aacute; en proceso de validaci&oacute;n. Una vez que haya sido validado, 
          haga 
          <a href=" <?php echo $_SESSION['app_path_p']; ?>beneficiario/registro/edita_beneficiario.php?id_aspirante=<?php echo $id_aspirante;?>&id_edicion_exp=<?php echo $id_edicion?>" 
              class="botonEnlace">Clic aqu&iacute;</a> 
          para darlo de alta y registrar sus productos o servicios.        
          </label>        
          </div>

        <?php } ?>
    
     </div>
  </fieldset>
 <?php }else if($id_beneficiario){

  //Obtenemos listado de beneficiario(s) ligados al expediente
  list($lista,$p) = Trab_expediente::listaExpBeneficiario($id_beneficiario);

 include ($_SESSION['inc_path'] . "trabajo_social/lista_beneficiario_exp.php");
 }

 ?>
 <?php 
 //Búsqueda de beneficiarios para ligar al expediente
 if($id_beneficiario){ ?>
  <fieldset class="busqueda">
    <div>
      <legend>
        <label>Buscar beneficiarios del padr&oacute;n &uacute;nico</label>  
      </legend>      
      
        <div>
          <label for="b_nombre">Nombre(s)</label>
          <input type = 'text' id = 'b_nombres' name = 'b_nombres' class="nombre"/>
        </div>
        <div>
          <label for="b_paterno">Apellido Paterno</label>
          <input type = 'text' id = 'b_paterno' name = 'b_paterno' class="nombre"/>
        </div>
        <div>
          <label for="b_materno">Apellido Materno</label>
          <input type = 'text' id = 'b_materno' name = 'b_materno' class="nombre"/>
        </div>
        <div>
          <label for="b_curp">CURP</label>
          <input type = 'text' id = 'b_curp' name = 'b_curp' class="nom_num"/>
        </div>
      
        <div>
          <input type="button" id="busca_beneficiario"  value="Buscar" />
        </div>
    </div>
  </fieldset>

  <div id="lista_agregados">
      <?php 
      
      //Obtenemos listado de beneficiario(s) ligados al expediente      
      list($lista,$p) = Trab_exp_beneficiario::listaBeneficarios($trab_expediente['id']);
  
      include ($_SESSION['inc_path'] . "trabajo_social/listado_beneficiario_exp.php");

      ?>
  </div>
  <div id="busqueda_ben"></div>
  <div id="listado_ben"></div>

<?php } ?>

<?php if($id_beneficiario){ ?>
  <fieldset class="expediente_particular">
    <legend>
      <label>Expediente Trabajo Social Particular</label>  
    </legend>     
      
    <div id="agregar_programa"> 
        <div>
          <label class="obligatorio">*</label>
          <label for="numero_documento">N&uacute;mero de Documento</label>
          <input type = 'text' id = 'numero_documento' name = 'numero_documento' class="digits condicion"  value="<?php echo $trab_expediente['numero_documento']; ?>"/>
        </div>      
        <div>
          <label class="obligatorio">*</label>
          <label for="id_instancia">Instancia</label>
          <select  id="id_instancia" class="condicion" name="id_instancia">
            <option value=''>Seleccione Instancia</option>
            <?php foreach($lista_instancia as $l): ?>
              <option value='<?php echo $l['id'] ?>' <?php echo ($l['id'] == $trab_expediente['id_instancia'])? 'selected': '' ;?> > 
                  <?php echo $l['nombre'];?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>              
                       
        <div>
          <label class="obligatorio">*</label>
          <label for="id_problematica">Problem&aacute;tica</label>
          <select  id="id_problematica" class="condicion"  name="id_problematica">
            <option value=''>Seleccione Problem&aacute;tica</option>
            <?php foreach($lista_problematica as $l): ?>
              <option value='<?php echo $l['id'] ?>' <?php echo ($l['id'] == $trab_expediente['id_problematica'])? 'selected': '' ;?> > 
                  <?php echo $l['nombre'];?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div>
          <label class="obligatorio">*</label>
          <label for="id_enfermedad">Enfermedad</label>
          <select  id="id_enfermedad" name="id_enfermedad" class="condicion">
            <option value=''>Seleccione Enfermedad</option>
            <?php foreach($lista_enfermedad as $l): ?>
              <option value='<?php echo $l['id'] ?>' <?php echo ($l['id'] == $trab_expediente['id_enfermedad'])? 'selected': '' ;?> > 
                  <?php echo $l['nombre'];?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>     
      
        <div>          
          <label for="id_motivo_cierre">Motivo de Cierre</label>
          <select  id="id_motivo_cierre"  name="id_motivo_cierre" >
            <option value=''>Seleccione Motivo de Cierre</option>
            <?php foreach($lista_cierre as $l): ?>
              <option value='<?php echo $l['id'] ?>' <?php echo ($l['id'] == $trab_expediente['id_motivo_cierre'])? 'selected': '' ;?> > 
                  <?php echo $l['nombre'];?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div>
          <label class="obligatorio">*</label>
          <label for="id_atencion_medica">Atenci&oacute;n M&eacute;dica</label>
          <select  id="id_atencion_medica" class="condicion" name="id_atencion_medica" >
            <option value=''>Seleccione Atenci&oacute;n M&eacute;dica</option>
            <?php foreach($lista_medica as $l): ?>
              <option value='<?php echo $l['id'] ?>' <?php echo ($l['id'] == $trab_expediente['id_atencion_medica'])? 'selected': '' ;?> > 
                <?php echo $l['nombre'];?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>        
                                  
        <div><label for="observacion_cierre">Observaci&oacute;n Cierre</label>          
          <textarea id='observacion_cierre' name = 'observacion_cierre' cols="50" rows="5">
            <?php echo $trab_expediente['observacion_cierre']; ?>
          </textarea>
          </div> 
      
               
        <div>
          <label class="obligatorio">*</label>
          <label for="id_tipo_apoyo">Tipo de Apoyo</label>          
          <select  id="id_tipo_apoyo" class="condicion" name="id_tipo_apoyo" >
            <option value=''>Seleccione Tipo de Apoyo</option>
            <?php foreach($lista_apoyo as $p): ?>
              <option value='<?php echo $p['id'] ?>' <?php echo ($p['id'] == $trab_expediente['id_tipo_apoyo'])? 'selected': '' ;?> > 
                  <?php echo $p['nombre'];?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>        
      

      
        <div>
          <label class="obligatorio">*</label>
          <label for="id_tipo_discapacidad">Tipo Discapacidad</label>
          <select  id="id_tipo_discapacidad" class="condicion" name="id_tipo_discapacidad">
            <option value=''>Seleccione Tipo Discapacidad</option>
            <?php foreach($lista_discapacidad as $l): ?>
              <option value='<?php echo $l['id'] ?>' <?php echo ($l['id'] == $trab_expediente['id_tipo_discapacidad'])? 'selected': '' ;?> > 
                  <?php echo $l['nombre'];?>
              </option>
            <?php endforeach; ?>
          </select>
        </div> 
        <div>
          <label class="obligatorio">*</label>
          <label for="condicion">Condici&oacute;n</label> 
          <?php if($id_edicion > 0) { ?>           
          <select  id="condicion" name="condicion">
            <option value=''>Seleccione Condici&oacute;n</option>
            <?php foreach($lista_condicion as $value): ?>
              <option value='<?php echo $value ?>' <?php echo ($value == $trab_expediente['condicion'])? 'selected': '' ;?> > 
                  <?php echo $value;?>
              </option>
            <?php endforeach; ?>
          </select>
        <?php } ?>     
        </div>       
                
       <?php } ?>

      </div>      

      <div>
      <?php if($id_edicion > 0) { ?>       
            <div>
                <label for="activo">Estatus</label>
                <select id="activo" name="activo" class="">
                    <option value="">Seleccione</option>
                    <?php foreach($estatus as $e){                         
                        if($e['valor'] == $trab_expediente['activo']){
                            $selected = "selected";
                        }else{
                            $selected = "";
                        }
                    ?>                
                    <option value='<?php echo $e['valor'] ?>' <?php echo $selected;?> > <?php echo $e['nombre'];?></option>
                    <?php } ?>
                </select>
            </div>
       <?php } ?>
      </div>

 </fieldset>

 <div><input type = 'submit'  id = 'enviar' value = 'Enviar' /></div>		      
    
</form>