<?php

namespace App\Http\Controllers;

use App\bannerprincipal;
use App\bannerSucursal;
use App\categoria;
use App\producto;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $sucursales = User::where('activo',1)->simplePaginate(4);
        
        $bannerP = bannerprincipal::All();

       
        $data = array(
            'bannerP'=>$bannerP,
            'sucursales' =>$sucursales
        );
        $collection = collect($data);
        $page = 1;
        $perpage =10;
        $response = new LengthAwarePaginator($collection->forPage($page,$perpage),$collection->count().$perpage,$page);


        return $response;

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
         $sucursal = User::where('id',$id)->where('activo',1)->get();
        
            $datos =array();
         $productos = producto::where('id_sucursal',$id)->where('activo',1)->get();
         $categoria = categoria::where('id_sucursal',$id)->get();
         $banners = bannerSucursal::where('id_sucursal',$id)->get();
         $array = array(
             'productos'=>$productos,
             'categorias' => $categoria,
             'banners' =>$banners

         );
         //array_push($datos, $array);
     
        


         $collection = collect($array);
        $page=1;
        $perpage = 10;
        $response = new LengthAwarePaginator($collection->forPage($page,$perpage),$collection->count(),$perpage,$page);
        $sucursal = User::where('id',$id)->where('activo',1)->get();
         if(sizeof($sucursal)==0){
            return response()
            ->json(['estado'=>404,'mensaje'=>"no se encontro la sucursal"]);
         }else{

             return $response;
         }
       
         
         
        
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
    /* para solicitar el precio de un producto */
    public function producto($id){
         $producto = producto::find($id);

         return $producto;
    }

    public function productos_sucursal($id){
         $productos = producto::where('id_sucursal',$id)->get();
        
         return $productos; 
    }
}
