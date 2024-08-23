@props([
    'name' => '',
    'class' => 'form-control',
    'id' => '',
    'placeholder' => '',
    'required' => '',
    'data' => '',
    'value' => '',
    'label' => ''
])

<div class="row mb-3">
    <label class="col-md-3 col-form-label" for="{{ $id }}">{{ $label }}</label>
    <div class="col-md-9">
        <input type="text" value="{{ $value }}" name="{{ $name }}" id="{{ $id }}" class="{{ $class }}" placeholder="{{ $placeholder }}" {{ $required == 'yes' ? 'required' : '' }} />
    </div>
</div>
