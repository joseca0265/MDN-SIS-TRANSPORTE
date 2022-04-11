<?php 	error_reporting(0); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Resultados</title>


<style>
body {
margin: 0;
padding: 0;
}
#map {
position: absolute;
top: 0;
bottom: 0;
width: 100%;
}
.marker1 {
background-image: url('iconos/1.png');
background-size: cover;
width: 50px;
height: 50px;
border-radius: 50%;
cursor: pointer;
}

.marker2 {
background-image: url('iconos/2.png');
background-size: cover;
width: 50px;
height: 50px;
border-radius: 50%;
cursor: pointer;
}

.marker3 {
background-image: url('iconos/3.png');
background-size: cover;
width: 50px;
height: 50px;
border-radius: 50%;
cursor: pointer;
}

.marker4 {
background-image: url('iconos/4.png');
background-size: cover;
width: 50px;
height: 50px;
border-radius: 50%;
cursor: pointer;
}
a.mapboxgl-ctrl-logo{
   background-image:none;
   display: none !important;
}
.mapboxgl-popup-content{
	font-size:11px;
	line-height:129%;
}
</style>
	
  <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
   
    <!--
 <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>-->



<link href='https://api.mapbox.com/mapbox-gl-js/v2.2.0/mapbox-gl.css' rel='stylesheet' />
<script src='https://api.mapbox.com/mapbox-gl-js/v2.2.0/mapbox-gl.js'></script>
   <!--	<link rel="stylesheet" href="dist/MarkerCluster.css" />
	<link rel="stylesheet" href="dist/MarkerCluster.Default.css" />
	<script src="dist/leaflet.markercluster-src.js"></script>-->
	

</head>

<?php

require_once("conexion/conexion.php");

$obj=new ManejoBaseDatos();
$obj->conectar();

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
            <!--<?php echo $busqueda;?>-->

            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li class="active"></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row-fluid">
        <div id="map"></div>

    </div>
</div>

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

<script>

var bounds = [

[-91.37224615128879,-18.1556508709991],
[-57.40833424744614, 0.20814680528115084]
 // Northeast coordinates

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

<?php $porciones = explode(",", $ubicaciones[$numero]);?>
console.log('<?php echo $porciones[1].", ".$porciones[0]; ?>');
mapboxgl.accessToken = 'pk.eyJ1IjoiamNhcmxvc21kbiIsImEiOiJja21jbXpleHcyZGxqMnF1c3piZ20yMTFsIn0.oLcKC9dIzw3jFKrZuLdcZA';
var map = new mapboxgl.Map({
		attributionControl: false,
container: 'map', 
style: 'mapbox://styles/jcarlosmdn/cknq8hz090soe17mnzo78idy9', 
center: [<?php echo $porciones[1].", ".$porciones[0]; ?>], // posicion inicial [longitud, latitud]
zoom:13,

maxBounds: bounds
});
		
	


<?php }else{
///mostrando todas las ubicaciones
?>
///Busqueda para ver todo el mapa - boton abrir mapa

mapboxgl.accessToken = 'pk.eyJ1IjoiamNhcmxvc21kbiIsImEiOiJja21jbXpleHcyZGxqMnF1c3piZ20yMTFsIn0.oLcKC9dIzw3jFKrZuLdcZA';
var map = new mapboxgl.Map({
		attributionControl: false,
container: 'map', 
style: 'mapbox://styles/jcarlosmdn/cknq8hz090soe17mnzo78idy9', 
center: [-75.33244572571617, -9.577903389286705], 
zoom:5,
maxzoom:5,
maxBounds: bounds
});
	<?php } ?>
	
map.loadImage(
'iconos/11.png',
function (error, image1) {
if (error) throw error;
map.addImage('custom-marker1', image1);

});

map.loadImage(
'iconos/22.png',
function (error, image2) {
if (error) throw error;
map.addImage('custom-marker2', image2);

});

map.loadImage(
'iconos/33.png',
function (error, image3) {
if (error) throw error;
map.addImage('custom-marker3', image3);

});

map.loadImage(
'iconos/44.png',
function (error, image4) {
if (error) throw error;
map.addImage('custom-marker4', image4);

});

