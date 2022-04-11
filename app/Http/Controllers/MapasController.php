<?php

namespace App\Http\Controllers;

use App\Mapa;

use App\Http\Requests\GuardarCambiosmapa;
use App\Http\Requests\Guardarmapa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class MapasController extends Controller
{
/////////CREAR mapa////
    public function agregar(Guardarmapa $peticion)
    {
        $mapa = new mapa;
		 $mapa->Indicador = $peticion->rol;
        $mapa->Empresa = $peticion->empresa;
		$mapa->Codigo = $peticion->codigo;
		$mapa->Nombre_buscador = $peticion->nombre;
		$mapa->Ubicación_actual = $peticion->ubicacion_actual;
		$mapa->Codigo_division = $peticion->categoria;
		
		if($peticion->categoria =='1'){
		$mapa->Division = "Div. Construcción Civil";
		}
		if($peticion->categoria =='2'){
		$mapa->Division = "Div. Izaje";
		}
		if($peticion->categoria =='3'){
		$mapa->Division = "Div. Equipo Liviano";
		}
		if($peticion->categoria =='4'){
		$mapa->Division = "Div. Movimiento de Tierras";
		}
		
		$mapa->Marca = $peticion->marca;
		$mapa->Modelo = $peticion->modelo;
		$mapa->Codigo_division = $peticion->categoria;
		
		$ubicacion = $peticion->ubicacion;
		$palabras = explode (", ", $ubicacion);
        $mapa->Longitud = $palabras[0];
		$mapa->Latitud = $palabras[1];
		
        $exitoso = $mapa->save();
        $mensaje = "Equipo ".$mapa->Nombre_buscador." creado correctamente";
        $tipo = "success";
        if (!$exitoso) {
            $mensaje = "Error agregando este mapa. Intente más tarde";
            $tipo = "danger";
        }
        return redirect()->route("mapas")
            ->with("mensaje", $mensaje)
            ->with("tipo", $tipo);
    }
/////////VISTA mapa////
    public function mostrar()
    {
        return Mapa::orderBy("id", "desc")
      
            ->paginate(Config::get("constantes.paginas_en_paginacion"));
    }
	

    public function buscar(Request $peticion)
    {
        $busqueda = urldecode($peticion->busqueda);
		return mapa::where("Nombre_buscador", "like", "%$busqueda%")
            ->paginate(30);
    }

    public function editar(Request $peticion)
    {
        $idmapa = $peticion->id;
        $mapa = mapa::findOrFail($idmapa);
        return view("mapas/editar_ubicacion", [
            "mapa" => $mapa,
        ]);
    }

    public function eliminar($id)
    {
        $mapa = mapa::find($id);
        $mapa->delete();
    }

////////////EDITAR mapa/////////////
    public function guardarCambios(GuardarCambiosmapa $peticion)
    {

        $idmapa = $peticion->input("id");
        $mapa = mapa::findOrFail($idmapa);
		 $mapa->Indicador = $peticion->rol;
        $mapa->Empresa = $peticion->empresa;
		$mapa->Codigo = $peticion->codigo;
		$mapa->Nombre_buscador = $peticion->nombre;
		$mapa->Ubicación_actual = $peticion->ubicacion_actual;
		
		$mapa->Codigo_division = $peticion->categoria;
		
		if($peticion->categoria =='1'){
		$mapa->Division = "Div. Construcción Civil";
		}
		if($peticion->categoria =='2'){
		$mapa->Division = "Div. Izaje";
		}
		if($peticion->categoria =='3'){
		$mapa->Division = "Div. Equipo Liviano";
		}
		if($peticion->categoria =='4'){
		$mapa->Division = "Div. Movimiento de Tierras";
		}
		
		$mapa->Marca = $peticion->marca;
		$mapa->Modelo = $peticion->modelo;
		$mapa->Codigo_division = $peticion->categoria;
		
		$ubicacion = $peticion->input("ubicacion");
		$palabras = explode (", ", $ubicacion);
        $mapa->Longitud = $palabras[0];
		$mapa->Latitud = $palabras[1];
        $mapa->save();
		
        return back()->with(["mensaje" => "Actualizado correctamente", "tipo" => "success"]);

    }

    public function eliminarMuchas(Request $peticion)
    {
        $idsParaEliminar = json_decode($peticion->getContent());
        return mapa::destroy($idsParaEliminar);
    }
}