@extends('admin.layouts.app')

@section('content')
   <div class="main-content-inner">
        <div class="main-content-wrap">

<h3>Edit Testimonial</h3>

<form method="POST"
      enctype="multipart/form-data"
      action="{{ route('admin.testimonials.update', $testimonial->id) }}">
    @csrf
    @method('PUT')

    <input type="text"
           name="name"
           class="form-control mb-2"
           value="{{ $testimonial->name }}"
           required>

    <textarea name="message"
              class="form-control mb-2"
              required>{{ $testimonial->message }}</textarea>

    <input type="file" name="image" class="form-control mb-2">

    @if($testimonial->image)
        <img src="{{ asset('storage/'.$testimonial->image) }}"
             height="80" class="mb-2">
    @endif

    <select name="rating" class="form-control mb-2">
        @for($i=5;$i>=1;$i--)
            <option value="{{ $i }}"
                {{ $testimonial->rating == $i ? 'selected' : '' }}>
                {{ $i }} Stars
            </option>
        @endfor
    </select>

    <select name="is_active" class="form-control mb-3">
        <option value="1" {{ $testimonial->is_active ? 'selected' : '' }}>Active</option>
        <option value="0" {{ !$testimonial->is_active ? 'selected' : '' }}>Inactive</option>
    </select>

    <button class="btn btn-success">Update</button>
</form>
        </div>
    </div>      
@endsection
