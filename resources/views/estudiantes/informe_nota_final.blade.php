<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h3>Informe final</h3>
        <br>
        <p>Informe del estudiante {{ $est->nombre }} con cedula {{ $est->cedula}} que cursa la certificacion {{ $est->nombre_cer }}
        </p>
        <table class="table">
            <thead>
                <tr>
                    <th>Nota Final Modulos</th>
                    <th>Nota Final Laboratorios</th>
                    <th>Nota Certificacion</th>
                    <th>NotaTrabajo Final</th>
                    <th>Nota Definitiva</th>
                </tr>
            </thead>
            <tr>
                <td>{{ $est->nota_final_modulo }} </td>
                <td>{{ $est->nota_final_laboratorio }} </td>
                <td>{{ $est->nota_prueba }} </td>
                <td>{{ $est->nota_sustentacion }} </td>
                <td>{{ $est->definitiva }} </td>
            </tr>
            <tbody> </tbody>
        </table>
    </div>
</body>

</html>
