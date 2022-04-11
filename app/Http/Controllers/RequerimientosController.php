<?php

namespace App\Http\Controllers;

use App\requerimiento;
use App\mapa;

use App\Http\Requests\GuardarCambiosrequerimiento;
use App\Http\Requests\GuardarRequerimientoMapa;
use App\Http\Requests\Guardarrequerimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class requerimientosController extends Controller
{
/////////CREAR requerimiento////
    public function agregar(Guardarrequerimiento $peticion)
    {
        $requerimiento = new requerimiento;
		$requerimiento->Indicador = $peticion->rol;
        $requerimiento->Empresa = $peticion->empresa;
		$requerimiento->Codigo = $peticion->codigo;
		$requerimiento->Nombre_buscador = $peticion->nombre;
		$requerimiento->Ubicación_actual = $peticion->ubicacion_actual;
		
		$ubicacion = $peticion->ubicacion;
		$palabras = explode (", ", $ubicacion);
        $requerimiento->Longitud = $palabras[0];
		$requerimiento->Latitud = $palabras[1];
		
        $exitoso = $requerimiento->save();
        $mensaje = "Equipo Nr. 000".$requerimiento->id." creado correctamente";
        $tipo = "success";
        if (!$exitoso) {
            $mensaje = "Error agregando este requerimiento. Intente más tarde";
            $tipo = "danger";
        }
        return redirect()->route("requerimientos")
            ->with("mensaje", $mensaje)
            ->with("tipo", $tipo);
    }
/////////VISTA requerimiento////
    public function mostrar()
    {
        return requerimiento::orderBy("id", "desc")
      
            ->paginate(Config::get("constantes.paginas_en_paginacion"));
    }
	

    public function buscar(Request $peticion)
    {
        $busqueda = urldecode($peticion->busqueda);
		return requerimiento::where("Nombre_buscador", "like", "%$busqueda%")
            ->paginate(30);
    }

    public function editar(Request $peticion)
    {
        $idrequerimiento = $peticion->id;
        $requerimiento = requerimiento::findOrFail($idrequerimiento);
        return view("requerimientos/editar_ubicacion", [
            "requerimiento" => $requerimiento,
        ]);
    }


	public function agregar_requerimientoMapa(Request $peticion)
    {
        $idrequerimiento = $peticion->id;
        $requerimiento = mapa::findOrFail($idrequerimiento);
        return view("requerimientos/agregar_requerimiento_mapa", [
            "requerimiento" => $requerimiento,
        ]);
    }


    public function eliminar($id)
    {
        $requerimiento = requerimiento::find($id);
        $requerimiento->delete();
    }

////////////EDITAR requerimiento/////////////
  /*  public function guardarCambios(GuardarRequerimientoMapa $peticion)
    {

        $idrequerimiento = $peticion->input("id");
        $requerimiento = requerimiento::findOrFail($idrequerimiento);
		$requerimiento->id = $peticion->rol;
        $requerimiento->Empresa = $peticion->empresa;
		$requerimiento->Codigo = $peticion->codigo;
		$requerimiento->Nombre_buscador = $peticion->nombre;
		$requerimiento->Ubicación_actual = $peticion->ubicacion_actual;
		
		$ubicacion = $peticion->input("ubicacion");
		$palabras = explode (", ", $ubicacion);
        $requerimiento->Longitud = $palabras[0];
		$requerimiento->Latitud = $palabras[1];
        $requerimiento->save();
		
        return back()->with(["mensaje" => "Actualizado correctamente", "tipo" => "success"]);

    }
	*/
	//GUARDAR REQUERIMIENTO QUE PROVIENE AL CLICKEAR MAPA
	
	public function guardarCambios_req_mapa(GuardarRequerimientoMapa $peticion)
    {

        $requerimiento = new requerimiento;
		$requerimiento->razon_social = $peticion->razon_social;
        $requerimiento->ruc = $peticion->ruc;
		$requerimiento->contacto_nombre = $peticion->nombres;
		$requerimiento->contacto_correo = $peticion->correo;
		$requerimiento->contacto_celular = $peticion->celular;
		$requerimiento->descripcion_uso = $peticion->descripcion_uso;
		$requerimiento->tiempo_alquiler = $peticion->tiempo_alquiler;
		$requerimiento->lugar_solicitado = $peticion->lugar_solicitado;
		$requerimiento->cantidad = $peticion->cantidad;
		
		$requerimiento->codigo_equipo = $peticion->codigo_equipo;
		$requerimiento->categoria_equipo = $peticion->categoria_equipo;
		$requerimiento->marca_equipo = $peticion->marca_equipo;
		$requerimiento->modelo_equipo = $peticion->modelo_equipo;
		$requerimiento->ubicacion_actual = $peticion->ubicacion_actual;
		
		$requerimiento->estado = "Sin Atender";
		
        $requerimiento->save();
		
        return back()->with(["mensaje" => "Solicitud registrada correctamente", "tipo" => "success"]);

    }


    public function eliminarMuchas(Request $peticion)
    {
        $idsParaEliminar = json_decode($peticion->getContent());
        return requerimiento::destroy($idsParaEliminar);
    }
}