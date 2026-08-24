<x-layout>
    <header class="text-bg-dark">
        <div class="container">
            <nav class="navbar navbar-expand-lg text-light">
                <div class="container-fluid">
                    <a class="navbar-brand text-light" href="{{route('public.index')}}">PhotoPortal</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 justify-content-end">
                            <li class="nav-item text-light">
                                <a class="nav-link text-light" href="{{route('public.gallery')}}">Gallery</a>
                            </li>
                            <li class="nav-item text-light">
                                <a class="nav-link text-light" href="{{route('public.posts')}}">Posts</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <main class="pb-5">
        {{$slot}}
    </main>
    <footer class="text-bg-dark text-center py-4">
        <h2 class="fs-4">PhotoPortal</h2>
        <p>Sharing photography stories, inspiration and creative experiences.</p>
        <span class="fs-6">@ 2026 PhotoPortal. All rights reserved.</span>
    </footer>
</x-layout>
