@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Novo Produto</h2>
        @include('partials.alerts')
        <form action="{{ route('products.store') }}" method="POST">
            @include('products._form')
            <button class="btn btn-primary">Salvar</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
@endsection
