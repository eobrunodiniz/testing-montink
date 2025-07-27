@csrf

<div class="mb-3">
    <label class="form-label">Nome</label>
    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="form-control" required>
</div>

<div class="mb-3">
    <label class="form-label">Preço (R$)</label>
    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}"
        class="form-control" required>
</div>

<hr>
<h5>Variações e Estoque</h5>
<table class="table" id="variations-table">
    <thead>
        <tr>
            <th>Variação</th>
            <th>Quantidade</th>
            <th><button type="button" id="add-row" class="btn btn-sm btn-success">+</button></th>
        </tr>
    </thead>
    <tbody>
        @php
            $vars = old('variations', $product->variations ?? []);
            $qtys = old('quantities', optional($product)->stocks->pluck('quantity')->toArray() ?? []);
        @endphp

        @forelse($vars as $i => $v)
            <tr>
                <td><input name="variations[]" class="form-control" value="{{ $v }}" required></td>
                <td><input type="number" name="quantities[]" class="form-control" value="{{ $qtys[$i] ?? 0 }}"
                        min="0" required></td>
                <td><button type="button" class="btn btn-sm btn-danger remove-row">×</button></td>
            </tr>
        @empty
            <tr>
                <td><input name="variations[]" class="form-control" required></td>
                <td><input type="number" name="quantities[]" class="form-control" value="0" min="0"
                        required></td>
                <td><button type="button" class="btn btn-sm btn-danger remove-row">×</button></td>
            </tr>
        @endforelse
    </tbody>
</table>

@push('scripts')
    <script>
        $(function() {
            $('#add-row').click(function() {
                $('#variations-table tbody').append(`
      <tr>
        <td><input name="variations[]" class="form-control" required></td>
        <td><input type="number" name="quantities[]" class="form-control" value="0" min="0" required></td>
        <td><button type="button" class="btn btn-sm btn-danger remove-row">×</button></td>
      </tr>`);
            });
            $(document).on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>
@endpush
