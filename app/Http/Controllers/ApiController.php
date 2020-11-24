<?php

namespace App\Http\Controllers;

use App\bannerprincipal;
use App\bannerSucursal;
use App\categoria;
use App\pedidos;
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

        $sucursales = User::where('activo', 1)->simplePaginate(4);

        $bannerP = bannerprincipal::All();


        $data = array(
            'bannerP' => $bannerP,
            'sucursales' => $sucursales
        );
        $collection = collect($data);
        $page = 1;
        $perpage = 10;
        $response = new LengthAwarePaginator($collection->forPage($page, $perpage), $collection->count() . $perpage, $page);


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
        $sucursal = User::where('id', $id)->where('activo', 1)->get();

        $datos = array();
        $productos = producto::where('id_sucursal', $id)->where('activo', 1)->get();
        $categoria = categoria::where('id_sucursal', $id)->get();
        $banners = bannerSucursal::where('id_sucursal', $id)->get();
        $array = array(
            'productos' => $productos,
            'categorias' => $categoria,
            'banners' => $banners

        );
        //array_push($datos, $array);




        $collection = collect($array);
        $page = 1;
        $perpage = 10;
        $response = new LengthAwarePaginator($collection->forPage($page, $perpage), $collection->count(), $perpage, $page);
        $sucursal = User::where('id', $id)->where('activo', 1)->get();
        if (sizeof($sucursal) == 0) {
            return response()
                ->json(['estado' => 404, 'mensaje' => "no se encontro la sucursal"]);
        } else {

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
    public function producto($id)
    {
        $producto = producto::find($id);

        return $producto;
    }

    public function productos_sucursal($id)
    {
        $productos = producto::where('id_sucursal', $id)->get();

        return $productos;
    }


    public function store_pedido(Request $request)
    {

        $id_sucursal = $request->id_sucursal; //el id de la sucursal para posteriormente consultar
        $arrayDatosCliente = (array) $request->datos_cliente; //array con los datos de envio del cliente
        $comentario = $request->comentario; // si hay comentario del campo en el checkout 
        $total_pedido = $request->totalc; //total de producto del carrito 

        /* obtener los datos de la sucursal*/
        $sucursal =  User::where('id', '=', $id_sucursal)->first();
        $id_telegram = $sucursal->id_sucursal;/* obtener el id de telegram de la sucursal a enviar */

        $carrito = $request->carrito; // obtener  el  objeto del carrito del cliente;

        $texto = "\n Hola tienes un nuevo pedido \n \n";
        $texto .= "\n *** Datos del cliente****";
        $texto .= "Nombre: " . $arrayDatosCliente['nombre'] . "\n";
        $texto .= "Teléfono: " . $arrayDatosCliente['telefono'] . "\n";
        $texto .= "Dirección: " . $arrayDatosCliente['direccion'] . "\n";
        $texto .= "Entre: " . $arrayDatosCliente['telefono'] . "\n";
        $texto .= "Colonia: " . $arrayDatosCliente['colonia'] . "\n";
        $texto .= "Referencia: " . $arrayDatosCliente['referencia'] . "\n";
        $texto .= "Fecha de entrega: " . $request->fecha_entrega . "\n";

        /* salta de linea*/
        $texto .= "\n \n";
        /* carrito y sus productos */
        $texto .= "***Lista de productos***\n";
        foreach ($carrito as $item) {
               

                    $total_item = ( (float)$item['precio'] * (float)$item['cantidad']);
                    $texto .= $item['producto']['titulo']. ': $' . (float) $item['precio'] . '*' . $item['cantidad'] . ' = $' . $total_item . "\n";
                
        }
        /* total del carrito */
        $texto .= "Total: $" . $request->totalc . "\n";

        $texto .= "\n";/* salto de linea */

        /* request  parametros */
        $request_params = [
            'chat_id' => $id_telegram,
            'text' => $texto,
        ];

        /* url de telegram chat  conexion*/
        $token = 'bot1267434596:AAEN1WSsLPKYfyEK9BBj7IV7jWIQWK3hG-M';
        $request_url = 'https://api.telegram.org' . $token . '/sendMessage?' . http_build_query($request_params);

        /* enviar a telegram */
        try {
            file_get_contents($request_url);
        } catch (\Throwable $th) {
            return response()->json(['code' => 500, 'message' => 'Ocurrio un problema', 'status' => 'danger'], 500);
        }

        /* fin de envio a telegram */

        /* guardar datos en la base de datos  */


        $pedido = new pedidos();
        $pedido->carrito = json_encode($carrito);
        $pedido->total = $request->totalc;
        $pedido->datos_cliente = json_encode($arrayDatosCliente);
        $pedido->id_sucursal = $id_sucursal;
        $pedido->comentario = $request->comentario != null ? $request->comentario : 'no hay comentarios';
        $pedido->fecha_entrega =  $request->fecha_entrega;
        $pedido->save();
        /* finalizacion de  guarda datos en la base datos */

        return response()->json(['code' => 200, 'message' => 'Datos guardados exitosamente...', 'status' => 'success'], 200);
    }
}
