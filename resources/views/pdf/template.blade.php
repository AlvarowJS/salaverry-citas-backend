<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        color: #333333;

    }

    header {
        text-align: center
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .logo-img{
        width: 100px;
        height: 100px;
        float: right;
    }
    .observacion {
    width: 300px; /* O cualquier otro ancho que desees */
}
</style>

<body>
    <header>
    <img src="{{ public_path('images/logo.png') }}" class="logo-img" alt="Logo">
        <h2>
            Historias de Citas del Médico
            {{ $medico[0]->nombre }} {{ $medico[0]->apellido_paterno }} {{ $medico[0]->apellido_materno }}
        </h2>
        <div>
            Fecha: {{ $fechaInicio }} al {{ $fechaFin}}
            <br>
            Número de consultorio: {{ $medico[0]->numero_consultorio}}
        </div>
    </header>
    <hr>
    <br>
    <div>
        <table>
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Observacion</th>
                <th>Paciente</th>
                <th>Tipo de pago</th>
                <th>Pago</th>

            </tr>
            @foreach ($citas as $cita)
                <tr>
                    <td>{{ $cita->fecha }}</td>
                    <td>{{ $cita->hora }}</td>
                    <td class="observacion">{{ $cita->observacion }}</td>
                    <!-- <td>{{ $cita->multiuso ? 'Si' : 'No' }}</td> -->
                    <td>{{ $cita->nombre }} {{ $cita->apellido_paterno }} {{ $cita->apellido_materno }}</td>
                    <td>{{ $cita->tipoPago }}</td>
                    <td>$ {{ $cita->pago }}</td>
                </tr>
            @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total</td>
                    <td>$ {{$sumaTotal}}</td>
                </tr>
        </table>
    </div>
</body>

</html>
