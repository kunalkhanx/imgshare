@extends('app')

@section('title', $listTitle . ' | ImgShare :: Upload & Share Images For Free')

@section('main')


    <div class="my-6 section px-4">
        <div class="bg-white shadow-md border rounded min-h-full flex flex-col overflow-hidden mb-6">
            <div class="bg-teal-600 text-white p-4 text-xl flex-shrink-0">
                <h1>{{$listTitle}}</h1>
            </div>
    
            <div class="divide-y flex-1">
                @foreach ($posts as $post)
                    <div class="flex w-full gap-2 py-3 px-4">
                        <img src="{{route('image', ['image' => $post->images[0]->id])}}"
                            class="object-cover w-16 h-16 object-center rounded flex-shrink-0 {{$post->nsfw && (!$access || !$access->nsfw) ? 'blur' : ''}} " alt="{{$post->title}}" loading="lazy" />
                        <div class="">
                            <a href="{{route('show', ['slug' => $post->slug])}}" class="hover:text-teal-600">
                                <h3 class="h-fit mb-1">{{$post->title ? $post->title : 'Untitled'}}</h3>
                            </a>
                            <div class="flex items-center gap-2 text-gray-500 text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center gap-1">
                                        <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        <span>{{\App\Helpers\AppHelper::formatReadableNumber($post->views)}}</span>
                                    </div>
                                </div>
                                <span>|</span>
                                <div class="flex items-center gap-1">
                                    <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <span>{{$post->created_at->diffForHumans()}}</span>
                                </div>
                                @if(request()->user() && request()->user()->role === 'admin' && isset($post->reports[0]))
                                <span>|</span>
                                <div class="flex items-center gap-1 text-red-600">
                                    <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <span>{{$post->reports[0]->type}}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    
        <div class="section flex items-center justify-between">
            <a @if($posts->previousPageUrl()) href="{{$posts->previousPageUrl()}}" @endif class="py-2 px-3 text-white bg-teal-600 shadow-md hover:shadow-none hover:bg-teal-700 uppercase rounded">Prev</a>
    
            <a @if($posts->nextPageUrl()) href="{{$posts->nextPageUrl()}}" @endif class="py-2 px-3 text-white bg-teal-600 shadow-md hover:shadow-none hover:bg-teal-700 uppercase rounded">Next</a>
        </div>
    </div>
@endsection
