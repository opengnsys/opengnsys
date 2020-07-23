<?php
// *************************************************************************************************************************************************
// Aplicación WEB: ogAdmWebCon
// Autor: José Manuel Alonso (E.T.S.I.I.) Universidad de Sevilla
// Fecha Creación: Año 2009-2010
// Fecha Última modificación: Agosto-2010
// Nombre del fichero: hardwares.php
// Descripción : 
//		Administra el hardware de los ordenadores de un determinado Centro
// *************************************************************************************************************************************************
include_once("../includes/ctrlacc.php");
include_once("../includes/arbol.php");
include_once("../clases/AdoPhp.php");
include_once("../clases/XmlPhp.php");
include_once("../clases/ArbolVistaXML.php");
include_once("../clases/MenuContextual.php");
include_once("../includes/constantes.php");
include_once("../includes/CreaComando.php");
include_once("../idiomas/php/".$idioma."/hardwares_".$idioma.".php");
include_once("../idiomas/php/".$idioma."/tiposhardwares_".$idioma.".php");
//________________________________________________________________________________________________________
$cmd=CreaComando($cadenaconexion);
if (!$cmd)
	Header('Location: '.$pagerror.'?herror=2');  // Error de conexióncon servidor B.D.
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
	<SCRIPT language="javascript" src="../jscripts/arbol.js"></SCRIPT>
	<SCRIPT language="javascript" src="../jscripts/hardwares.js"></SCRIPT>
	<SCRIPT language="javascript" src="../jscripts/opciones.js"></SCRIPT>
	<SCRIPT language="javascript" src="../jscripts/constantes.js"></SCRIPT>
	<SCRIPT language="javascript" src="../jscripts/comunes.js"></SCRIPT>
	<SCRIPT language="javascript" src="../clases/jscripts/HttpLib.js"></SCRIPT>
	<?php echo '<SCRIPT language="javascript" src="../idiomas/javascripts/'.$idioma.'/comunes_'.$idioma.'.js"></SCRIPT>'?>
	<?php echo '<SCRIPT language="javascript" src="../idiomas/javascripts/'.$idioma.'/hardwares_'.$idioma.'.js"></SCRIPT>'?>
</HEAD>
<BODY onclick="ocultar_menu();" OnContextMenu="return false">

<?php
//________________________________________________________________________________________________________
echo $arbol->CreaArbolVistaXML();	 // Crea árbol (HTML) a partir del XML
$flotante=new MenuContextual();			 // Crea objeto MenuContextual

// Crea contextual de tipos de hardware
$XMLcontextual=CreacontextualXMLTipos_Hardware(); 
 echo $flotante->CreaMenuContextual($XMLcontextual);
$XMLcontextual=CreacontextualXMLTipoHardware(); 
echo $flotante->CreaMenuContextual($XMLcontextual); 

// Crea contextual de componentes hardware
$XMLcontextual=CreacontextualXMLComponentes_Hardware(); 
echo $flotante->CreaMenuContextual($XMLcontextual); 
$XMLcontextual=ContextualXMLGruposComponentes(); // Grupos de componentes
echo $flotante->CreaMenuContextual($XMLcontextual); 
$XMLcontextual=CreacontextualXMLComponente_Hardware(); // Componentes
 echo $flotante->CreaMenuContextual($XMLcontextual);

// Crea contextual de perfiles hardware
$XMLcontextual=CreacontextualXMLPerfiles_Hardware(); 
echo $flotante->CreaMenuContextual($XMLcontextual);
$XMLcontextual=ContextualXMLGruposPerfiles(); // Grupos de perfiles
echo $flotante->CreaMenuContextual($XMLcontextual); 
$XMLcontextual=CreacontextualXMLPerfil_Hardware(); // Perfiles
 echo $flotante->CreaMenuContextual($XMLcontextual);

echo "<br><br>";
echo "<br><br>\n";
$tipos=nodos_arbol("tiposhardware");
$componentes=nodos_arbol("componenteshardware");
$perfiles=nodos_arbol("perfileshardware");
/* En la BD no existen grupos de tipos de software.
 * Creo el grupo que 0 que es padre de los tipos de software.
 */
$grp_tipos[1]=Array();
$grp_componentes=grupos_arbol("componenteshardware");
$grp_perfiles=grupos_arbol("perfileshardware");

$nodos=$tipos + $componentes + $perfiles;
$grupos=$grp_tipos + $grp_componentes + $grp_perfiles;

