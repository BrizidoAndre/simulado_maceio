@props([
    'model' => new \App\Models\Category(),
    'action',
    'method' => 'post',
    'label' => '',
])
<x-form method="{{$method}}" action="{{$action}}">
    <x-field value="{{old('name',$model->name)}}" name="name">
        Name
    </x-field>
    <button class="btn btn-primary">{{$label}}</button>
</x-form>
