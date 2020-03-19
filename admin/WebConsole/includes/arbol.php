<?php
/* Funciones auxiliares para pintar árboles de nodos en el frame izquierdo */

// grupos(tipo_nodo) 
// Descripción: Devuelve un array de grupos de imágenes. Ordenados por tipos de imágenes y grupo padre
// Parámetros: 
//     tipo_nodo: str tipo de elemento a mostrar en el árbol (aulas, imagenes, ...)
// devuelve: array de grupos.
// Nota: usamos la variable tipo por compatibilidad con grupos de imágenes.

function grupos_arbol($tipo_nodo) {
        global $cmd;
        global $idcentro;

        $grupos_hijos=Array();
	$sql="";

	switch ($tipo_nodo){
	    case 'aulas':
		global $AMBITO_GRUPOSAULAS;
		$ambito=$AMBITO_GRUPOSAULAS;
                break; 
	    case 'componenteshardware':
		global $AMBITO_GRUPOSCOMPONENTESHARD;
		$ambito=$AMBITO_GRUPOSCOMPONENTESHARD;
                break; 
	    case 'componentessoftware':
		global $AMBITO_GRUPOSCOMPONENTESSOFT;
		$ambito=$AMBITO_GRUPOSCOMPONENTESSOFT;
                break; 
	    case 'imagenes':
		$ambito="70, 71, 72";
                break; 
	    case 'menus':
		global $AMBITO_GRUPOSMENUS;
		$ambito=$AMBITO_GRUPOSMENUS;
                break; 
	    case 'ordenadores':
		$sql="SELECT gruposordenadores.idgrupo AS id, nombregrupoordenador AS nombre,
                            gruposordenadores.idaula AS conjuntoid, gruposordenadores.grupoid AS grupopadre
                       FROM gruposordenadores
                 INNER JOIN aulas
                      WHERE gruposordenadores.idaula=aulas.idaula AND idcentro=$idcentro
                   ORDER BY conjuntoid, gruposordenadores.grupoid;";
                break; 
	    case 'perfileshardware':
		global $AMBITO_GRUPOSPERFILESHARD;
		$ambito=$AMBITO_GRUPOSPERFILESHARD;
                break; 
	    case 'perfilessoftware':
		global $AMBITO_GRUPOSPERFILESSOFT;
		$ambito=$AMBITO_GRUPOSPERFILESSOFT;
                break; 
	    case 'perfilessoftwareincremental':
		global $AMBITO_GRUPOSSOFTINCREMENTAL;
		$ambito=$AMBITO_GRUPOSSOFTINCREMENTAL;
                break; 
	    case 'procedimientos':
		global $AMBITO_GRUPOSPROCEDIMIENTOS;
		$ambito=$AMBITO_GRUPOSPROCEDIMIENTOS;
                break; 
	    case 'repositorios':
		global $AMBITO_GRUPOSREPOSITORIOS;
		$ambito=$AMBITO_GRUPOSREPOSITORIOS;
                break; 
	    case 'tareas':
		global $AMBITO_GRUPOSTAREAS;
		$ambito=$AMBITO_GRUPOSTAREAS;
                break; 
	}
        if ($sql == "" && $ambito != "") {
		$sql="SELECT idgrupo AS id, nombregrupo AS nombre, grupos.grupoid AS grupopadre, tipo AS conjuntoid
                       FROM grupos
                      WHERE idcentro=$idcentro AND tipo IN ($ambito)
                   ORDER BY tipo, grupopadre, grupoid;";
	}
	if ($sql == "")	return ($grupos_hijos);

        $rs=new Recordset;
        $cmd->texto=$sql;
 echo "text: ".$cmd->texto;
 echo "<br><br>";
        $rs->Comando=&$cmd;
        if (!$rs->Abrir()) return($grupos_hijos);

        $rs->Primero();
        $oldgrupopadre=0;
        $num=-1;
        while (!$rs->EOF){
                $grupopadre=$rs->campos["grupopadre"];
                $nombre=$rs->campos["nombre"];

                $id=$rs->campos["id"];
                $conjuntoid=$rs->campos["conjuntoid"];
		// El tipo de grupo de imagenes son 70, 71 y 72 correspondiendo al tipo de imagen 1, 2 y 3
		if ($tipo_nodo == "imagenes") $conjuntoid-=69;

                if ($oldgrupopadre != $grupopadre) {
                        $oldgrupopadre=$grupopadre;
                        // Cuando cambio de grupo pongo el orden del array a cero
                        $num=0;
                } else {
                        $num++;
                }
                $grupos_hijos[$conjuntoid][$grupopadre][$num]["id"] = $id;
                $grupos_hijos[$conjuntoid][$grupopadre][$num]["nombre"] = $nombre;

                $rs->Siguiente();
        }
        $rs->Cerrar();
        return ($grupos_hijos);

}
/*
 * Descripción: Devuelve un array de nodos ordenados por el grupo al que pertenecen.
 * Parámetros:
 *     tipo_nodo: str tipo de elemento a mostrar en el árbol (aulas, imagenes, ...)
 *     Devuelve: array de nodos
 * Nota: Existen nodos clasificados por tipos. Para los no tienen tipos se usa un único tipo = 1
 */
