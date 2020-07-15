<?php
// *************************************************************************************************************************************************
// Aplicación WEB: ogAdmWebCon
// Autor: José Manuel Alonso (E.T.S.I.I.) Universidad de Sevilla
// Fecha Creación: Año 2009-2010
// Fecha Última modificación: Agosto-2010
// Nombre del fichero: repositorios.php
// Descripción : 
//		Administra los repositorios de un determinado Centro
// *************************************************************************************************************************************************
include_once("../includes/ctrlacc.php");
include_once("../includes/arbol.php");
include_once("../clases/AdoPhp.php");
include_once("../clases/XmlPhp.php");
include_once("../clases/ArbolVistaXML.php");
include_once("../clases/MenuContextual.php");
include_once("../includes/constantes.php");
include_once("../includes/CreaComando.php");
include_once("../idiomas/php/".$idioma."/repositorios_".$idioma.".php");
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

$flotante=new MenuContextual();	 // Crea objeto MenuContextual
$XMLcontextual=ContextualXMLComandos($LITAMBITO_CENTROS,$AMBITO_CENTROS);
//echo $flotante->CreaMenuContextual($XMLcontextual);

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
	<SCRIPT language="javascript" src="../jscripts/repositorios.js"></SCRIPT>
	<SCRIPT language="javascript" src="../jscripts/opciones.js"></SCRIPT>
	<SCRIPT language="javascript" src="../jscripts/constantes.js"></SCRIPT>
	<SCRIPT language="javascript" src="../jscripts/comunes.js"></SCRIPT>	
	<SCRIPT language="javascript" src="../clases/jscripts/HttpLib.js"></SCRIPT>
	<?php echo '<SCRIPT language="javascript" src="../idiomas/javascripts/'.$idioma.'/comunes_'.$idioma.'.js"></SCRIPT>'?>
</HEAD>
<BODY onclick="ocultar_menu();" OnContextMenu="return false">

<FORM name="fcomandos" action="" method="post" target="frame_contenidos">
	<INPUT type="hidden" name="idcomando" value="">
	<INPUT type="hidden" name="descricomando" value="">
	<INPUT type="hidden" name="ambito" value="">
	<INPUT type="hidden" name="idambito" value="">
	<INPUT type="hidden" name="nombreambito" value="">
	<INPUT type="hidden" name="gestor" value="">
	<INPUT type="hidden" name="funcion" value="">
</FORM>
<?php
//________________________________________________________________________________________________________
echo $arbol->CreaArbolVistaXML();	 // Crea árbol (HTML) a partir del XML
$flotante=new MenuContextual();			 // Crea objeto MenuContextual

// Crea contextual de repositorios
$XMLcontextual=CreacontextualXMLRepositorios(); 
echo $flotante->CreaMenuContextual($XMLcontextual);
$XMLcontextual=CreacontextualXMLGruposRepositorios(); // Grupos de repositorios
echo $flotante->CreaMenuContextual($XMLcontextual);
$XMLcontextual=CreacontextualXMLRepositorio(); // Repositorio
echo $flotante->CreaMenuContextual($XMLcontextual);

echo "<br><br>\n";
$nodos=nodos_arbol("repositorios");
$grupos=grupos_arbol("repositorios");

lista_raiz_arbol("repositorios", $nodos, $grupos);
?>
<!-- Repositorios -->
<ul id="menu-type-65" name="menu-type-65" oncontextmenu="return false;">
  <li onclick="insertar_grupos(65,'gruporepositorio')"><img class="menu-icono" src="../images/iconos/carpeta.gif"> Nuevo grupo de Repositorios </li>
  <li onclick="insertar(140,115,550,280,'../propiedades/propiedades_repositorios.php')"><img class="menu-icono" src="../images/iconos/aula.gif"> Añadir Repositorio </li>
  <li> <hr class="separador"> </li>
  <li onclick="colocar('../gestores/gestor_repositorios.php',41)"><img class="menu-icono" src="../images/iconos/colocar.gif"> Colocar Repositorio </li>
</ul>

