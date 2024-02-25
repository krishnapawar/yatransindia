<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __($pageTitle?? config('app.name', 'Laravel')) }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <style>
        #profile_picture_preview {
            width: 100px;
            /* Set the desired width */
            height: 100px;
            /* Set the desired height */
            overflow: hidden;
            position: relative;
        }

        #profile_picture_preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Maintain aspect ratio and cover the container */
            border-radius: 50%;
            /* Make the image circular */
            border: 2px solid #ccc;
            /* Optional: Add a border */
        }

        .custom-file {
            overflow: hidden;
        }

        .custom-file-input {
            width: 0;
            overflow: hidden;
        }

        .custom-file-label {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        body {
            background-color: #fbfbfb;
        }
        @auth
        @media (min-width: 991.98px) {
            main {
                padding-left: 240px;
            }
        }
        @endauth

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding: 58px 0 0;
            /* Height of navbar */
            box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
            width: 240px;
            z-index: 600;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                width: 100%;
            }
        }

        .sidebar .active {
            border-radius: 5px;
            box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: 0.5rem;
            overflow-x: hidden;
            overflow-y: auto;
            /* Scrollable contents if viewport is shorter than content. */
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">        
            <!--Main Navigation-->
            <header>
                @auth
                <!-- Sidebar -->
                @include('./admin/sidebare');
                @endauth
                <!-- Sidebar -->

                <!-- Navbar -->
                <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
                    <!-- Container wrapper -->
                    <div class="container-fluid">
                        <!-- Toggle button -->
                        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                            data-mdb-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <i class="fas fa-bars"></i>
                        </button>

                        <!-- Brand -->
                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                        @guest
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
                            
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                        </ul>
                        @else
                        <!-- Search form -->
                        <form class="d-none d-md-flex input-group w-auto my-auto">
                            <input autocomplete="off" type="search" class="form-control rounded"
                                placeholder='Search (ctrl + "/" to focus)' style="min-width: 225px;" />
                            <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
                        </form>

                        <!-- Right links -->
                        <ul class="navbar-nav ms-auto d-flex flex-row">
                            <!-- Notification dropdown -->
                            <li class="nav-item dropdown">
                                <a class="nav-link me-3 me-lg-0 dropdown-toggle hidden-arrow" href="#"
                                    id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-bell"></i>
                                    <span class="badge rounded-pill badge-notification bg-danger">1</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                                    <li>
                                        <a class="dropdown-item" href="#">Some news</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">Another news</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </li>
                                </ul>
                            </li>

                            <!-- Icon -->
                            {{--<li class="nav-item">
                                <a class="nav-link me-3 me-lg-0" href="#">
                                    <i class="fas fa-fill-drip"></i>
                                </a>
                            </li>--}}
                            <!-- Icon -->
                            <li class="nav-item me-3 me-lg-0">
                                <a class="nav-link" href="https://github.com/krishnapawar">
                                    <i class="fab fa-github"></i>
                                </a>
                            </li>
                            <!-- Avatar -->
                            <li class="nav-item dropdown">
                                <a  class="nav-link" href="{{route('profile')}}" role="button">
                                    <img src="{{asset(auth()->user()->profile_picture??'https://mdbcdn.b-cdn.net/img/Photos/Avatars/img (31).webp')}}"
                                        class="rounded-circle" height="22" alt="Avatar" loading="lazy" />
                                    {{ Auth::user()->name }}
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{route('profile')}}">My profile</a>
                                    </li>
                                    
                                </ul>
                            </li>
                            @endguest
                        </ul>
                        </li>
                        </ul>
                    </div>
                    <!-- Container wrapper -->
                </nav>
                <!-- Navbar -->
            </header>
            <!--Main Navigation-->

            <!--Main layout-->
            <main style="margin-top: 58px;">
                <div class="container pt-4"></div>
            </main>
            <!--Main layout-->

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @auth
                    <div class="col-md-12">
                        <div class="card">
                            <div class="row card-header">
                                <div class="col-md-6">
                                    {{ __($pageTitle??'') }}
                                </div>
                                @yield('content_header')
                            </div>

                            <div class="card-body">
                                @if (session('status'))
                                    @if (session('status')=='success')
                                        <div class="alert alert-success" role="alert">
                                            {{ session('message') }}
                                        </div>
                                    @else
                                        <div class="alert alert-danger" role="alert">
                                            {{ session('message') }}
                                        </div>
                                    @endif
                                    
                                @endif
                                @yield('content')
                            </div>
                        </div>
                    </div>
                    
                    @endauth
                </div>
            </div>
            @guest
                @yield('content')
            @endguest
        </main>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
@yield('script')
<script>
    document.querySelectorAll('.numeric-input').forEach(function (input) {
        input.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, ''); // Allow only numeric characters
        });
    });
</script>

</html>
