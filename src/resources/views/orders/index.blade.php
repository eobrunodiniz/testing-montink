@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Admin de Pedidos</h2>
        @include('partials.alerts')

        @if ($orders->isEmpty())
            <p>Não há pedidos.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente (e-mail)</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $o)
                        <tr>
                            <td>{{ $o->id }}</td>
                            <td>{{ $o->email ?? '—' }}</td>
                            <td>R$ {{ number_format($o->total, 2, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('orders.updateStatus', $o->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                        @foreach (['pending', 'processing', 'completed', 'cancelled'] as $st)
                                            <option value="{{ $st }}" {{ $o->status === $st ? 'selected' : '' }}>
                                                {{ ucfirst($st) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('orders.destroy', $o->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Remover pedido?')">×</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
