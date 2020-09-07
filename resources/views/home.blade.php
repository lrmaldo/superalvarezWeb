@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <div class="row">

                        <!--(Sucursales) Card Usuarios -->
                        <div class="col-xl-3 col-md-6 mb-4">
                          <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Sucursales</div>
                                  <div class="h5 mb-0 font-weight-bold text-gray-800">cantidad</div>
                                </div>
                                <div class="col-auto">
                                  <i class="fas fa-store fa-3x text-gray-300"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                          <!--(Sucursales) Card total de productos -->
                          <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                              <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                  <div class="col mr-2">
                                   <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Productos totales</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">cantidad</div>
                                  </div>
                                  <div class="col-auto">
                                    <i class="fas fa-cube fa-3x text-gray-300"></i>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                    </div>

                    <div class="card text-center " style="width: 100%">
                        <div class="card-header">
                         
                        </div>
                        <div class="card-body">
                            <img class="img-fluid  " style="width: 25%;" src="img/portada.svg" alt="">
                            <br>
                            Administra tu sucursal
                        </div>
                      </div>
                      <div class="card">
                        <div class="card-body">
                            <a href="" class="btn btn-primary"> <i class="fas fa-store"></i> Crear sucursal</a>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
