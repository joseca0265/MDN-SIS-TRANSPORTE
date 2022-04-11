/*
 *     Copyright (C) 2019  Luis Cabrera Benito a.k.a. parzibyte
 *
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

const RUTA_EDITAR_USUARIO = URL_BASE + "/usuarios/editar";


new Vue({
    el: "#app",
    data: () => ({
        buscando: false,
        usuarioss: [],	
		usuarioSeleccionada: {},
		 mostrar: {
            usuarioss: false,
            aviso: false,
        },
		 busqueda2: "",
        numeroDeElementosMarcados: 0,
        cargando: {
            eliminandoMuchos: false,
            lista: false,
            paginacion: false,
        },
        busqueda: "",

        paginacion: {
            total: 0,
            actual: 0,
            ultima: 0,
            siguientePagina: "",
            paginaAnterior: "",
        },
        paginas: [],
		
    }),
	
    beforeMount() {
        this.refrescarSinQueImporteBusquedaOPagina();
		//this.refrescarSinQueImporteBusquedaOPagina2();
    },
    computed: {
        deberiaDeshabilitarBusqueda() {
            return this.usuarioss.length <= 0 && !this.busqueda;
        }
    },
    methods: {
        puedeAvanzarPaginacion() {
            return this.paginacion.actual < this.paginacion.ultima;
        },
        puedeRetrocederPaginacion() {
            return this.paginacion.actual > 1;
        },
        avanzarPaginacion() {
            if (this.puedeAvanzarPaginacion()) {
                this.irALaPagina(this.paginacion.actual + 1);
            }
        },
        retrocederPaginacion() {
            if (this.puedeRetrocederPaginacion()) {
                this.irALaPagina(this.paginacion.actual - 1);
            }
        },
        limpiarBusqueda() {
            this.busqueda = "";
            this.refrescarSinQueImporteBusquedaOPagina();
        },
        buscar: debounce(function () {
            if (this.busqueda && !this.buscando) {
                this.buscando = true;
                this.consultarusuariosConUrl(`/usuarios/buscar/${encodeURIComponent(this.busqueda)}`)
                    .finally(() => this.buscando = false);
            } else {
                this.refrescarSinQueImporteBusquedaOPagina();
            }
        }, 500),
        editar(usuario) {
            window.location.href = `${RUTA_EDITAR_USUARIO}/${usuario.id}`;
        },
        eliminarMarcados() {
            if (!confirm("¿Eliminar todos los elementos marcados?")) return;
            let arregloParaEliminar = this.usuarioss.filter(usuario => usuario.marcado).map(usuario => usuario.id);
            this.cargando.eliminandoMuchos = true;
            HTTP.post("/usuarios/eliminar", arregloParaEliminar)
                .then(resultado => {

                })
                .finally(() => {
                    this.desmarcarTodos();
                    this.refrescarSinQueImporteBusquedaOPagina();
                    this.cargando.eliminandoMuchos = false;
                });
        },
        onBotonParaMarcarClickeado() {
            if (this.usuarioss.some(usuario => usuario.marcado)) {
                this.desmarcarTodos();
            } else {
                this.marcarTodos();
            }
        },
        marcarTodos() {
            this.numeroDeElementosMarcados = this.usuarioss.length;
            this.usuarioss.forEach(usuario => {
                Vue.set(usuario, "marcado", true);
            });
        },
        desmarcarTodos() {
            this.numeroDeElementosMarcados = 0;
            this.usuarioss.forEach(usuario => {
                Vue.set(usuario, "marcado", false);
            });
        },
        invertirEstado(usuario) {
            // Si está marcada, ahora estará desmarcada
            if (usuario.marcado) this.numeroDeElementosMarcados--;
            else this.numeroDeElementosMarcados++;
            Vue.set(usuario, "marcado", !usuario.marcado);
        },
        eliminar(usuario) {
            if (!confirm(`¿Eliminar usuario ${usuario.nombre}?`)) return;
            this.desmarcarTodos();
            let {id} = usuario;
            Vue.set(usuario, "eliminando", true);
            HTTP.delete(`/usuario/${id}`)
                .then(resultado => {

                })
                .finally(() => {
                    this.refrescarSinQueImporteBusquedaOPagina();
                })
        },
        refrescarSinQueImporteBusquedaOPagina() {
            let url = this.busqueda ? `/usuarios/buscar/${encodeURIComponent(this.busqueda)}?page=${this.paginacion.actual}` : "/usuarios";
            this.consultarusuariosConUrl(url);
        },
		
        consultarusuariosConUrl(url) {

            // return console.log("Todavía no!");
            this.desmarcarTodos();
            this.cargando.lista = true;
            return HTTP.get(url)
                .then(respuesta => {
                    this.usuarioss = respuesta.data;
                    this.establecerPaginacion(respuesta);
                })
                .finally(() => this.cargando.lista = false);
        },


        establecerPaginacion(respuesta) {
            this.paginacion.siguientePagina = respuesta.next_page_url;
            this.paginacion.paginaAnterior = respuesta.prev_page_url;
            this.paginacion.actual = respuesta.current_page;
            this.paginacion.total = respuesta.total;
            this.paginacion.ultima = respuesta.last_page;
            this.prepararArregloParaPaginacion();
        },
        irALaPagina(pagina) {
            this.cargando.paginacion = true;
            this.consultarusuariosConUrl("/usuarios?page=" + pagina).finally(() => this.cargando.paginacion = false);
        },
        prepararArregloParaPaginacion() {

            // Si no hay más de una página ¿Para qué mostrar algo?
            if (this.paginacion.ultima <= 1) return;
            this.paginas = [];
            // Poner la primera página
            this.paginas.push({numero: 1});
            // Izquierda de la actual
            let posibleIzquierdaDeActual = this.paginacion.actual - 1;
            if (posibleIzquierdaDeActual > 1 && posibleIzquierdaDeActual !== this.paginacion.ultima) {

                this.paginas.push({numero: posibleIzquierdaDeActual});
                // Si entre la izquierda de la actual y la primera hay un espacio grande, poner ...
                if (posibleIzquierdaDeActual - 1 > 1) this.paginas.splice(1, 0, {puntosSuspensivos: true})
            }
            // Poner la actual igualmente si no es la primera o última
            if (this.paginacion.actual !== 1 && this.paginacion.actual !== this.paginacion.ultima) {

                this.paginas.push({numero: this.paginacion.actual});
            }
            // Derecha de la actual
            let posibleDerechaDeActual = this.paginacion.actual + 1;
            if (posibleDerechaDeActual !== 1 && posibleDerechaDeActual < this.paginacion.ultima) {

                this.paginas.push({numero: posibleDerechaDeActual});
                // Si entre la derecha de la actual y la última hay un espacio grande, poner ...
                if (posibleDerechaDeActual + 1 < this.paginacion.ultima) this.paginas.push({puntosSuspensivos: true})
            }
            // Última
            this.paginas.push({numero: this.paginacion.ultima});
        },
		validar() {
            this.errores = [];
           
            if (this.usuario.nombre.length > 255)
                this.errores.push("El nombre no debe contener más de 255 caracteres");
            /*if (!this.responsable.direccion.trim())
                this.errores.push("Escribe la direccion");*/
            if (!this.usuarioSeleccionada.id)
                this.errores.push("Selecciona un área");
            return this.errores.length <= 0;
        },
        
		seleccionarUsuario(usuario) {
            console.log("SEleccionas:", this.usuarioSeleccionada);
            this.usuarioSeleccionada = usuario;
            this.mostrar.usuarioss = false;
        },
		 resetear() {
            this.usuarioss = [];
            this.usuarioSeleccionada = {};
            this.usuario.nombre = "";
            this.errores = [];
            this.cargando = false;
            this.busqueda2 = "";
        },
		buscarUsuario: debounce(function () {
            if (!this.busqueda2) return;
            HTTP.get("/usuarios/buscar/" + encodeURIComponent(this.busqueda2))
                .then(usuarioss => this.usuarioss = usuarioss.data)
        }, 500)
		
    }
});


