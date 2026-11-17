@props([
    'id',
    'name',
    'label',
    'type' => 'text',
    'value' => '',
    'required' => false,
    'placeholder' => '',
    'autocomplete' => null,
    'full' => false,
])
<div class="field {{ $full ? 'full' : '' }} {{ $errors->has($name) ? 'invalid' : '' }}">
  <label for="{{ $id }}">{{ $label }}</label>
  @if($type === 'textarea')
    <textarea id="{{ $id }}" name="{{ $name }}" @if($required) required @endif @if($placeholder) placeholder="{{ $placeholder }}" @endif>{{ old($name, $value) }}</textarea>
  @elseif($type === 'select')
    <select id="{{ $id }}" name="{{ $name }}" @if($required) required @endif>
      {{ $slot }}
    </select>
  @else
    <input id="{{ $id }}" type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $value) }}" @if($required) required @endif @if($placeholder) placeholder="{{ $placeholder }}" @endif @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif>
  @endif
  <div class="error">{{ $errors->first($name) }}</div>
</div>
