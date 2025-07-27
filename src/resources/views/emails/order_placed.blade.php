@component('mail::message')
    # Pedido Recebido

    Obrigado pelo seu pedido **#{{ $order->id }}**!

    ## Itens
    @foreach ($order->items as $item)
        - {{ $item['name'] }} ({{ $item['variation'] }}) x {{ $item['qty'] }}
    @endforeach

    **Subtotal:** R$ {{ number_format($order->subtotal, 2, ',', '.') }}
    **Frete:** R$ {{ number_format($order->shipping, 2, ',', '.') }}
    **Desconto:** R$ {{ number_format($order->discount, 2, ',', '.') }}
    **Total:** R$ {{ number_format($order->total, 2, ',', '.') }}

    ## Endereço de Entrega
    {{ $order->street }}, {{ $order->number }}
    {{ $order->district }} – {{ $order->city }}/{{ $order->state }}
    CEP: {{ $order->cep }}

    Obrigado,<br>
    {{ config('app.name') }}
@endcomponent
