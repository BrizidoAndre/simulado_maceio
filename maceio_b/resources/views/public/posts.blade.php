<x-layout-public>
    <section class="container">
        <h2>Posts</h2>
        @foreach($posts as $post)
            <div class="card my-3">
                <img src="{{asset($post->image->image_path)}}" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-title">{{$post->title}}</p>
                    <p class="card-text">{{\Illuminate\Support\Str::substr($post->content, 0 ,70)}}...</p>
                    <a href="{{route('public.postShow', $post)}}" class="btn btn-dark">Read More</a>
                </div>
            </div>
        @endforeach
    </section>
</x-layout-public>