//mapa normal
map.dragRotate.disable();
map.touchZoomRotate.disableRotation();

	
//INICIO
  map.on('load', function () {
        
		
        map.addSource('earthquakes', {
            type: 'geojson',
           
            data:
               {	
'type': 'FeatureCollection',
'features': [	
	<?php for($j=0;$j<$contador;$j++){
	$texto0=$indicador[$j];
	$texto1=$nombre[$j];
	$texto2=$empresa[$j];
	$texto3=$id[$j];
	$texto4=$disponibilidad[$j];
	$texto5=$codigo_division[$j];
	$lon=$longitud[$j];
	$lat=$latitud[$j];
		
	?>
{
'type': 'Feature',
'properties': {
'message': 'Foo',	
'indicador': '<?php echo $texto0; ?>',
'nombre': '<?php echo $texto1; ?>',
'empresa': '<?php echo $texto2; ?>',
'id': '<?php echo $texto3; ?>',
'disponibilidad': '<?php echo $texto4; ?>',
'iconMarker': '<?php echo $texto5; ?>',
'lat': '<?php echo $lon; ?>',
'lon': '<?php echo $lat; ?>',
},
'geometry': {
'type': 'Point',
'coordinates': ['<?php echo $lat; ?>', '<?php echo $lon; ?>']
}
},
<?php } ?>
]
},
			cluster: true,
            clusterMaxZoom: 14, // Max zoom to cluster points on
            clusterRadius: 25 // Radius of each cluster when clustering points (defaults to 50)
        });	

 map.addLayer({
            id: 'clusters',
            type: 'circle',
            source: 'earthquakes',
            filter: ['has', 'point_count'],
            paint: {
                // Use step expressions (https://docs.mapbox.com/mapbox-gl-js/style-spec/#expressions-step)
                'circle-color': [
                    'step',
                    ['get', 'point_count'],
                    '#599E9C',
                    100,
                    '#fff',
                    750,
                    '#62CB85'
                ],
                'circle-radius': [
                    'step',
                    ['get', 'point_count'],
                    20,
                    100,
                    30,
                    750,
                    40
                ]
            }
        });		
		
		        map.addLayer({
            id: 'cluster-count',
            type: 'symbol',
            source: 'earthquakes',
            filter: ['has', 'point_count'],
            layout: {
                'text-field': '{point_count_abbreviated}',
                'text-font': ['DIN Offc Pro Medium', 'Arial Unicode MS Bold'],
                'text-size': 15,
            },
			paint: {
			"text-color": "#ffffff"
}
        });
		
		
        map.addLayer({
		
            id: 'unclustered-point',
            type: 'symbol',
			layout: {
			'icon-image': 'custom-marker'+'{iconMarker}',
			'icon-size': 1,
			// get the title name from the source's "title" property


			'text-font': [
			'Open Sans Semibold',
			'Arial Unicode MS Bold',
			],
			'text-size': 10,
			'text-offset': [0, 4.25],
			'text-anchor': 'top',
			},

            source: 'earthquakes',
            filter: ['!', ['has', 'point_count']],
			


        
        });
		
		 map.on('click', 'clusters', function (e) {
            var features = map.queryRenderedFeatures(e.point, {
                layers: ['clusters']
            });
            var clusterId = features[0].properties.cluster_id;
            map.getSource('earthquakes').getClusterExpansionZoom(
                clusterId,
                function (err, zoom) {
                    if (err) return;

                    map.easeTo({
                        center: features[0].geometry.coordinates,
                        zoom: zoom
                    });
                }
            );
        });

 map.on('click', 'unclustered-point', function (e) {
            var coordinates = e.features[0].geometry.coordinates.slice();
            var id = e.features[0].properties.id;
			   var indicador = e.features[0].properties.indicador;
			    var empresa = e.features[0].properties.empresa;
				 var disponibilidad = e.features[0].properties.disponibilidad;
          	 var nombre = e.features[0].properties.nombre;
			
            while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
            }

            new mapboxgl.Popup({ offset: 15, closeOnClick: true  })
                .setLngLat(coordinates)
                .setHTML(
                    id + ' - <b>'+ nombre 
					+'</b><br>Empresa: '+ empresa 
					+'<br>Disponibilidad: <b>'+ disponibilidad 
					+"</b><br><a href='requerimientos/agregar/"+id+"'>Solicitar Equipo</a>"
				)
                .addTo(map);
        });
		
		 map.on('mouseenter', 'unclustered-point', function () {
            map.getCanvas().style.cursor = 'pointer';
        });
        map.on('mouseleave', 'unclustered-point', function () {
            map.getCanvas().style.cursor = '';
        });
		
			 map.on('mouseenter', 'clusters', function () {
            map.getCanvas().style.cursor = 'pointer';
        });
        map.on('mouseleave', 'clusters', function () {
            map.getCanvas().style.cursor = '';
        });
		 
		 
        });

	
</script>

</html>