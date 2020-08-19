<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        switch ($request->criterio) {
            case 'activo':
                $valor = 1;
                if ($buscar  == '') {
                    $usuario = User::where('active', $valor)->orderBy('id', 'asc')->paginate(20);
                }else{
                    $usuario = User::where('active', $valor)->where('name', 'like', '%' . $buscar . '%')->orderBy('id', 'asc')->paginate(20);
                }
                break;
            case 'inactivo':
                $valor = 0;
                if ($buscar  == '') {
                    $usuario = User::where('active', $valor)->orderBy('id', 'asc')->paginate(20);
                }else{
                    $usuario = User::where('active', $valor)->where('name', 'like', '%' . $buscar . '%')->orderBy('id', 'asc')->paginate(20);
                }
                break;
            case 'todos':
                if ($buscar  == '') {
                    $usuario = User::orderBy('id', 'asc')->paginate(20);
                }else{
                    $usuario = User::where('name', 'like', '%' . $buscar . '%')->orderBy('id', 'asc')->paginate(20);
                }
                break;
        }
        return [
            'pagination' => [
                'total' => $usuario->total(),
                'current_page' => $usuario->currentPage(),
                'per_page' => $usuario->perPage(),
                'first_page' => $usuario->firstItem(),
                'last_page' => $usuario->lastPage(),
                'from' => $usuario->firstItem(),
                'to' => $usuario->lastItem(),
            ],
            'usuarios' => $usuario
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->active = '1';
        $user->save();
    }
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->active = '0';
        $user->save();
    }
}
