<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <meta name="description" content="Upload images share with everybody in the blink of an eye! ImgShare is FREE, and will always be." />
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="bg-gray-200 text-gray-700">
    @php
        if(!isset($categories)){
            $categories = \App\Models\Category::all();
        }
        
    @endphp

    <nav class="bg-white border-gray-200 dark:bg-gray-900 shadow-md">
        <div class="section flex flex-wrap items-center justify-between p-4">
            <a href="{{route('home')}}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="/images/logo.png" class="h-10" alt="ImgShare Logo">
            </a>
            <div class="flex md:order-2">
                <button type="button" data-collapse-toggle="navbar-search" aria-controls="navbar-search"
                    aria-expanded="false"
                    class="md:hidden text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 me-1">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
                <form class="relative hidden md:block" action="{{route('search')}}" method="GET">
                    <button type="submit" class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Search icon</span>
                    </button>
                    <input type="text" id="search-navbar" name="q"
                        class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-teal-500 dark:focus:border-teal-500"
                        placeholder="Search...">
                </form>
                <button data-collapse-toggle="navbar-search" type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-controls="navbar-search" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-search">
                <div class="relative mt-3 md:hidden">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="search-navbar"
                        class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-teal-500 dark:focus:border-teal-500"
                        placeholder="Search...">
                </div>
                <ul
                    class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700 items-center">
                    <li>
                        <a href="{{route('home')}}"
                            class="py-2 px-3 text-white bg-teal-700 rounded flex items-center gap-2"
                            aria-current="page">
                            <svg class="dark:text-white size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                            </svg>
                            New Post                           
                        </a>
                    </li>
                    <li>
                        <button id="discoverNavMenuLink" data-dropdown-toggle="discoverNavMenu"
                            class="flex items-center justify-between w-full py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-teal-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-teal-500 dark:focus:text-white dark:hover:bg-gray-700 md:dark:hover:bg-transparent">Discover
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="discoverNavMenu"
                            class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownLargeButton">
                                @foreach ($categories as $category)
                                <li>
                                    <a href="{{route('categories', ['slug' => $category->slug])}}"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{$category->title}}</a>
                                </li>
                                @endforeach
                                <li>
                                    <a href="{{route('categories', ['slug' => 'uncategorized'])}}"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Uncategorized</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="{{route('recent')}}"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-teal-700 md:p-0 md:dark:hover:text-teal-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Recent</a>
                    </li>
                    <li>
                        <a href="{{route('trending')}}"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-teal-700 md:p-0 dark:text-white md:dark:hover:text-teal-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Trending</a>
                    </li>
                    @if(request()->user() && request()->user()->role === 'admin')
                    <li>
                        <button id="navAdminMenuLink" data-dropdown-toggle="navAdminMenu"
                            class="flex items-center justify-between w-full py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-teal-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-teal-500 dark:focus:text-white dark:hover:bg-gray-700 md:dark:hover:bg-transparent">Admin
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="navAdminMenu"
                            class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownLargeButton">
                                <li>
                                    <a href="{{route('admin.dashboard')}}"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.reports')}}"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reportd Images</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    {{-- <div class="section px-4 flex justify-center mt-6">
        <!-- Start of banner code -->
        <a href="https://shrinkearn.com/ref/kunalkhan370"><img src="https://shrinkearn.com/webroot/modern_theme/img/728x90.gif" title="Shorten URLs and Earn Money" /></a>
        <!-- End of banner code -->
    </div> --}}

    {{view('partials.alert')}}

    @yield('main')

    {{-- <div class="section px-4 flex justify-center mt-8">
        <!-- Start of banner code -->
        <a href="https://shrinkearn.com/ref/kunalkhan370"><img src="https://shrinkearn.com/webroot/modern_theme/img/300x250.gif" title="Shorten URLs and Earn Money" /></a>
        <!-- End of banner code -->
    </div> --}}

    <div class="bg-teal-600 text-white mt-16">
        <div class="section px-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 py-6">
            <div class="sm:col-span-2">
                <h2 class="mb-2 text-2xl font-medium">ImgShare</h2>
                <p class="mb-4">We allows you to store images that have been dedicated to. But wait! There's more, you can share those with everybody in the blink of an eye! ImgShare is FREE, and will always be.</p>
                {{-- <div class="flex items-center gap-1">
                    <svg class="size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m3.5 5.5 7.893 6.036a1 1 0 0 0 1.214 0L20.5 5.5M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z"/>
                    </svg>                      
                    <span>kunal@backendguy.com</span>
                </div> --}}
            </div>

            <div>
                <h3 class="mb-2 text-2xl font-medium">Menu</h3>
                <ul>
                    <li><a href="{{route('home')}}">Home</a></li>
                    <li><a href="{{route('recent')}}">Recent Posts</a></li>
                    <li><a href="{{route('trending')}}">Trending Posts</a></li>
                </ul>
            </div>


            <div>
                <h3 class="mb-2 text-2xl font-medium">More</h3>
                <ul>
                    <li><a href="{{route('faq')}}">FAQ</a></li>
                    <li><a href="{{route('policy')}}">Privacy Policy</a></li>
                    <li><a href="{{route('terms')}}">Terms of Use</a></li>
                </ul>
            </div>
        </div>
    </div>

</body>

</html>
