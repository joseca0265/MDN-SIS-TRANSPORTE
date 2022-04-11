@extends("maestra")
@section("titulo", "Agregar Usuario")
@section("contenido")
    <div class="container">
        <div class="columns">
            <div class="column is-half-tablet">
                <h1 class="is-size-1">Agregar Usuario</h1>
                <form method="POST" action="{{route("guardarUsuario")}}">
                    @csrf
                    <div class="field">
                        <label class="label">Nombre</label>
                        <div class="control">
                            <input autocomplete="off" name="nombre" class="input" type="text"
                                   placeholder="Nombre de Usuario">
                        </div>
                  
					</div>
					
					<div class="field">
                        <label class="label">Contraseña</label>
                        <div class="control">
                            <input autocomplete="off" name="password" class="input" type="text"
                                   placeholder="Digite su contraseña">
                        </div>
                  
					</div>
					
					<div class="field">
                        <label class="label">Roles</label>
                        <div class="control">
                            <input type="radio" name="rol" id="Administrador" value="1">
							<label for="Administrador">Administrador</label>
							<br>
							<input type="radio" name="rol" id="Empleado" value="2">  
							<label for="Empleado">Empleado</label>
							<br>
                        </div>
                  
					</div>
					
					
			
					
					
                    @include("errores")
                    @include("notificacion")
                    <button class="button is-success">Guardar</button>
                    <a class="button is-primary" href="{{route("usuarios")}}">Ver todas</a>
                </form>
                <br>
            </div>
        </div>
    </div>
@endsection
