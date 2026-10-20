{{-- Labelled order-meta input with inline validation. Params: key, label, value, type?, col?, attrs? --}}
<div class="{{ $col ?? 'col-md-6' }} mb-3">
    <label class="form-label" for="f-{{ $key }}">{{ $label }}</label>
    <input type="{{ $type ?? 'text' }}" id="f-{{ $key }}" name="{{ $key }}" value="{{ old($key, $value) }}"
           class="form-control @error($key) is-invalid @enderror" {!! $attrs ?? '' !!}>
    @error($key)<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
