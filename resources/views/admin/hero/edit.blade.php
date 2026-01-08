@extends('admin.layouts.app')

@section('content')
   <div class="main-content-inner">
        <div class="main-content-wrap">
<h3>Home Hero Section</h3>

<form method="POST" action="{{ route('admin.hero.update') }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label>Sub Title</label>
        <input type="text" name="sub_title"
               value="{{ $hero->sub_title ?? '' }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title"
               value="{{ $hero->title ?? '' }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Hero Image</label>
        <input type="file" name="hero_image" class="form-control">

        @if($hero?->hero_image)
<img src="{{ asset('storage/'.$hero->hero_image) }}?v={{ time() }}" height="80">
        @endif
    </div>

    <button class="btn btn-primary">Save</button>
</form>

        </div>
    </div>  
@endsection
