@extends('admin.layouts.app')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">

        <div class="flex items-center justify-between mb-20">
            <h3>Edit Product</h3>
            <a href="{{ route('admin.products.index') }}" class="tf-button style-1">
                Back
            </a>
        </div>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data"
            class="tf-section-2">
            @csrf
            @method('PUT')

            <div class="wg-box">

                {{-- Name --}}
                <fieldset class="mb-20">
                    <div class="body-title mb-10">Product Name *</div>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
                </fieldset>

                {{-- Category --}}
                <fieldset class="mb-20">
                    <div class="body-title mb-10">Category *</div>
                    <select name="category_id" required>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </fieldset>

                {{-- Price --}}
                <fieldset class="mb-20">
                    <div class="body-title mb-10">Price *</div>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" required>
                </fieldset>

                {{-- Status --}}
                <fieldset class="mb-20">
                    <div class="body-title mb-10">Status *</div>
                    <select name="status">
                        <option value="1" {{ $product->status ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$product->status ? 'selected' : '' }}>Inactive</option>
                    </select>
                </fieldset>

                {{-- Description --}}
                <fieldset class="mb-20">
                    <div class="body-title mb-10">Description</div>
                    <textarea name="description">{{ old('description', $product->description) }}</textarea>
                </fieldset>

                {{-- Image --}}
                <fieldset class="mb-20">
                    <div class="body-title mb-10">Product Image</div>

                    @if($product->image)
                    <img src="{{ asset('admin/images/products/' . $product->image) }}" width="120" class="mb-10">
                    @endif

                    <input type="file" name="image">
                </fieldset>

                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Update Product</button>
                    <a href="{{ route('admin.products.index') }}" class="tf-button style-1 w-full">Cancel</a>
                </div>

            </div>
        </form>

    </div>
</div>
@endsection