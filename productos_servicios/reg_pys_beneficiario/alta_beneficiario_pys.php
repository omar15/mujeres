<?php
session_start();//Habilitamos uso de variables de sesión

//Incluimos cabecera
include('../../inc/header.php');

//Incluimos modelos a usar
include_once($_SESSION['model_path'].'beneficiario.php');
include_once($_SESSION['model_path'].'beneficiario_pys.php');

//Variable de respuesta
$respuesta = intval($_GET['r']);

//Mensaje respuesta
$mensaje = Permiso::mensajeRespuesta($respuesta);

//Valores de la búsqueda
$tipo_filtro=$_GET['tipo_filtro'];
$busqueda=$_GET['busqueda'];
$respuesta=$_GET['r'];
$id_dif=$_GET['id_dif'];

list($lista,$p) = Beneficiario::listaProgBeneficiario($busqueda,$tipo_filtro);      
  
 
?>
<div id="principal">
   <div id="contenido">
   
   
    <h2 class="centro">Alta de Beneficiario Productos y Servicios</h2>
    
    <?php if($respuesta > 0){?>
    
    <div class="mensaje"><?php echo $mensaje;?></div>
    
    <?php } ?>
    <div class="centro">       
        <div  align="center">
            <form id='formbusqueda' method="get" action='alta_beneficiario_pys.php'>        
            <table>
            <tr>
                <td class="centro" colspan="6">
                <label>B&uacute;squeda de Beneficiario</label>
                </td>                
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
            <td><label for="tipo_filtro"> Buscar Por: </label></td>
            <td>
                <select id="tipo_filtro" name="tipo_filtro">
                <option value="nombre">Nombre</option> 
                <option value="curp">CURP</option>
                </select>
            </td>
            <td><label for="busqueda"> Palabra Clave</label></td>
            <td><input type = 'text' id = 'busqueda' name = 'busqueda'/><td>&nbsp;</td>
            <td><input type="submit" id="boton"  value="Buscar" /></td></td>            
            </tr>
            </table>            
            </form>
            <?php 
            //Verificamos si tiene permiso de alta de beneficiario
            if(Permiso::accesoAccion('alta_beneficiario', 'registro', 'beneficiario')){ ?>                
            
            <table>
                <tr>
                    <td>
                    <form action="../../beneficiario/registro/alta_beneficiario.php">
                        <input type="submit" id="agregar"  value="Agregar Nuevo Beneficiario" />
                    </form>
                    </td>
                </tr>
            </table>

            <?php } ?>                           
        </div>
    
    <div>
    <?php 
    if($lista == NULL && $tipo_filtro != NULL){?>
    <div class="mensaje">
        No se encontraron resultados con el criterio de b&uacute;squeda seleccionado
    </div>
    <?php } elseif($lista !=null){
                
      include_once("lista_beneficiario_serv.php");
             
    }?>
    </div>
    
   </div>
            
    
	
    
    </div>
</div>

<?php 
//Incluimos pie
include($_SESSION['inc_path'].'/footer.php');
?>