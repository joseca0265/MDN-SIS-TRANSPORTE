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

new Vue({
    el: "#app",
    data: () => ({
        usuarios: [],
        busqueda: "",
        usuarioSeleccionada: {},
        mostrar: {
            usuarios: false,
            aviso: false,
        },
        responsable: {
            nombre: "",
            direccion: "",
            id: null,
        },
        errores: [],
        cargando: false,
        aviso: {},
    }),
    beforeMount() {
        // Separar por / y obtener el último elemento
        let idResponsable = window.location.href.split("/").pop();
        HTTP.get("/responsable/" + idResponsable).then(responsable => {
            if (!responsable) {
                alert("El responsable que intentas editar no existe");
                window.location.href = URL_BASE;
                // Sí sí ya sé que lo de arriba igualmente detiene la ejecución
                return;
            }
            this.responsable.id = responsable.id;
            this.responsable.nombre = responsable.nombre;
            this.responsable.direccion = responsable.direccion;
            this.usuarioSeleccionada.id = responsable.usuario.id;
            this.usuarioSeleccionada.nombre = responsable.usuario.nombre;
        })

    },
    methods: {
        guardar() {
            this.mostrar.aviso = false;
            if (!this.validar()) return;
            this.cargando = true;
            HTTP
                .put("/responsable", {
                    id: this.responsable.id,
                    nombre: this.responsable.nombre,
                    direccion: this.responsable.direccion,
                    usuarios_id: this.usuarioSeleccionada.id
                })
                .then(resultado => {
                    resultado && this.resetear();
                    this.mostrar.aviso = true;
                    this.aviso.mensaje = resultado ? "Cambios guardados con éxito" : "Error editando responsable. Intenta de nuevo";
                    this.aviso.tipo = resultado ? "is-success" : "is-danger";
                })
                .finally(() => this.cargando = false);
        },
        validar() {
            this.errores = [];
            if (!this.responsable.nombre.trim())
                this.errores.push("Escribe el nombre");
            if (this.responsable.nombre.length > 255)
                this.errores.push("El nombre no debe contener más de 255 caracteres");
            if (!this.responsable.direccion.trim())
                this.errores.push("Escribe la direccion");
            if (this.responsable.direccion.length > 255)
                this.errores.push("La dirección no debe contener más de 255 caracteres");
            if (!this.usuarioSeleccionada.id)
                this.errores.push("Selecciona un área");
            return this.errores.length <= 0;
        },
        seleccionarusuario(usuario) {
            this.usuarioSeleccionada = usuario;
            this.mostrar.usuarios = false;
        },
        resetear() {
            this.usuarios = [];
            this.usuarioSeleccionada = {};
            this.responsable.nombre = "";
            this.responsable.direccion = "";
            this.errores = [];
            this.cargando = false;
            this.busqueda = "";
        },
        buscarusuario: debounce(function () {
            if (!this.busqueda) return;
            HTTP.get("/usuarios/buscar/" + encodeURIComponent(this.busqueda))
                .then(usuarios => this.usuarios = usuarios.data)
        }, 500)
    }
});