<?php

namespace App\Http\Controllers;

use App\Usuario;

use App\Http\Requests\GuardarCambiosDeUsuario;
use App\Http\Requests\GuardarUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class usuariosController extends Controller
{
/////////CREAR usuarios////
    public function agregar(Guardarusuario $peticion)
    {
        $usuario = new Usuario;
		$hasheada = password_hash ($peticion->input("password"), PASSWORD_BCRYPT );
        $usuario->nombre = $peticion->nombre;
		$usuario->password = $hasheada;
		$usuario->rol = $peticion->rol;
        $exitoso = $usuario->save();
        $mensaje = "Usuario ".$usuario->nombre." creado correctamente";
        $tipo = "success";
        if (!$exitoso) {
            $mensaje = "Error agregando este usuario. Intente más tarde";
            $tipo = "danger";
        }
        return redirect()->route("formularioUsuario")
            ->with("mensaje", $mensaje)
            ->with("tipo", $tipo);
    }
/////////VISTA usuarios////
    public function mostrar()
    {
        return Usuario::orderBy("updated_at", "desc")
            ->orderBy("created_at", "desc")
            ->paginate(Config::get("constantes.paginas_en_paginacion"));
    }
	

    public function buscar(Request $peticion)
    {
        $busqueda = urldecode($peticion->busqueda);
		return Usuario::where("nombre", "like", "%$busqueda%","or","password","like", "%$busqueda%")
            ->paginate(Config::get("constantes.paginas_en_paginacion"));
			

			
		
    }

    public function editar(Request $peticion)
    {
        $idusuario = $peticion->id;
        $usuario = Usuario::findOrFail($idusuario);
        return view("usuarios/editar_usuario", [
            "usuario" => $usuario,
        ]);
    }

    public function eliminar($id)
    {
        $usuario = Usuario::find($id);
        $usuario->delete();
    }

////////////EDITAR usuarios/////////////
    public function guardarCambios(GuardarCambiosDeusuario $peticion)
    {
		$hasheada = password_hash ($peticion->input("password"), PASSWORD_BCRYPT );
        $idusuario = $peticion->input("id");
        $usuario = usuario::findOrFail($idusuario);
        $usuario->nombre = $peticion->input("nombre");
		$usuario->password = $hasheada;
		$usuario->rol = $peticion->input("rol");
        $usuario->save();
        return redirect()->route("usuarios")->with(["mensaje" => "Usuario ".$usuario->nombre." actualizado correctamente", "tipo" => "success"]);

    }

    public function eliminarMuchas(Request $peticion)
    {
        $idsParaEliminar = json_decode($peticion->getContent());
        return Usuario::destroy($idsParaEliminar);
    }
}