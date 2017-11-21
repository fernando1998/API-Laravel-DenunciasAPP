<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Usuario;

class ApiController extends Controller
{
    
      public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        
        if (Auth::once($credentials)) 
        {
         $user = Auth::user();
         
         return $user;
        }
        return response()->json(['error' => 'Usuario y/o clave inválido'], 401); 
    }

    public function register(Request $request){
        try
        {
            if(!$request->has('username') || !$request->has('password'))
            {
                throw new \Exception('Se esperaba campos obligatorios');
            }
            
            $usuario = new Usuario();
            $usuario->username = $request->get('username');
    		$usuario->password = bcrypt($request->get('password'));
    		$usuario->email = $request->get('email');
    
    		
    		$usuario->save();
    	    
    	    return response()->json(['type' => 'success', 'message' => 'Usuario completo'], 200);
    	    
        }catch(\Exception $e)
        {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
