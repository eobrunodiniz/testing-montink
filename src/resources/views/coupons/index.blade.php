@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Cupons</h2>
        @include('partials.alerts')
        <a href="{{ route('coupons.create') }}" class="btn btn-success mb-3">Novo Cupom</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Desconto</th>
                    <th>Subtotal Mínimo</th>
                    <th>Validade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coupons as $c)
                    <tr>
                        <td>{{ $c->code }}</td>
                        <td>
                            @if ($c->discount_type === 'fixed')
                                R$ {{ number_format($c->discount_value, 2, ',', '.') }}
                            @else
                                {{ $c->discount_value }}%
                            @endif
                        </td>
                        <td>R$ {{ number_format($c->min_subtotal, 2, ',', '.') }}</td>
                        <td>
                            {{ $c->valid_from?->format('d/m/Y') }}
                            até
                            {{ $c->valid_to?->format('d/m/Y') }}
                        </td>
                        <td>
                            <a href="{{ route('coupons.edit', $c->id) }}" class="btn btn-sm btn-warning">✎</a>
                            <form action="{{ route('coupons.destroy', $c->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger btn-delete">🗑</button>
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
                    title: 'Remover cupom?',
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
