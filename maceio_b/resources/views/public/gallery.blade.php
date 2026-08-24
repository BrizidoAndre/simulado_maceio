<x-layout-public>
    <section class="container">
        <h1>Gallery</h1>
        <div class="row row-cols-3 g-3">
            @foreach($photos as $photo)
                <div class="col">
                    <button class="w-100 h-100 btn" type="button" data-bs-toggle="modal"
                            data-bs-target="#{{$photo->image_path}}">
                        <img src="{{$photo->image_path}}" alt="{{$photo->metadata_hash}}"
                             class="w-100 h-100 object-fit-cover rounded-3">
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="{{$photo->image_path}}" tabindex="-1"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body position-relative p-0">
                                    <button type="button" class="btn-close position-absolute end-0 top-0 m-3"
                                            data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    <img src="{{$photo->image_path}}" alt="{{$photo->image_path}}"
                                         class="w-100 object-fit-cover rounded-3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-layout-public>