<ul id="menu-group-65" name="menu-group-65" oncontextmenu="return false;">
  <li onclick="insertar_grupos(65,'gruporepositorio')"><img class="menu-icono" src="../images/iconos/carpeta.gif"> Nuevo grupo de Repositorios </li>
  <li onclick="insertar(140,115,550,280,'../propiedades/propiedades_repositorios.php')"><img class="menu-icono" src="../images/iconos/aula.gif"> Añadir Repositorio </li>
  <li> <hr class="separador"> </li>
  <li onclick="colocar('../gestores/gestor_repositorios.php',41)"><img class="menu-icono" src="../images/iconos/colocar.gif"> Colocar Repositorio </li>
  <li> <hr class="separador"> </li>
  <li onclick="modificar_grupos()"><img class="menu-icono" src="../images/iconos/modificar.gif"> Propiedades </li>
  <li onclick="eliminar_grupos()"><img class="menu-icono" src="../images/iconos/eliminar.gif"> Eliminar grupo de repositorios </li>
</ul>

<ul id="menu-node-65" name="menu-node-65" oncontextmenu="return false;">
  <li id="showInfo"><img class="menu-icono" src="../images/iconos/informacion.gif"> Información Repositorio </li>
  <li> <hr class="separador"> </li>
  <li onclick="mover(41)"><img class="menu-icono" src="../images/iconos/mover.gif"> Mover Repositorio </li>
  <li> <hr class="separador"> </li>
  <li onclick="modificar(140,115,550,280,'../comandos/EliminarImagenRepositorio.php')"><img class="menu-icono" src="../images/iconos/comandos.gif"> Eliminar Imagen Repositorio </li>
  <li> <hr class="separador"> </li>
  <li onclick="modificar(140,115,550,280,'../propiedades/propiedades_repositorios.php')"><img class="menu-icono" src="../images/iconos/propiedades.gif"> Propiedades </li>
  <li onclick="eliminar(140,115,550,280,'../propiedades/propiedades_repositorios.php')"><img class="menu-icono" src="../images/iconos/eliminar.gif"> Eliminar Repositorio </li>
</ul>

