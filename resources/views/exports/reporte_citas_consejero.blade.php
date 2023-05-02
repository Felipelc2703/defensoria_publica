<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>REPORTE CITAS</h3>
    <table>
        <thead>
            <tr>
                <th>FOLIO</th>
                <th>NOMBRE</th>
                <th></th>
                <th></th>
                <th>SEXO</th>
                <th></th>
                <th></th>
                <th>CORREO</th>
                <th></th>
                <th>TELÉFONO</th>
                <th></th>
                <th>Expediente</th>
                <th></th>
                <th></th>
                <th></th>
                <th>FECHA</th>
                <th></th>
                <th>HORARIO</th>
                <th></th>
                <th>ESTATUS</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($citas as $key => $cita)
                <tr>
                    <td>{{$cita['folio']}}</td>
                    <td>{{$cita['nombre']}}</td>
                    <td></td>
                    <td></td>
                    @if($cita['sexo'] == 'Masculino')
                        <td>Hombre</td>
                    @elseif($cita['sexo'] == 'Femenino')
                        <td>Mujer</td>
                    @else
                        <td>{{$cita['sexo']}}</td>
                    @endif
                    {{-- <td>{{$cita['sexo']}}</td> --}}
                    <td></td>
                    <td></td>
                    <td>{{$cita['correo']}}</td>
                    <td></td>
                    <td>{{$cita['telefono']}}</td>
                    <td></td>
                    <td>{{$cita['expediente']}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{$cita['fecha']}}</td>
                    <td></td>
                    <td>{{$cita['horario']}}</td>
                    <td></td>
                    <td>{{$cita['estatus']}}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>