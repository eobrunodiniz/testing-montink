{{-- create.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Novo Cupom</h2>
        @include('partials.alerts')
        <form action="{{ route('coupons.store') }}" method="POST">
            @include('coupons._form')
            <button class="btn btn-primary">Salvar</button>
            <a href="{{ route('coupons.index') }}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
@endsection
