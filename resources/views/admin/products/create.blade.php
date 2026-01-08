@extends('admin.layouts.app')
@section('content')
<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3 class="mb-20">Add Product</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="index.html">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="#">
                        <div class="text-tiny">Ecommerce</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Add product</div>
                </li>
            </ul>
        </div>
        <!-- form-add-product -->
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
            class="tf-section-2 form-add-product">
            @csrf
            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Product name *<span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enter product name" name="name" tabindex="0"
                        value="{{old('name')}}" aria-required="true" required>
                    <div class="text-tiny">Do not exceed 20 characters when entering the product name.</div>
                </fieldset>
                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select class="" name="category_id" required>
                                <option>Choose category</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">
                                    {{$category->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="male">
                        <div class="body-title mb-10">Price <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="number" placeholder="Enter price" name="price"
                            value="{{old('price')}}" aria-required="true" required>
                    </fieldset>
                </div>

                <fieldset class="mb-20">
                    <div class="body-title mb-10">Status *</div>
                    <select name="status" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </fieldset>

                <!-- <fieldset class="brand">
                    <div class="body-title mb-10">Brand <span class="tf-color-1">*</span></div>
                    <div class="select">
                        <select class="">
                            <option>Choose category</option>
                            <option>Shop</option>
                            <option>Product</option>
                        </select>
                    </div>
                </fieldset> -->
                <fieldset class="description">
                    <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10" name="description" placeholder="Product Description" tabindex="0"
                        aria-required="true">{{old('description')}}</textarea>
                </fieldset>

                <fieldset class="mb-20">
                    <div class="body-title mb-10">Product Image</div>
                    <input type="file" name="image">
                </fieldset>


                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Add product</button>
                    <a href="{{route('admin.products.index')}}" class="tf-button style-1 w-full">Cancel</a>
                </div>

            </div>

        </form>
        <!-- /form-add-product -->
    </div>
    <!-- /main-content-wrap -->
</div>

@endsection