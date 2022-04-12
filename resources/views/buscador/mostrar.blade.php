@extends("header_buscador")
@section("titulo", "Buscador")
@section("contenido")


<div id="app" class="container">
	<br><br><br><br>

					<center>
					<a href="resultados.php?categoria=1">
					<img class="logo" style="margin-left:-300px;width:35px;height:35px" src='{{url("/img_actualizado/icono_1.png") }}'>
					</a>
					</center>
						
					<center style="margin-top:-28px;position:relative;">
					<a href="resultados.php?categoria=2">
					<img class="logo" style="margin-left:365px;width:35px;height:35px" src='{{url("/img_actualizado/icono_3.png") }}'>
					</a>
					</center>
					<!--fondo de buscador-->
					<center style="margin-top:-17px;margin-left:-450px">
					<img class="logo" style="position:absolute;z-index:-1;margin-top:-54px;width:750px;margin-left:-131px" 
					src='{{url("/img_actualizado/fondo_buscador.png") }}'>
					</center>
					
                    <center style="margin-top:-17px"> <a href="https://www.mdnperu.com"><img class="logo" style="max-height: 93px;margin-top:-26px" 
					src='{{url("/img_actualizado/sin-fondo.png") }}'></a>
					</center>
					
					<center style="margin-top:-21px">
					<a href="resultados.php?categoria=4">
					<img class="logo" style="margin-left:310px;width:35px;height:35px" src='{{url("/img_actualizado/icono_4.png") }}'>
					</a>
					</center>
					
					 <center style="margin-top:-45px">
					 <a href="resultados.php?categoria=3">
					 <img class="logo" style=" margin-left:-330px;width:35px;height:35px" src='{{url("/img_actualizado/icono_2.png") }}'>
					 </a>
					 </center>
					 
					 <br><br>
				
				
					  <br>
					<center style="padding-left:45px">  <div >
					 <form method="POST" action="resultados.php">

					  <!--CAJA DE BUSQUEDA-->
					<div class="row" style="font-weight:600;font-size:13px" >
					<div class="col s12" >
					<div class="row" >
					<div class="input-field col s12" style="margin-top:-2.5%" >
       
					<i class="fa fa-search" style="position:absolute; padding:13px;padding-top:17px;"></i>
					<input type="text" placeholder="Ejemplo: Autohormigonera Carmix 5.5" name="buscador"
					id="autocomplete-input" autocomplete="off" class="autocomplete form-control-lg" 
					style="padding-left:35px;border:1px solid #d9d9d9;width:620px; height:45px;border-radius:10px;font-size:13px">
         
					<div>
					<!--BUSQUEDA RAPIDA-->
					<!--Oculto-->
					<input class="form-control-lg seleccion" id="submit" type="submit" value="Búsqueda Rápida"
						style="height:36px;width:165px;border-radius:8px;border:0px solid;margin-top:26px;color:#7f7f7f;font-weight:600;font-size:13px">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<!--ABRIR MAPA -->
					<a href="resultados.php?busqueda="><input type="button" class="form-control-lg seleccion" name="btnVerTodo"  value="Abrir Mapa"
						style="height:36px;width:165px;border-radius:8px;border:0px solid;color:#7f7f7f;font-weight:600;font-size:13px"></a>
					</div>
					</div>
					</div>
					</div>
					</div>
					</div>

					</form>	
					</center>	
           
</div>

<br>


<style>
.form-control-lg{
     
      outline: none;
	 
}
::-webkit-scrollbar {
    display: none;
}
.seleccion{
  transition: background-color .5s;
}

.seleccion:hover{
	background-color:#7f7f7f50;
	font-size:15px;
}
#buscador::placeholder {
            color: #7f7f7f90;
			font-weight:600;
          }



</style>


 <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
            
		<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
		<?php  



include('departamentos.php');

		?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
	  var options={
		   data: {
          <?php for($i=1;$i<29;$i++){?>
		
		'<?php echo $equipos[$i];?>':null,
		   <?php }?>
		<?php for($i=1;$i<99;$i++){?>
		
		'<?php echo $departamentos[$i];?>':null,
		   <?php }?>
		
		"Autohormigonera Fiori": null,
		"Minicargador": null,
		
        "Arequipa": null,
		"LAPTOP HP": null,
		"LAPTOP DELL": null,
		
      },
	  limit: 4,
	  
	  onAutocomplete:function(res){
	document.getElementById("submit").click();
	    var expresionRegular = "-";
		var data = res.split(expresionRegular);
	
	console.log(data[0]);
	
	  }
			  
	  };
	  
    var elems = document.querySelectorAll('.autocomplete');
    var instances = M.Autocomplete.init(elems, options);
  });

function BuscarRapido(){
document.getElementById("submit").click();

}
       
</script>

@endsection


