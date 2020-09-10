@extends('layouts.app')
@section('content')

    <h1 class="mt-4">Crear Tienda</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Crear</li>
    </ol>

<form role="form" method="POST" enctype="multipart/form-data" action="{{ route('sucursal.store') }}" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-lg  btn-primary">
                    <i class="fa fas-store"></i>
                    Crear
                </button>
                <!--button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#exampleModal"> <i class="far fa-trash-alt"></i>
                                                              Eliminar
                                                              </button-->
            </div>
        </div>
        {{-- nombre --}}
        <div class="form-group">
            <div class="input-group-prepend">
                <label class="col-md-4 control-label">Nombre de la sucursal:*</label>
            </div>
            <div class="col-md-8">
                <input type="text" id="nombre" class="form-control" name="nombre" value=""
                    placeholder="Como se llama la sucursal" required autofocus>
            </div>
        </div>

        {{-- email --}}

        <div class="form-group">
            <div class="input-group-prepend">
                <label class="col-md-4 control-label">Email:*</label>
            </div>
            <div class="col-md-8">
                <input type="email" id="correo" class="form-control" name="correo" value=""
                    placeholder="Email para iniciar sesion en esta plataforma" required>
            </div>
        </div>
        {{-- contraseña  --}}

        <div class="form-group">
            <div class="input-group-prepend">
                <label class="col-md-4 control-label">Contraseña:*</label>
            </div>
            <div class="col-md-8">
                <input type="text" id="contrasenia" class="form-control" name="contrasenia" value=""
                    placeholder="Contraseña" required>
            </div>
        </div>

        {{-- direccion --}}
        <div class="form-group">
            <div class="input-group-prepend">
                <label class="col-md-4 control-label">Dirección:</label>
            </div>
            <div class="col-md-8">
                <input type="text" id="direccion" class="form-control" name="direccion" value=""
                    placeholder="Dirección de la sucursal" >
            </div>
        </div>

        {{-- descripcion --}}
        <div class="form-group">
            <div class="input-group-prepend">
                <label class="col-md-4 control-label">Descripcion:</label>
            </div>
            <div class="col-md-8">
                <textarea  id="descripcion" class="form-control "  rows="5" cols="50" name="descripcion" 
                placeholder="puedes poner una breve descripción de la sucursal o puedes dejar este campo vacío "  ></textarea>
            </div>
        </div>
        {{-- id telegram --}}

    
        {{-- ubicacion --}}
        <div class="form-group" >
            <div class="input-group-prepend">
              <label class="col-md-4 control-label">Localiza la sucursal en el mapa*</label>
              </div>
              <div class="col-md-8">
                <div class="map-responsive">
                <div id="mapa" style="width: 450px; height: 350px;"> </div>
               </div>
                <input type="hidden" id ="lat" class="form-control" name="lat" value="18.0864363" placeholder="Como se llama la tienda" required>
                <input type="hidden" id ="long" class="form-control" name="long" value="-96.1248874" placeholder="Como se llama la tienda" required>
              </div>
            </div>


    </form>

    @endsection

    <!--  script de mapa -->
    <style>
        .map-responsive {
            overflow: hidden;
            padding-bottom: 56.25%;
            position: relative;
            height: 0;
        }

    </style>

   
    <script>
        mapa = {
            map: false,
            marker: false,
            initMap: function() {
                // Creamos un objeto mapa y especificamos el elemento DOM donde se va a mostrar.
                mapa.map = new google.maps.Map(document.getElementById('mapa'), {
                    center: {
                        lat: 17.8282252,
                        lng: -95.8210509
                    },
                    scrollwheel: false,
                    zoom: 14,
                    zoomControl: true,
                    rotateControl: false,
                    mapTypeControl: true,
                    streetViewControl: false,
                });
                // Creamos el marcador
                mapa.marker = new google.maps.Marker({
                    position: {
                        lat: 17.8282252,
                        lng: -95.8210509
                    },
                    icon:"../img/logo_fondo.png",

                    draggable: true
                });
                // Le asignamos el mapa a los marcadores.
                mapa.marker.setMap(mapa.map);
                mapa.marker.addListener('dragend', function(event) {
                    //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
                    document.getElementById("lat").value = this.getPosition().lat();
                    document.getElementById("long").value = this.getPosition().lng();
                });
            },
            // función que se ejecuta al pulsar el botón buscar dirección
            getCoords: function() {
                // Creamos el objeto geodecoder
                var geocoder = new google.maps.Geocoder();
                address = document.getElementById('search').value;
                document.getElementById("coordenadas").innerHTML = 'Coordenadas:   ' + results[0].geometry
                    .location.lat() + ', ' + results[0].geometry.location.lng();
                if (address != '') {
                    // Llamamos a la función geodecode pasandole la dirección que hemos introducido en la caja de texto.
                    geocoder.geocode({
                        'address': address
                    }, function(results, status) {
                        if (status == 'OK') {
                            // Mostramos las coordenadas obtenidas en el p con id coordenadas
                            document.getElementById("coordenadas").innerHTML = 'Coordenadas:   ' +
                                results[0].geometry.location.lat() + ', ' + results[0].geometry.location
                                .lng();
                            // Posicionamos el marcador en las coordenadas obtenidas
                            mapa.marker.setPosition(results[0].geometry.location);
                            // Centramos el mapa en las coordenadas obtenidas
                            mapa.map.setCenter(mapa.marker.getPosition());
                            agendaForm.showMapaEventForm();
                        }
                    });
                }
            }
        }

    </script>
