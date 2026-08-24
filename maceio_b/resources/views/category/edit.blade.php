<x-layout-admin>
    <h1>Update category</h1>
    <x-form-category
        method="put"
        action="{{route('category.update', $category)}}"
        :model="$category"
        label="Update"
    >

    </x-form-category>
</x-layout-admin>
