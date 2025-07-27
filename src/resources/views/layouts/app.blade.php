<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montink :: Mini ERP</title>
    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font-Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('products.index') }}">
                <i class="fas fa-store"></i> Mini ERP
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('products.*') ? ' active' : '' }}"
                            href="{{ route('products.index') }}">
                            <i class="fas fa-box-open"></i> Produtos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('cart.*') ? ' active' : '' }}"
                            href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart"></i> Carrinho
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('checkout.*') ? ' active' : '' }}"
                            href="{{ route('checkout.index') }}">
                            <i class="fas fa-credit-card"></i> Checkout
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('orders.*') ? ' active' : '' }}"
                            href="{{ route('orders.index') }}">
                            <i class="fas fa-list-alt"></i> Pedidos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('coupons.*') ? ' active' : '' }}"
                            href="{{ route('coupons.index') }}">
                            <i class="fas fa-ticket-alt"></i> Cupons
                        </a>
                    </li>
                </ul>

                {{-- Botão rápido do Carrinho com badge --}}
                <a href="{{ route('cart.index') }}" class="btn btn-outline-light position-relative">
                    <i class="fas fa-shopping-cart"></i>
                    @php
                        $cartCount = collect(session('cart', []))->sum('qty');
                    @endphp
                    @if ($cartCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        {{-- Aqui entra o conteúdo de cada página --}}
        @yield('content')
    </div>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
