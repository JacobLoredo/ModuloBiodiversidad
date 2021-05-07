<?php

namespace App\Http\Controllers;

use App\Rol;
use App\User;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard.index');
    }
    public function Bio()
    {
        return view('index');
    }
    public function getUsers()
    {
        return view('Administrador.usuarios')->with('usuarios', User::all())->with('roles', Rol::all());
    }
    public function verificar()
    {
        return view('UsuarioXVerificar');
    }
    public function editRol(Request $request)
    {
        $user = user::findorFail($request->idUser);
        
        if($request->roles!=null){
            $user->roles()->detach();
            foreach ($request->roles as $rol) {
                
                if (!$user->hasRoleid($rol)) {
                    $user->roles()->attach(Rol::where('id', $rol)->first());
                }
            }
            return back()->with('message', 'Cambio de roles con exito');
        }else{
            return back()->withErrors("Debes de seleccionar al menos 1 rol");
        }
    }
    public function deleteUser(Request $request )
    {
       $user= user::findorFail( $request->idUserR);
       $user->delete();
       
        return back()->with('message', 'El usuario fue eliminado con exito');
    }
    public function getHCByUser()
    {
        $user = user::findorFail(Auth::id());
        
        return view('HojaCampo.User.index')->with('MisHojasCampo', $user->Plantas()->paginate(12));
    }

}
