@extends('layouts.app')

@section('title', 'Healthub - Inicio')
@section('page', 'Inicio')

@section('content')
            <div class="row align-items-center">
                <div class="col-xl-4">
                    <div class="card overflow-hidden">
                        <div class="bg-primary-subtle">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-3">
                                        <h5 class="text-primary">Bienvenida {{ $usuario->nombre }}!</h5>
                                        <p>Poner algo aqui</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <!-- <img src="{{asset('assets/images/profile-img.png')}}" alt="" class="img-fluid"> -->
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <img src="{{ $usuario->foto ? $usuario->foto : asset('assets/images/users/default.webp') }}" alt="" class="img-thumbnail rounded-circle">
                                    </div>
                                    <h5 class="font-size-15 text-truncate"></h5>
                                    <p class="text-muted mb-0 text-truncate"></p>
                                </div>

                                <div class="col-sm-8">
                                    <div class="pt-4">
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="text-muted mb-0">Citas</p>
                                                <h5 class="font-size-15">{{ count($citas) }}</h5>
                                            </div>
                                            <div class="col-6">
                                                <p class="text-muted mb-0">Chats</p>
                                                <h5 class="font-size-15">0</h5>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <a href="{{ route('profile') }}" class="btn btn-primary waves-effect waves-light btn-sm">Ver perfil<i class="mdi mdi-arrow-right ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Citas</p>
                                            <h4 class="mb-0">{{ count($citas) }}</h4>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center ">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-calendar font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Informes</p>
                                            <h4 class="mb-0">0</h4>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center ">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-file font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Resultados</p>
                                            <h4 class="mb-0">0</h4>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center ">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-file font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Chat</p>
                                            <h4 class="mb-0">0</h4>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center ">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-chat font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        <script>document.write(new Date().getFullYear())</script> © Healthub
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
</div>
<div class="rightbar-overlay"></div>
@endsection