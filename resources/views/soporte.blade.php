@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card pg-4">
            <div id="accordion">

                <div class="card pg-4">
                    <h5 class="p-3 mb-2">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne"
                            aria-expanded="false" aria-controls="collapseOne">¿Como comenazar? </button>
                    </h5>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item list-group-item-action">
                                <a target="_blank"
                                    href="https://www.cisco.com/c/dam/en_us/training-events/le31/le46/cln/cln-images/cisco-concentrations/THe_Value_of_Certifications-Spanish_2011.pdf">
                                    Sueldos y mas</a>
                            </li>
                            <li class="list-group-item list-group-item-action">
                                <a target="_blank" href="https://learningnetwork.cisco.com/s/certifications">
                                    Certificaciones Cisco</a>
                            </li>
                            <li class="list-group-item list-group-item-action">
                                <a target="_blank"
                                    href="https://www.cisco.com/c/dam/en_us/training-events/le31/le46/cln/cln-images/cisco-concentrations/Cisco_CCNA_Concentrations.pdf">
                                    Security, voice, wireless</a>
                            </li>
                            <li class="list-group-item list-group-item-action">
                                <a target="_blank" href="https://testyourself.psychtests.com/testid/3965">
                                    ¿Las TI son para usted?</a>
                            </li>

                        </ul>
                    </div>
                </div>


                <div class="card pg-4">
                    <h5 class="p-3 mb-2">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                            aria-expanded="false" aria-controls="collapseTwo">
                            FAQ
                        </button>
                    </h5>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item list-group-item-action">
                                <a target="_blank"
                                    href="https://www.cisco.com/c/dam/en_us/training-events/le31/le46/cln/cln-images/cisco-concentrations/Spanish-Cisco_Certifications-FAQ-2011.pdf">Preguntas
                                    Frecuentes</a>
                            </li>
                        </ul>
                    </div>
                </div>


                <div class="card pg-4">
                    <h5 class="p-3 mb-2">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree"
                            aria-expanded="false" aria-controls="collapseThree">
                            Certificaciones
                        </button>
                    </h5>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <li class="list-group-item list-group-item-action"><a target="_blank" href="{{ url('certificaciones/card') }}">Nuestas
                                Certificaciones </a>
                        </li>
                        <li class="list-group-item list-group-item-action"><a target="_blank"
                                href="https://learningnetwork.cisco.com/s/certifications"> Certificaciones de Cisco </a>
                        </li>
                    </div>
                </div>

            </div>
        </div>
    @endsection
