@props([
    'model' => new \App\Models\Post(),
    'action' => '',
    'method' => 'POST',
    'label' => ''
])
<x-form action="{{$action}}" method="{{$method}}">
    <x-field name="title" value="{{old('title', $model->title)}}">Title</x-field>
    <x-field-select name="category_id" label="Category">
        @foreach(\App\Models\Category::pluck('name','id') as $key => $value)
            <option @selected($key == $model->category_id) value="{{$key}}">{{$value}}</option>
        @endforeach
    </x-field-select>
    <x-field type="file" name="image">Image</x-field>
    <x-field-area value="{{$model->content}}" name="content">Content</x-field-area>
    <x-field-check :checked="$model->highlight" name="highlight">Highlight</x-field-check>
    <button class="btn btn-primary">{{$label}}</button>
</x-form>
