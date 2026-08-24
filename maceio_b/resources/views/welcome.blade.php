<x-layout-public>
    <section class="text-center py-5 bg-body-tertiary" id="hero">
        <h1>Welcome to PhotoPortal</h1>
        <p>Photography stories, tutorials and galleries.</p>
    </section>
    <section class="py-5 container">
        <div class="row row-cols-3">
            <div class="col">
                <div class="card">
                    <img src="{{asset('assets/imgs/07.jpg')}}" class="card-img-top" alt="First image preview">
                    <div class="card-body">
                        <p class="card-title">Urban Photography</p>
                        <p class="card-text">
                            Explore create4ive city photography techniques.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="{{asset('assets/imgs/14.jpg')}}" class="card-img-top" alt="Second image preview">
                    <div class="card-body">
                        <p class="card-title">Nature Photography</p>
                        <p class="card-text">
                            Capture beautiful landscapes and outdoor scenes
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="{{asset('assets/imgs/15.jpg')}}" class="card-img-top" alt="Third image preview">
                    <div class="card-body">
                        <p class="card-title">Editing Workflow</p>
                        <p class="card-text">
                            Learn simple editing techniques for better photos
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container bg-body-tertiary">
        <div class="row">
            <div class="col-5">
                <img src="{{asset('assets/imgs/{2DD8ABF5-3C1C-4438-A99F-C1FE1ED08E1C}.png')}}"
                     alt="Person taking photo"
                     class="w-100 h-100 object-fit-cover rounded-3 shadow"
                >
            </div>
            <div class="col py-5">
                <h2>About</h2>
                <p class="text-muted text-light">Capturing moments emotions and stories through photography</p>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet aspernatur at aut beatae dicta
                    doloribus et excepturi id, incidunt iusto labore libero maiores nemo numquam, officia officiis omnis
                    provident rem repudiandae sed sit tempora voluptas? Accusamus dolorem expedita illum ipsam iste
                    laudantium, nam nostrum quam quo repellat sapiente, sunt vel.
                </p>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ab accusamus amet animi aspernatur
                    blanditiis commodi consectetur corporis culpa distinctio dolorum earum enim esse est eum explicabo
                    hic, laborum maiores molestiae nam natus nesciunt nihil nostrum nulla numquam obcaecati omnis
                    perspiciatis porro quam quasi ratione reiciendis sequi totam ut voluptate?
                </p>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea eaque inventore iste magni nam neque
                    nulla, ut! Ab, aut, modi!
                </p>
                <div class="hstack gap-2">
                    <a href="{{route('public.gallery')}}" class="btn btn-dark">View Gallery</a>
                    <a href="#contact" class="btn btn-outline-dark">Contact</a>
                </div>
            </div>
        </div>
    </section>
    <section id="contact" class="container">
        <h2 class="text-center my-5">Contact</h2>
        <x-form action="{{route('public.contact')}}">
            <x-field name="name">Name</x-field>
            <x-field name="email">Email</x-field>
            <x-field-area name="message">Message</x-field-area>
            <button class="btn btn-dark">Send</button>
        </x-form>
    </section>
</x-layout-public>
