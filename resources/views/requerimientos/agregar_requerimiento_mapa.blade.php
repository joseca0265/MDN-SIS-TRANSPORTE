@extends("maestra")
@section("titulo", "Agregar Usuario")
@section("contenido")
    <div class="container">
        <div class="columns">
            <div class="column "><br>
                <a style="font-size:1.5rem!important;color:#4589d9">Solicitar 
				 {{$requerimiento->Nombre_buscador}}</a>
                <form method="POST" action="{{ route("guardarCambiosReqMapa") }}">
				@method("put")
                    @csrf
                    <br>
					
					<input autocomplete="off" name="codigo_equipo" class="input" type="hidden"  style="font-size:15px;width:450px"
                    value="{{$requerimiento->Codigo}}"  >
					
					<input autocomplete="off" name="marca_equipo" class="input" type="hidden"  style="font-size:15px;width:450px"
                    value="{{$requerimiento->Marca}}"  >
					
					<input autocomplete="off" name="modelo_equipo" class="input" type="hidden"  style="font-size:15px;width:450px"
                    value="{{$requerimiento->Modelo}}"  >
					
					<input autocomplete="off" name="categoria_equipo" class="input" type="hidden"  style="font-size:15px;width:450px"
                    value="{{$requerimiento->Categoria}}"  >
					
					<input autocomplete="off" name="ubicacion_actual" class="input" type="hidden"  style="font-size:15px;width:450px"
                    value="{{$requerimiento->Ubicación_actual}}"  >
								   
				<div class="columns">
				
                <div class="column" Style="max-width:430px">
				
				<div class="field">
                         <b style="color:#00000099">Tiempo Alquiler <a style="color:#D35555;font-size:12px">(*)</a> </b>
                        <div class="control">
                            <input autocomplete="off" name="tiempo_alquiler" class="input" type="text"  style="font-size:15px;width:450px"
                                   placeholder="Digite el tiempo de alquiler">
                        </div>
				</div>
					
					<div class="field">
                        <b style="color:#00000099">Cantidad de equipos a solicitar <a style="color:#D35555;font-size:12px">(*)</a></b>
                            <input autocomplete="off" name="cantidad" class="input" type="text" style="font-size:15px;width:450px"
                                   placeholder="Digite la cantidad de equipos que desea">
					</div>		

					<div class="field">
                        <b style="color:#00000099">Lugar  donde trabajará el equipo <a style="color:#D35555;font-size:12px">(*)</a> </b>
                            <input autocomplete="off" name="lugar_solicitado" class="input" type="text"  style="font-size:15px;width:450px"
                                   placeholder="Digite el lugar">
					</div>		

					<div class="field">
                        <b style="color:#00000099">Trabajo a Realizar:</b>
                        <div class="control">
                           <textarea autocomplete="off" name="descripcion_uso" rows="5" style="resize: none;width:410px;padding:10px"></textarea>
                        </div><br>
						<b><a style="color:#D35555;font-size:12px">(*) Campos Obligatorios</a> </b>
					</div>	
				</div>
					
					<div class="column">
					
					<div class="field">
                        <b style="color:#00000099">Razon Social <a style="color:#D35555;font-size:12px">(*)</a> </b> 
						 <div class="control">
                            <input autocomplete="off" name="razon_social" class="input" type="text" style="font-size:15px;width:450px"
                                   placeholder="Digite el nombre de su Empresa">
								   </div>
					</div>
					
					<div class="field">
						<b style="color:#00000099"> RUC</b>
						 <div class="control">
                            <input autocomplete="off" name="ruc" class="input" type="text"  style="font-size:15px;width:450px"
                                   placeholder="Digite el RUC de su Empresa">
								   </div>
					</div>
					
					<div class="field">
                        <b style="color:#00000099">Nombres y Apellidos <a style="color:#D35555;font-size:12px">(*)</a> </b>
                        <div class="control">
                            <input autocomplete="off" name="nombres" class="input" type="text"  style="font-size:15px;width:450px"
                                   placeholder="Digite sus Nombres y Apellidos">
                        </div>
					</div>
					
					<div class="field">
                         <b style="color:#00000099">Correo Electronico <a style="color:#D35555;font-size:12px">(*)</a> </b>
                        <div class="control">
                            <input autocomplete="off" name="correo" class="input" type="text"  style="font-size:15px;width:450px"
                                   placeholder="Digite sus Nombres y Apellidos">
                        </div>
					</div>
					
					<div class="field">
                         <b style="color:#00000099">Celular <a style="color:#D35555;font-size:12px">(*)</a> </b>
                        <div class="control">
                            <input autocomplete="off" name="celular" class="input" type="text"  style="font-size:15px;width:450px"
                                   placeholder="Digite su Nro. de Celular">
                        </div>
					</div>
					</div>								
				</div>
				
                    @include("errores")
                    @include("notificacion")
                    <button class="button is-success">Guardar</button>
                    <a class="button is-primary" href="#">Ver todas</a>
                </form>
                <br>
            </div>
        </div>
    </div>
@endsection
<style>
::placeholder {
  color: blue;
  font-size: 0.80em;
}
</style>
