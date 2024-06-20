<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 400px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333333;
        }

        .logo {
            width: 100px;
            height: 100px;
            margin-bottom: 10px;
        }

        .pay-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        .pay-button:hover {
            background-color: #45a049;
        }

        .card {
            background-color: #f9f9f9;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-content {
            font-size: 16px;
        }

        li {
            color: #d4af37;
        }

    </style>
</head>

<body>
    <div class="container">
        <img class="logo"
            src="https://firebasestorage.googleapis.com/v0/b/reactwebapp-bf5ca.appspot.com/o/WhatsApp%20Image%202024-04-28%20at%2000.27.57.jpeg?alt=media&token=2aa675c6-6bff-4965-84e2-591b3bbaddc2"
            alt="Logo">
        <h1>Pagar con Niubiz</h1>
        <div class="card-content">
            <p>Número de Orden: 00021</p>
            <p>Monto Total: S/.10</p>
        </div>
        <form action="{!!route('niubiz-success', ['order_id'=>12, '_token' => $response_token ])!!}" method="POST">
            <script type="text/javascript"
                src="https://static-content-qas.vnforapps.com/v2/js/checkout.js?qa=true"
                data-sessiontoken="{{$session_key}}"
                data-channel="web"
                data-merchantid="{{$merchantId}}"
                data-purchasenumber="00021"
                data-amount="10"
                data-expirationminutes="20"
                data-timeouturl="about:blank"
                data-merchantlogo="img/niubiz.png"
                data-formbuttoncolor="#000000">
            </script>

        </form>
    </div>
</body>

</html>
