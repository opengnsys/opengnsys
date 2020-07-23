/**
 * @file includes/arbol.js
 * Funciones para mostrar y ocultar el menú contextual del frame izquierdo.
 *
 * @note Nomenclatura menú:
 *         Inicial menu-tipo-N , menu-grupo-N, menu-N.
 *         mostrar_menu le incluye el identificador del elemento después de un subrayado:
 *             menu-tipo-N_M , menu-grupo-N_M, menu-N_M
 *         ocultar_menu vuelve a su nombre original.
 */


/*
 * Los tipos de objetos tiene asociados una serie de identificadores y constantes que no coinciden enten sí.
 *      mysql tabla grupos: 		ej: procedimientos campo tipo 51
 *      constantes php			ej: procedimientos $AMBITO_GRUPOSPROCEDIMIENTOS=0x33;
 *      constantes js			ej: procedimientos var AMBITO_GRUPOSPROCEDIMIENTOS=0x32;
 */

/**
 * Hace visible el menú elegido
 *
 * @param[event]   Evento del ratón para determinar posición del menú
 * @param[tipo]    int identificador del tipo de nodo
 * @param[id]      int identificador del elemento
 * @param[menu_id] str Identificador del menú en la página
 */
function mostrar_menu(event, tipo, id, menu_id) {
	//console.log("mostrar_menu");
   var posX, posY, span; // Declaracion de variables

   posX = event.pageX; // Obtenemos pocision X del cursor
   posY = event.pageY; // Obtenemos pocision Y del cursor

   // Flecha que indica submenues
   //span = $('#' + menu_id + " span");
   //span.html("»");

   // Editando el codigo CSS para ciertos elementos

   $('#' + menu_id).css({position: 'absolute',display: 'block',top: posY,left: posX,cursor: 'default',width: '200px',height: 'auto',padding: '2px 9px 2px 2px',listStyle: 'none',listStyleType: 'none'});
$('#' + menu_id + " li ul").css({listStyle:'none',listStyleType:'none',cursor:'default',position:'absolute',left:'212px',marginTop:'-20px',width:'200px',height:'auto',padding:'2px 9px 2px 2px'});
   //$('#' + menu_id).css({position: 'absolute',display: 'block',top: posY,left: posX,cursor: 'default',height: 'auto',padding: '2px 9px 2px 2px',listStyle: 'none',listStyleType: 'none'});
   //$('#' + menu_id + " li ul").css({listStyle:'none',listStyleType:'none',cursor:'default',position:'absolute',left:'212px',marginTop:'-20px',height:'auto',padding:'2px 9px 2px 2px'});

         //console.log($('#' + menu_id));
  // Incluyo el tipo de imagen y el id en el ientificador
  $('#' + menu_id ).attr("id", menu_id + "_" + tipo + "_" + id);

         //console.log($('#' + menu_id+ "_" + tipo + "_" + id));
  }

/**
 * Oculta todos los menús o los de comando, sincronizadas y aistentes 
 *
 * @param[tipo_menu]    str [ comandos| ""] 
 * @note La página aulas tiene dos niveles de menús, el del elemento y el de comandos.
 */
function ocultar_menu(tipo_menu="") {
            //console.log("ocultar menu");
	var menus = "";
	if (tipo_menu == 'comandos'){
            menus += "[id|='menu-comandos']"+",";
            menus += "[id|='menu-sincronizadas']"+",";
            menus += "[id|='menu-asistentes']";
	} else {
	    menus += "[id|='menu']";
	}
   	$(menus).hide();
	$(menus).each(function(){
	    old_id = $(this).attr('id')+"_";
	    $(this).attr('id',old_id.substring(0,old_id.indexOf('_')));
	});
}

$(function() {
    // Mostrar información del menú
    $("[id^='showInfoNode']").on ('click', function() {
        // Id menu-node-tipoNodo_tipoNodo_idNodo
        var id=$(this).parent().attr('id').split("_");
        var description=$('#nodo-'+id[1]+'_'+id[2]).find('a').text().trim();
	    console.log("tipo: "+id[1]+" nodo; "+id[2]);
	// url según tipo de nodo
	switch(id[1]) {
            case '56':
                // hardware
		var url="../varios/informacion_perfileshardware.php?idperfil="+id[2]+"&descripcionperfil="+description;
                break;
            case '64':
                // menus
                var url="../varios/informacion_menus.php?idmenu="+id[2]+"&descripcionmenu="+description;
                break;
            case '57':
                // perfil de software
                var url="../varios/informacion_perfilessoftware.php?idperfil="+id[2]+"&descripcionperfil="+description;
                break;
            case '51':
                // procedimientos
                var tipoaccion=33; // constantes.php AMBITO_GRUPOSPROCEDIMIENTOS
                var url="../varios/informacion_acciones.php?idtipoaccion="+id[2]+"&descripcionaccion="+description+"&tipoaccion="+tipoaccion;
                break;
            case '65':
                // repositorios
                var url="../varios/informacion_repositorios.php?idrepositorio="+id[2]+"&descripcionrepositorio='"+description+"'";
                break;
            case '52':
                // tareas
                var tipoaccion=34; // constantes.php AMBITO_GRUPOSTAREAS
                var url="../varios/informacion_acciones.php?idtipoaccion="+id[2]+"&descripcionaccion="+description+"&tipoaccion="+tipoaccion;
                break;
	    default:
		console.log("case default");
                break;
	}
        console.log("id:" +url);
        window.open(url,"frame_contenidos")
    });

    // Getionar nodo
    $("[id^='manageNode']").on ('click', function() {
        // Id menu-node-tipoNodo_tipoNodo_idNodo
        var id=$(this).parent().attr('id').split("_");
        var description=$('#nodo-'+id[1]+'_'+id[2]).find('a').text().trim();
	    console.log("tipo: "+id[1]+" nodo; "+id[2]);
	// url según tipo de nodo
	switch(id[1]) {
            case '56':
                // hardware
                var url="../varios/perfilcomponente_hard.php?idperfilhard="+id[2]+"&descripcionperfil="+description;
                break;
            case '64':
                // menus
                var url="../varios/accionmenu.php?idmenu="+id[2]+"&descripcionmenu="+description;
                break;
            case '57':
                // perfil de software
                var url="../varios/perfilcomponente_soft.php?idperfilsoft="+id[2]+"&descripcionperfil="+description;
                break;
            case '51':
                // procedimientos
                var tipoaccion=33; // constantes.php AMBITO_GRUPOSPROCEDIMIENTOS
                var url="../varios/inclusionacciones.php?idtipoaccion="+id[2]+"&descripcionaccion="+description+"&tipoaccion="+tipoaccion;
                break;
            case '52':
                // tareas
                var tipoaccion=34; // constantes.php AMBITO_GRUPOSTAREAS
                var url="../varios/inclusionacciones.php?idtipoaccion="+id[2]+"&descripcionaccion="+description+"&tipoaccion="+tipoaccion;
                break;
	    default:
		console.log("case default");
                break;
	}
        console.log("id:" +url);
        window.open(url,"frame_contenidos")
   });

});
