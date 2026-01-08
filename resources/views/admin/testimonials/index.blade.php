@extends('admin.layouts.app')

@section('content')
   <div class="main-content-inner">
        <div class="main-content-wrap">
<h3>Testimonials</h3><br>

<a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary mb-3">
    <h5>Add Testimonial</h5>
</a>
<hr>
<table class="table">
    <tr>
        <th>Name</th>
        <th>Rating</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    @foreach($testimonials as $t)
    <tr>
        <td>{{ $t->name }}</td>
        <td>{{ $t->rating }} ⭐</td>
        <td>
            {{ $t->is_active ? 'Active' : 'Inactive' }}
        </td>
        <td class="d-flex gap-2">

            {{-- EDIT --}}
            <a href="{{ route('admin.testimonials.edit', $t->id) }}"
               class="btn btn-sm btn-warning">
                Edit
            </a>

            {{-- DELETE --}}
            <form method="POST"
                  action="{{ route('admin.testimonials.destroy', $t->id) }}"
                  onsubmit="return confirm('Delete this testimonial?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger">
                    Delete
                </button>
            </form>

        </td>
    </tr>
    @endforeach
</table>
        </div>
    </div>      

@endsection
