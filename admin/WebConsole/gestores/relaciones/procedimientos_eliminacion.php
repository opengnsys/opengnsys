<?php
// *************************************************************************************************************************************************
// Aplicación WEB: ogAdmWebCon
// Autor: José Manuel Alonso (E.T.S.I.I.) Universidad de Sevilla
// Fecha Creación: Año 2009-2010
// Fecha Última modificación: Agosto-2010
// Nombre del fichero: procedimientos_eliminacion.php
// Descripción :
//	Elimina en cascada registros de la tabla procedimientos 
//		Parametros: 
//		-	cmd:Una comando ya operativo (con conexión abierta)  
//		-	identificador: El identificador por el que se eliminará el procedimiento
//		-	nombreid: Nombre del campo identificador del registro 
//		-	swid: Indica 0= El identificador es tipo alfanumérico	1= EI identificador es tipo numérico ( valor por defecto) *************************************************************************************************************************************************
function	EliminaProcedimientos($cmd,$identificador,$nombreid,$swid=1){
	global $EJECUCION_PROCEDIMIENTO;
	if (empty($identificador)) return(true);
	if($swid==0)
		$cmd->texto="SELECT  idprocedimiento  FROM  procedimientos WHERE ".$nombreid."='".$identificador."'";
	else
		$cmd->texto='SELECT  idprocedimiento  FROM procedimientos WHERE '.$nombreid.'='.$identificador;
	$rs=new Recordset; 
	$rs->Comando=&$cmd; 
	if (!$rs->Abrir()) return(false); // Error al abrir recordset
	if ($rs->numeroderegistros==0) return(true);
	$rs->Primero(); 
	while (!$rs->EOF){
		$cmd->texto="DELETE  FROM acciones_menus WHERE tipoaccion=".$EJECUCION_PROCEDIMIENTO." AND idtipoaccion=".$rs->campos["idprocedimiento"];
		$resul=$cmd->Ejecutar();
		if ($resul){
			$cmd->texto="DELETE  FROM procedimientos_acciones WHERE idprocedimiento=".$rs->campos["idprocedimiento"];
			$resul=$cmd->Ejecutar();
		}
		if ($resul){
			$cmd->texto="DELETE  FROM tareas_acciones WHERE idprocedimiento=".$rs->campos["idprocedimiento"];
			$resul=$cmd->Ejecutar();
		}
		if (!$resul){
			$rs->Cerrar();
			return(false);
		}
		$rs->Siguiente();
	}
	if($swid==0)
		$cmd->texto="DELETE  FROM procedimientos WHERE ".$nombreid."='".$identificador."'";
	else
		$cmd->texto='DELETE  FROM procedimientos  WHERE '.$nombreid.'='.$identificador;
	$resul=$cmd->Ejecutar();
	return($resul);
}

