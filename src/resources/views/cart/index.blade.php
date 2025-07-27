@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Carrinho</h2>
        @include('partials.alerts')

        @if (empty($items))
            <p>Seu carrinho está vazio.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Variação</th>
                        <th>Preço</th>
                        <th>Qtd</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['variation'] }}</td>
                            <td>R$ {{ number_format($item['price'], 2, ',', '.') }}</td>
                            <td style="width:150px;">
                                <form action="{{ route('cart.update') }}" method="POST" class="d-flex">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                    <input type="hidden" name="variation" value="{{ $item['variation'] }}">
                                    <input type="number" name="qty" value="{{ $item['qty'] }}" min="1"
                                        class="form-control me-1" style="width:120px">
                                    <button class="btn btn-sm btn-primary">OK</button>
                                </form>
                            </td>
                            <td>R$ {{ number_format($item['price'] * $item['qty'], 2, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                    <input type="hidden" name="variation" value="{{ $item['variation'] }}">
                                    <button class="btn btn-sm btn-danger">×</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mb-4">
                <p><strong>Subtotal:</strong> R$ {{ number_format($subtotal, 2, ',', '.') }}</p>
                <p><strong>Frete:</strong> R$ {{ number_format($shipping, 2, ',', '.') }}</p>
                <p><strong>Total:</strong> R$ {{ number_format($total, 2, ',', '.') }}</p>
            </div>

            <a href="{{ route('checkout.index') }}" class="btn btn-success">Finalizar Pedido</a>
        @endif
    </div>
@endsection
