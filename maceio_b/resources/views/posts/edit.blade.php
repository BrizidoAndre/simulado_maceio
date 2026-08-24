<x-layout-admin>
    <h1>Update post</h1>
    <a href="{{route('post.toggle', $post)}}" class="btn btn-secondary">Toggle Post Status</a>
    <x-form-post label="Update" method="put" action="{{route('post.update', $post)}}" :model="$post"></x-form-post>
</x-layout-admin>
