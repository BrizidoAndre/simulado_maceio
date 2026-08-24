<x-layout>
    <header class="bg-dark">
        <div class="container">
            <nav class="navbar fixed-top bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand text-light" href="{{route('public.index')}}">PhotoPortal</a>
                    <button class="bg-light navbar-toggler" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasNavbar"
                            aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                         aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Photoportal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('post.index')}}">Posts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('category.index')}}">Categories</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('gallery.index')}}">Gallery</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('contact.index')}}">Contacts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="w-100 btn btn-danger" href="{{route('auth.logout')}}">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <main class="container pt-5 mt-4">
        {{$slot}}
    </main>
</x-layout>