function nodos_arbol($tipo_nodo){
        global $TbMsg;
        global $cmd;
        global $idcentro;
	//$nodos= Array();

	switch ($tipo_nodo){
	    case 'aulas':
		$sql="SELECT idaula AS id, nombreaula AS nombre, grupoid, '1' AS conjuntoid
			FROM  aulas
                      WHERE idcentro=$idcentro ORDER BY conjuntoid, grupoid;";
                break; 
	    case 'comandos':
		$sql="SELECT idcomando AS id, descripcion AS nombre, urlimg,
			    '1' AS conjuntoid, '0' AS grupoid
			FROM comandos
		       WHERE activo=1 ORDER BY conjuntoid, grupoid;";
                break; 
	    case 'componenteshardware':
		$sql="SELECT hardwares.idhardware AS id, hardwares.descripcion AS nombre,
			     tipohardwares.urlimg, '2' AS conjuntoid, grupoid
		        FROM hardwares INNER JOIN tipohardwares
		       WHERE hardwares.idtipohardware=tipohardwares.idtipohardware AND idcentro=$idcentro
                    ORDER BY conjuntoid, grupoid;";
                break; 
	    case 'componentessoftware':
		$sql="SELECT softwares.idsoftware AS id, softwares.descripcion AS nombre,
			     tiposoftwares.urlimg, '2' AS conjuntoid, grupoid
                        FROM softwares INNER JOIN tiposoftwares
		       WHERE softwares.idtiposoftware=tiposoftwares.idtiposoftware AND idcentro=$idcentro
		     ORDER BY conjuntoid, grupoid;";
                break; 
	    case 'imagenes':
		$sql="SELECT DISTINCT imagenes.idimagen AS id ,imagenes.descripcion AS nombre,
			              imagenes.tipo AS conjuntoid, imagenes.grupoid,
                             IF(imagenes.idrepositorio=0,basica.idrepositorio,imagenes.idrepositorio)  AS repo
                        FROM imagenes
                   LEFT JOIN imagenes AS basica  ON imagenes.imagenid=basica.idimagen
                       WHERE imagenes.idcentro=$idcentro ORDER BY conjuntoid, grupoid;";
                break; 
	    case 'menus':
		$sql="SELECT idmenu AS id, descripcion AS nombre, '1' AS conjuntoid, grupoid
			FROM menus  
		       WHERE idcentro=$idcentro ORDER BY conjuntoid, grupoid;";
                break; 
	    case 'ordenadores':
		$sql="SELECT idordenador AS id, nombreordenador AS nombre,
                             ordenadores.idaula AS conjuntoid, ordenadores.grupoid
                        FROM ordenadores
                  INNER JOIN aulas
                       WHERE ordenadores.idaula=aulas.idaula AND idcentro=$idcentro
                    ORDER BY conjuntoid, grupoid;";
                break; 
	    case 'perfileshardware':
		$sql="SELECT idperfilhard AS id, descripcion AS nombre,
			     '3' AS conjuntoid, grupoid
			FROM perfileshard
		       WHERE idcentro=$idcentro
                   ORDER BY conjuntoid, grupoid;";
                break; 
	    case 'perfilessoftware':
		$sql="SELECT idperfilsoft AS id, descripcion AS nombre,
			     '3' AS conjuntoid, grupoid
			FROM perfilessoft
		       WHERE idcentro=$idcentro
                   ORDER BY conjuntoid, grupoid;";
                break; 
	    case 'procedimientos':
		$sql="SELECT idprocedimiento AS id, descripcion AS nombre, '2' AS conjuntoid, grupoid
		        FROM procedimientos
		       WHERE idcentro=$idcentro ORDER BY conjuntoid, grupoid;";
                break; 
	    case 'repositorios':
		$sql="SELECT idrepositorio AS id, nombrerepositorio AS nombre, '1' AS conjuntoid, grupoid
	    	        FROM repositorios
		       WHERE idcentro=$idcentro ORDER BY conjuntoid, grupoid;";
                break; 
	    case 'tareas':
		$sql="SELECT idtarea AS id, descripcion AS nombre, ambito, '3' AS conjuntoid, grupoid
                        FROM tareas 
		       WHERE idcentro=$idcentro ORDER BY conjuntoid, grupoid;";
                break; 
	    case 'tiposhardware':
		$sql="SELECT idtipohardware AS id, descripcion AS nombre, urlimg, nemonico,
			     '1' AS conjuntoid, '0' AS grupoid
                        FROM tipohardwares
		    ORDER BY conjuntoid, grupoid;";
                break; 
	    case 'tipossoftware':
		$sql="SELECT idtiposoftware AS id, descripcion AS nombre, urlimg,
			     '1' AS conjuntoid, '0' AS grupoid
                        FROM tiposoftwares
		    ORDER BY conjuntoid, grupoid;";
                break; 
	}
	
echo "sql: ".$sql;
echo "<br><br>";
        $nodos=Array();
        $grupos_hijos=Array();
        $rs=new Recordset;
        $cmd->texto=$sql;

        $rs->Comando=&$cmd;
        if (!$rs->Abrir()) return(Array($nodos));

        $rs->Primero();
        $ordenNodo=-1;
	$oldgrupoid=(isset($rs->campos["grupoid"]))? $rs->campos["grupoid"] : 0;
	while (!$rs->EOF){
		$conjuntoid=$rs->campos["conjuntoid"];
                $id=$rs->campos["id"];
                $descripcion=$rs->campos["nombre"];
                // Las nodos de un grupo son un array. Cuando cambio de grupo pongo el orden a cero:
                $grupoid=(isset($rs->campos["grupoid"]))? $rs->campos["grupoid"] : 0;
                if ($oldgrupoid != $grupoid) {
                        $oldgrupoid=$grupoid;
                        $ordenNodo=0;
                } else {
                        $ordenNodo=$ordenNodo+1;
                }

                $nodos[$conjuntoid][$grupoid][$ordenNodo]["descripcion"]=$descripcion;
                $nodos[$conjuntoid][$grupoid][$ordenNodo]["id"]=$id;
                $rs->Siguiente();
        }

        $rs->Cerrar();
        return($nodos);
}



?>
