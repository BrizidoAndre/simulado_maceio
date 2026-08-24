@props([
    'name',
    'id' => $name,
    'value'=> '',
])

<div class="mb-3">
    <label for="{{$id}}" class="form-label">{{$slot}}</label>
    <textarea class="form-control" id="{{$id}}" rows="3"
    {{$attributes->merge([
    'class' => 'form-control',
    'name' => $name,
])}}>{{old($name, $value)}}</textarea>
</div>
