

    <div class="container">
            <div id="carouselExampleSlidesOnly" class="carousel slide bg-info text-white" data-ride="carousel">
                <div class="carousel-inner" style="height: 300px;">
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-6 align-self-center text-dark">
                                <h2> {{ 'Cursos de la academia local ufps' }}</h2>
                            </div>

                            <div class="col-6">
                                <img class="d-block w-100" src="{{ asset('storage') . '/uploads/cursos.png' }}"
                                    alt="First slide">

                            </div>
                        </div>
                    </div>
                    @foreach ($cursos as $curso)
                        @if ($curso->imagen != '')

                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-6 align-self-center text-dark">
                                        <h2> {{ $curso->nombre }}</h2>
                                    </div>


                                    <div class="col-6">
                                        <img class="d-block w-100" src="{{ asset('storage') . '/' . $curso->imagen }}">

                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>
        

