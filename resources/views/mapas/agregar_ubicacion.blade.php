@extends("maestra")
@section("titulo", "Agregar equipo")
@section("contenido")
    <div class="container" style="font-size:14px">
        <div class="columns">
            <div class="column">
                <h1 class="is-size-1">Agregar Equipo</h1>
                <form method="POST" action="{{route("guardarEquipo")}}">
                    @csrf
					
				<div class="columns">
				<div class="column" Style="max-width:480px">
					<div class="field">
                        <label class="label">Propietario</label>
                        <div class="control">
                            <input type="radio" name="rol" id="Administrador" value="PROPIO" checked>
							<label for="Administrador">Propio</label>
							<br>
							<input type="radio" name="rol" id="Empleado" value="SUBARRENDADO">  
							<label for="Empleado">Subarrendado</label>
							<br>
							
							
                        </div>
                  
					</div>
					
                    <div class="field">
                        <label class="label">Empresa</label>
                        <div class="control">
                            <input autocomplete="off" name="empresa" class="input" type="text"
                                   placeholder="Empresa - Nombre - Razon Social">
                        </div>
                  
					</div>
					
					
					
					<div class="field">
                        <label class="label">Nombre</label>
                        <div class="control">
                            <input autocomplete="off" name="nombre" class="input" type="text"
                                   placeholder="Digite el nombre del equipo">
                        </div>
                  
					</div>
					
					<div class="field">
                        <label class="label">Ubicacion Actual</label>
                        <div class="control">
                            <input autocomplete="off" name="ubicacion_actual" class="input" type="text"
                                   placeholder="Digite la ubicación del equipo">
                        </div>
                  
					</div>
				<div class="field" style="line-height:5%"><br></div>
					 <div class="field">
                       <label class="label" style="line-height:20%"> <b>Latitud, Longitud </b></label>Ejemplo: -12.286455910642195, -76.86299875646704
                        <div class="control">
                            <input  autocomplete="off" name="ubicacion" class="input" type="text"
                                   placeholder="Ejemplo: -12.286455910642195, -76.86299875646704">
                        </div>
                    </div>
					
					</div>
					
					<div class="column">
					
					<div class="field">
                        <b>Codigo </b> 
						 <div class="control">
                            <input autocomplete="off" name="codigo" class="input" type="text" style="font-size:15px;width:450px"
                                   placeholder="Digite el codigo del equipo">
								   </div>
					</div>
					
					<div class="field">
                        <b>Marca </b> 
						 <div class="control">
                            <input autocomplete="off" name="marca" class="input" type="text" style="font-size:15px;width:450px"
                                   placeholder="Digite la marca del equipo">
								   </div>
					</div>
					
					<div class="field">
                        <b>Modelo </b> 
						 <div class="control">
                            <input autocomplete="off" name="modelo" class="input" type="text" style="font-size:15px;width:450px"
                                   placeholder="Digite el modelo del equipo">
								   </div>
					</div>
					
					<div class="field">
                        <b>Categoria </b> 
						 <div class="control">
                           <input type="radio" name="categoria" id="construccion" value="1" checked>
							<label for="construccion">Construcción Civil</label>
							<br>
							<input type="radio" name="categoria" id="movimiento_tierra" value="4">  
							<label for="movimiento_tierra">Movimiento de Tierra</label>
							<br>
							<input type="radio" name="categoria" id="izaje" value="2">  
							<label for="izaje">Izaje</label>
							<br>
							<input type="radio" name="categoria" id="liviano" value="3">  
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
    </div>
@endsection
