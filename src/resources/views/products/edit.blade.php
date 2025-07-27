@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Produto</h2>
        @include('partials.alerts')
        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @method('PUT')
            @include('products._form')
            <button class="btn btn-primary">Atualizar</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
@endsection
