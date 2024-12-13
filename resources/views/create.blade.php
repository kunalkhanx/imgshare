@extends('app')

@section('title', 'ImgShare :: Upload & Share Images For Free')

@section('main')
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 my-6 section px-4">
        <form class="bg-white lg:col-span-3 shadow-md border p-6 rounded h-fit" method="POST" action="{{route('create_post')}}" enctype="multipart/form-data">

            @csrf

            <h1 class="text-xl font-bold mb-6">New Post</h1>

            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="image">Upload image <span class="text-gray-400">(max 2MB)</span></label>
                <input
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    id="image" type="file" name="image" accept=".jpg,.jpeg,.png">
                @error('image')
                    <p class="text-sm text-red-600">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description <span
                        class="text-gray-400">(Optional)</span></label>
                <textarea id="description" rows="6" name="description"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-teal-500 dark:focus:border-teal-500 resize-none"
                    placeholder="Description about the image...">{{old('description')}}</textarea>
                @error('description')
                    <p class="text-sm text-red-600">{{$message}}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Post Title
                        <span class="text-gray-400">(optional)</span></label>
                    <input type="text" id="title" name="title"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-teal-500 dark:focus:border-teal-500"
                        placeholder="Post title" value="{{old('title')}}" />
                    @error('title')
                        <p class="text-sm text-red-600">{{$message}}</p>
                    @enderror
                </div>

                <div>
                    <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category
                        <span class="text-gray-400">(optional)</span></label>
                    <select id="category" name="category"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-teal-500 dark:focus:border-teal-500">
                        <option value="">Choose a category</option>
                        @foreach ($categories as $category)
                        <option value="{{$category->id}}" {{old('category') === $category->id ? 'selected' : ''}}>{{$category->title}}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-sm text-red-600">{{$message}}</p>
                    @enderror
                </div>

                <div class="flex flex-wrap items-center">

                    <p class="block text-sm font-medium text-gray-900 dark:text-white me-4">Post Visibility</p>

                    <div class="flex items-center me-4">
                        <input id="public-radio" type="radio" {{old('visibility') === 'public' || old('visibility') === null ? 'checked' : ''}} value="public" name="visibility"
                            class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 focus:ring-teal-500 dark:focus:ring-teal-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="public-radio"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Public</label>
                    </div>
                    <div class="flex items-center me-4">
                        <input id="unlisted-radio" type="radio" value="unlisted" name="visibility" {{old('visibility') === 'unlisted' ? 'checked' : ''}}
                            class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 focus:ring-teal-500 dark:focus:ring-teal-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="unlisted-radio"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Unlisted</label>
                    </div>

                </div>

                <div class="flex items-center">
                    <input id="nsfw-checkbox" type="checkbox" value="1" name="nsfw" {{old('nsfw') ? 'checked' : ''}}
                        class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500 dark:focus:ring-teal-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="nsfw-checkbox"
                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">NSFW</label>
                </div>

            </div>

            <div class="mb-6">
                <p>By posting an image, you agree to the <a href="{{route('terms')}}" class="text-blue-600">Terms of Use</a> and <a href="{{route('policy')}}" class="text-blue-600">Privacy Policy</a>.</p>
            </div>

            <div class="flex items-center p-4 mb-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    Posts and images are valid for 7 days only. After this period, they will be automatically removed from the server.
                </div>
            </div>

            <div>
                <button
                    type="submit"
                    class="py-2 px-3 text-white bg-teal-600 shadow-md hover:shadow-none hover:bg-teal-600 uppercase rounded">Create
                    New Post</button>
            </div>
        </form>

        {{view('partials.recent', ['recent' => $recent, 'access' => $access])}}
    </div>
@endsection
