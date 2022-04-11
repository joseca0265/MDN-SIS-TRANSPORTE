<?php 	error_reporting(0); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Resultados</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
	 <link href="css/mapa.css" rel="stylesheet">
	<link rel="shortcut icon" type="image/jpg" href="img/favicon.png"/>
    <link rel="stylesheet" href="css/bootstrap-responsive.css">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/dvf.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="css/example.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="css/ui.css" type="text/css" media="screen"/>
	
	<link rel="stylesheet" href="dist/MarkerCluster.css" />
	<link rel="stylesheet" href="dist/MarkerCluster.Default.css" />
	
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
<div class="container-fluid">
    <div class="row-fluid">
        <div id="map"></div>
        <!--<div id="info" class="leaflet-control-legend"><span style="font-style: italic; font-size: 16px;">Click on airport to view details</span></div>-->
    </div>
</div>


<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

<script type="text/javascript" src="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.js"></script>
<script type="text/javascript" src="http://maps.stamen.com/js/tile.stamen.js?v1.2.3"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.1/underscore-min.js"></script>

<!--

<script type="text/javascript" src="../lib/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src = "http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.0.0/moment.min.js" ></script>
<script type="text/javascript" src="../data/flightData.js"></script>
<script type="text/javascript" src="../data/usAirports.js"></script>	<script src="dist/leaflet.markercluster-src.js"></script>-->
<script type="text/javascript" src="js/leaflet-dvf.js"></script>


<script src="dist/leaflet.markercluster.js"></script>

<script type="text/javascript">


    $(document).ready(function () {
		$('.leaflet-control-attribution').hide()
        var map;
		
       
        var $map = $('#map');
        var resize = function () {
            $map.height($(window).height() - $('div.navbar').outerHeight());
			$map.attributionControl = false;

            if (map) {
                map.invalidateSize();
            }
        };

        $(window).on('resize', function () {
            resize();
        });

        resize();
		
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

map = L.map('map',{
	//attributionControl: false,
	minZoom: 6,
	maxZoom: 18,
	zoomSnap: 0,
	zoomDelta: 0.50,
	maxBounds: bounds
	}).setView([<?php echo $ubicaciones[$numero]; ?>],8);



<?php }else{
///codigo mostrando todas las ubicaciones



	?>


					
map = L.map('map',options: {
	//attributionControl: false,
	minZoom: 6,
	maxZoom: 18,
	zoomSnap: 0,
	zoomDelta: 0.50,
	maxBounds: bounds
	}).setView([-9.577903389286705, -75.33244572571617],6);



<?php } ?>

var CustomIcon = L.Icon.extend({
		options: {
		iconSize:     [35, 35],
		iconAnchor:   [15, 25]
		}
	});
	
	var rectIcon2 = new CustomIcon({iconUrl: 'https://image.flaticon.com/icons/svg/854/854866.svg'})
	
		var Icon1 = new CustomIcon({iconUrl: 'iconos/ConstCivil.png'})
			var Icon2 = new CustomIcon({iconUrl: 'iconos/Izaje.png'})
				var Icon3 = new CustomIcon({iconUrl: 'iconos/Liviano.png'})
					var Icon4 = new CustomIcon({iconUrl: 'iconos/Movimiento.png'})

var markers = L.markerClusterGroup({ animateAddingMarkers : true,
									polygonOptions: {color: 'transparent'}	
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


//get randomlat long para generar 100 puntos random
//console.log({<?php echo "lat: ".$longitud[$j];?>, <?php echo "lng: ".$latitud[$j];?>});

markers.addLayer(m).addTo(map);
//map.addLayer(markers);

/*
L.marker([<?php echo $longitud[$j];?>, <?php echo $latitud[$j];?>],{icon: Icon<?php echo $codigo_division[$j]; ?>} ,1000, {
	color: '#985',
	fillcolor: '#03',
	fillOpacity: 0.5
}).addTo(map)
.bindPopup(""+'<?php echo $texto3; ?> - '+"<b>"+'<?php echo $texto0; ?>'+
"<br>"+'<?php echo $texto1; ?>'+"</b><br>Empresa:"+'<?php echo $texto2; ?>'+
"<br><b style='color:#787334'>Disponibilidad: "+'<?php echo $texto4; ?>'+"</b>"+

" <br> <br><a href='requerimientos/agregar/<?php echo $texto3; ?>'>Solicitar Equipo</a>");
*/
<?php } ?>






	   
        // Add the Stamen toner tiles as a base layer
        var baseLayer = new L.StamenTileLayer('toner', {
            detectRetina: true
        }).addTo(map);


    });
	
	
	
</script>
</body>
</html>