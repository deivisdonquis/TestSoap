<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Notificacion de Pago</title>
</head>
<body>
    <p><h1>Usted a realizado un pago de:{{ $monto }} desde su billetera virtual.</h1></p>
    <p>Para que este pago se ejecute debe confirmarlo enviando los siguientes datos desde su aplicacion</p>
    <ul>
        <li>Id de Session: {{ $idsesion }}</li>
        <li>Token        : {{ $token }}</li>
    </ul>
    <p>Gracias por usar los servicios de su billetera virtual.</p>
</body>
</html>