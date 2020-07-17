<?php
// *************************************************************************************************************************************************
// Aplicación WEB: ogAdmWebCon
// Autor: José Manuel Alonso (E.T.S.I.I.) Universidad de Sevilla
// Fecha Creación: Año 2009-2010
// Fecha Última modificación: Agosto-2010
// Nombre del fichero: menus.php
// Descripción : 
//		Administra los menus de los clientes rembo de un determinado Centro
// *************************************************************************************************************************************************
include_once("../includes/ctrlacc.php");
include_once("../includes/arbol.php");
include_once("../clases/AdoPhp.php");
include_once("../clases/XmlPhp.php");
include_once("../clases/ArbolVistaXML.php");
include_once("../clases/MenuContextual.php");
include_once("../includes/constantes.php");
include_once("../includes/CreaComando.php");
include_once("../idiomas/php/".$idioma."/menus_".$idioma.".php");
//________________________________________________________________________________________________________
$cmd=CreaComando($cadenaconexion);
if (!$cmd)
	Header('Location: '.$pagerror.'?herror=2');  // Error de conexión con servidor B.D.
else
	$arbolXML=CreaArbol($cmd,$idcentro); // Crea el arbol XML con todos los datos del Centro
// Creación del árbol
$baseurlimg="../images/signos"; // Url de las imágenes de signo
$clasedefault="texto_arbol"; // Hoja de estilo (Clase por defecto) del árbol
$arbol=new ArbolVistaXML($arbolXML,0,$baseurlimg,$clasedefault,1,0,5);
//________________________________________________________________________________________________________
?>
<HTML>
<HEAD>
	<TITLE>Administración web de aulas</TITLE>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<LINK rel="stylesheet" type="text/css" href="../estilos.css">
	<SCRIPT language="javascript" src="../api/jquery.js"></SCRIPT>
	<SCRIPT language="javascript" src="../clases/jscripts/ArbolVistaXML.js"></SCRIPT>
	<SCRIPT language="javascript" src="../clases/jscripts/MenuContextual.js"></SCRIPT>
	<SCRIPT language="javascript" src="../jscripts/menus.js"></SCRIPT>
	<SCRIPT language="javascript" src="../jscripts/arbol.js"></SCRIPT>
	<SCRIPT language="javascript" src="../jscripts/opciones.js"></SCRIPT>
	<SCRIPT language="javascript" src="../jscripts/constantes.js"></SCRIPT>
	<SCRIPT language="javascript" src="../jscripts/comunes.js"></SCRIPT>
	<SCRIPT language="javascript" src="../clases/jscripts/HttpLib.js"></SCRIPT>
	<?php echo '<SCRIPT language="javascript" src="../idiomas/javascripts/'.$idioma.'/comunes_'.$idioma.'.js"></SCRIPT>'?>
	<?php echo '<SCRIPT language="javascript" src="../idiomas/javascripts/'.$idioma.'/menus_'.$idioma.'.js"></SCRIPT>'?>
</HEAD>
<BODY onclick="ocultar_menu();" OnContextMenu="return false">

<?php
//________________________________________________________________________________________________________
echo $arbol->CreaArbolVistaXML();	 // Crea árbol (HTML) a partir del XML
$flotante=new MenuContextual();			 // Crea objeto MenuContextual

// Crea contextual de los menus
$XMLcontextual=CreacontextualXMLMenus();
echo $flotante->CreaMenuContextual($XMLcontextual); 
$XMLcontextual=ContextualXMLGruposMenus(); // Grupos de menus
echo $flotante->CreaMenuContextual($XMLcontextual); 
$XMLcontextual=CreacontextualXMLMenu(); // Menús
echo $flotante->CreaMenuContextual($XMLcontextual); 

echo "<br><br>";
echo "<br><br>\n";
$nodos=nodos_arbol("menus");
$grupos=grupos_arbol("menus");

lista_raiz_arbol("software", $nodos, $grupos);
?>
<!-- Menús -->
<ul id="menu-type-64" name="menu-type-64" oncontextmenu="return false;">
  <li onclick="insertar_grupos(64,'gruposmenus')"><img class="menu-icono" src="../images/iconos/carpeta.gif"> Nuevo grupo de menús </li>
  <li id="insert-type-64"><img class="menu-icono" src="../images/iconos/menu.gif"> Definir nuevo menú </li>
  <li> <hr class="separador"> </li>
  <li onclick="colocar('../gestores/gestor_menus.php',40)"><img class="menu-icono" src="../images/iconos/colocar.gif"> Colocar menú </li>
