<div id="carouselExampleSlidesOnly" class="carousel-fade slide bg-info text-white rounded" data-ride="carousel">
    <div class="carousel-inner rounded" style="height: 300px;">
        <div class="carousel-item active rounded">
            <div class="row">
                <div class="col-6 align-self-center text-white">
                    <h2> {{ 'Certificaciones de la academia local ufps' }}</h2>
                    <a class="btn btn-dark text-center rounded" href="{{ url('certificaciones/card') }}">Ver Certificaciones </a>
                </div>

                <div class="col-6 rounded">
                    <img class="d-block w-100" src="{{ asset('storage') . '/uploads/cursos.png' }}" alt="First slide">

                </div>
            </div>
        </div>
        @foreach ($certificaciones as $certificacion)
            @if ($certificacion->imagen != '')

                <div class="carousel-item rounded" style="height: 300px;">
                    <div class="row">
                        <div class="col-6 align-self-center text-light rounded">
                            <h2 class="text-white"> {{ $certificacion->nombre }}</h2>
                            <a class="btn btn-dark" href="{{ url('certificaciones/card') }}">Ver
                                Certificaciones </a>
                        </div>
                        <div class="col-6 rounded">
                            <img class="d-block w-100 rounded" src="{{ asset('storage') . '/' . $certificacion->imagen }} "
                                style="height: 300px;">

                        </div>
                    </div>
                </div>
            @endif
        @endforeach

    </div>
</div>
