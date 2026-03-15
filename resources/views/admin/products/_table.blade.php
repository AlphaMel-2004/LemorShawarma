@forelse($products as $product)
    <tr>
        <td class="fw-semibold">{{ $product->id }}</td>
        <td>
            @if($product->image)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-thumb">
            @else
                <div class="product-thumb-placeholder">
                    <i class="bi bi-image"></i>
                </div>
            @endif
        </td>
        <td class="fw-semibold">{{ $product->name }}</td>
        <td>{{ $product->category }}</td>
        <td>
            <span class="text-description-preview d-inline-block" title="{{ $product->description }}">
                {{ $product->description ?? '—' }}
            </span>
        </td>
        <td class="fw-semibold">₱{{ number_format($product->price, 2) }}</td>
        <td>
            @if($product->is_active)
                <span class="badge-status badge-active">Active</span>
            @else
                <span class="badge-status badge-inactive">Inactive</span>
            @endif
        </td>
        <td class="text-muted" style="font-size: 0.85rem;">{{ $product->created_at->format('M d, Y') }}</td>
        <td>
            <div class="d-flex gap-1">
                <button class="btn-action" title="Edit" onclick="openEditModal({{ $product->id }})">
                    <i class="bi bi-pencil-square"></i>
                </button>
                <button class="btn-action btn-action-danger" title="Delete" onclick="openDeleteModal({{ $product->id }})">
                    <i class="bi bi-trash3"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="9" class="text-center py-5">
            <div style="color: var(--admin-text-muted);">
                <i class="bi bi-inbox" style="font-size: 2.5rem; display: block; margin-bottom: 0.75rem;"></i>
                <p class="mb-0">No products found.</p>
            </div>
        </td>
    </tr>
@endforelse
