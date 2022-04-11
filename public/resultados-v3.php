<?php 	error_reporting(0); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Resultados</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<style>
	#mapid { height: 780px; width: 70% }
	</style>
		<style>
		.mycluster {
			 margin-top: -20px;
			 background-size: 30px;
			  background-image: url("iconos/ConstCivil-gris.png");
			 background-repeat: no-repeat;
			text-align: center;
			font-size: 18px;
			color:#fff;
			text-shadow:
   -1px -1px 0 #000,  
    1px -1px 0 #000,
    -1px 1px 0 #000,
     1px 1px 0 #000;
			  line-height: 29px;
			background-position: center;
			  position: relative;
		}

	</style>
	
   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
   
    <!-- Make sure you put this AFTER Leaflet's CSS 	<link rel="stylesheet" href="dist/MarkerCluster.Default.css" />-->
 <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>



<link href='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.css' rel='stylesheet' />
<script src='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.js'></script>
   	<link rel="stylesheet" href="dist/MarkerCluster.css" />

	<script src="dist/leaflet.markercluster-src.js"></script>
	   <style type="text/css">
			.leaflet-tile-loaded {
			    filter: brightness(0.95) invert(0) grayscale(10000);
			}
			.leaflet-container a {
				color: #123555;
			}
			.leaflet-container .leaflet-control-attribution {
				background: #159;
				background-color: #fff;
			}
			body { margin:0; padding:0; }
			#map { position:absolute; top:0; bottom:0; width:100%; }
	  	</style>
</head>

<?php

require_once("conexion/conexion.php");

$obj=new ManejoBaseDatos();
$obj->conectar();
//$obj->selectPromociones();

include('departamentos.php');

if( $_GET["categoria"]){
	
	$cate = $_GET["categoria"];

	$datos_categoria=$obj->selectBusquedaCategoria($cate);

	$contador=0;
	$valida_cate=0;
	while( $row_cate = sqlsrv_fetch_array( $datos_categoria, SQLSRV_FETCH_ASSOC)) {
	  $indicador[]=$row_cate['Indicador'];
	  $nombre[]=$row_cate['Nombre_buscador'];
	  $id[]=$row_cate['id'];
	  $longitud[]=$row_cate['Longitud'];
	  $latitud[]=$row_cate['Latitud'];
	  $empresa[]=$row_cate['Empresa'];
	  $disponibilidad[]=$row_cate['Disponibilidad'];
	  $codigo_division[]=$row_cate['Codigo_division'];
		
	  $contador++; 
	  $valida_cate++;
	
	}
		
}else{
	
$busqueda = $_POST['buscador'];

$contador = strlen($busqueda);

$inicial = substr($busqueda,0,1); 
$final = substr($busqueda,1,$contador); 

$letra_inicial = strtoupper($inicial);

$busqueda = $letra_inicial.$final;

	$datos=$obj->selectBusquedaPrincipal($busqueda);
	
	$contador=0;
	while( $row = sqlsrv_fetch_array( $datos, SQLSRV_FETCH_ASSOC)) {
	  $indicador[]=$row['Indicador'];
	  $nombre[]=$row['Nombre_buscador'];
	  $id[]=$row['id'];
	  $longitud[]=$row['Longitud'];
	  $latitud[]=$row['Latitud'];
	  $empresa[]=$row['Empresa'];
	    $disponibilidad[]=$row['Disponibilidad'];
		$codigo_division[]=$row['Codigo_division'];
		
	  $contador++;

	}
	
	if($indicador[0] == ""){

	$n_busqueda = substr($busqueda, 0, 3);

	$datos=$obj->selectBusquedaPrincipal($n_busqueda);
	$contador=0;
	while( $row = sqlsrv_fetch_array( $datos, SQLSRV_FETCH_ASSOC)) {
	  $indicador[]=$row['Indicador'];
	  $nombre[]=$row['Nombre_buscador'];
	  $id[]=$row['id'];
	  $longitud[]=$row['Longitud'];
	  $latitud[]=$row['Latitud'];
	  $empresa[]=$row['Empresa'];
	    $disponibilidad[]=$row['Disponibilidad'];
		$codigo_division[]=$row['Codigo_division'];
		
	  $contador++;

	}
	
	}
	
?>
<?php }?>
<body>
<div class="navbar">
    <div class="navbar-inner" style="margin-top:-20px">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <?php echo $busqueda;?>

            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li class="active"></li>
                </ul>
            </div>
        </div>
    </div>
</div>

        <div id="map"></div>
        <!--<div id="info" class="leaflet-control-legend"><span style="font-style: italic; font-size: 16px;">Click on airport to view details</span></div>-->


</body>
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.js"></script>
<script type="text/javascript" src="http://maps.stamen.com/js/tile.stamen.js?v1.2.3"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.1/underscore-min.js"></script>

<!--

<script type="text/javascript" src="../lib/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src = "http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.0.0/moment.min.js" ></script>
<script type="text/javascript" src="../data/flightData.js"></script>
<script type="text/javascript" src="../data/usAirports.js"></script>	<script src="dist/leaflet.markercluster-src.js"></script>
<script type="text/javascript" src="js/leaflet-dvf.js"></script>


