<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Role;
class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return redirect('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sucursal.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $role_user = Role::where('name', 'user')->first();
         $sucursal = new User();
        if ($request->hasFile('url_imagen')) {
            $nombre_carpeta =str_replace(' ', '', $sucursal->name);

            $image = $request->file('url_imagen');
            $nombre_imagen = "fotoperfil".time().".".$image->getClientOriginalExtension();
            /* destino de la imagen */
            $destinoPath = public_path('/imagenes/sucursal/'.$nombre_carpeta."/perfil"."/");
            /* guardar imagen en la ruta */
            $image->move($destinoPath,$nombre_imagen);
            
            $sucursal->name= $request->nombre;
            $sucursal->email =$request->correo;
            $sucursal->password = bcrypt($request->contrasenia);
            $sucursal->descripcion = $request->descripcion;
            $sucursal->url_imagen = $request->root().'/imagenes/sucursal/'.$nombre_carpeta."/perfil"."/".$nombre_imagen;
            $sucursal->id_telegram = 1;
            $sucursal->direccion = $request->direccion;
            $sucursal->lat = $request->lat;
            $sucursal->long = $request->long;
            $sucursal->save();
            $sucursal->roles()->attach($role_user);
        }else{
            $sucursal->name= $request->nombre;
            $sucursal->email =$request->correo;
            $sucursal->password = bcrypt($request->contrasenia);
            $sucursal->descripcion = $request->descripcion;
            
            $sucursal->id_telegram = 1;
            $sucursal->direccion = $request->direccion;
            $sucursal->lat = $request->lat;
            $sucursal->lon = $request->long;
            $sucursal->save();
            $sucursal->roles()->attach($role_user);
        }
        return redirect('home')->with("success",'Sucursal creada correctamente');
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
        $sucursal = User::find($id);
        return view('sucursal.edit', compact('sucursal'));
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

        $sucursal = User::find($id);
        if ($request->hasFile('url_imagen')) {

            /* checar si existe una ruta de imagen en la bd */
            $checar_img =str_replace($request->root(),'',$sucursal->url_imagen); 
            if(file_exists(".".$checar_img)){
                /* proseguir en eliminarlo  */
                unlink(".".$checar_img);
                /* archivo eliminado */
                $nombre_carpeta =str_replace(' ', '', $sucursal->name);

                $image = $request->file('url_imagen');
                $nombre_imagen = "fotoperfil".time().".".$image->getClientOriginalExtension();
                /* destino de la imagen */
                $destinoPath = public_path('/imagenes/sucursal/'.$nombre_carpeta."/perfil"."/");
                /* guardar imagen en la ruta */
                $image->move($destinoPath,$nombre_imagen);

                /* guardar las variables */
                $sucursal->name= $request->nombre;
                $sucursal->email =$request->correo;
                if($request->contrasenia){

                    $sucursal->password = bcrypt($request->contrasenia);
                }
                $sucursal->descripcion = $request->descripcion;
                $sucursal->url_imagen = $request->root().'/imagenes/sucursal/'.$nombre_carpeta."/perfil"."/".$nombre_imagen;
                $sucursal->id_telegram = 1;
                $sucursal->direccion = $request->direccion;
                $sucursal->lat = $request->lat;
                $sucursal->lon = $request->long;
                $sucursal->save();


            }else{
                /* sino hay imagen se crea una carpeta con el nombre de la tienda o el id y se guarda la imagen */
                /* creacion del archivo y de la ruta  */

                $nombre_carpeta =str_replace(' ', '', $sucursal->name);

                $image = $request->file('url_imagen');
                $nombre_imagen = "fotoperfil".time().".".$image->getClientOriginalExtension();
                /* destino de la imagen */
                $destinoPath = public_path('/imagenes/sucursal/'.$nombre_carpeta."/perfil"."/");
                /* guardar imagen en la ruta */
                $image->move($destinoPath,$nombre_imagen);
                
                $sucursal->name= $request->nombre;
                $sucursal->email =$request->correo;
                if($request->contrasenia){

                    $sucursal->password = bcrypt($request->contrasenia);
                }
                $sucursal->descripcion = $request->descripcion;
                $sucursal->url_imagen = $request->root().'/imagenes/sucursal/'.$nombre_carpeta."/perfil"."/".$nombre_imagen;
                $sucursal->id_telegram = 1;
                $sucursal->direccion = $request->direccion;
                $sucursal->lat = $request->lat;
                $sucursal->lon = $request->long;
                $sucursal->save();



            }
           
            
        }else{
            /* sino hay archivo en el resquest solo guarda las variables */

            $sucursal->name= $request->nombre;
            $sucursal->email =$request->correo;
            if($request->contrasenia){

                $sucursal->password = bcrypt($request->contrasenia);
            }
            $sucursal->descripcion = $request->descripcion;
            $sucursal->id_telegram = 1;
            $sucursal->direccion = $request->direccion;
            $sucursal->lat = $request->lat;
            $sucursal->lon = $request->long;
            $sucursal->save();

        }
        return redirect('home')->with('info','Sucursal actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect('home')->with('success','se elimino correctamente');
    }
}
