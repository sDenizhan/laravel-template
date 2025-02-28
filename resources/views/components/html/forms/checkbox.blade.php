@props([
    'name' => '',
    'class' => 'form-group',
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
        @foreach($data as $checkbox)
            <div class="form-check">
                <input type="checkbox" name="{{ $name }}" id="{{ $id }}" class="{{ $class }}" placeholder="{{ $placeholder }}" {{ $required == 'yes' ? 'required' : '' }} value="{{ $checkbox->id }}" />
                <label for="{{ $id }}">{{ $checkbox->answer }}</label>
            </div>
        @endforeach
    </div>
</div>