lista_raiz_arbol("hardware", $nodos, $grupos);
?>
<!-- los id de los "li" contienen los tipos de nodos porque tienen que ser distintos, pero no se usan -->
<!-- tipos -->

<ul id="menu-type-1" name="menu-type-1" oncontextmenu="return false;">
  <li onclick="insertar(170,150,480,240,'../propiedades/propiedades_tipohardwares.php')"><img class="menu-icono" src="../images/iconos/confihard.gif"> Definir nuevo tipo de hardware </li>
</ul>

<ul id="menu-node-1" name="menu-node-1" oncontextmenu="return false;">
  <li onclick="modificar(170,150,480,240,'../propiedades/propiedades_tipohardwares.php')"><img class="menu-icono" src="../images/iconos/propiedades.gif"> Propiedades </li>
  <li> <hr class="separador"> </li>
  <li onclick="eliminar(170,150,480,240,'../propiedades/propiedades_tipohardwares.php')"><img class="menu-icono" src="../images/iconos/eliminar.gif"> Eliminar tipo de hardware </li>
</ul>

<!-- componentes -->
<ul id="menu-type-54" name="menu-type-54" oncontextmenu="return false;">
  <li id="insertGroup-type-54"><img class="menu-icono" src="../images/iconos/carpeta.gif"> Nuevo grupo de componentes </li>
  <li id="insertNode-type-54"><img class="menu-icono" src="../images/iconos/confihard.gif"> Definir nuevo componente </li>
  <li> <hr class="separador"> </li>
  <li id="put-type-54"><img class="menu-icono" src="../images/iconos/colocar.gif"> Colocar componente </li>
</ul>

<ul id="menu-group-54" name="menu-group-54" oncontextmenu="return false;">
  <li id="insertGroup-group-54"><img class="menu-icono" src="../images/iconos/carpeta.gif"> Nuevo grupo de componentes </li>
  <li id="insertNode-group-54"><img class="menu-icono" src="../images/iconos/confihard.gif"> Definir nuevo componente </li>
  <li> <hr class="separador"> </li>
  <li id="put-group-54"><img class="menu-icono" src="../images/iconos/colocar.gif"> Colocar componente </li>
  <li> <hr class="separador"> </li>
  <li id="modifyGroup-54"><img class="menu-icono" src="../images/iconos/modificar.gif"> Propiedades </li>
  <li id="removeGroup-54"><img class="menu-icono" src="../images/iconos/eliminar.gif"> Eliminar grupo de componentes </li>
</ul>

<ul id="menu-node-54" name="menu-node-54" oncontextmenu="return false;">
  <li id="move-54"><img class="menu-icono" src="../images/iconos/mover.gif"> Mover componente </li>
  <li> <hr class="separador"> </li>
  <li id="modifyNode-54"><img class="menu-icono" src="../images/iconos/propiedades.gif"> Propiedades </li>

  <li id="removeNode-54"><img class="menu-icono" src="../images/iconos/eliminar.gif"> Eliminar componente </li>
</ul>

<!-- perfiles -->

<ul id="menu-type-56" name="menu-type-56" oncontextmenu="return false;">
  <li id="insertGroup-type-56"><img class="menu-icono" src="../images/iconos/carpeta.gif"> Nuevo grupo de perfiles </li>
  <li id="insertNode-type-56"><img class="menu-icono" src="../images/iconos/confihard.gif"> Definir nuevo perfil </li>
  <li> <hr class="separador"> </li>
  <li id="put-type-56"><img class="menu-icono" src="../images/iconos/colocar.gif"> Colocar perfil </li>
</ul>

<ul id="menu-group-56" name="menu-group-56" oncontextmenu="return false;">
  <li id="insertGroup-group-56"><img class="menu-icono" src="../images/iconos/carpeta.gif"> Nuevo grupo de perfiles </li>
  <li id="insertNode-group-56"><img class="menu-icono" src="../images/iconos/confihard.gif"> Definir nuevo perfil </li>
  <li> <hr class="separador"> </li>
  <li id="put-group-56"><img class="menu-icono" src="../images/iconos/colocar.gif"> Colocar perfil </li>
  <li> <hr class="separador"> </li>
  <li id="modifyGroup-56"><img class="menu-icono" src="../images/iconos/modificar.gif"> Propiedades </li>
  <li id="removeGroup-56"><img class="menu-icono" src="../images/iconos/eliminar.gif"> Eliminar grupo de perfiles </li>
</ul>

