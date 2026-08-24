@props([
    'name',
    'id' => $name,
    'checked' => false,
])
<div class="form-check">
    <input class="form-check-input" type="hidden" value="0" name="{{$name}}">
    <input @checked($checked) class="form-check-input" type="checkbox" value="1" id="{{$id}}" name="{{$name}}">
    <label class="form-check-label" for="{{$id}}">
        {{$slot}}
    </label>
</div>
