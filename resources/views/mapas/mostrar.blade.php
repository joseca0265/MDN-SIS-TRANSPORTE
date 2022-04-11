@extends("maestra")
@section("titulo", "Ubicaciones")
@section("contenido")

    <div id="app" class="container" v-cloak>
       

	   <div class="columns">
		
            <div class="column">
			
                <div class="notification">
				
                    <div class="columns is-vcentered">
                        <div class="column">
                            @verbatim
                                <h4 class="is-size-4">Equipos ({{paginacion.total}})</h4>
                            @endverbatim
                        </div>
                        <div class="column">
                            <div class="field has-addons">
                                <div class="control">
                                    <input :readonly="deberiaDeshabilitarBusqueda" v-model="busqueda" @keyup="buscar()"
                                           class="input " type="text"
                                           placeholder="Buscar por nombre">
                                </div>
                                <div class="control">
                                    <button :disabled="deberiaDeshabilitarBusqueda || !busqueda" v-show="!this.busqueda"
                                            @click="buscar()" class="button is-info"
                                            :class="{'is-loading': buscando}">
                                            <span class="icon is-small">
                                              <i class="fa fa-search"></i>
                                            </span>
                                    </button>

                                    <button v-show="this.busqueda" @click="limpiarBusqueda()" class="button is-info"
                                            :class="{'is-loading': buscando}">
                                            <span class="icon is-small">
                                              <i class="fa fa-times"></i>
                                            </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                     
			
                        <div class="column">
                            <div class="field is-grouped is-pulled-right">
                                <div class="control">
                                  <a href="{{route("formularioGuardarEquipo")}}" class="button is-success">Agregar</a>
                                </div>
                                <div class="control">
                                    @verbatim
                                        <transition name="bounce">
                                            <button @click="eliminarMarcados()" v-show="numeroDeElementosMarcados > 0"
                                                    class="button is-warning"
                                                    :class="{'is-loading': cargando.eliminandoMuchos}">
                                                Eliminar ({{numeroDeElementosMarcados}})
                                            </button>
                                        </transition>
                                    @endverbatim
                                </div>
                            </div>
                            &nbsp;
                        </div>
                    </div>
                </div>
                <div v-show="cargando.lista" class="notification is-info has-text-centered">
                    <h3 class="is-size-3">Cargando</h3>
                    <div>
                        <h1 class="icono-gigante">
                            <i class="fas fa-spinner fa-spin"></i>
                        </h1>
                    </div>
                    <p class="is-size-5">
                        Por favor, espera un momento
                    </p>
                </div>
                <transition name="fade">
                    <div v-show="mapas.length <= 0 && !busqueda && !cargando.lista"
                         class="notification is-info has-text-centered">
                        <h3 class="is-size-3">Todavía no hay mapas</h3>
                        <div>
                            <h1 class="icono-gigante">
                                <i class="fas fa-box-open"></i>
                            </h1>
                        </div>
                        <p class="is-size-5">
                            Parece que no has agregado ninguna persona. Registra una haciendo click en el botón
                            <strong>Agregar</strong>
                        </p>
                    </div>
                </transition>
                <transition name="fade">
                    <div v-show="mapas.length <= 0 && busqueda && !cargando.lista"
                         class="notification is-warning has-text-centered">
                        <h3 class="is-size-3">No hay resultados</h3>
                        <div>
                            <h1 class="icono-gigante">
                                <i class="fas fa-search"></i>
                            </h1>
                        </div>
                        <p class="is-size-5">
                            No hay resultados que coincidan con tu búsqueda
                        </p>
                    </div>
                </transition>
                @include("errores")
                @include("notificacion")
                <div>

		
					
                    <table v-show="mapas.length > 0 && !cargando.lista"
                           class="table is-bordered is-striped is-hoverable is-fullwidth"
                           style="margin-left:-50px; font-size:14px"
                           >
                        <thead>
                        <tr>
                            <th style="width:90px"> 
                                <button @click="onBotonParaMarcarClickeado()" class="button"
                                        :class="{'is-info': numeroDeElementosMarcados > 0}">
                                    <span class="icon is-small">
                                        <i class="fa fa-check"></i>
                                    </span>
                                </button> 
                            </th>
							<th style="width:10px;text-align:center"><center><br>ID</center></th>
                            <th style="width:15px;text-align:center"><center><br>Indicador</center></th>
                            <th style="width:145px;text-align:center"><br><center>Empresa</center></th>
                            <th style="width:25px;text-align:center"><br><center>Codigo</center></th>
                            <th style="width:125px;text-align:center"><center><br>Nombre</center></th>
                            <th style="width:305px;text-align:center"><center><br>Ubicacion Actual</center></th>
							
                        </tr>
                        </thead>
                        <tbody>
                        @verbatim
                            <tr v-for="mapa in mapas">
                                <td>
                                    <button @click="invertirEstado(mapa)" class="button"
                                            :class="{'is-info': mapa.marcado}">
                                    <span class="icon is-small">
                                        <i class="fa fa-check"></i>
                                    </span>
                                    </button>
                                </td>
								
							<!--<td v-if="mapa.rol == 1">Administrador</td>  
							<td v-else="mapa.rol == 1">Empleado</td> 
							-->
                                <td style="width:10px;text-align:center" >{{mapa.id}} <br></td>
                                <td><center>{{mapa.Indicador}}</center></td>
							



								<!--CONTRASEÑA-->
								<?php $i=1;?>
                                <td style="color:#448395;"><center><b>{{mapa.Empresa}}</b></center></td>
								
								<td><b>{{mapa.Codigo}}</b></td>
								<td style="color:#C1A809;width:405px;font-size:13px"><b>{{mapa.Nombre_buscador}}</b></td>
								<td style="color:#17C473;font-size:13px"><b>{{mapa.Ubicación_actual}} </b></td>
                         
                                <td>
                                    <button @click="editar(mapa)" class="button is-warning">
                                    <span class="icon is-small">
                                        <i class="fa fa-edit"></i>
                                    </span>
                                    </button>
                                </td>
								
                                <td>
                                    <button @click="eliminar(mapa)" class="button is-danger"
                                            :class="{'is-loading': mapa.eliminando}">
                                    <span class="icon is-small">
                                        <i class="fa fa-trash"></i>
                                    </span>
                                    </button>
                                </td>
                            </tr>
							
                        @endverbatim
                        </tbody>
                    </table>
                    <nav v-show="paginacion.ultima > 1" class="pagination" role="navigation" aria-label="pagination">
                        <a :disabled="!puedeRetrocederPaginacion()" @click="retrocederPaginacion()"
                           class="pagination-previous">Anterior</a>
                        <a :disabled="!puedeAvanzarPaginacion()" @click="avanzarPaginacion()" class="pagination-next">Siguiente
                            página</a>
                        @verbatim
                            <ul class="pagination-list">
                                <li v-for="pagina in paginas">
                                    <a v-if="!pagina.puntosSuspensivos" @click="irALaPagina(pagina.numero)"
                                       class="pagination-link"
                                       :class="{'is-current':pagina.numero === paginacion.actual}">{{pagina.numero}}</a>
                                    <span class="pagination-ellipsis" v-else>&hellip;</span>
                                </li>

                            </ul>
                        @endverbatim
                    </nav>
                </div>
            </div>
        </div>
		
			
    </div >
	<div  >

	 </div>

	
  
   




    <script src="{{url("/js/mapas/mostrar.js?q=") . time()}}"></script>

@endsection
