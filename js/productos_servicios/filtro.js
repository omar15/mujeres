jQuery(document).ready(function ($) {

    //Filtra componentes (programas)
    $(document).on("change","#id_componente", function () {

    id_beneficiario = $('#id_beneficiario').val();    

        if(id_beneficiario > 0){

         $("select[name='id_componente'] option:selected").each(function () {

		      id_componente = $(this).attr("value");

            var parametros = {		  
            'id_componente' : id_componente,
            'id_beneficiario' : id_beneficiario
            }

            frmAjax(parametros,'pys','filtra_programa');            

		    })

        }else{
            alert('Seleccione un beneficiario para verificar sus servicios');
        }    		

	});

  //Tabla de productos y servicios seleccionados
  $(document).on("change","#id_producto_servicio", function () {

    $("select[name='id_producto_servicio'] option:selected").each(function () {

        id_producto_servicio = $(this).attr("value");
        id_beneficiario = $('#id_beneficiario').val();

        var parametros = {      
            'id_producto_servicio' : id_producto_servicio,
            'accion': 'agregar',
            'id_beneficiario': id_beneficiario
            }

        //alert(parametros.toSource());

        frmAjax(parametros,'servicios','servicios_beneficiario');

    })

  });  

    //Eliminamos elementos del "carrito" de Artículos
    $(document).on("click","#elimina_art", function () {

        id_producto_servicio = $(this).attr("name");

        var parametros = {
          "id_producto_servicio" : id_producto_servicio,
          'accion': 'eliminar'
        };

        frmAjax(parametros,'servicios','servicios_beneficiario');

    });

    //Actualizamos listado de productos y servicios del beneficiario
    $(document).on("submit","#formBen_pys", function (e){ 

        //alert('aquí');        

        //Obtenemos id del beneficiario
        id_beneficiario = $('#id_beneficiario').val();
        id_componente = $('#id_componente').val();
        observaciones = $('#observaciones').val();

        //Arreglo de fechas
        var arreglo_fechas = $('.fecha').map(function () {
          return this.value;
          }).get();        

        //Armamos lista de parámetros
        var parametros = {            
          'id_beneficiario' : id_beneficiario,
          'id_componente' : id_componente,
          'observaciones' : observaciones,
          'ajax' : 'ajax',          
          'arreglo_fechas' : JSON.stringify(arreglo_fechas)
        };

        //Ruta para guardar los servicios
        var ruta_guarda = '../../productos_servicios/reg_pys_beneficiario/';

        //Guardamos los servicios
        frmAjax(parametros,'page_list','save_beneficiario_pys','POST',ruta_guarda);

        //Actualizamos lista de productos y servicios
        frmAjax(parametros,'page_list','lista_pys');

        //Ocultamos carrito
        $('#servicios').html('');   

        e.preventDefault();
    });

  //Form Ajax Genérico
   function frmAjax(parametros,div,accion,tipo,ruta,selector){       

       //Valores predeterminados
       ruta = typeof ruta !== 'undefined' ? ruta : '../../inc/productos_servicios/';
       tipo = typeof tipo !== 'undefined' ? tipo : 'POST';
       selector = typeof selector !== 'undefined' ? selector : '#';

       //alert(selector+div);
       $.ajax({
               type: tipo,
               url: ruta+accion+".php",
               data: parametros,
                  beforeSend: function(){
                   $(selector+div).html('<img src="../../css/img/loader_sug.gif"/>Buscando');
                   //alert(parametros.tipo+' before');
               },
               success: function( respuesta ){
                       $(selector+div).html(respuesta);    
                   //alert(parametros.tipo+' success');                
                  },
               error: function(){
                   $(selector+div).html(' ');
               }                
       });
   }

  //Filtra localidad
  $(document).on("change","#id_cat_municipio", function () {

    //alert('hola');  
    var CVE_EDO_RES = $("#CVE_EDO_RES").val();

    $("select[name='id_cat_municipio'] option:selected").each(function () {
      id_cat_municipio = $(this).attr("value");

      var parametros = {
      'id_cat_municipio' : id_cat_municipio,
      'CVE_EDO_RES' : CVE_EDO_RES
      }

      //Localidad
      frmAjax(parametros,'localidad','filtra_localidad');

      });

  });

//FILTRA PROGRAMA_GENERAL
  $(document).on("change","#cod_programa_g",function(){

//var CVE_EDO_RES = $("#CVE_EDO_RES").val();

  $("select[name='cod_programa_g'] option:selected").each(function () {

    cod_programa_g = $(this).attr("value");

    var parametros={
      'cod_programa_g' : cod_programa_g
      //'CVE_EDO_RES' : CVE_EDO_RES
    }

    //Localidad
    frmAjax(parametros,'pys_g','filtra_programa_g');

    })

});

});    