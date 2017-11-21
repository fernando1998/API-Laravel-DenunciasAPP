<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Denuncias;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class DenunciasController extends Controller
{
    public function index()
    {
        $denuncias = Denuncias::select('denuncias.id','denuncias.titulo','denuncias.comentario','denuncias.latitud','denuncias.longitud','denuncias.imagen','users.username')
            ->join('users', 'users.id', '=', 'denuncias.users_id')
            ->orderBy("id")
            ->get();
        
	    
	    return $denuncias;
    }
    
        public function store(Request $request)
    {
        try
        {
            if(!$request->has('titulo') || !$request->has('comentario'))
            {
                throw new \Exception('Se esperaba campos mandatorios');
            }
            
            $denuncia = new Denuncias();
            $denuncia->titulo = $request->get('titulo');
    		$denuncia->comentario = $request->get('comentario');
    		$denuncia->latitud = $request->get('latitud');
    		$denuncia->longitud = $request->get('longitud');
    		
    		
    		if($request->hasFile('imagen') && $request->file('imagen')->isValid())
    		{
        		$imagen = $request->file('imagen');
        		$filename = $request->file('imagen')->getClientOriginalName();
        		
        		Storage::disk('images')->put($filename,  File::get($imagen));
        		
        		$denuncia->imagen = $filename;
    		}
    		
    		$denuncia->users_id = $request->get('users_id');
    		$denuncia->save();
    	    
    	    return response()->json(['type' => 'success', 'message' => 'Registro completo'], 200);
    	    
        }catch(\Exception $e)
        {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
       public function destroy($id){
        try
        {
            $denuncia = Denuncias::find($id);
            
            if($denuncia == null)
                throw new \Exception('Registro no encontrado');
    		
    		if(Storage::disk('images')->exists($denuncia->imagen))
    		    Storage::disk('images')->delete($denuncia->imagen);
    		
    		$denuncia->delete();
    		
            return response()->json(['type' => 'success', 'message' => 'Registro eliminado'], 200);
    	    
        }catch(\Exception $e)
        {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    
    
    

}
