@extends('admin.layouts.app')

@section('content')
   <div class="main-content-inner">
        <div class="main-content-wrap">

<h3>Add Testimonial</h3>

<form method="POST" enctype="multipart/form-data"
      action="{{ route('admin.testimonials.store') }}">
    @csrf

    <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>

    <textarea name="message" class="form-control mb-2" placeholder="Message" required></textarea>

    <input type="file" name="image" class="form-control mb-2">

    <select name="rating" class="form-control mb-2">
        @for($i=5;$i>=1;$i--)
            <option value="{{ $i }}">{{ $i }} Stars</option>
        @endfor
    </select>

    <button class="btn btn-success">Save</button>
</form>
        </div>
    </div>  
@endsection
