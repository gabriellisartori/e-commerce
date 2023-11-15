<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inria+Sans:wght@400;700&family=Roboto&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        .title {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #5f8a17;
            font-family: 'Inria Sans', sans-serif;
        }

        .info {
            margin: 0 1rem;
            font-size: 1rem;
            margin-bottom: 1rem;
            font-family: 'Inria Sans', sans-serif;
        }

        .info-details {
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 1rem;
            margin-right: 0.5rem;
            font-family: 'Inria Sans', sans-serif;
        }

        .card-details {
            border: 2px solid #5f8a17;
            border-radius: 16px;
            padding: 1rem;
            margin: 1rem 2.5rem;
            font-family: 'Inria Sans', sans-serif;

            @media screen and (max-width: 768px) {
                margin: 1rem 1rem;
            }
        }

        .green {
            color: #3e5903;
        }

        .ingredients-items {
            margin-top: 0.5rem;
            margin-left: 1rem;
            display: flex;
            flex-direction: column;
            font-family: 'Inria Sans', sans-serif;
        }

        .dot {
            height: 10px;
            width: 10px;
            background-color: #5f8a17;
            border-radius: 50%;
            display: inline-block;
            margin-right: 0.5rem;
        }

        .mt {
            margin-top: 0.5rem;
        }

        .ml {
            margin-left: 1rem;
        }
        .mb {
            margin-bottom: 5rem;
        }
    </style>
</head>

<body>
    <div>
        <h1 class="title">Novo pedido 🎉</h1>
        <p class="info ml">Olá! 😄</p>
        <p class="info ml">Você tem um novo pedido, veja detalhes abaixo:</p>
    </div>
    <div>
        <p class="info-details">
            <span class="info-details green ml">Nome do cliente: </span> {{ $order['name'] }}
        </p>
        <p class="info-details green ml">Detalhes do pedido:</p>
        <div>
            <div class="card-details">
                @foreach ($order['order_product'] as $orderProduct)
                <p><span class="info-details green">Nome:</span> {{ $orderProduct['product']['name'] }}</p>
                <p class="mt"><span class="info-details green">Valor:</span> R$ {{ $orderProduct['product']['value'] }}</p>
                <p class="mt"><span class="info-details green">Quantidade:</span> {{ $orderProduct['quantity'] }}</p>
                <p class="mt"><span class="info-details green">Ingredientes:</span></p>
                <div class="ingredients-items">
                    @foreach ($orderProduct['product']['product_ingredient'] as $ingredient)
                    <p><span class="dot"></span>{{ $ingredient['name'] }}</p>
                    @endforeach
                </div>
            </div>
            <div class="card-details">
                <p class="info-details green">Adicionais:</p>
                <div>
                    <p class="mt"><span class="info-details green">Nome:</span> {{ $orderProduct['order_product_additional']['name'] }}</p>
                    <p class="mt"><span class="info-details green">Valor:</span> R$ {{ $orderProduct['order_product_additional']['additional_value'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
        <p class="mt ml"><span class="info-details green">Observação:</span> {{ $order['observation'] }}</p>
        <p class="mt ml mb"><span class="info-details green">Valor total:</span> R$ {{ $order['total_value'] }}</p>
    </div>
</body>

</html>