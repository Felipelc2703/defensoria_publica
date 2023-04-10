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
            font-weight: bold;
        }

        .texto-tramite {
            text-transform: uppercase;
            font-weight: bold;
        }

        .centro-atencion-cita {
            text-transform: uppercase;
            font-weight: bold;
        }

        .direccion-cita {
            text-transform: uppercase;
            font-weight: bold;
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
            border-bottom: 0.2cm;
        }

        .second-line {
            border-bottom: 0.5px;
        }
        .texto-fecha {
        text-transform: uppercase;
        font-weight: bold;
    }
    </style>
</head>
<body>
    <br>
    <br>
    <br>
    <br>
    <h5 class="titulo-confirmacion">Confirmación de Cita</h5>
    <p><span class="formato-texto">Información Importante</span></p>
    <p class="texto-cita">Estimado(a) <span class="texto-nombre;">{{$citaAgendada->nombre}}</span> su cita con el Juez <span class="texto-tramite">{{$citaAgendada->juez}}</span> ha quedado agendada para el <span class="texto-fecha">{{$citaAgendada->fecha}}</span>, a las <span class="texto-fecha">{{$citaAgendada->hora}}</span> horas.</p>
    <p class="texto-cita">Por lo que reiteramos debe presentarse en el Juzgado <span class="centro-atencion-cita">{{$citaAgendada->juzgado}}</span> ubicado en <span class="direccion-cita">Ciudad Judicial</span>, en la fecha y hora antes mencionada.</p>
    <br>
    <div class="first-line"></div>
    <p>Le recordamos que el <span class="texto-folio">folio</span> de su cita es:</p>
    <br>
    <br>
    <h4 class="folio-cita">{{$citaAgendada->folio}}</h4>
    <div class="second-line"></div>
    <br>
    <p class="texto-cita">Notas:</p>
</body>
</html>