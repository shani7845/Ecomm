@extends('admin.layouts.app')

@section('content')
<style>
.switch {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 22px;
}

.switch input {
    display: none;
}

.slider {
    position: absolute;
    cursor: pointer;
    background-color: #ccc;
    border-radius: 22px;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    border-radius: 50%;
    transition: .4s;
}

input:checked+.slider {
    background-color: #28a745;
}

input:checked+.slider:before {
    transform: translateX(18px);
}
</style>

<div class="main-content-inner">
    <div class="main-content-wrap">

        <div class="flex items-center justify-between mb-20">
            <h3>Products</h3>
            <a href="{{ route('admin.products.create') }}" class="tf-button">
                + Add Product
            </a>
        </div>

        <div class="wg-box">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            @if($product->image)
                            <img src="{{ asset('admin/images/products/' . $product->image) }}" width="60" height="60"
                                style="object-fit:cover;border-radius:6px;">
                            @else
                            <span>No Image</span>
                            @endif
                        </td>

                        <td>{{ $product->name }}</td>

                        <td>
                            {{ $product->category?->name ?? 'N/A' }}
                        </td>

                        <td>₹ {{ $product->price }}</td>

                        <td>
                            <label class="switch">
                                <input type="checkbox" class="toggle-status" data-id="{{ $product->id }}"
                                    {{ $product->status ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </td>

                        <td>
                            <a href="{{ route('admin.products.edit', $product) }}"
                                class="btn btn-sm btn-primary">Edit</a>

                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                style="display:inline-block" onsubmit="return confirm('Delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No products found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-20">
                {{ $products->links() }}
            </div>
        </div>

    </div>
</div>

<script>
document.querySelectorAll('.toggle-status').forEach(toggle => {
    toggle.addEventListener('change', function() {
        let productId = this.dataset.id;
        let status = this.checked ? 1 : 0;

        fetch(`/admin/products/${productId}/status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                status: status
            })
        });
    });
});
</script>

@endsection