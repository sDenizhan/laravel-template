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
        <select type="text" name="{{ $name }}" id="{{ $id }}" class="{{ $class }}" {{ $required == 'yes' ? 'required' : '' }}>
            @if(!is_null($data))
                @foreach($data as $option)
                    <option value="{{ $option->id }}" {{ $value == $option->id ? 'selected' : '' }}>{{ $option->answer }}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>
