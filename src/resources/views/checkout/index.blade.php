@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Finalizar Pedido</h2>
        @include('partials.alerts')

        @php
            $cart = session(\App\Services\CartService::SESSION_KEY, []);
            $subtotal = app(\App\Services\CartService::class)->subtotal();
            $shipping = app(\App\Services\CartService::class)->shipping();
            $total = $subtotal + $shipping;
        @endphp

        @if (empty($cart))
            <p>Seu carrinho está vazio.</p>
        @else
            <table class="table">
                <tbody>
                    @foreach ($cart as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['variation'] }}</td>
                            <td>{{ $item['qty'] }}</td>
                            <td>R$ {{ number_format($item['price'] * $item['qty'], 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p><strong>Subtotal:</strong> R$ {{ number_format($subtotal, 2, ',', '.') }}</p>
            <p><strong>Frete:</strong> R$ {{ number_format($shipping, 2, ',', '.') }}</p>

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Seu e-mail</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">CEP</label>
                        <input type="text" id="cep" name="cep" class="form-control" required>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Rua</label>
                        <input type="text" id="street" name="street" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Número</label>
                        <input type="text" name="number" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Complemento</label>
                        <input type="text" name="complement" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Bairro</label>
                        <input type="text" id="district" name="district" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Cidade</label>
                        <input type="text" id="city" name="city" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-2 mb-3">
                        <label class="form-label">Estado</label>
                        <input type="text" id="state" name="state" class="form-control" maxlength="2" required>
                    </div>

                    <div class=" col-10 mb-3">
                        <label class="form-label">Cupom (opcional)</label>
                        <input type="text" name="coupon_code" class="form-control">
                    </div>
                </div>

                <button class="btn btn-success">Confirmar Pedido – R$ {{ number_format($total, 2, ',', '.') }}</button>
            </form>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        // Busca automática de endereço via CEP
        document.getElementById('cep').addEventListener('blur', function() {
            let cep = this.value.replace(/\D/g, '');
            if (cep.length === 8) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('street').value = data.logradouro;
                            document.getElementById('district').value = data.bairro;
                            document.getElementById('city').value = data.localidade;
                            document.getElementById('state').value = data.uf;
                        }
                    });
            }
        });
    </script>
@endpush
