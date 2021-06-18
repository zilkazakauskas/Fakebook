@extends('layouts.app')

@section('content')
    @isset($comments)
        <h2 class="text-center mb-5">Post {{ $post->id }} Comments</h2>
        <div class="container mt-5">

            @foreach ($comments as $comment)
                <div class="row mb-5 d-flex align-items-center justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="d-flex justify-content-between p-2 px-3">
                                <div class="d-flex flex-row align-items-center"> <img
                                        src="{{ asset('/storage/images/users/' . $post['user']->avatar) }}" alt="avatar"
                                        width="50" class="rounded-circle">
                                    <div class="d-flex flex-column ml-2"> <span
                                            class="font-weight-bold">{{ $comment->user->name }}</span>
                                    </div>
                                </div>
                                <div class="d-flex flex-row mt-1 ellipsis"> <small
                                        class="mr-2">{{ $comment->created_at }}</small> <i class="fa fa-ellipsis-h"></i>
                                </div>
                            </div>
                            <div class="p-2">
                                <p class="text-justify">{{ $comment->content }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endisset
    @if ($comments->count() === 0)
        <h3 class="text-center">There are no comments in this post yet.</h3>
    @endif

@endsection
