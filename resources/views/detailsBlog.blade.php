@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Details Blog') }}</div>

                <div class="card-body">
                    <form method="POST" id="editBlogForm" action="{{ route('storeBlog') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="Title" class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>

                            <div class="col-md-6 form-group">
                                <input id="title" readonly type="text" class="form-control" name="title" value="{{ $blogData->title }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Image" class="col-md-4 col-form-label text-md-end">{{ __('image') }}</label>

                            <div class="col-md-6 form-group">
                                <img height="100px" width="120px" src="{{asset('/images/'.$blogData->image)}}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                            <div class="col-md-6 form-group">
                                <textarea readonly id="description" class="form-control" name="description" > {{ $blogData->description }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{route('list')}}" class="btn btn-secondary"> {{ __('Cancel') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
