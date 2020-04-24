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

/**
 * Hace visible el menú elegido
 *
 * @param[event]   Evento del ratón para determinar posición del menú
 * @param[tipo]    int identificador del tipo de nodo
 * @param[id]      int identificador del elemento
 * @param[menu_id] str Identificador del menú en la página
 */
function mostrar_menu(event, tipo, id, menu_id) {
	console.log("mostrar_menu");
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


         console.log($('#' + menu_id));
  // Incluyo el tipo de imagen y el id en el ientificador
  $('#' + menu_id ).attr("id", menu_id + "_" + tipo + "_" + id);

         console.log($('#' + menu_id+ "_" + tipo + "_" + id));
         //console.log( $('#' + menu_id ).css("display")); No definido
  }

/**
 * Oculta todos los menús o los de comando, sincronizadas y aistentes 
 *
 * @param[tipo_menu]    str [ comandos| ""] 
 * @note La página aulas tiene dos niveles de menús, el del elemento y el de comandos.
 */
function ocultar_menu(tipo_menu="") {
            console.log("ocultar menu");
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
