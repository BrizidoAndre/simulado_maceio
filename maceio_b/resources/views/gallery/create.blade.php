<x-layout-admin>
    <h1>Upload Image</h1>
    <x-form action="{{route('gallery.store')}}">
        <x-field type="file" name="image">Image</x-field>
        <x-field-select label="Category" name="category_id">
            @foreach(\App\Models\Category::pluck('name','id') as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        </x-field-select>
        <button class="btn btn-primary">Upload</button>
    </x-form>
</x-layout-admin>
