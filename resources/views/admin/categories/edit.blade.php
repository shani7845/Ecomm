   @extends('admin.layouts.app')
   @section('content')
   <div class="main-content-inner">
       <!-- main-content-wrap -->
       <div class="main-content-wrap">
           <div class="flex items-center flex-wrap justify-between gap20 mb-27">
               <h3>Category infomation</h3>
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
                           <div class="text-tiny">Category</div>
                       </a>
                   </li>
                   <li>
                       <i class="icon-chevron-right"></i>
                   </li>
                   <li>
                       <div class="text-tiny">New category</div>
                   </li>
               </ul>
           </div>
           <!-- new-category -->
           <div class="wg-box">
               <form class="form-new-product form-style-1"
                   action="{{ route('admin.categories.update', $category->id) }}" method="POST"
                   enctype="multipart/form-data">
                   @csrf
                   @method('PUT')

                   <fieldset class="name">
                       <div class="body-title">Product name <span class="tf-color-1">*</span></div>
                       <input class="flex-grow" type="text" placeholder="Category name" name="name" tabindex="0"
                           value="{{$category->name}}" aria-required="true" required>
                   </fieldset>


                   <fieldset class="category">
                       <div class="body-title">Parent Category (Optional)</div>
                       <div class="select flex-grow">
                           <select name="parent_id" class="form-control">
                               <option value="">None</option>
                               @foreach($parents as $parent)
                               <option value="{{ $parent->id }}"
                                   {{ $category->parent_id == $parent->id ? 'selected' : '' }}>
                                   {{ $parent->name }}
                               </option>
                               @endforeach
                           </select>
                       </div>
                   </fieldset>



                   <fieldset>
                       <div class="body-title">Upload images <span class="tf-color-1">*</span></div>
                       @if($category->image)
                       <img src="{{ asset('storage/'.$category->image) }}" width="80" class="mb-10">
                       @endif
                       <div class="upload-image flex-grow">
                           <div class="item up-load">
                               <label class="uploadfile" for="myFile">
                                   <span class="icon">
                                       <i class="icon-upload-cloud"></i>
                                   </span>
                                   <span class="body-text">Drop your images here or select <span class="tf-color">click
                                           to browse</span></span>
                                   <input type="file" id="myFile" name="image">
                               </label>
                           </div>
                       </div>
                   </fieldset>

                   <div class="bot">
                       <div></div>
                       <button class="tf-button w208" type="submit">Update Category</button>
                       <a href="{{ route('admin.categories.index') }}" class="tf-button style-1">Cancel</a>
                   </div>
               </form>
           </div>
           <!-- /new-category -->
       </div>
       <!-- /main-content-wrap -->
   </div>

   @endsection