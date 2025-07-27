{{-- edit.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Cupom</h2>
        @include('partials.alerts')
        <form action="{{ route('coupons.update', $coupon->id) }}" method="POST">
            @method('PUT')
            @include('coupons._form')
            <button class="btn btn-primary">Atualizar</button>
            <a href="{{ route('coupons.index') }}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
@endsection
