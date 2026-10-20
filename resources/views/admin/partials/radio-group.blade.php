{{-- Accessible radio group with unique ids. Params: name, label, options [value => label], value --}}
<fieldset class="mb-3">
    <legend class="form-label fs-6 mb-1" style="font-size:.8125rem !important;">{{ $label }}</legend>
    <div class="d-flex flex-wrap gap-3">
        @foreach($options as $optValue => $optLabel)
            <div class="form-check">
                <input class="form-check-input @error($name) is-invalid @enderror" type="radio" id="{{ $name }}-{{ $optValue }}" name="{{ $name }}" value="{{ $optValue }}" @checked((string) $value === (string) $optValue)>
                <label class="form-check-label" for="{{ $name }}-{{ $optValue }}">{{ $optLabel }}</label>
            </div>
        @endforeach
    </div>
    @error($name)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
</fieldset>
