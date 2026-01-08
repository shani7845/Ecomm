
@extends('admin.layouts.app')

@section('content')

    <div class="main-content-inner">
        <div class="main-content-wrap">

<h3>About Section</h3>

<form method="POST" action="{{ route('admin.about.update') }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label>Small Title</label>
        <input type="text" name="small_title"
               value="{{ $about->small_title ?? '' }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Main Title</label>
        <input type="text" name="title"
               value="{{ $about->title ?? '' }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="4">{{ $about->description ?? '' }}</textarea>
    </div>

    <div class="mb-3">
        <label>Image</label>
        <input type="file" name="image" class="form-control">

        @if($about?->image)
            <img src="{{ asset('storage/'.$about->image) }}" height="100" class="mt-2">
        @endif
    </div>

    <button class="btn btn-primary">Save</button>
</form>

        </div>
    </div>  

@endsection
