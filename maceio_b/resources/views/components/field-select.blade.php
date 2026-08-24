@props([
    'label' => '',
    'name',
    'id' => $name
])
<div class="mb-3">
    <label for="{{$id}}" class="form-label">{{$label}}</label>
    <select id="{{$id}}" class="form-select" name="{{$name}}" {{$attributes->merge()}}>
        <option value="">No category</option>
        {{$slot}}
    </select>
</div>