<script src="dist/leaflet.markercluster.js"></script>-->

<script type="text/javascript">


		
		var bounds = [
[-19.019692520435946, -70.0736549907865], // Southwest coordinates
[0.6889060059792217, -76.05743390525693], // Northeast coordinates
[-7.058481706809659, -63.71723571980325],//este
[-9.947903032924703, -88.88728305417061]//oeste
];

<?php  ?>
		
<?php 

include('departamentos.php');
$validador=0;
$numero=0;
for($j=1;$j<99;$j++){
if ($busqueda == $departamentos[$j]){
	$numero=$j;
	?>

//map = L.map('map',{attributionControl: false}).setView([-9.577903389286705, -75.33244572571617],6);
<?php }else{
	$validador++;?> <?php
 }} 

if($numero>0){

$datos_total=$obj->selectVista();
	$contador=0;
	while( $row = sqlsrv_fetch_array( $datos_total, SQLSRV_FETCH_ASSOC)) {
	  $indicador[]=$row['Indicador'];
	  $nombre[]=$row['Nombre_buscador'];
	  $id[]=$row['id'];
	  $longitud[]=$row['Longitud'];
	  $latitud[]=$row['Latitud'];
	  $empresa[]=$row['Empresa'];
	   $disponibilidad[]=$row['Disponibilidad'];
	   $codigo_division[]=$row['Codigo_division'];
		
	  $contador++;

	}
	
?>
L.mapbox.accessToken = 'pk.eyJ1IjoiamNhcmxvc21kbiIsImEiOiJja21jbXpleHcyZGxqMnF1c3piZ20yMTFsIn0.oLcKC9dIzw3jFKrZuLdcZA';
var map = L.mapbox.map('map')
    .setView([<?php echo $ubicaciones[$numero]; ?>],8)
    .addLayer(L.mapbox.styleLayer('mapbox://styles/jcarlosmdn/cknq8hz090soe17mnzo78idy9'));
	
		
	


<?php }else{
///codigo mostrando todas las ubicaciones

	?>


	L.mapbox.accessToken = 'pk.eyJ1IjoiamNhcmxvc21kbiIsImEiOiJja21jbXpleHcyZGxqMnF1c3piZ20yMTFsIn0.oLcKC9dIzw3jFKrZuLdcZA';
var map = L.mapbox.map('map')
    .setView([-9.577903389286705, -75.33244572571617],6)
    .addLayer(L.mapbox.styleLayer('mapbox://styles/jcarlosmdn/cknq8hz090soe17mnzo78idy9'));
	
		
	


<?php } ?>

var CustomIcon = L.Icon.extend({
		options: {
		iconSize:     [35, 35],
		iconAnchor:   [15, 25]
		}
	});
	
	var rectIcon2 = new CustomIcon({iconUrl: 'https://image.flaticon.com/icons/svg/854/854866.svg'})
	
		var Icon1 = new CustomIcon({iconUrl: 'iconos/ConstCivil-gris.png'})
			var Icon2 = new CustomIcon({iconUrl: 'iconos/Izaje-gris.png'})
				var Icon3 = new CustomIcon({iconUrl: 'iconos/Liviano-gris.png'})
					var Icon4 = new CustomIcon({iconUrl: 'iconos/Movimiento-gris.png'})

var markers = L.markerClusterGroup({ animateAddingMarkers : true,
maxClusterRadius: 70,
									polygonOptions: {color: 'transparent'},
									iconCreateFunction: function (cluster) {
				var markers = cluster.getAllChildMarkers();
				
				return L.divIcon({ html: markers.length, className: 'mycluster', iconSize: L.point(30, 30) });
			},
								
});

//map.addLayer(markers);	

	<?php for($j=0;$j<$contador;$j++){
	$texto0=$indicador[$j];
	$texto1=$nombre[$j];
	$texto2=$empresa[$j];
	$texto3=$id[$j];
	$texto4=$disponibilidad[$j];
	$texto5=$codigo_division[$j];
		
	?>


var m = L.marker({<?php echo "lat: ".$longitud[$j];?>, <?php echo "lng: ".$latitud[$j];?>},{icon: Icon<?php echo $codigo_division[$j]; ?>},1000, {
	color: '#985',
	fillcolor: '#03',
	fillOpacity: 0.5
}).bindPopup(""+'<?php echo $texto3; ?> - '+"<b>"+'<?php echo $texto0; ?>'+
"<br>"+'<?php echo $texto1; ?>'+"</b><br>Empresa:"+'<?php echo $texto2; ?>'+
"<br><b style='color:#787334'>Disponibilidad: "+'<?php echo $texto4; ?>'+"</b>"+
"<br> <br><a href='requerimientos/agregar/<?php echo $texto3; ?>'>Solicitar Equipo</a>");


markers.addLayer(m).addTo(map);
//map.addLayer(markers);

<?php } ?>

        // Add the Stamen toner tiles as a base layer
    
	
	
	
</script>

</html>