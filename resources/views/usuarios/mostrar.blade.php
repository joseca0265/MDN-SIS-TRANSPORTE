@extends("maestra")
@section("titulo", "Usuarios")
@section("contenido")

    <div id="app" class="container" v-cloak>
       
	   <div class="columns">
		
            <div class="column">
			
                <div class="notification">
				
                    <div class="columns is-vcentered">
                        <div class="column">
                            @verbatim
                                <h4 class="is-size-4">Usuarios ({{paginacion.total}})</h4>
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
					
	
				
						<!--   @verbatim-->
                           
								<!--ID-->
                             	<!-- 
								 <select>
            <option  v-for="usuario in usuarios" value="articulo">{{usuario.nombre}}</option><br>
        </select>
								<!--CONTRASEÑA-->
							
						
                           
                       <!--  @endverbatim-->
						
					<!-- <nav class="panel">
                    <div class="panel-block">
                        <p class="control">
                            <label class="label">Proyecto</label>
                            <input @focus="mostrar.usuarioss = true" v-model="busqueda2"
                                   @keyup="buscarUsuario()" class="input is-loading" type="text"
                                   placeholder="Buscar Proyecto">
                        </p>
                    </div>
                    @verbatim
                        <a v-show="mostrar.usuarioss && busqueda2" @click="seleccionarUsuario(usuario)" v-for="usuario in usuarioss"
                           class="panel-block" :class="{'is-active': usuario.id === usuarioSeleccionada.id}">
                            <span class="panel-icon">
                                <i class="fas fa-building" aria-hidden="true"></i>
                            </span>
                            {{usuario.nombre}}
                        </a>
                        <div v-show="!mostrar.usuarioss && usuarioSeleccionada.id" class="notification is-info">
                            <h4 class="is-size-4"> {{usuarioSeleccionada.nombre}}</h4>
                        </div>
                </nav>-->
				
					@endverbatim
						

						


					  
					

						
                        <div class="column">
                            <div class="field is-grouped is-pulled-right">
                                <div class="control">
                                    <a href="{{route("formularioUsuario")}}" class="button is-success">Agregar</a>
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
                    <div v-show="usuarioss.length <= 0 && !busqueda && !cargando.lista"
                         class="notification is-info has-text-centered">
                        <h3 class="is-size-3">Todavía no hay usuarios</h3>
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
                    <div v-show="usuarioss.length <= 0 && busqueda && !cargando.lista"
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

				
					
                    <table v-show="usuarioss.length > 0 && !cargando.lista"
                           class="table is-bordered is-striped is-hoverable is-fullwidth">
                        <thead>
                        <tr>
                            <th> Seleccionar<br> Todos
                                <button @click="onBotonParaMarcarClickeado()" class="button"
                                        :class="{'is-info': numeroDeElementosMarcados > 0}">
                                    <span class="icon is-small">
                                        <i class="fa fa-check"></i>
                                    </span>
                                </button> 
                            </th>
							<th>Rol</th>
                            <th>ID</th>
                            <th>Contraseña</th>
                            <th>Fecha de Creacion</th>
                            <th>Fecha de Actualizacion</th>
                        </tr>
                        </thead>
                        <tbody>
                        @verbatim
                            <tr v-for="usuario in usuarioss">
                                <td>
                                    <button @click="invertirEstado(usuario)" class="button"
                                            :class="{'is-info': usuario.marcado}">
                                    <span class="icon is-small">
                                        <i class="fa fa-check"></i>
                                    </span>
                                    </button>
                                </td>
								
							<td v-if="usuario.rol == 1">Administrador</td>  
							<td v-else="usuario.rol == 1">Empleado</td> 
							<!--ID-->
                                <td>{{usuario.nombre}}</td>
							
								
								<!--CONTRASEÑA-->
                                <td>{{usuario.password}}</td>
								
								<td>{{usuario.created_at}}</td>
								<td>{{usuario.updated_at}}</td>
                              
                                <td>
                                    <button @click="editar(usuario)" class="button is-warning">
                                    <span class="icon is-small">
                                        <i class="fa fa-edit"></i>
                                    </span>
                                    </button>
                                </td>
								
                                <td>
                                    <button @click="eliminar(usuario)" class="button is-danger"
                                            :class="{'is-loading': usuario.eliminando}">
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
    </div>

    <script src="{{url("/js/usuarios/mostrar.js?q=") . time()}}"></script>
	
@endsection
