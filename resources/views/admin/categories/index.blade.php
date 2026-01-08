@extends('admin.layouts.app')

@section('content')
<div class="main-content-inner">
    <h3 class="mb-20">Categories</h3>

    <a href="{{ route('admin.categories.create') }}" class="tf-button mb-20">
        + Add Category
    </a>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if($category->image)
                    <img src="{{ asset('admin/images/categories/'.$category->image) }}" width="50">
                    @endif
                </td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="tf-button style-1">
                        Edit
                    </a>

                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                        style="display:inline-block" onsubmit="return confirm('Delete this category?')">
                        @csrf
                        @method('DELETE')
                        <button class="tf-button style-2">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $categories->links() }}
</div>
@endsection