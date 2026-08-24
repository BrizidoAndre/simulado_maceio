@php
    $types = [
        'primary',
        'secondary',
        'danger',
        'warning',
        'success'
]
@endphp
<div class="position-fixed end-0 bottom-0 m-5">
    @foreach($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{$error}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endforeach
    @foreach($types as $type)
        @session($type)
        <div class="alert alert-{{$type}} alert-dismissible fade show" role="alert">
            {{$value}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endsession
    @endforeach
</div>
