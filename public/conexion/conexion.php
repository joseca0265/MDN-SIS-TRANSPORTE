<?php 
class ManejoBaseDatos {
	private $conn;
 function conectar() {
    $serverName = "dbmdnperucomercial.database.windows.net"; //serverName\instanceName
    $connectionInfo = array( "Database"=>"STOCK Y ALMACÉN", "UID"=>"josearmacanqui", "PWD"=>"Interbank14");
   
  
       $this->conn = sqlsrv_connect( $serverName, $connectionInfo);

		if( $this->conn ) {
     echo "<br/>";
}else{
     echo "Conexión no se pudo establecer.<br/>";
     die( print_r( sqlsrv_errors(), true));
}
 }


function selectPromociones(){
   $sql = "SELECT * FROM MDN_Equipos_GPS";
		$stmt=sqlsrv_query($this->conn,$sql);
		if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}?><table border="2px"><tr><td>ID</td><td>Indicador</td><td>Empresa</td><td>Nombre Buscador</td><td>Longitud</td><td>Latitud</td>
	</tr><?php
	
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	$i=0;
	$contenedor[$i]=$row['Indicador'];
	$i++;
	
      echo "<tr><td>".$row['id']."</td><td> ".$row['Indicador']."</td><td> ".$row['Empresa']."</td><td>".$row['Nombre_buscador']."</td><td>".$row['Longitud']."</td><td>".$row['Latitud']."</td></tr>";
	  
}?></table><?php

sqlsrv_free_stmt( $stmt);
		}
 
		function insertData($codigo,$fecha,$latitud,$longitud,$ubicacion){
			$sql = "INSERT INTO historial_ubicaciones_gps(codigo,fecha,latitud,longitud,ubicacion) values('$codigo','$fecha','$latitud','$longitud','$ubicacion');";
			$stmt=sqlsrv_query($this->conn,$sql);
			if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
			}
			return $stmt;
		}
		
		function selectHistoricoCMX03($fecha){
			$sql = "SELECT * FROM historial_ubicaciones_gps where codigo = 'CMX03' and fecha='$fecha';";
			$stmt=sqlsrv_query($this->conn,$sql);
			if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
			}
			return $stmt;
		}

		function selectVista(){
			$sql = "SELECT * FROM MDN_Equipos_GPS;";
			$stmt=sqlsrv_query($this->conn,$sql);
			if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
			}
			return $stmt;
		}

		function selectBusquedaPrincipal($equipo){
			$sql = "SELECT * FROM MDN_Equipos_GPS 
			WHERE Nombre_buscador like '%$equipo%'";
			$stmt=sqlsrv_query($this->conn,$sql);
			if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
			}
			return $stmt;
		}
		
		//Esta es la funcion para la consulta x categoria de equipos del buscador
		function selectBusquedaCategoria($categoria){
			$sql = "SELECT * FROM MDN_Equipos_GPS 
			WHERE Codigo_division = $categoria";
			$stmt=sqlsrv_query($this->conn,$sql);
			if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
			}
			return $stmt;
		}


}
  
?>
	

	
	
				

    	
	