</BODY>
</HTML>
<?php
// *************************************************************************************************************************************************
//	Devuelve una cadena con formato XML de toda la información de los repositorios de un Centro concreto
//	Parametros: 
//		- cmd:Una comando ya operativo ( con conexión abierta)  
//		- idcentro: El identificador del centro
//________________________________________________________________________________________________________
function CreaArbol($cmd,$idcentro)
{
	global $TbMsg;
	global $LITAMBITO_REPOSITORIOS;
	$cadenaXML='<REPOSITORIOS';
	// Atributos		
	$cadenaXML.=' imagenodo="../images/iconos/repositorio.gif"';
	$cadenaXML.=' clickcontextualnodo="menu_contextual(this,' ."'flo_Raiz".$LITAMBITO_REPOSITORIOS."'" .')"';
	$cadenaXML.=' nodoid=Raiz'.$LITAMBITO_REPOSITORIOS;
	$cadenaXML.=' infonodo='.$TbMsg[12];
	$cadenaXML.='>';
	$cadenaXML.=SubarbolXML_grupos_repositorios($cmd,$idcentro,0);
	$cadenaXML.='</REPOSITORIOS>';
	return($cadenaXML);
}
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function SubarbolXML_grupos_repositorios($cmd,$idcentro,$grupoid){
	global $LITAMBITO_GRUPOSREPOSITORIOS;
	global $AMBITO_GRUPOSREPOSITORIOS;
	global $LITAMBITO_REPOSITORIOS;
	$cadenaXML="";
	$rs=new Recordset; 
	$cmd->texto="SELECT idgrupo,nombregrupo,grupoid FROM grupos WHERE grupoid=".$grupoid." AND idcentro=".$idcentro." AND tipo=".$AMBITO_GRUPOSREPOSITORIOS." ORDER BY nombregrupo";
	$rs->Comando=&$cmd; 
	if (!$rs->Abrir()) return($cadenaXML); // Error al abrir recordset
	$rs->Primero(); 
	while (!$rs->EOF){
		$cadenaXML.='<GRUPOSREPOSITORIOS ';
		// Atributos		
		$cadenaXML.=' imagenodo="../images/iconos/carpeta.gif"';
		$cadenaXML.=' clickcontextualnodo="menu_contextual(this,'. " 'flo_".$LITAMBITO_GRUPOSREPOSITORIOS."'" .');"';
		$cadenaXML.=' infonodo="'.$rs->campos["nombregrupo"].'"';
		$cadenaXML.=' nodoid='.$LITAMBITO_GRUPOSREPOSITORIOS.'-'.$rs->campos["idgrupo"];
		$cadenaXML.='>';
		$cadenaXML.=SubarbolXML_grupos_repositorios($cmd,$idcentro,$rs->campos["idgrupo"]);
		$cadenaXML.='</GRUPOSREPOSITORIOS>';
		$rs->Siguiente();
	}
	$rs->Cerrar();
	$cmd->texto="SELECT idrepositorio,nombrerepositorio FROM repositorios WHERE grupoid=".$grupoid." AND idcentro=".$idcentro." order by idrepositorio desc" ;
	$rs->Comando=&$cmd; 
	if (!$rs->Abrir()) return($cadenaXML); // Error al abrir recordset
	$rs->Primero(); 
	while (!$rs->EOF){
		$cadenaXML.='<REPOSITORIO';
		// Atributos			
		$cadenaXML.=' clickcontextualnodo="menu_contextual(this,' ."'flo_".$LITAMBITO_REPOSITORIOS."'" .')"';
		$cadenaXML.=' imagenodo="../images/iconos/repositorio.gif" ';
		$cadenaXML.=' infonodo="'.$rs->campos["nombrerepositorio"].'"';
		$cadenaXML.=' nodoid='.$LITAMBITO_REPOSITORIOS.'-'.$rs->campos["idrepositorio"];
		$cadenaXML.='>';
		$cadenaXML.='</REPOSITORIO>';
		$rs->Siguiente();
	}
	$rs->Cerrar();
	return($cadenaXML);
}
//________________________________________________________________________________________________________
//
//	Menús Contextuales
//________________________________________________________________________________________________________
function CreacontextualXMLRepositorios(){
	global $AMBITO_REPOSITORIOS;
	global $AMBITO_GRUPOSREPOSITORIOS;
	global $LITAMBITO_GRUPOSREPOSITORIOS;
	global $LITAMBITO_REPOSITORIOS;
	global $TbMsg;

	$layerXML='<MENUCONTEXTUAL';
	$layerXML.=' idctx="flo_Raiz'.$LITAMBITO_REPOSITORIOS.'"';
	$layerXML.=' maxanchu=185';
	$layerXML.=' swimg=1';
	$layerXML.=' clase="menu_contextual"';
	$layerXML.='>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="insertar_grupos('.$AMBITO_GRUPOSREPOSITORIOS.',' . "'".$LITAMBITO_GRUPOSREPOSITORIOS."'" . ')"';
	$layerXML.=' imgitem="../images/iconos/carpeta.gif"';
	$layerXML.=' textoitem='.$TbMsg[0];
	$layerXML.='></ITEM>';

	$wLeft=140;
	$wTop=115; 
	$wWidth=550;
	$wHeight=280;
	$wpages="../propiedades/propiedades_repositorios.php";
	$wParam=$wLeft .",".$wTop.",".$wWidth.",".$wHeight.",'". $wpages."'";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="insertar('.$wParam.')"';
	$layerXML.=' imgitem="../images/iconos/aula.gif"';
	$layerXML.=' textoitem='.$TbMsg[1];
	$layerXML.='></ITEM>';

	$layerXML.='<SEPARADOR>';
	$layerXML.='</SEPARADOR>';

	$wParam="../gestores/gestor_repositorios.php";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="colocar('."'".$wParam."'".','.$AMBITO_REPOSITORIOS.')"';
	$layerXML.=' imgitem="../images/iconos/colocar.gif"';
	$layerXML.=' textoitem='.$TbMsg[2];
	$layerXML.='></ITEM>';

	$layerXML.='</MENUCONTEXTUAL>';
	return($layerXML);
}
//________________________________________________________________________________________________________
function CreacontextualXMLGruposRepositorios(){
	global $AMBITO_REPOSITORIOS;
	global $AMBITO_GRUPOSREPOSITORIOS;
	global $LITAMBITO_GRUPOSREPOSITORIOS;
	global $TbMsg;

	$layerXML='<MENUCONTEXTUAL';
	$layerXML.=' idctx="flo_'.$LITAMBITO_GRUPOSREPOSITORIOS.'"';
	$layerXML.=' maxanchu=185';
	$layerXML.=' swimg=1';
	$layerXML.=' clase="menu_contextual"';
	$layerXML.='>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="insertar_grupos('.$AMBITO_GRUPOSREPOSITORIOS.',' ."'".$LITAMBITO_GRUPOSREPOSITORIOS."'". ')"';
	$layerXML.=' imgitem="../images/iconos/carpeta.gif"';
	$layerXML.=' textoitem='.$TbMsg[0];
	$layerXML.='></ITEM>';

	$wLeft=140;
	$wTop=115;
	$wWidth=550;
	$wHeight=280;
	$wpages="../propiedades/propiedades_repositorios.php";
	$wParam=$wLeft .",".$wTop.",".$wWidth.",".$wHeight.",'". $wpages."'";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="insertar('.$wParam.')"';
	$layerXML.=' imgitem="../images/iconos/aula.gif"';
	$layerXML.=' textoitem='.$TbMsg[1];
	$layerXML.='></ITEM>';

	$layerXML.='<SEPARADOR>';
	$layerXML.='</SEPARADOR>';

	$wParam="../gestores/gestor_repositorios.php";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="colocar('."'".$wParam."'".','.$AMBITO_REPOSITORIOS.')"';
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
function CreacontextualXMLRepositorio(){
	global $AMBITO_REPOSITORIOS;
	global $LITAMBITO_REPOSITORIOS;
	global $TbMsg;

	$layerXML='<MENUCONTEXTUAL';
	$layerXML.=' idctx="flo_'.$LITAMBITO_REPOSITORIOS.'"';
	$layerXML.=' maxanchu=160';
	$layerXML.=' swimg=1';
	$layerXML.=' clase="menu_contextual"';
	$layerXML.='>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="muestra_inforRepositorios()"';
	$layerXML.=' textoitem='.$TbMsg[5];
	$layerXML.=' imgitem="../images/iconos/informacion.gif"';
	$layerXML.='></ITEM>';

	$layerXML.='<SEPARADOR>';
	$layerXML.='</SEPARADOR>';

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="mover('.$AMBITO_REPOSITORIOS.')"';
	$layerXML.=' imgitem="../images/iconos/mover.gif"';
	$layerXML.=' textoitem='.$TbMsg[6];
	$layerXML.='></ITEM>';

	$layerXML.='<SEPARADOR>';
	$layerXML.='</SEPARADOR>';

	$wLeft=140;
	$wTop=115;
	$wWidth=550;
	$wHeight=280;
	$wpages="../comandos/EliminarImagenRepositorio.php";
	$wParam=$wLeft .",".$wTop.",".$wWidth.",".$wHeight.",'". $wpages."'";

	$layerXML.='<ITEM';
	$layerXML.=' alpulsar="modificar('.$wParam.')"';	
	$layerXML.=' textoitem='.$TbMsg[10];
	$layerXML.=' imgitem="../images/iconos/comandos.gif"';
	$layerXML.='></ITEM>';

	$layerXML.='<SEPARADOR>';
	$layerXML.='</SEPARADOR>';

	$wLeft=140;
	$wTop=115;
	$wWidth=550;
	$wHeight=280;
	$wpages="../propiedades/propiedades_repositorios.php";
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


//________________________________________________________________________________________________________
function ContextualXMLComandos($litambito,$ambito){
	global $cmd;
	global $TbMsg;
 	$maxlongdescri=0;
	$descrip="";
	$rs=new Recordset;
	$cmd->texto="SELECT  idcomando,descripcion,pagina,gestor,funcion 
			FROM comandos 
			WHERE activo=1 AND aplicambito & ".$ambito.">0 
			ORDER BY descripcion";
	$rs->Comando=&$cmd; 
	if ($rs->Abrir()){
		$layerXML="";
		$rs->Primero(); 
		while (!$rs->EOF){
			if (isset($TbMsg["COMMAND_".$rs->campos["funcion"]])) {
			    $descrip=$TbMsg["COMMAND_".$rs->campos["funcion"]];
			}
			if (empty($descrip)) {
				$descrip=$rs->campos["funcion"];
			}
			$layerXML.='<ITEM';
			$layerXML.=' alpulsar="confirmarcomando('."'".$ambito."'".','.$rs->campos["idcomando"].',\''.$rs->campos["descripcion"].'\',\''.$rs->campos["pagina"]. '\',\''.$rs->campos["gestor"]. '\',\''.$rs->campos["funcion"]. '\')"';
			$layerXML.=' textoitem="'.$descrip.'"';
			$layerXML.='></ITEM>';
			if ($maxlongdescri < strlen($descrip)) // Toma la Descripción de mayor longitud
				$maxlongdescri=strlen($descrip);
			$rs->Siguiente();
		}
	$layerXML.='</MENUCONTEXTUAL>';
	$prelayerXML='<MENUCONTEXTUAL';
	$prelayerXML.=' idctx="flo_comandos_'.$litambito.'"';
	$prelayerXML.=' maxanchu='.$maxlongdescri*7;
	$prelayerXML.=' clase="menu_contextual"';
	$prelayerXML.='>';
	$finallayerXML=$prelayerXML.$layerXML;
	return($finallayerXML);
	}
}
?>
