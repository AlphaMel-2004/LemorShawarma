@forelse($products as $product)
    <tr>
        <td class="text-muted">{{ $product->id }}</td>
        <td>
            @if($product->image)
                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="product-thumb">
            @else
                <div class="product-thumb-placeholder">
                    <i class="bi bi-image"></i>
                </div>
            @endif
        </td>
        <td class="fw-semibold">{{ $product->name }}</td>
        <td>
            <span class="text-description-preview d-inline-block" title="{{ $product->description }}">
                {{ Str::limit($product->description, 50) }}
            </span>
        </td>
        <td>${{ number_format($product->price, 2) }}</td>
        <td>
            <span class="badge-status {{ $product->is_active ? 'badge-active' : 'badge-inactive' }}">
                {{ $product->is_active ? 'Active' : 'Inactive' }}
            </span>
        </td>
        <td class="text-end">
            <button class="btn-action" onclick="openEditModal({{ $product->id }})" title="Edit">
                <i class="bi bi-pencil"></i>
            </button>
            <button class="btn-action btn-action-danger ms-1" onclick="openDeleteModal({{ $product->id }})" title="Delete">
                <i class="bi bi-trash3"></i>
            </button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center py-5">
            <div class="text-muted">
                <i class="bi bi-box-seam" style="font-size: 2rem;"></i>
                <p class="mt-2 mb-0">No products found.</p>
            </div>
        </td>
    </tr>
@endforelse
