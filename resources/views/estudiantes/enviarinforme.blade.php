<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        #estudiante {
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }
        
        #estudiante td, #estudiante th {
          border: 1px solid #ddd;
          padding: 8px;
        }
        
        #estudiante tr:nth-child(even){background-color: #f2f2f2;}
        
        #estudiante tr:hover {background-color: #ddd;}
        
        #estudiante th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          background-color: #4CAF50;
          color: white;
        }
        </style>
</head>

<body>
    <div class="container">
        <h3>Informe final</h3>
        <br>
        <p>Informe del estudiante {{$nombre }} con cedula {{$cedula}} que cursa la certificacion {{$nombre_cer }}
        </p>
        <table id="estudiante">
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
                <td>{{ $nota_final_modulo }} </td>
                <td>{{ $nota_final_laboratorio }} </td>
                <td>{{ $nota_prueba }} </td>
                <td>{{ $nota_sustentacion }} </td>
                <td>{{ $definitiva }} </td>
            </tr>
            <tbody> </tbody>
        </table>
    </div>
</body>

</html>
