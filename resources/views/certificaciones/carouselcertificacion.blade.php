<div id="carouselExampleSlidesOnly" class="carousel slide bg-info text-white" data-ride="carousel">
    <div class="carousel-inner" style="height: 300px;">
        <div class="carousel-item active">
            <div class="row">
                <div class="col-6 align-self-center text-white">
                    <h2> {{ 'Certificaciones de la academia local ufps' }}</h2>
                    <a class="btn btn-dark text-center" href="{{ url('certificaciones/listcertificaciones') }}">Ver Certificaciones </a>
                </div>

                <div class="col-6">
                    <img class="d-block w-100" src="{{ asset('storage') . '/uploads/cursos.png' }}" alt="First slide">

                </div>
            </div>
        </div>
        @foreach ($certificaciones as $certificacion)
            @if ($certificacion->imagen != '')

                <div class="carousel-item" style="height: 300px;">
                    <div class="row">
                        <div class="col-6 align-self-center text-light">
                            <h2 class="text-white"> {{ $certificacion->nombre }}</h2>
                            <a class="btn btn-dark" href="{{ url('certificaciones/listcertificaciones') }}">Ver
                                Certificaciones </a>
                        </div>
                        <div class="col-6">
                            <img class="d-block w-100" src="{{ asset('storage') . '/' . $certificacion->imagen }} "
                                style="height: 300px;">

                        </div>
                    </div>
                </div>
            @endif
        @endforeach

    </div>
</div>
