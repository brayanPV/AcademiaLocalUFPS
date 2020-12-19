
   
        <div id="carouselExampleSlidesOnly" class="carousel-fade slide bg-info text-white rounded" data-ride="carousel">
            <div class="carousel-inner rounded" style="height: 300px;">
                <div class="carousel-item active" >
                    <img class="d-block w-100" src="{{ asset('storage') . '/uploads/anuncio1_bg.jpg'  }}" alt="First slide"> 
                </div>
                @foreach ($anuncios as $anuncio)

                    @if (count($anuncios) > 0 && $anuncio->tipo == 0)
                        <div class="carousel-item rounded">
                            <a href="{{$anuncio->url}}" target="_blank"><img class="d-block w-100 rounded" src="{{ asset('storage') . '/' . $anuncio->img1 }}"
                                alt="Second slide"> </a>
                        </div>
                    @endif
                @endforeach

            </div>
        </div>
   