<ul id="menu-node-56" name="menu-node-56" oncontextmenu="return false;">
  <li id="manageNode-56"><img class="menu-icono" src="../images/iconos/confihard.gif"> Gestión Componentes </li>
  <li id="showInfoNode-56"><img class="menu-icono" src="../images/iconos/informacion.gif"> Información Perfil </li>
  <li> <hr class="separador"> </li>
  <li id="move-56"><img class="menu-icono" src="../images/iconos/mover.gif"> Mover perfil </li>
  <li> <hr class="separador"> </li>
  <li id="modifyNode-56"><img class="menu-icono" src="../images/iconos/propiedades.gif"> Propiedades </li>
  <li id="removeNode-56"><img class="menu-icono" src="../images/iconos/eliminar.gif"> Eliminar perfil hardware </li>
</ul>


</BODY>
</HTML>
<?php
// *************************************************************************************************************************************************
//	Devuelve una cadena con formato XML de toda la informaci� del hardware registrado en un Centro concreto
//	Parametros: 
//		- cmd:Una comando ya operativo ( con conexiónabierta)  
//		- idcentro: El identificador del centro
//________________________________________________________________________________________________________
function CreaArbol($cmd,$idcentro){
	global $TbMsg;
	$cadenaXML='<HARDWARES';
	// Atributos
	$cadenaXML.=' imagenodo="../images/iconos/confihard.gif"';
	$cadenaXML.=' nodoid=RaizHardwares';
	$cadenaXML.=' infonodo="Hardware"';
	$cadenaXML.='>';
	$cadenaXML.='<TIPOS';
	// Atributos
	$cadenaXML.=' imagenodo="../images/iconos/carpeta.gif"';
	$cadenaXML.=' infonodo='.$TbMsg[18];
	$cadenaXML.=' nodoid=RaizTipoHardwares';
	$cadenaXML.=' clickcontextualnodo="menu_contextual(this,' ."'flo_RaizTipoHardwares'" .')"';
	$cadenaXML.='>';
	$cadenaXML.=SubarbolXML_TiposHardwares($cmd);
	$cadenaXML.='</TIPOS>';
	$cadenaXML.='<COMPONENTES';
	// Atributos
	$cadenaXML.=' imagenodo="../images/iconos/carpeta.gif"';
	$cadenaXML.=' infonodo='.$TbMsg[19];
	$cadenaXML.=' nodoid=RaizComponentesHardwares';
	$cadenaXML.=' clickcontextualnodo="menu_contextual(this,' ."'flo_RaizComponentesHardwares'" .')"';
	$cadenaXML.='>';
	$cadenaXML.=SubarbolXML_grupos_componenteshard($cmd,$idcentro,0);
	$cadenaXML.='</COMPONENTES>';
	$cadenaXML.='<PERFILES';
	// Atributos
	$cadenaXML.=' imagenodo="../images/iconos/carpeta.gif"';
	$cadenaXML.=' infonodo='.$TbMsg[20];
	$cadenaXML.=' nodoid=RaizPerfilesHardwares';
	$cadenaXML.=' clickcontextualnodo="menu_contextual(this,' ."'flo_RaizPerfilesHardwares'" .')"';
	$cadenaXML.='>';
	$cadenaXML.=SubarbolXML_grupos_perfileshard($cmd,$idcentro,0);
	$cadenaXML.='</PERFILES>';
	$cadenaXML.='</HARDWARES>';
	return($cadenaXML);
}
//________________________________________________________________________________________________________
function SubarbolXML_TiposHardwares($cmd){
	global $LITAMBITO_TIPOHARDWARES;
	global $TbMsg;
	$cadenaXML="";
	$rs=new Recordset; 
	$cmd->texto="SELECT idtipohardware, descripcion, urlimg, nemonico
			FROM tipohardwares ORDER BY descripcion";
	$rs->Comando=&$cmd; 
	if (!$rs->Abrir()) return($cadenaXML); // Error al abrir recordset
	$rs->Primero(); 
	while (!$rs->EOF){
		$cadenaXML.='<TIPOHARDWARES';
		// Atributos
		if	($rs->campos["urlimg"]!="")
				$cadenaXML.=' imagenodo="'.$rs->campos["urlimg"].'"';
			else
				$cadenaXML.=' imagenodo="../images/iconos/confihard.gif"';		
		$descrip = $TbMsg["HARDWARE_".$rs->campos["nemonico"]];
		if (empty ($descrip)) {
			$descrip = $rs->campos["descripcion"];
		}
		$cadenaXML.=' infonodo="'.$descrip.'"';
		$cadenaXML.=' clickcontextualnodo="menu_contextual(this,' ."'flo_".$LITAMBITO_TIPOHARDWARES."'" .')"';
		$cadenaXML.=' nodoid='.$LITAMBITO_TIPOHARDWARES.'-'.$rs->campos["idtipohardware"];

		$cadenaXML.='>';
		$cadenaXML.='</TIPOHARDWARES>';
		$rs->Siguiente();
	}
	$rs->Cerrar();
	return($cadenaXML);
}
//________________________________________________________________________________________________________
function SubarbolXML_grupos_componenteshard($cmd,$idcentro,$grupoid){
	global $LITAMBITO_GRUPOSCOMPONENTESHARD;
	global $AMBITO_GRUPOSCOMPONENTESHARD;
	$cadenaXML="";
	$rs=new Recordset; 
	$cmd->texto="SELECT idgrupo,nombregrupo,grupoid FROM grupos WHERE grupoid=".$grupoid." AND idcentro=".$idcentro." AND tipo=".$AMBITO_GRUPOSCOMPONENTESHARD." ORDER BY nombregrupo";
	$rs->Comando=&$cmd; 
	if (!$rs->Abrir()) return($cadenaXML); // Error al abrir recordset
	$rs->Primero(); 
	while (!$rs->EOF){
		$cadenaXML.='<GRUPOSCOMPONENTESHARD';
		// Atributos
		$cadenaXML.=' clickcontextualnodo="menu_contextual(this,'. " 'flo_".$LITAMBITO_GRUPOSCOMPONENTESHARD."'" .');"';
		$cadenaXML.=' imagenodo="../images/iconos/carpeta.gif"';
		$cadenaXML.=' infonodo="'.$rs->campos["nombregrupo"].'"';
		$cadenaXML.=' nodoid='.$LITAMBITO_GRUPOSCOMPONENTESHARD.'-'.$rs->campos["idgrupo"];
		$cadenaXML.='>';
		$cadenaXML.=SubarbolXML_grupos_componenteshard($cmd,$idcentro,$rs->campos["idgrupo"]);
		$cadenaXML.='</GRUPOSCOMPONENTESHARD>';
		$rs->Siguiente();
	}
	$rs->Cerrar();
	$cadenaXML.=SubarbolXML_ComponentesHardwares($cmd,$idcentro,$grupoid);
	return($cadenaXML);
}
//________________________________________________________________________________________________________
function SubarbolXML_ComponentesHardwares($cmd,$idcentro,$grupoid){
	global $LITAMBITO_COMPONENTESHARD;
	$cadenaXML="";
	$rs=new Recordset; 
	$cmd->texto="SELECT hardwares.idhardware,hardwares.descripcion,tipohardwares.urlimg FROM hardwares INNER JOIN tipohardwares  ON hardwares.idtipohardware=tipohardwares.idtipohardware WHERE idcentro=".$idcentro." AND grupoid=". $grupoid." order by tipohardwares.idtipohardware,hardwares.descripcion";
	$rs->Comando=&$cmd; 
	if (!$rs->Abrir()) return($cadenaXML); // Error al abrir recordset
	$rs->Primero(); 
	while (!$rs->EOF){
		$cadenaXML.='<COMPONENTES';
		// Atributos
		if ($rs->campos["urlimg"]!="")
			$cadenaXML.=' imagenodo='.$rs->campos["urlimg"];
		else
			$cadenaXML.=' imagenodo="../images/iconos/confihard.gif"';		


		$cadenaXML.=' infonodo="'.$rs->campos["descripcion"].'"';
		$cadenaXML.=' nodoid='.$LITAMBITO_COMPONENTESHARD.'-'.$rs->campos["idhardware"];
		$cadenaXML.=' clickcontextualnodo="menu_contextual(this,' ."'flo_".$LITAMBITO_COMPONENTESHARD."'" .')"';
		$cadenaXML.='>';
		$cadenaXML.='</COMPONENTES>';
		$rs->Siguiente();
	}
	$rs->Cerrar();
	return($cadenaXML);
}
//________________________________________________________________________________________________________
function SubarbolXML_grupos_perfileshard($cmd,$idcentro,$grupoid){
	global $LITAMBITO_GRUPOSPERFILESHARD;
	global $AMBITO_GRUPOSPERFILESHARD;
	$cadenaXML="";
	$rs=new Recordset; 
	$cmd->texto="SELECT idgrupo,nombregrupo,grupoid FROM grupos WHERE grupoid=".$grupoid." AND idcentro=".$idcentro." AND tipo=".$AMBITO_GRUPOSPERFILESHARD." ORDER BY nombregrupo";
	$rs->Comando=&$cmd; 
	if (!$rs->Abrir()) return($cadenaXML); // Error al abrir recordset
	$rs->Primero(); 
	while (!$rs->EOF){
		$cadenaXML.='<GRUPOSPERFILESHARD';
		// Atributos
		$cadenaXML.=' clickcontextualnodo="menu_contextual(this,'. " 'flo_".$LITAMBITO_GRUPOSPERFILESHARD."'" .');"';
		$cadenaXML.=' imagenodo="../images/iconos/carpeta.gif"';
		$cadenaXML.=' infonodo="'.$rs->campos["nombregrupo"].'"';
		$cadenaXML.=' nodoid='.$LITAMBITO_GRUPOSPERFILESHARD.'-'.$rs->campos["idgrupo"];
		$cadenaXML.='>';
		$cadenaXML.=SubarbolXML_grupos_perfileshard($cmd,$idcentro,$rs->campos["idgrupo"]);
		$cadenaXML.='</GRUPOSPERFILESHARD>';
		$rs->Siguiente();
	}
	$rs->Cerrar();
	$cadenaXML.=SubarbolXML_PerfilesHardwares($cmd,$idcentro,$grupoid);
	return($cadenaXML);
}
//________________________________________________________________________________________________________
function SubarbolXML_PerfilesHardwares($cmd,$idcentro,$grupoid){
	global $LITAMBITO_PERFILESHARD;
	$cadenaXML="";
	$rs=new Recordset; 
	$cmd->texto="SELECT perfileshard.idperfilhard ,perfileshard.descripcion FROM perfileshard WHERE perfileshard.idcentro=".$idcentro." AND perfileshard.grupoid=". $grupoid;
	$cmd->texto.=" ORDER by perfileshard.descripcion";
	$rs->Comando=&$cmd; 
	if (!$rs->Abrir()) return($cadenaXML); // Error al abrir recordset
	$rs->Primero(); 
	while (!$rs->EOF){
			$cadenaXML.='<PERFILESHARDWARES';
			// Atributos
			$cadenaXML.=' imagenodo="../images/iconos/perfilhardware.gif"';
			$cadenaXML.=' infonodo="'.$rs->campos["descripcion"].'"';
			$cadenaXML.=' nodoid='.$LITAMBITO_PERFILESHARD.'-'.$rs->campos["idperfilhard"];
			$cadenaXML.=' clickcontextualnodo="menu_contextual(this,' ."'flo_".$LITAMBITO_PERFILESHARD."'" .')"';
			$cadenaXML.='>';
			$cadenaXML.='</PERFILESHARDWARES>';
			$rs->Siguiente();
	}
	$rs->Cerrar();
	return($cadenaXML);
}
//________________________________________________________________________________________________________
//
//	Mens Contextuales
//________________________________________________________________________________________________________
function CreacontextualXMLTipos_Hardware(){
	global $TbMsg;

	$layerXML='<MENUCONTEXTUAL';
	$layerXML.=' idctx="flo_RaizTipoHardwares"';
	$layerXML.=' maxanchu=175';
	$layerXML.=' swimg=1';
	$layerXML.=' clase="menu_contextual"';
	$layerXML.='>';

	$wLeft=170;
	$wTop=150;
	$wWidth=480;
	$wHeight=240;
	$wpages="../propiedades/propiedades_tipohardwares.php";
	$wParam=$wLeft .",".$wTop.",".$wWidth.",".$wHeight.",'". $wpages."'";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="insertar('.$wParam.')"';
	$layerXML.=' imgitem="../images/iconos/confihard.gif"';
	$layerXML.=' textoitem='.$TbMsg[0];

	$layerXML.='></ITEM>';

	$layerXML.='</MENUCONTEXTUAL>';
	return($layerXML);
}
//________________________________________________________________________________________________________
function CreacontextualXMLTipoHardware(){
	global $LITAMBITO_TIPOHARDWARES;
	global $TbMsg;

	$layerXML='<MENUCONTEXTUAL';
	$layerXML.=' idctx="flo_'.$LITAMBITO_TIPOHARDWARES.'"';
	$layerXML.=' maxanchu=165';
	$layerXML.=' swimg=1';
	$layerXML.='>';

	$wLeft=170;
	$wTop=150;
	$wWidth=480;
	$wHeight=240;
	$wpages="../propiedades/propiedades_tipohardwares.php";
	$wParam=$wLeft .",".$wTop.",".$wWidth.",".$wHeight.",'". $wpages."'";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="modificar('.$wParam.')"';
	$layerXML.=' imgitem="../images/iconos/propiedades.gif"';
	$layerXML.=' textoitem='.$TbMsg[1];
	$layerXML.='></ITEM>';

	$layerXML.='<SEPARADOR>';
	$layerXML.='</SEPARADOR>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="eliminar('.$wParam.')"';
	$layerXML.=' imgitem="../images/iconos/eliminar.gif"';
	$layerXML.=' textoitem='.$TbMsg[2];
	$layerXML.='></ITEM>';

	$layerXML.='</MENUCONTEXTUAL>';
	return($layerXML);
}
//________________________________________________________________________________________________________
function CreacontextualXMLComponentes_Hardware(){
	global $AMBITO_COMPONENTESHARD;
	global $AMBITO_GRUPOSCOMPONENTESHARD;
	global $LITAMBITO_GRUPOSCOMPONENTESHARD;
	global $TbMsg;

	$layerXML='<MENUCONTEXTUAL';
	$layerXML.=' idctx="flo_RaizComponentesHardwares"';
	$layerXML.=' maxanchu=185';
	$layerXML.=' swimg=1';
	$layerXML.='>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="insertar_grupos('.$AMBITO_GRUPOSCOMPONENTESHARD.',' . "'".$LITAMBITO_GRUPOSCOMPONENTESHARD."'" . ')"';
	$layerXML.=' imgitem="../images/iconos/carpeta.gif"';
	$layerXML.=' textoitem='.$TbMsg[3];
	$layerXML.='></ITEM>';

	$wLeft=170;
	$wTop=150; 
	$wWidth=480;
	$wHeight=230;
	$wpages="../propiedades/propiedades_componentehardwares.php";
	$wParam=$wLeft .",".$wTop.",".$wWidth.",".$wHeight.",'". $wpages."'";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="insertar('.$wParam.')"';
	$layerXML.=' imgitem="../images/iconos/confihard.gif"';
	$layerXML.=' textoitem='.$TbMsg[4];
	$layerXML.='></ITEM>';

	$layerXML.='<SEPARADOR>';
	$layerXML.='</SEPARADOR>';

	$wParam="../gestores/gestor_componentehardwares.php";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="colocar('."'".$wParam."'".','.$AMBITO_COMPONENTESHARD.')"';
	$layerXML.=' imgitem="../images/iconos/colocar.gif"';
	$layerXML.=' textoitem='.$TbMsg[5];
	$layerXML.='></ITEM>';

	$layerXML.='</MENUCONTEXTUAL>'; 
	return($layerXML);
}
//________________________________________________________________________________________________________
function ContextualXMLGruposComponentes(){
	global $AMBITO_COMPONENTESHARD;
	global $AMBITO_GRUPOSCOMPONENTESHARD;
	global $LITAMBITO_GRUPOSCOMPONENTESHARD;
	global $TbMsg;

	$layerXML='<MENUCONTEXTUAL';
	$layerXML.=' idctx="flo_'.$LITAMBITO_GRUPOSCOMPONENTESHARD.'"';
	$layerXML.=' maxanchu=195';
	$layerXML.=' swimg=1';
	$layerXML.=' clase="menu_contextual"';
	$layerXML.='>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="insertar_grupos('.$AMBITO_GRUPOSCOMPONENTESHARD.',' ."'".$LITAMBITO_GRUPOSCOMPONENTESHARD."'". ')"';
	$layerXML.=' imgitem="../images/iconos/carpeta.gif"';
	$layerXML.=' textoitem='.$TbMsg[3];
	$layerXML.='></ITEM>';
	
	$wLeft=170;
	$wTop=150;
	$wWidth=480;
	$wHeight=230;
	$wpages="../propiedades/propiedades_componentehardwares.php";
	$wParam=$wLeft .",".$wTop.",".$wWidth.",".$wHeight.",'". $wpages."'";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="insertar('.$wParam.')"';
	$layerXML.=' imgitem="../images/iconos/confihard.gif"';
	$layerXML.=' textoitem='.$TbMsg[4];
	$layerXML.='></ITEM>';

	$layerXML.='<SEPARADOR>';
	$layerXML.='</SEPARADOR>';

	$wParam="../gestores/gestor_componentehardwares.php";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="colocar('."'".$wParam."'".','.$AMBITO_COMPONENTESHARD.')"';
	$layerXML.=' imgitem="../images/iconos/colocar.gif"';
	$layerXML.=' textoitem='.$TbMsg[5];
	$layerXML.='></ITEM>';

	$layerXML.='<SEPARADOR>';
	$layerXML.='</SEPARADOR>'; 

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="modificar_grupos()"';
	$layerXML.=' imgitem="../images/iconos/modificar.gif"';
	$layerXML.=' textoitem='.$TbMsg[1];
	$layerXML.='></ITEM>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="eliminar_grupos()"';
	$layerXML.=' imgitem="../images/iconos/eliminar.gif"';
	$layerXML.=' textoitem='.$TbMsg[7];
	$layerXML.='></ITEM>';

	$layerXML.='</MENUCONTEXTUAL>';
	return($layerXML);
}
//________________________________________________________________________________________________________
function CreacontextualXMLComponente_Hardware(){
	global $AMBITO_COMPONENTESHARD;
	global $LITAMBITO_COMPONENTESHARD;
	global $TbMsg;
 
	$layerXML='<MENUCONTEXTUAL';
	$layerXML.=' idctx="flo_'.$LITAMBITO_COMPONENTESHARD.'"';
	$layerXML.=' maxanchu=145';
	$layerXML.='>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="mover('.$AMBITO_COMPONENTESHARD.')"';
	$layerXML.=' imgitem="../images/iconos/mover.gif"';
	$layerXML.=' textoitem='.$TbMsg[8];
	$layerXML.='></ITEM>';

	$layerXML.='<SEPARADOR>';
	$layerXML.='</SEPARADOR>';

	$wLeft=170;
	$wTop=150;
	$wWidth=480;
	$wHeight=230;
	$wpages="../propiedades/propiedades_componentehardwares.php";
	$wParam=$wLeft .",".$wTop.",".$wWidth.",".$wHeight.",'". $wpages."'";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="modificar('.$wParam.')"';
	$layerXML.=' textoitem='.$TbMsg[1];
	$layerXML.=' imgitem="../images/iconos/propiedades.gif"';
	$layerXML.='></ITEM>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="eliminar('.$wParam.')"';
	$layerXML.=' imgitem="../images/iconos/eliminar.gif"';
	$layerXML.=' textoitem='.$TbMsg[9];
	$layerXML.='></ITEM>';

	$layerXML.='</MENUCONTEXTUAL>';
	return($layerXML);
}
//________________________________________________________________________________________________________
function CreacontextualXMLPerfiles_Hardware(){
	global $AMBITO_PERFILESHARD;
	global $AMBITO_GRUPOSPERFILESHARD;
	global $LITAMBITO_GRUPOSPERFILESHARD;
	global $TbMsg;

	$layerXML='<MENUCONTEXTUAL';
	$layerXML.=' idctx="flo_RaizPerfilesHardwares"';
	$layerXML.=' maxanchu=155';
	$layerXML.=' swimg=1';
	$layerXML.=' clase="menu_contextual"';
	$layerXML.='>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="insertar_grupos('.$AMBITO_GRUPOSPERFILESHARD.',' ."'".$LITAMBITO_GRUPOSPERFILESHARD."'". ')"';
	$layerXML.=' imgitem="../images/iconos/carpeta.gif"';
	$layerXML.=' textoitem='.$TbMsg[10];
	$layerXML.='></ITEM>';

	$wLeft=170;
	$wTop=150; 
	$wWidth=480;
	$wHeight=280;
	$wpages="../propiedades/propiedades_perfilhardwares.php";
	$wParam=$wLeft .",".$wTop.",".$wWidth.",".$wHeight.",'". $wpages."'";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="insertar('.$wParam.')"';
	$layerXML.=' imgitem="../images/iconos/confihard.gif"';
	$layerXML.=' textoitem='.$TbMsg[11];
	$layerXML.='></ITEM>';

	$layerXML.='<SEPARADOR>';
	$layerXML.='</SEPARADOR>';

	$wParam="../gestores/gestor_perfilhardwares.php";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="colocar('."'".$wParam."'".','.$AMBITO_PERFILESHARD.')"';
	$layerXML.=' imgitem="../images/iconos/colocar.gif"';
	$layerXML.=' textoitem='.$TbMsg[12];
	$layerXML.='></ITEM>';

	$layerXML.='</MENUCONTEXTUAL>';
	return($layerXML);
}
//________________________________________________________________________________________________________
function ContextualXMLGruposPerfiles(){
	global $AMBITO_PERFILESHARD;
	global $AMBITO_GRUPOSPERFILESHARD;
	global $LITAMBITO_GRUPOSPERFILESHARD;
	global $TbMsg;

	$layerXML='<MENUCONTEXTUAL';
	$layerXML.=' idctx="flo_'.$LITAMBITO_GRUPOSPERFILESHARD.'"';
	$layerXML.=' maxanchu=160';
	$layerXML.=' swimg=1';
	$layerXML.=' clase="menu_contextual"';
	$layerXML.='>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="insertar_grupos('.$AMBITO_GRUPOSPERFILESHARD.',' ."'".$LITAMBITO_GRUPOSPERFILESHARD."'". ')"';
	$layerXML.=' imgitem="../images/iconos/carpeta.gif"';
	$layerXML.=' textoitem='.$TbMsg[10];
	$layerXML.='></ITEM>';
	
	$wLeft=170;
	$wTop=150;
	$wWidth=480;
	$wHeight=280;
	$wpages="../propiedades/propiedades_perfilhardwares.php";
	$wParam=$wLeft .",".$wTop.",".$wWidth.",".$wHeight.",'". $wpages."'";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="insertar('.$wParam.')"';
	$layerXML.=' imgitem="../images/iconos/confihard.gif"';
	$layerXML.=' textoitem='.$TbMsg[11];
	$layerXML.='></ITEM>';

	$layerXML.='<SEPARADOR>';
	$layerXML.='</SEPARADOR>';

	$wParam="../gestores/gestor_perfilhardwares.php";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="colocar('."'".$wParam."'".','.$AMBITO_PERFILESHARD.')"';
	$layerXML.=' imgitem="../images/iconos/colocar.gif"';
	$layerXML.=' textoitem='.$TbMsg[12];
	$layerXML.='></ITEM>';

	$layerXML.='<SEPARADOR>';
	$layerXML.='</SEPARADOR>'; 

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="modificar_grupos()"';
	$layerXML.=' imgitem="../images/iconos/modificar.gif"';
	$layerXML.=' textoitem='.$TbMsg[1];
	$layerXML.='></ITEM>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="eliminar_grupos()"';
	$layerXML.=' imgitem="../images/iconos/eliminar.gif"';
	$layerXML.=' textoitem='.$TbMsg[13];
	$layerXML.='></ITEM>';

	$layerXML.='</MENUCONTEXTUAL>';
	return($layerXML);
}
//________________________________________________________________________________________________________
function CreacontextualXMLPerfil_Hardware(){
	global $AMBITO_PERFILESHARD;
	global $LITAMBITO_PERFILESHARD;
	global $TbMsg;

	$layerXML='<MENUCONTEXTUAL';
	$layerXML.=' idctx="flo_'.$LITAMBITO_PERFILESHARD.'"';
	$layerXML.=' maxanchu=155';
	$layerXML.=' swimg=1';
	$layerXML.=' clase="menu_contextual"';
	$layerXML.='>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="insertar_perfilcomponente()"';
	$layerXML.=' imgitem="../images/iconos/confihard.gif"';
	$layerXML.=' textoitem='.$TbMsg[14];
	$layerXML.='></ITEM>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="muestra_informacion()"';
	$layerXML.=' textoitem='.$TbMsg[15];
	$layerXML.=' imgitem="../images/iconos/informacion.gif"';
	$layerXML.='></ITEM>';

	$layerXML.='<SEPARADOR>';
	$layerXML.='</SEPARADOR>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="mover('.$AMBITO_PERFILESHARD.')"';
	$layerXML.=' imgitem="../images/iconos/mover.gif"';
	$layerXML.=' textoitem='.$TbMsg[16];
	$layerXML.='></ITEM>';

	$layerXML.='<SEPARADOR>';
	$layerXML.='</SEPARADOR>';

	$wLeft=170;
	$wTop=150;
	$wWidth=480;
	$wHeight=280;
	$wpages="../propiedades/propiedades_perfilhardwares.php";
	$wParam=$wLeft .",".$wTop.",".$wWidth.",".$wHeight.",'". $wpages."'";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="modificar('.$wParam.')"';
	$layerXML.=' textoitem='.$TbMsg[1];
	$layerXML.=' imgitem="../images/iconos/propiedades.gif"';
	$layerXML.='></ITEM>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="eliminar('.$wParam.')"';
	$layerXML.=' imgitem="../images/iconos/eliminar.gif"';
	$layerXML.=' textoitem='.$TbMsg[17];
	$layerXML.='></ITEM>';

	$layerXML.='</MENUCONTEXTUAL>';
	return($layerXML);
}
?>
