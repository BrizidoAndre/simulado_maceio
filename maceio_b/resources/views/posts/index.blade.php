@php
    $status = [
        'Draft' => 'text-bg-secondary',
        'Published' => 'text-bg-success',
]
@endphp
<x-layout-admin>
    <div class="hstack justify-content-between">
        <h1>Posts</h1>
        <a href="{{route('post.create')}}" class="btn btn-primary">Create Post</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Publication Date</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td>{{$post->title}}</td>
                <td>{{$post->category?->name ?? 'No category attached'}}</td>
                <td>
                    <span class="badge {{$status[$post->status]}}">
                        {{$post->status}}
                    </span>
                </td>
                <td>{{$post->published_at?->format('d/m/Y') ?? ''}}</td>
                <td class="hstack gap-2">
                    <a href="{{route('post.edit', $post)}}" class="btn btn-secondary">Edit</a>
                    <x-form
                        action="{{route('post.destroy', $post)}}"
                        method="DELETE"
                        onsubmit="return confirm('Are you sure you want to perform this action?')"
                    >
                        <button class="btn btn-danger">Delete</button>
                    </x-form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</x-layout-admin>
