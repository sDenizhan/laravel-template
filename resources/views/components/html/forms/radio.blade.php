@props([
    'name' => '',
    'class' => 'form-group',
    'id' => '',
    'placeholder' => '',
    'required' => '',
    'data' => ''
])

@foreach($data as $checkbox)
    <label for="">{{ $checkbox->answer }}</label>
    <input type="radio" name="{{ $name }}" id="{{ $id }}" class="{{ $class }}" placeholder="{{ $placeholder }}" {{ $required == 'yes' ? 'required' : '' }} value="{{ $checkbox->id }}" />
@endforeach
