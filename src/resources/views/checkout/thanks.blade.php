@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Obrigado pelo pedido!</h2>
        <p>Seu pedido #{{ $order->id }} foi registrado com sucesso.</p>

        <h4>Itens</h4>
        <ul>
            @foreach ($order->items as $item)
                <li>{{ $item['name'] }} ({{ $item['variation'] }}) x {{ $item['qty'] }}</li>
            @endforeach
        </ul>

        <p><strong>Subtotal:</strong> R$ {{ number_format($order->subtotal, 2, ',', '.') }}</p>
        <p><strong>Frete:</strong> R$ {{ number_format($order->shipping, 2, ',', '.') }}</p>
        <p><strong>Desconto:</strong> R$ {{ number_format($order->discount, 2, ',', '.') }}</p>
        <p><strong>Total:</strong> R$ {{ number_format($order->total, 2, ',', '.') }}</p>

        <h4>Endereço de Entrega</h4>
        <p>
            {{ $order->street }}, {{ $order->number }}
            {{ $order->complement }}<br>
            {{ $order->district }} – {{ $order->city }}/{{ $order->state }}<br>
            CEP: {{ $order->cep }}
        </p>

        <a href="{{ route('products.index') }}" class="btn btn-primary">Voltar à loja</a>
    </div>
@endsection
