<x-layout-admin>
    <div class="hstack justify-content-between">
        <h1>Galleries</h1>
        <a href="{{route('gallery.create')}}" class="btn btn-primary">Create Image</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Preview</th>
            <th>Filename</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($images as $image)
            <tr>
                <td>
                    <img src="{{asset($image->image_path)}}" alt="{{$image->image_path}}" width="150px">
                </td>
                <td class="fst-italic">{{$image->image_path}}</td>
                <td>{{$image->category?->name?? 'No category attached'}}</td>
                <td>
                    <x-form
                        action="{{route('gallery.destroy', $image)}}"
                        method="delete"
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
