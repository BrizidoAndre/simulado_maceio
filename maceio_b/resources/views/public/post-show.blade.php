<x-layout-public>
    <section class="container py-5">
        @if($post->category)
            <p class="badge text-bg-dark">{{$post->category->name}}</p>
        @endif
        <h1>{{$post->title}}</h1>
        <p class="text-muted">{{$post->published_at->format('F d, Y')}} - {{$post->status}}</p>
        <img src="{{asset($post->image->image_path)}}" alt="" class="w-100 rounded-3 my-3">
        <p>{{$post->content}}</p>
    </section>
</x-layout-public>
