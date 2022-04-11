@extends("maestra")
@section("titulo", "Editar usuario")
@section("contenido")
    <div class="container">
        <div class="columns">
            <div class="column is-half-tablet">
                <h1 class="is-size-1">Editar usuario</h1>
                <form method="POST" action="{{route("guardarCambiosDeUsuario")}}">
                    @method("put")
                    @csrf
                    <input type="hidden" value="{{$usuario->id}}" name="id">
                    <div class="field">
                        <label class="label">Nombre</label>
                        <div class="control">
                            <input value="{{$usuario->nombre}}" autocomplete="off" name="nombre" class="input" type="text"
                                   placeholder="Nombre de usuario">
                        </div>
                    </div>
					<div class="field">
                        <label class="label">Nueva Contraseña</label>
                        <div class="control">
                            <input value="{{$usuario->password}}" autocomplete="off" name="password" class="input" type="text"
                                   placeholder="Digite nueva contraseña">
                        </div>
                    </div>
					<div class="field">
                        <label class="label">Roles</label>
                        <div class="control">
						
					<?php 
				
					if(($usuario->rol)== 1){
					
					?>
					<input type="radio" name="rol" id="Administrador" value="1" checked>
					<label for="Administrador">Administrador</label>
					<br>
					<input type="radio" name="rol" id="Empleado" value="2">  
					<label for="Empleado">Empleado</label><br>
					<?php
					}else{
						?>
					<input type="radio" name="rol" id="Administrador" value="1" >
					<label for="Administrador">Administrador</label>
					<br>
					<input type="radio" name="rol" id="Empleado" value="2" checked>  
					<label for="Empleado">Empleado</label><br>
					<?php
					}
					?>
					
				
				
                              
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
@endsection
