@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Produtos</h2>
        @include('partials.alerts')
        <a href="{{ route('products.create') }}" class="btn btn-success mb-3">Novo Produto</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Preço (R$)</th>
                    <th>Variações</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $p)
                    <tr>
                        <td>{{ $p->name }}</td>
                        <td>{{ number_format($p->price, 2, ',', '.') }}</td>
                        <td>
                            @foreach ($p->stocks as $s)
                                <span class="badge bg-info text-dark">
                                    {{ $s->variation }}: {{ $s->quantity }}
                                </span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('products.edit', $p->id) }}" class="btn btn-sm btn-warning">✎</a>
                            <form action="{{ route('products.destroy', $p->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger btn-delete">🗑</button>
                            </form>
                            <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $p->id }}">
                                <input type="hidden" name="variation" value="{{ $p->stocks->first()->variation }}">
                                <input type="hidden" name="qty" value="1">
                                <button class="btn btn-sm btn-success">🛒</button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @push('scripts')
        <script>
            $('.btn-delete').on('click', function(e) {
                e.preventDefault();
                const form = $(this).closest('form');
                Swal.fire({
                    title: 'Remover produto?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, remover',
                    cancelButtonText: 'Cancelar'
                }).then(result => {
                    if (result.isConfirmed) form.submit();
                });
            });
        </script>
    @endpush
@endsection
