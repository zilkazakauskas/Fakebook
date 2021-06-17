@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col d-flex justify-content-center">
                <h3>Add Comment</h3>
            </div>
            {{-- {{ dd($post) }} --}}
        </div>
        <div class="row">
            <div class="col d-flex justify-content-center">
                <form method="POST" action={{ route('commentStore', $post) }} enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="content" class="col-md-4 col-form-label text-md-right"></label>
                        <div class="col-md-12">
                            <textarea type="input" required style="resize: none;" name="content" id="content" cols="42"
                                rows="10" class="form-control @error('content') is-invalid @enderror"></textarea>
                        </div>
                    </div>

                    <div class="form-group-reverse row mb-0">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Comment') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
