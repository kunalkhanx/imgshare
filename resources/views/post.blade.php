@extends('app')
@if($post->nsfw && (!$access || !$access->nsfw))
    @section('title', ' Content Warning: NSFW (Not Safe For Work | ImgShare')
@else
    @section('title', ($post->title ? $post->title : 'Untitled') . ' | ImgShare')
@endif

@section('main')

    @if($post->nsfw && (!$access || !$access->nsfw))
    <div class="w-screen h-screen flex items-center justify-center bg-white fixed top-0 left-0 z-[999]">
        <div class="w-full max-w-2xl p-4">
            <h3 class="font-bold text-2xl mb-4">Content Warning: NSFW (Not Safe For Work)</h3>
            <p class="mb-4">The content you are about to view is marked as NSFW and may contain material not suitable for individuals under 18 years of age.</p>
            <p>By clicking "Accept," you confirm that:</p>
            <ul class="list-disc pl-5 mb-4">
                <li>You are 18 years or older.</li>
                <li>You understand the nature of the content and wish to proceed.</li>
            </ul>
            <p>If you do not meet these requirements or do not wish to view this content, please click "Cancel."</p>
            <div class="flex items-center justify-center gap-12">
                <form action="{{route('allow_nsfw')}}" method="POST">
                    @csrf
                    <button
                    type="submit"
                    class="py-2 px-3 text-white bg-teal-600 shadow-md hover:shadow-none hover:bg-teal-600 uppercase rounded">Acecpt</button>
                </form>
                <a href="{{route('home')}}">Cancel</a>
            </div>
        </div>
    </div>
    @endif

    <div class="grid lg:grid-cols-4 gap-4 my-8 section px-4">

        <div class="lg:col-span-3">
            <div class="bg-white rounded shadow-md p-4 mb-6">
                <h1 class="text-2xl font-bold mb-4">{{ $post->title ? $post->title : 'Untitled' }}</h1>
                <div class="flex items-center gap-2 text-gray-500 flex-wrap">
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-1">
                            <svg class="size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2"
                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <span>{{\App\Helpers\AppHelper::formatReadableNumber($post->views)}}</span>
                        </div>
                    </div>
                    <span>|</span>
                    <div class="flex items-center gap-1">
                        <svg class="size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    @if ($post->category)
                        <span>|</span>
                        <div class="flex items-center gap-1">
                            <svg class="size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.583 8.445h.01M10.86 19.71l-6.573-6.63a.993.993 0 0 1 0-1.4l7.329-7.394A.98.98 0 0 1 12.31 4l5.734.007A1.968 1.968 0 0 1 20 5.983v5.5a.992.992 0 0 1-.316.727l-7.44 7.5a.974.974 0 0 1-1.384.001Z" />
                            </svg>
                            <a href="{{route('categories', ['slug' => $post->category->slug])}}" class="hover:text-teal-600">{{ $post->category->title }}</a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded shadow-md p-4 mb-6 w-full">
                <img src="{{ route('image', ['image' => $post->images[0]->id]) }}" loading="lazy"
                    class="w-full object-contain {{$post->nsfw && (!$access || !$access->nsfw) ? 'blur-2xl' : ''}}" alt="{{$post->title}}">
            </div>

            @if ($post->description)
                {{-- <div class="bg-white rounded shadow-md mb-6 w-full overflow-hidden">
                    <div class="bg-teal-600 text-white p-4 text-xl">
                        <h2>Description</h2>
                    </div>
                    <div class="p-4 w-full" id="text-container">
                        <p class="overflow-hidden">{!! nl2br(e($post->description)) !!}</p>
                    </div>
                </div> --}}

                <div class="bg-white rounded shadow-md mb-6 w-full overflow-hidden">
                    <div class="bg-teal-600 text-white p-4 text-xl">
                        <h2>Description</h2>
                    </div>
                    <div class="p-4 w-full overflow-x-auto" id="text-container">
                        <p class="break-all">{!! nl2br(e($post->description)) !!}</p>
                    </div>
                </div>

                <script>
                    function makeUrlsClickable(element) {
                        if (!element || !element.innerHTML) return;

                        const urlRegex = /\bhttps?:\/\/[^\s<>"']+/g;

                        element.innerHTML = element.innerHTML.replace(urlRegex, (url) => {
                            return `<a href="${url}" class="text-blue-600" target="_blank" rel="noopener noreferrer">${url}</a>`;
                        });
                    }

                    const element = document.getElementById('text-container'); // Replace 'text-container' with your element ID
                    makeUrlsClickable(element);
                </script>
            @endif

            @if(request()->user() && request()->user()->role === 'admin' && isset($post->reports[0]))
                <div class="bg-white rounded shadow-md mb-6 overflow-hidden">
                    <div class="bg-teal-600 text-white p-4 text-xl flex-shrink-0">
                        <h2>Reports</h2>
                    </div>
                    <div class="p-4 w-full overflow-x-auto flex flex-col gap-4">
                        @foreach ($post->reports as $report)
                            <div class="rounded bg-red-100 border border-red-500 p-3">
                                <h3 class="font-bold text-red-600 mb-2">{{$report->type}}</h3>
                                <div class="flex gap-2 items-center text-sm mb-2">
                                    <svg class="size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m3.5 5.5 7.893 6.036a1 1 0 0 0 1.214 0L20.5 5.5M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z"/>
                                    </svg>
                                    <span>{{$report->email}}</span>
                                </div>
                                @if($report->message)
                                <p>{{$report->message}}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>


        <div>
            <button id="report-modal-trigger"
                class="rounded bg-amber-600 hover:bg-amber-800 shadow-md text-white flex items-center gap-2 w-full py-1.5 justify-center mb-6">
                <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>Report image</span>
            </button>
            @if(request()->user() && request()->user()->role == 'admin')
            <form action="{{route('admin.delete_post', ['post' => $post->id])}}" method="POST" class="confirm" data-prompt="Are you sure to delete the post?">
                @csrf
                @method('DELETE')
                <button type="submit"
                class="rounded bg-rose-600 hover:bg-rose-800 shadow-md text-white flex items-center gap-2 w-full py-1.5 justify-center mb-6">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                    </svg>                  
                    <span>Delete</span>
                </button>
            </form>
            @endif
            {{ view('partials.recent', ['recent' => $recent, 'access' => $access]) }}
        </div>

    </div>


    <div class="w-screen h-screen fixed left-0 top-0 items-center justify-center z-[500] flex @if(!session()->has('report-error')) notactive @endif [&.notactive]:hidden"
        id="report-modal">
        <div class="w-screen h-screen bg-black/50 fixed left-0 top-0 z-[501] report-modal-close"></div>
        <div class="w-full max-w-xl bg-white relative z-[502] rounded overflow-hidden shadow-md">
            <div class="bg-teal-600 text-white p-2 text-xl flex-shrink-0 flex items-center justify-between">
                <h2>Report image/post</h2>
                <button type="button" class="p-2 report-modal-close">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg>
                </button>
            </div>
            <div class="p-4">
                <form action="{{route('report_post')}}" method="POST">
                    @csrf
                    <input type="hidden" name="post" value="{{ $post->id }}">
                    <p class="mb-4">Reason for reporting this image:</p>
                    @error('type')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <div class="flex items-center mb-4">
                        <input id="report-radio-1" type="radio" value="pornography" name="type"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="report-radio-1"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Pornography </label>
                    </div>
                    <div class="flex items-center mb-4">
                        <input checked id="report-radio-2" type="radio" value="child-abuse" name="type"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="report-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Child
                            Abuse</label>
                    </div>
                    <div class="flex items-center mb-4">
                        <input checked id="report-radio-3" type="radio" value="spam" name="type"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="report-radio-3" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Spam
                            or Misleading conetnt</label>
                    </div>
                    <div class="flex items-center mb-4">
                        <input checked id="report-radio-4" type="radio" value="abusive" name="type"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="report-radio-4"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Abusive or Offensive</label>
                    </div>
                    <div class="flex items-center mb-4">
                        <input checked id="report-radio-5" type="radio" value="illegal" name="type"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="report-radio-5"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Illegal or Restricted
                            content</label>
                    </div>
                    <div class="flex items-center mb-4">
                        <input checked id="report-radio-6" type="radio" value="other" name="type"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="report-radio-6"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Others <span
                                class="text-gray-500">(please type your reson)</span></label>
                    </div>
                    <div class="mb-4">
                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Explain
                            <span class="text-gray-500">(optional)</span></label>
                        <input type="text" id="message"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Write your opinion" name="message" value="{{ old('message') }}" />
                        @error('message')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <hr class="mb-4">
                    <div class="mb-4">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                            email</label>
                        <input type="email" id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Write your opinion" name="email" value="{{ old('email') }}" />
                        @error('email')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <button type="submit"
                            class="py-2 px-3 text-white bg-teal-600 shadow-md hover:shadow-none hover:bg-teal-600 uppercase rounded">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const modal = document.getElementById("report-modal");
            const trigger = document.getElementById("report-modal-trigger");
            const closeButtons = document.querySelectorAll(".report-modal-close");

            trigger.addEventListener("click", () => {
                modal.classList.remove("notactive");
            });

            closeButtons.forEach((button) => {
                button.addEventListener("click", () => {
                    modal.classList.add("notactive");
                });
            });
        });
    </script>
@endsection
