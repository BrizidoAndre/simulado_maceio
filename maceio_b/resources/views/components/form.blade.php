@props([
    'method' => 'POST',
    'action' => '',
])
<form method="post" action="{{$action}}" {{$attributes->merge()}} enctype="multipart/form-data">
    @csrf
    @method($method)
    {{$slot}}
</form>
