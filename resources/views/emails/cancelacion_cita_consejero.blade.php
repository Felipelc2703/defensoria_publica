<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Citas en Línea</title>

    <style>
        .titulo-confirmacion {
            font-family: 'Lato', sans-serif;
            font-weight: 900;
            font-size: 18pt;
        }

        .formato-texto {
            font-family: 'Lato', sans-serif;
            font-size: 14pt;
        }

        .texto-cita {
            text-align: justify;
        }

        .texto-nombre {
            text-transform: uppercase;
        }

        .texto-tramite {
            text-transform: uppercase;
        }

        .centro-atencion-cita {
            text-transform: uppercase;
        }

        .direccion-cita {
            text-transform: uppercase;
        }

        .texto-folio {
            text-transform: uppercase;
            font-weight: 900;
            font-size: 15pt;
        }

        .folio-cita {
            text-transform: uppercase;
            font-weight: 900;
            font-size: 37pt;
            color: #6a73a0;
            text-align: center;
        }

        .first-line {
            background-color: #b1bced;
            height: 3px;
        }
    </style>
</head>
<body>
    <h5 class="titulo-confirmacion">Cancelación de Cita</h5>
    <p><span class="formato-texto">Información Importante</span></p>
    < class="texto-cita">Estimado(a) <span class="texto-nombre">{{$cita->nombre}}</span> su cita con fecha {{$cita->fecha}}, a las {{$cita->hora}} horas, ha sido cancelada  por el motivo: <span class="centro-atencion-cita">{{$cita->motivo}}</span>, en la fecha y hora antes mencionada.</p>
    <br>
    <p>Favor de reagendar la cita.</p>
    <br>
    <br>
    <p>citasenlinea.pjpuebla.gob.mx</p>
    <div class="first-line"></div>
</body>
</html>