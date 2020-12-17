@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card pg-4">
            <div id="accordion">

                <div class="card pg-4">
                    <h5 class="p-3 mb-2">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne"
                            aria-expanded="false" aria-controls="collapseOne">¿Quienes Somos? </button>
                    </h5>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="col">
                            <h3>Cisco Networking Academy en la UFPS</h3>
                            La Universidad Francisco de Paula Santander a trav&eacute;s del grupo de investigaci&oacute;n
                            GIRET (Grupo de Investigaci&oacute;n en Redes de Computadores y Telecomunicaciones) elaboro un
                            convenio con Cisco System Network Academy para ofrecer en la regi&oacute;n el programa de
                            Certificaci&oacute;n Internacional en Redes de Computadores Cisco y proyectar a la Universidad
                            como una instituci&oacute;n de capacitaci&oacute;n en Tecnolog&iacute;as con est&aacute;ndares
                            internacionales.
                            <br /><br /><br>

                            <h3>Infraestructura Tecnol&oacute;gica de la UFPS.</h3>
                            La Universidad Francisco de Paula Santander cuenta con dos laboratorios totalmente equipados
                            para el desarrollo de pr&aacute;cticas en el dise&ntilde;o, instalaci&oacute;n,
                            operaci&oacute;n, administraci&oacute;n y mantenimiento de redes de computadores alambricas e
                            inal&aacute;mbricas y seguridad en redes. Los equipos con que cuenta son Routers de la serie
                            800, 1700, 1800, 2800 y 2900, Switch Catalasys 2950, 3560 y 2960, Access Point Aironet de la
                            serie 1100, 1200 y 1300, Kit de antenas, Firewall Pix 515 y ASA 5510, Herramientas y probadores
                            como Fluke 620, LinkRunner , computadores personales de escritorio y port&aacute;tiles para
                            facilitar el desarrollo de las certificaciones que ofrece como CCNA R&S ,CCNA Wireless ,CCNA
                            Security,Routing & Switching CCNP (CCNP Routing,CCNP Switch,CCNP TSHOOT)
                            <br /><br /><br>
                            <img src="{{ asset('img/camino-cisco.jpg') }}" width="947" heigth="320" />
                            <br /><br /><br>
                        </div>
                    </div>
                </div>


                <div class="card pg-4">
                    <h5 class="p-3 mb-2">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                            aria-expanded="false" aria-controls="collapseTwo">
                            ¿Donde estamos?
                        </button>
                    </h5>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div>
                            <h5 class="text-primary">Ubicacion</h5>
                            <br /><br /><br>
                            <div class="d-flex justify-content-center">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15807.706749027308!2d-72.4909025!3d7.90272815!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e6645102f9b7269%3A0xab4b03ed6c85830e!2sUniversidad+Francisco+de+Paula+Santander!5e0!3m2!1ses-419!2sco!4v1526486565903"
                                    width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                                <br /><br /><br>
                            </div>
                            <br /><br /><br>
                        </div>
                    </div>


                    <div class="card pg-4">
                        <h5 class="p-3 mb-2">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree"
                                aria-expanded="false" aria-controls="collapseThree">
                                Costos
                            </button>
                        </h5>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div id="row">

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            DE CONTADO
                                        </div>
                                        <div class="card-body">

                                            <p>
                                                <span>Valor de la Inscripci&oacute;n</span>: <b
                                                    class="rojillo">$62.000</b><br /><br />
                                                <span>Valor del Curso</span>: <b class="rojillo">$1.800.000</b> (Puede
                                                cancelarse de contado, con tarjeta de cr&eacute;dito o financiado con
                                                Pichincha o COOPFUTURO)<br /><br />
                                                <span>Cupo Maximo</span>: <b class="rojillo">20 Personas</b><br /><br />
                                                <span>Consignaci&oacute;n</span>: Consignar en BANCOLOMBIA a la cuenta No.
                                                83248722994 :: Cta Ahorros a nombre de FRIE-UFPS :: C&oacute;digo de
                                                Convenio No: 29570
                                            </p>

                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            FRIE
                                        </div>
                                        <div class="card-body">

                                            <p>
                                                Fondo Rotatorio de Investigaci&oacute;n y Extensi&oacute;n UFPS, Edif. de
                                                Investigacion 2do Piso 5776655 EXT 169 <br /><br />
                                                <b>Pago con tarjeta de credito</b>, en las cuotas que considere.<br /><br />
                                                <b>Financia</b>: 70%, con el 0.5% de inter&eacute;s, dividido en tres cuotas
                                                <br /><br />
                                                <b>Requisitos</b>:
                                            <ul>
                                                <li>Codeudor con inca ra&iacute;z, que no tenga patrimonio familiar ni
                                                    embargo, no
                                                    puede ser padre ni c&oacute;nyugue del estudiante o profesional.</li>
                                                <li>Certificado de libertad y tradici&oacute;n</li>
                                                <li>Certificado de ingresos del estudiante</li>
                                                <li>Certificado de ingresos del codeudor</li>
                                                <li>Traer la consignaci&oacute;n del 30% pago</li>
                                            </ul>
                                            <br />
                                            Duraci&oacute;n del estudio de cr&eacute;dito, 1 semana.
                                            </p>

                                        </div>
                                    </div>
                                </div>


                                <br>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            COOPFUTURO
                                        </div>
                                        <div class="card-body">

                                            <p>
                                                Sede Administrativa Universidad Libre Tels: 5792434-5791464 <br><br>
                                                Sede francisco de Paula Tel: 5729878 Cel:3187358176 Ext 102 -101
                                                <br><br>
                                                <b>Requisitos</b>: <br>
                                                <i>Un codeudor con estabilidad laboral:</i>
                                            <ul>
                                                <li>Certificado de trabajo donde indique cargo, fecha de ingreso y sueldo.
                                                </li>
                                                <li>Copia de la cedula al 150 </li>
                                                <li>Ultimo desprendible de pago </li>
                                            </ul><br />
                                            <i>El estudiante:</i>
                                            <ul>
                                                <li>Copia de la cedula al 150 </li>
                                            </ul><br />
                                            Duraci&oacute;n de la aprobaci&oacute;n 1 d&iacute;a.</p>

                                        </div>
                                    </div>
                                </div>
                                <br>

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            PICHINCHA
                                        </div>
                                        <div class="card-body">

                                            <p>
                                                Av 0 # 13-80 Centro Tel 5721146 <br /><br />
                                                <b>Financia</b>: 100% con el 1.8% de inter&eacute;s, m&aacute;ximo 6 cuotas
                                                m&iacute;nimo 3 cuotas <br />
                                                <b>Requisitos</b>:
                                            <ul>
                                                <li>Formulario Inv. Pichincha </li>
                                                <li>Fotocopia Cedula ampliada 150 </li>
                                                <li>Mayor de 23 menor de 70 </li>
                                                <li>Ingresos como empleado o independiente superiores a $ 800.000 </li>
                                            </ul><br />
                                            <i>Independiente:</i>
                                            <ul>
                                                <li>Carta certificando ingresos actividad y tiempo de realizada la
                                                    actividad. </li>
                                            </ul>
                                            </p>

                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        Contacto
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title"></h5>
                                        <p class="card-text">CUALQUIER DUDA COMUNICARSE AL 5776655 EXT 277 - ESCRIBIR AL CORREO ciscoal@ufps.edu.co</p>
                                        <a href="{{ url('contacto/contac') }}" class="btn btn-primary">Contectenos</a>
                                    </div>
                                </div>
                                </div>  
                                <br>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endsection
