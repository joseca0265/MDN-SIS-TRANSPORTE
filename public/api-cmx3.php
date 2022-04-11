
<?php 
/*
$ch = curl_init();
$url = 'https://api.gservicetrack.com/history/detektorsecurity?limit=25&dates=2021-04-07 00:00:00,2021-04-07 23:59:59&start=0&movil=MINEXC-01';

curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_HEADER, array(
      'x-api-key: fv5mc5jHsv5NQZ1MctioB1S06ra3J6e7aY9iwI8Z',
      'Content-Type: application/json',
	  'Accept-Encoding:gzip, deflate, br',
	  'Connection:keep-alive'
	  
   ));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$resp = curl_exec($ch);

if($e = curl_error($ch)){
	echo $e;
}else{
	$decoded = json_decode($resp);
	print_r($decoded);
	echo $decoded;

}

curl_close($ch);
*/

//$hoy = getdate();
date_default_timezone_set('America/Lima');

/*
echo "<br> Dia:".date("d");
echo "<br> Mes:".date("m");
echo "<br> Año:".date("Y");
*/
$dia = date("d");
$mes = date("m");
$anio = date("Y");
/*

echo "<br>";
echo "Hora: ".date("H");
echo "<br>Minuto: ".date("i");
*/

$hora_reporte = date("H");
$minuto_reporte = date("i");

if($hora_reporte == '00'){
	$limite_hora = '23:00';
}

$limite_hora = $hora_reporte - 1;

//echo "--Limite-Hora: ".$limite_hora;


$movil_consulta="CMX03";
//2021-04-07%2000:00:00
$f_inicio = "$anio-$mes-$dia%20$limite_hora:$minuto_reporte:00";
//2021-04-07%2023:59:59
$f_final="$anio-$mes-$dia%20$hora_reporte:$minuto_reporte:59";

//echo "<br>".$f_inicio;
//echo "<br>".$f_final;

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.gservicetrack.com/history/detektorsecurity?limit=1&start=0&movil=$movil_consulta&dates=$f_inicio,$f_final",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'x-api-key: fv5mc5jHsv5NQZ1MctioB1S06ra3J6e7aY9iwI8Z'
  ),
));

$response = curl_exec($curl);
$decoded = json_decode($response,true);

//var_dump(json_decode($response, true));
//echo $response;


//
	


$info = curl_getinfo($curl);

$codigo_error=$info['http_code'] ;

if ($codigo_error == 429){
	$cantidad_datos =0;
	//echo "Error de consulta";
}else{
	$cantidad_datos = $decoded['count'];
	//echo "Llego a consultar";
}
//echo $decoded['data'][0]['movil'];
/*echo "<br>";

echo "Cantidad de data ->".$decoded['count']."<br><br>";

*/


curl_close($curl);

require_once("conexion/conexion.php");

$obj=new ManejoBaseDatos();
$obj->conectar();



	if(!$cantidad_datos){
	
	}else{
	//echo "este es el dato del contador:".$contador;
	
	

for($i=0;$i<$cantidad_datos;$i++){
$latitud[$i] = $decoded['data'][$i]['lat'];
$longitud[$i] = $decoded['data'][$i]['lon'];
$ubicacion[$i] = $decoded['data'][$i]['location'];
$movil[$i] = $decoded['data'][$i]['movil'];
$fecha[$i] = $decoded['data'][$i]['date'];

$cmx3 = $obj->selectHistoricoCMX03($fecha[$i]);
$contador=0;
	while( $row = sqlsrv_fetch_array( $cmx3, SQLSRV_FETCH_ASSOC)) {
	  $fecha[]=$row['fecha'];
	  $contador++;
	}
if($contador>0){

}else{
	$obj->insertData($movil[$i],$fecha[$i],$latitud[$i],$longitud[$i],utf8_decode($ubicacion[$i]));
}
/*
echo "ID_historico-->".$i."<br>";
echo "Equipo-->".$movil[$i]."<br>";
echo "Fecha-->".$fecha[$i]."<br>";
echo "Latitud-->".$latitud[$i]."<br>";
echo "Longitud-->".$longitud[$i]."<br>";
echo "Ubicacion-->".$ubicacion[$i]."<br>";
echo "<br>";
*/


}

	}
//setlocale( LC_ALL, "Spanish_Peru.UTF-8" );
/*
$hoy = getdate();
date_default_timezone_set('America/Lima');
$dia = $hoy['mday'];
$mes = $hoy['mon'];
$anio = $hoy['year'];
$hora = $hoy['hours'];
print_r($hoy);

if(strlen($dia)==1){
	$dia = "0".$dia;
} 

if(strlen($mes)==1){
	$mes = "0".$mes;
}
echo "<br> Dia:".$dia;
echo "<br> Mes:".$mes;
echo "<br> Año:".$anio;


echo "<br>";
echo "Hora: ".date("H");
echo "<br>Minuto: ".date("i");

$hora_reporte = date("H");
$minuto_reporte = date("i");

if($hora_reporte == '00'){
	$hora_reporte = '23:00';
}

$limite_hora = $hora_reporte - 1;

echo "--Limite-Hora: ".$limite_hora;

*/
?>

