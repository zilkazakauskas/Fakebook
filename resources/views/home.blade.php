@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <a href="/addPostForm"><button class="btn btn-primary">Add post</button></a>
        </div>
        {{-- {{ dd($posts) }} --}}
        <div class="row d-flex justify-content-center mb-5">
            <form class="d-inline-block" action="{{ route('search') }}" method="get">
                {{-- @csrf --}}
                <div class="input-group mb-2">
                    <input id="keyword" type="text" class="form-control @error('keyword') is-invalid @enderror"
                        name="keyword" value="{{ old('keyword') }}" required autocomplete="keyword"
                        placeholder="Search keyword here...">
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-search" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                @if ($errors->has('keyword'))
                    <span class="invalid-feedback mb-3" style="display: block;" role="alert">
                        <strong>{{ $errors->first('keyword') }}</strong>
                    </span>
                @endif
                <div class="input-group mb-2">
                    <select name="searchBy" class="custom-select @error('searchBy') is-invalid @enderror" id="searchBy">
                        <option selected value="">Choose search criteria...</option>
                        <option value="1">Search by author name</option>
                        <option value="2">Search by content fragment</option>
                    </select>
                </div>
                @if ($errors->has('searchBy'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $errors->first('searchBy') }}</strong>
                    </span>
                @endif
            </form>
        </div>

        @isset($posts)
            @foreach ($posts as $post)
                <div class="row mt-2 mb-5 d-flex align-items-center justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="d-flex justify-content-between p-2 px-3">
                                <div class="d-flex flex-row align-items-center"> <img
                                        src="{{ asset('/storage/images/users/' . $post['user']->avatar) }}" alt="avatar"
                                        width="50" class="rounded-circle">
                                    <div class="d-flex flex-column ml-2"> <span
                                            class="font-weight-bold">{{ $post->user->name }}</span></div>
                                </div>
                                <div class="d-flex flex-row mt-1 ellipsis"> <small
                                        class="mr-2">{{ $post->created_at }}</small> <i class="fa fa-ellipsis-h"></i>
                                </div>
                            </div>
                            <div class="p-2">

                                @if ($post->image !== null)
                                    <p>
                                        <img src="{{ asset('/storage/images/posts/' . $post->image) }}" alt="img"
                                            style="max-width: 75%">
                                    </p>
                                @endif

                                <p class="text-justify">{{ $post->content }}</p>
                                <hr>
                                <div class="d-flex flex-row-reverse icons d-flex align-items-center">
                                    {{ $post->commentsCount() }}
                                    <a class="btn btn-link" href={{ route('postComments', $post->id) }}>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-chat-dots" viewBox="0 0 16 16">
                                            <path
                                                d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                            <path
                                                d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z" />
                                        </svg>
                                    </a>
                                    {{ $post->likesCount() }}
                                    <form class="d-inline-block"
                                        action={{ route('like', ['user' => Auth::id(), 'post' => $post->id]) }}
                                        method="post">
                                        @csrf
                                        <button class="btn btn-link" type="submit"> <svg xmlns="http://www.w3.org/2000/svg"
                                                width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2.144 2.144 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a9.84 9.84 0 0 0-.443.05 9.365 9.365 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111L8.864.046zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a8.908 8.908 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.224 2.224 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.866.866 0 0 1-.121.416c-.165.288-.503.56-1.066.56z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                <div class="row">
                                    <div class="col d-flex inline-block">
                                        <form action={{ route('deletePost', $post->id) }} method="post">
                                            @csrf
                                            <button class="btn btn-danger" type="submit">Delete</button>
                                        </form>
                                        <a href={{ route('editPost', $post->id) }}><button class="btn btn-primary ml-2"
                                                type="submit">Edit</button></a>
                                        <a href={{ route('addCommentForm', $post->id) }}><button class="btn btn-warning ml-2"
                                                type="submit">Add
                                                comment</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        @endforeach
    @endisset
    @if ($posts->count() === 0)
        <h3 class="text-center">There are no posts yet.</h3>
    @endif
@endsection