</ul>

<ul id="menu-group-64" name="menu-group-64" oncontextmenu="return false;">
  <li onclick="insertar_grupos(64,'gruposmenus')"><img class="menu-icono" src="../images/iconos/carpeta.gif"> Nuevo grupo de menús </li>
  <li id="insert-group-64"><img class="menu-icono" src="../images/iconos/menu.gif"> Definir nuevo menú </li>
  <li> <hr class="separador"> </li>
  <li onclick="colocar('../gestores/gestor_menus.php',40)"><img class="menu-icono" src="../images/iconos/colocar.gif"> Colocar menú </li>
  <li> <hr class="separador"> </li>
  <li onclick="modificar_grupos()"><img class="menu-icono" src="../images/iconos/modificar.gif"> Propiedades </li>
  <li onclick="eliminar_grupos()"><img class="menu-icono" src="../images/iconos/eliminar.gif"> Eliminar grupo de menús </li>
</ul>

<ul id="menu-node-64" name="menu-node-64" oncontextmenu="return false;">
  <li id="manage-64"><img class="menu-icono" src="../images/iconos/comandos.gif"> Gestionar Items </li>
  <li id="showInfo-64"><img class="menu-icono" src="../images/iconos/informacion.gif"> Información Menú </li>
  <li> <hr class="separador"> </li>
  <li onclick="mover(id)"><img class="menu-icono" src="../images/iconos/mover.gif"> Mover menú </li>
  <li> <hr class="separador"> </li>
  <li id="modify-64"><img class="menu-icono" src="../images/iconos/propiedades.gif"> Propiedades </li>
  <li id="remove-64"><img class="menu-icono" src="../images/iconos/eliminar.gif"> Eliminar menú </li>
</ul>

