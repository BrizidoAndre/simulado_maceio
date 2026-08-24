@php
    $categoriesSelect = collect(\App\Models\Category::pluck('name','id'));
@endphp
<x-layout-admin>
    <div class="hstack justify-content-between">
        <h1>Categories</h1>
        <a href="{{route('category.create')}}" class="btn btn-primary">Create Category</a>
    </div>
    <table class="table">
        <thead>
        <th>Name</th>
        <th>Actions</th>
        </thead>
        <tbody>
        @foreach($categories as $category)
            @php
                $ulid = \Illuminate\Support\Str::ulid();
                $formId = \Illuminate\Support\Str::ulid();
            @endphp
            <tr>
                <td>{{$category->name}}</td>
                <td>
                    <a href="{{route('category.edit', $category)}}" class="btn btn-secondary">Edit</a>
                    <button
                        data-bs-toggle="modal"
                        data-bs-target="#{{$ulid}}"
                        class="btn btn-danger"
                    >
                        Delete
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="{{$ulid}}" tabindex="-1" aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel"
                                    >
                                        Are you sure you want to perform this action?
                                    </h1>
                                </div>
                                <div class="modal-body">
                                    <x-form
                                        action="{{route('category.destroy', $category)}}"
                                        id="{{$formId}}"
                                        method="delete"
                                    >
                                        <x-field-select name="replacement" label="Replacement">
                                            @foreach($categoriesSelect->except($category->getKey())->toArray() as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </x-field-select>
                                    </x-form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        No!
                                    </button>
                                    <button type="submit" form="{{$formId}}" class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</x-layout-admin>
