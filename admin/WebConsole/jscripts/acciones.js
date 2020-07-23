// *************************************************************************************************************************************************
// Libreria de scripts de Javascript
// Autor: José Manuel Alonso (E.T.S.I.I.) Universidad de Sevilla
// Fecha Creación: 2009-2010
// Fecha Última modificación: Agosto-2010
// Nombre del fichero: acciones.js
// Descripción : 
//		Este fichero implementa las funciones javascript del fichero acciones.php
// *************************************************************************************************************************************************
//________________________________________________________________________________________________________
//	
//	Ejecuta una tarea
//________________________________________________________________________________________________________

function ejecutar_tareas(op)
{

	reset_contextual(-1,-1); // Oculta menu contextual
	var resul=window.confirm(TbMsg[0]);
	if (!resul) return;
	var idtarea=currentNodo.toma_identificador(); // identificador del ambito
	var tarea=currentNodo.toma_infonodo(); // Nombre de la tarea

	/* LLamada a la gestión */
	var wurl="../gestores/gestor_ejecutaracciones.php";
	var prm="opcion="+op+"&idtarea="+idtarea+"&descritarea="+tarea;

	CallPage(wurl,prm,"retornoGestion","POST");
}
//______________________________________________________________________________________________________

function retornoGestion(resul)
{
	//alert(resul)
	if(resul.length>0)
		eval(resul);
}
//________________________________________________________________________________________________________
//	
//	Devuelve el resultado de ejecutar una tarea
//	Parámetros:
//			- resul: resultado de la operación( true si tuvo éxito)
//			- descrierror: Descripción del error en su caso
//________________________________________________________________________________________________________

function resultado_ejecutar_tareas(resul,descrierror)
{
	if (!resul){ // Ha habido algún error en la ejecución
		alert(descrierror);
		return
	}
	alert(TbMsg[2])
}
//________________________________________________________________________________________________________
//	
//		Muestra formulario de programaciones para tareas y trabajos 
//________________________________________________________________________________________________________

function programacion(tipoaccion)
{
	reset_contextual(-1,-1);
	var identificador=currentNodo.toma_identificador();
	var descripcion=currentNodo.toma_infonodo();
	var whref;
	switch(tipoaccion){
		case EJECUCION_COMANDO:
			whref="../varios/programaciones.php?idcomando="+identificador+"&descripcioncomando="+descripcion+"&tipoaccion="+EJECUCION_COMANDO;
			break;
		case EJECUCION_TAREA:
			whref="../varios/programaciones.php?idtarea="+identificador+"&descripciontarea="+descripcion+"&tipoaccion="+EJECUCION_TAREA;
			break;
	}
	window.open(whref,"frame_contenidos")
}
//________________________________________________________________________________________________________
//	
//	Muestra información de procedimientos y tareas
//________________________________________________________________________________________________________

function informacion_acciones(tipo)
{
	reset_contextual(-1,-1);
	var identificador=currentNodo.toma_identificador();
	var descripcionaccion=currentNodo.toma_infonodo();
	var whref="../varios/informacion_acciones.php?idtipoaccion="+identificador+"&descripcionaccion="+descripcionaccion+"&tipoaccion="+tipo;
	window.open(whref,"frame_contenidos")
}
//________________________________________________________________________________________________________
//	
//	Muestra el formulario de Menús disponibles para gestionar la inclusión de procedimientos, tareas o trabajos en ellos 
//________________________________________________________________________________________________________

function insertar_accionmenu(tipo)
{
	reset_contextual(-1,-1);
	var identificador=currentNodo.toma_identificador();
	var descripcionaccion=currentNodo.toma_infonodo();
	var whref="../varios/accionmenu.php?idtipoaccion="+identificador+"&descripcionaccion="+descripcionaccion+"&tipoaccion="+tipo;
	window.open(whref,"frame_contenidos")
}
//________________________________________________________________________________________________________

function inclusion_acciones(tipo)
{
	reset_contextual(-1,-1);
	var identificador=currentNodo.toma_identificador();
	var descripcionaccion=currentNodo.toma_infonodo();
	var ambito=currentNodo.toma_atributoNodo("value");
	var whref="../varios/inclusionacciones.php";
	whref+="?idtipoaccion="+identificador+"&descripcionaccion="+descripcionaccion+"&tipoaccion="+tipo+"&ambito="+ambito;
	window.open(whref,"frame_contenidos")
}

$(function() {
    // Ejecutar tarea
    $("[id^='execute']").on ('click', function() {
        var resul=window.confirm(TbMsg[0]);
        if (!resul) return;

        var id=$(this).parent().attr('id').split("_");
        var description=$('#nodo-'+id[1]+'_'+id[2]).find('a').text().trim();
        var url="../gestores/gestor_ejecutaracciones.php";
        var param="opcion="+actionType(id[1])+"&idtarea="+id[2]+"&descritarea="+description;

        /* LLamada a la gestión */
        CallPage(url,param,"retornoGestion","POST");
    });

    $("[id^='manageMenu']").on ('click', function() {
        var id=$(this).parent().attr('id').split("_");
        var description=$('#nodo-'+id[1]+'_'+id[2]).find('a').text().trim();
        var url="../varios/accionmenu.php?idtipoaccion="+id[2]+"&descripcionaccion="+description+"&tipoaccion="+actionType(id[1]);

        console.log("id:" +url);
        window.open(url,"frame_contenidos")
    });

    $("[id^='program']").on ('click', function() {
        var id=$(this).parent().attr('id').split("_");
        var description=$('#nodo-'+id[1]+'_'+id[2]).find('a').text().trim();
        var url="../varios/programaciones.php";
        switch(id[1]){
            case '50':
                // comando
                url+="?idcomando="+id[2]+"&descripcioncomando="+description+"&tipoaccion="+actionType(id[1]);
                break;
            case '52':
                // tarea
                url+="?idtarea="+id[2]+"&descripciontarea="+description+"&tipoaccion="+actionType(id[1]);
                break;
        }
        console.log("id:" +url);
        window.open(url,"frame_contenidos")
    });

    // Devuelve el tipo de acción según el identificador del grupo
    // procedimiento 51, tarea 52.  AMBITO_GRUPOS en constantes.php
    function actionType(id){
        switch(id){
            case '50':
                // id comando provisional
                return EJECUCION_COMANDO;
                break;
            case '51':
                return EJECUCION_PROCEDIMIENTO;
                break;
            case '52':
                return EJECUCION_TAREA;
                break;
        }

    }
});
