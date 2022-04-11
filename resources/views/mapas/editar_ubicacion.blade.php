@extends("maestra")
@section("titulo", "Editar mapa")
@section("contenido")
    <div class="container">
        <div class="columns">
            <div class="column">
                <h2 style="font-size:22px"> <b>EQUIPO: {{$mapa->Nombre_buscador}}</b></h2> <br>
                <form method="POST" action="{{route("guardarCambiosMapa")}}">
                    @method("put")
                    @csrf
					<div class="columns">
				<div class="column" Style="max-width:480px">
                    <input type="hidden" value="{{$mapa->id}}" name="id">
					<div class="field">
					<?php
					$a;
					$b;
					$c;
					$d;
					$e;
					$f;
					if(($mapa->Indicador) == 'PROPIO'){
					$a='checked';
					}else{
						$a='';
					}
					if(($mapa->Indicador) == 'SUBARRENDADO'){
					$b='checked';
					}else{
						$b='';
					}
					
					
					if(($mapa->Codigo_division) == '1'){
					$c='checked';
					}else{
						$c='';
					}
					if(($mapa->Codigo_division) == '2'){
					$d='checked';
					}else{
						$d='';
					}
					if(($mapa->Codigo_division) == '3'){
					$e='checked';
					}else{
						$e='';
					}
					if(($mapa->Codigo_division) == '4'){
					$f='checked';
					}else{
						$f='';
					}
					?>
					  <label class="label">Propietario</label>
                        <div class="control">
                            <input type="radio" name="rol" id="Administrador" value="PROPIO" <?php echo $a; ?>>
							<label for="Administrador"  >Propio</label>
							<br>
							<input type="radio" name="rol" id="Empleado" value="SUBARRENDADO" <?php echo $b; ?>>  
							<label for="Empleado"  >Subarrendado</label>
							<br>
							
							
                        </div>
                  
					</div>
					
                    <div class="field">
                        <label class="label">Empresa</label>
                        <div class="control">
                            <input autocomplete="off" name="empresa" class="input" type="text" value="{{$mapa->Empresa}}"
                                   placeholder="Empresa - Nombre - Razon Social">
                        </div>
                  
					</div>
					
				
					
					<div class="field">
                        <label class="label">Nombre</label>
                        <div class="control">
                            <input autocomplete="off" name="nombre" class="input" type="text" value="{{$mapa->Nombre_buscador}}"
                                   placeholder="Digite el nombre del equipo">
                        </div>
                  
					</div>
					
					<div class="field">
                        <label class="label">Ubicacion Actual</label>
                        <div class="control">
                            <input autocomplete="off" name="ubicacion_actual" class="input" type="text" value="{{$mapa->Ubicación_actual}}"
                                   placeholder="Digite la ubicación del equipo">
                        </div>
                  
					</div>
					
                    <div class="field">
                        Latitud, Longitud <label class="label">Ejemplo: -12.286455910642195, -76.86299875646704</label>
                        <div class="control">
			
								   
                            <input  autocomplete="off" name="ubicacion" class="input" type="text"
                                   value ="<?php echo $mapa->Longitud.", ".$mapa->Latitud; ?>">
                        </div>
                    </div>
						</div>
						
						
						<div class="column">
					
					<div class="field">
                        <b>Codigo </b> 
						 <div class="control">
                            <input autocomplete="off" name="codigo" class="input" type="text" style="font-size:15px;width:450px"
                                  value="{{$mapa->Codigo}}" placeholder="Digite el codigo del equipo">
								   </div>
					</div>
					
					<div class="field">
                        <b>Marca </b> 
						 <div class="control">
                            <input autocomplete="off" name="marca" class="input" type="text" style="font-size:15px;width:450px"
                                value="{{$mapa->Marca}}"   placeholder="Digite la marca del equipo">
								   </div>
					</div>
					
					<div class="field">
                        <b>Modelo </b> 
						 <div class="control">
                            <input autocomplete="off" name="modelo" class="input" type="text" style="font-size:15px;width:450px"
                                 value="{{$mapa->Modelo}}"  placeholder="Digite el modelo del equipo">
								   </div>
					</div>
					
					<div class="field">
                        <b>Categoria </b> 
						 <div class="control">
                           <input type="radio" name="categoria" id="construccion" value="1" <?php echo $c; ?>>
							<label for="construccion">Construcción Civil</label>
							<br>
							<input type="radio" name="categoria" id="movimiento_tierra" value="4" <?php echo $f; ?>>  
							<label for="movimiento_tierra">Movimiento de Tierra</label>
							<br>
							<input type="radio" name="categoria" id="izaje" value="2" <?php echo $d; ?>>  
							<label for="izaje">Izaje</label>
							<br>
							<input type="radio" name="categoria" id="liviano" value="3" <?php echo $e; ?>>  
							<label for="liviano">Equipo Liviano</label>
							<br>
						
								   </div>
					</div>
					
					
					</div>
					
			</div>
                    @include("errores")
                    @include("notificacion")
                    <button class="button is-success">Guardar</button>
                    <a class="button is-primary" href="{{route("mapas")}}">Ver todas</a>
                </form>
                <br>
            </div>
        </div>
@endsection
