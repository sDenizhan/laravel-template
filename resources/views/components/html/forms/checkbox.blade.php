@props([
    'name' => '',
    'class' => 'form-group',
    'id' => '',
    'placeholder' => '',
    'required' => '',
    'data' => '',
    'value' => ''
])

@foreach($data as $checkbox)
    <label for="">{{ $checkbox->answer }}</label>
    <input type="checkbox" name="{{ $name }}" id="{{ $id }}" class="{{ $class }}" placeholder="{{ $placeholder }}" {{ $required == 'yes' ? 'required' : '' }} value="{{ $checkbox->id }}" />
@endforeach