</BODY>
</HTML>
<?php
// *************************************************************************************************************************************************
//	Devuelve una cadena con formato XML con toda la información de los menus iniciales de los clientes rembo de un Centro
//	Parametros: 
//		- cmd:Una comando ya operativo ( con conexión abierta)  
//		- idcentro: El identificador del centro
//________________________________________________________________________________________________________
function CreaArbol($cmd,$idcentro){
	global $TbMsg;
	global $LITAMBITO_MENUS;
	$cadenaXML='<MENUS';
	// Atributos
	$cadenaXML.=' imagenodo="../images/iconos/menus.gif"';
	$cadenaXML.=' infonodo='.$TbMsg[9];
	$cadenaXML.=' nodoid=Raiz'.$LITAMBITO_MENUS;
	$cadenaXML.=' clickcontextualnodo="menu_contextual(this,' ."'flo_Raiz".$LITAMBITO_MENUS."'".')"';
	$cadenaXML.='>';
	$cadenaXML.=SubarbolXML_grupos_menus($cmd,$idcentro,0);
	$cadenaXML.='</MENUS>';
	return($cadenaXML);
}
//________________________________________________________________________________________________________
function SubarbolXML_grupos_menus($cmd,$idcentro,$grupoid){
	global $LITAMBITO_GRUPOSMENUS;
	global $AMBITO_GRUPOSMENUS;
	$cadenaXML="";
	$rs=new Recordset; 
	$cmd->texto="SELECT idgrupo,nombregrupo,grupoid FROM grupos WHERE grupoid=".$grupoid." AND idcentro=".$idcentro." AND tipo=".$AMBITO_GRUPOSMENUS." ORDER BY nombregrupo";
	$rs->Comando=&$cmd; 
	if (!$rs->Abrir()) return($cadenaXML); // Error al abrir recordset
	$rs->Primero(); 
	while (!$rs->EOF){
		$cadenaXML.='<GRUPOSMENU';
		// Atributos
		$cadenaXML.=' clickcontextualnodo="menu_contextual(this,'. " 'flo_".$LITAMBITO_GRUPOSMENUS."'" .');"';
		$cadenaXML.=' imagenodo="../images/iconos/carpeta.gif"';
		$cadenaXML.=' infonodo="'.$rs->campos["nombregrupo"].'"';
		$cadenaXML.=' nodoid='.$LITAMBITO_GRUPOSMENUS.'-'.$rs->campos["idgrupo"];
		$cadenaXML.='>';
		$cadenaXML.=SubarbolXML_grupos_menus($cmd,$idcentro,$rs->campos["idgrupo"]);
		$cadenaXML.='</GRUPOSMENU>';
		$rs->Siguiente();
	}
	$rs->Cerrar();
	$cadenaXML.=SubarbolXML_Menus($cmd,$idcentro,$grupoid);
	return($cadenaXML);
}
//________________________________________________________________________________________________________
function SubarbolXML_Menus($cmd,$idcentro,$grupoid){
	global $LITAMBITO_MENUS;
	$cadenaXML="";
	$rs=new Recordset; 
	$cmd->texto="SELECT idmenu,descripcion FROM menus  WHERE idcentro=".$idcentro." AND grupoid=". $grupoid." ORDER BY descripcion";
	$rs->Comando=&$cmd; 
	if (!$rs->Abrir()) return($cadenaXML); // Error al abrir recordset
	$rs->Primero(); 
	while (!$rs->EOF){
		$cadenaXML.='<MENU';
		// Atributos
		$cadenaXML.=' imagenodo="../images/iconos/menu.gif"';	
		$cadenaXML.=' infonodo="'.$rs->campos["descripcion"].'"';
		$cadenaXML.=' nodoid='.$LITAMBITO_MENUS.'-'.$rs->campos["idmenu"];
		$cadenaXML.=' clickcontextualnodo="menu_contextual(this,' ."'flo_".$LITAMBITO_MENUS."'" .')"';
		$cadenaXML.=' >';
		$cadenaXML.='</MENU>';
		$rs->Siguiente();
	}
	$rs->Cerrar();
	return($cadenaXML);
}
//________________________________________________________________________________________________________
//
//	Menús Contextuales
//________________________________________________________________________________________________________
function CreacontextualXMLMenus(){
	global $AMBITO_MENUS;
	global $AMBITO_GRUPOSMENUS;
	global $LITAMBITO_GRUPOSMENUS;
	global $LITAMBITO_MENUS;
	global $TbMsg;

	$layerXML='<MENUCONTEXTUAL';
	$layerXML.=' idctx="flo_Raiz'.$LITAMBITO_MENUS.'"';
	$layerXML.=' maxanchu=155';
	$layerXML.=' swimg=1';
	$layerXML.=' clase="menu_contextual"';
	$layerXML.='>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="insertar_grupos('.$AMBITO_GRUPOSMENUS.',' . "'".$LITAMBITO_GRUPOSMENUS."'" . ')"';
	$layerXML.=' imgitem="../images/iconos/carpeta.gif"';
	$layerXML.=' textoitem='.$TbMsg[0];
	$layerXML.='></ITEM>';

	$wLeft=140;
	$wTop=115; 
	$wWidth=550;
	$wHeight=480;
	$wpages="../propiedades/propiedades_menus.php";
	$wParam=$wLeft .",".$wTop.",".$wWidth.",".$wHeight.",'". $wpages."'";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="insertar('.$wParam.')"';
	$layerXML.=' imgitem="../images/iconos/menu.gif"';
	$layerXML.=' textoitem='.$TbMsg[1];
	$layerXML.='></ITEM>';

	$layerXML.='<SEPARADOR>';
	$layerXML.='</SEPARADOR>';

	$wParam="../gestores/gestor_menus.php";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="colocar('."'".$wParam."'".','.$AMBITO_MENUS.')"';
	$layerXML.=' imgitem="../images/iconos/colocar.gif"';
	$layerXML.=' textoitem='.$TbMsg[2];
	$layerXML.='></ITEM>';

	$layerXML.='</MENUCONTEXTUAL>';
	return($layerXML);
}
//________________________________________________________________________________________________________
function ContextualXMLGruposMenus(){
	global $AMBITO_MENUS;
	global $AMBITO_GRUPOSMENUS;
	global $LITAMBITO_GRUPOSMENUS;
	global $TbMsg;

	$layerXML='<MENUCONTEXTUAL';
	$layerXML.=' idctx="flo_'.$LITAMBITO_GRUPOSMENUS.'"';
	$layerXML.=' maxanchu=160';
	$layerXML.=' swimg=1';
	$layerXML.=' clase="menu_contextual"';
	$layerXML.='>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="insertar_grupos('.$AMBITO_GRUPOSMENUS.',' ."'".$LITAMBITO_GRUPOSMENUS."'". ')"';
	$layerXML.=' imgitem="../images/iconos/carpeta.gif"';
	$layerXML.=' textoitem='.$TbMsg[0];
	$layerXML.='></ITEM>';
	
	$wLeft=140;
	$wTop=115; 
	$wWidth=550;
	$wHeight=480;

	$wpages="../propiedades/propiedades_menus.php";
	$wParam=$wLeft .",".$wTop.",".$wWidth.",".$wHeight.",'". $wpages."'";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="insertar('.$wParam.')"';
	$layerXML.=' imgitem="../images/iconos/menu.gif"';
	$layerXML.=' textoitem='.$TbMsg[1];
	$layerXML.='></ITEM>';

	$layerXML.='<SEPARADOR>';
	$layerXML.='</SEPARADOR>';

	$wParam="../gestores/gestor_menus.php";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="colocar('."'".$wParam."'".','.$AMBITO_MENUS.')"';
	$layerXML.=' imgitem="../images/iconos/colocar.gif"';
	$layerXML.=' textoitem='.$TbMsg[2];
	$layerXML.='></ITEM>';

	$layerXML.='<SEPARADOR>';
	$layerXML.='</SEPARADOR>'; 

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="modificar_grupos()"';
	$layerXML.=' imgitem="../images/iconos/modificar.gif"';
	$layerXML.=' textoitem='.$TbMsg[7];
	$layerXML.='></ITEM>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="eliminar_grupos()"';
	$layerXML.=' imgitem="../images/iconos/eliminar.gif"';
	$layerXML.=' textoitem='.$TbMsg[4];
	$layerXML.='></ITEM>';

	$layerXML.='</MENUCONTEXTUAL>';
	return($layerXML);
}
//________________________________________________________________________________________________________
function CreacontextualXMLMenu(){
	global $AMBITO_MENUS;
	global $LITAMBITO_MENUS;
	global $TbMsg;

	$layerXML='<MENUCONTEXTUAL';
	$layerXML.=' idctx="flo_'.$LITAMBITO_MENUS.'"';
	$layerXML.=' maxanchu=130';
	$layerXML.=' swimg=1';
	$layerXML.=' clase="menu_contextual"';
	$layerXML.='>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="gestionar_items()"';
	$layerXML.=' imgitem="../images/iconos/comandos.gif"';
	$layerXML.=' textoitem='.$TbMsg[10];
	$layerXML.='></ITEM>';
	
	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="muestra_informacion()"';
	$layerXML.=' textoitem='.$TbMsg[5];
	$layerXML.=' imgitem="../images/iconos/informacion.gif"';
	$layerXML.='></ITEM>';

	$layerXML.='<SEPARADOR>';
	$layerXML.='</SEPARADOR>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="mover('.$AMBITO_MENUS.')"';
	$layerXML.=' imgitem="../images/iconos/mover.gif"';
	$layerXML.=' textoitem='.$TbMsg[6];
	$layerXML.='></ITEM>';

	$layerXML.='<SEPARADOR>';
	$layerXML.='</SEPARADOR>';

	$wLeft=140;
	$wTop=115; 
	$wWidth=550;
	$wHeight=480;

	$wpages="../propiedades/propiedades_menus.php";
	$wParam=$wLeft .",".$wTop.",".$wWidth.",".$wHeight.",'". $wpages."'";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="modificar('.$wParam.')"';	
	$layerXML.=' textoitem='.$TbMsg[7];
	$layerXML.=' imgitem="../images/iconos/propiedades.gif"';
	$layerXML.='></ITEM>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="eliminar('.$wParam.')"';	
	$layerXML.=' imgitem="../images/iconos/eliminar.gif"';
	$layerXML.=' textoitem='.$TbMsg[8];
	$layerXML.='></ITEM>';

	$layerXML.='</MENUCONTEXTUAL>';
	return($layerXML);
}
?>
