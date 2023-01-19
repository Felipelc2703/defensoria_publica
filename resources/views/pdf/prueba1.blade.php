<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Citas en Línea</title>
</head>
<body>
    <br>
    <br>
    <br>
    <br>
    <center>
        <h2> Citas canceladas por inhabilitar el día {{$fecha_pdf}}</h2> <br>
        {{-- <h2>{{$fecha}}</h2> --}}
    </center>
    <table>
        <tr >
            <th class="tabla_encabezado">Folio</th>
            <th class="tabla_encabezado">Nombre Solicitante</th>
            <th class="tabla_encabezado">Trámite</th>
            <th class="tabla_encabezado">Teléfono</th>
            <th class="tabla_encabezado">CURP</th>
        </tr>
        @foreach($citasCanceladas as $key => $cita)
            <tr>
                <td class="contenido-td texto-dato">{{$cita->folio}}</td>
                <td class="contenido-td texto-dato">{{$cita->nombre}}</td>
                <td class="contenido-td texto-dato">{{$cita->tramite}}</td>
                <td class="contenido-td texto-dato">{{$cita->telefono}}</td>
                <td class="contenido-td texto-dato">{{$cita->curp}}</td>
            </tr>
        @endforeach
    </table>
   
</body>
</html>

<style>
     .contenido-td {
        border: 1px solid #D4D7D8;
    }

    .texto-datos {
        padding: 10px;
    }
    .tabla_encabezado{
            background-color: #6a73a0;
            font-weight: bold;
            color: white;
            text-align: center;
    }
    table, td, th {
        font-size: 10px;
    }
</style>