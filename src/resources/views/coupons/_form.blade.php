@csrf

<div class="mb-3">
    <label class="form-label">Código</label>
    <input type="text" name="code" value="{{ old('code', $coupon->code) }}" class="form-control" required>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Tipo de Desconto</label>
        <select name="discount_type" class="form-select" required>
            <option value="fixed" {{ old('discount_type', $coupon->discount_type) == 'fixed' ? 'selected' : '' }}>Valor
                Fixo</option>
            <option value="percent" {{ old('discount_type', $coupon->discount_type) == 'percent' ? 'selected' : '' }}>
                Porcentagem</option>
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Valor do Desconto</label>
        <input type="number" step="0.01" name="discount_value"
            value="{{ old('discount_value', $coupon->discount_value) }}" class="form-control" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Subtotal Mínimo (R$)</label>
        <input type="number" step="0.01" name="min_subtotal"
            value="{{ old('min_subtotal', $coupon->min_subtotal) }}" class="form-control" required>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Validade de</label>
        <input type="date" name="valid_from" value="{{ old('valid_from', $coupon->valid_from?->format('Y-m-d')) }}"
            class="form-control">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Até</label>
        <input type="date" name="valid_to" value="{{ old('valid_to', $coupon->valid_to?->format('Y-m-d')) }}"
            class="form-control">
    </div>
</div>
