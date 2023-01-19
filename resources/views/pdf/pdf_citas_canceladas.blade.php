<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Citas en Línea</title>
</head>
<body>

<h2>CITAS CANCELADAS</h2>

<p>{{$r}}</p>

    <table>
        <tr>
            <th>Folio</th>
            <th>Fecha</th>
            <th>Nombre Solicitante</th>
            <th>Tramite</th>
            <th>Telefono</th>
            <th>CURP</th>
        </tr>
        @foreach($citasCanceladas as $cita)
        {
            <tr>
                <td>{{$cita['folio']}}</td>
                <td>{{$cita->fecha}}</td>
                <td>{{$cita->nombre}}</td>
                <td>{{$cita->tramite}}</td>
                <td>{{$cita->telefono}}</td>
                <td>{{$cita->curp}}</td>
            </tr>
        }
    </table>
</body>
</html>