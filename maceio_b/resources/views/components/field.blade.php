@props([
    'name',
    'id' => $name,
])
<div class="mb-3">
    <label for="{{$id}}" class="form-label">{{$slot}}</label>
    <input id="{{$id}}"
        {{$attributes->merge([
        'type' => 'text',
        'class' => 'form-control',
        'name' => $name,
        'value' => old($name, ''),
    ])}}
    >
</div>
