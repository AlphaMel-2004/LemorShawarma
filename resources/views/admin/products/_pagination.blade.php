@if($products->hasPages())
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div class="text-muted" style="font-size: 0.85rem;">
            Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} products
        </div>
        <nav>
            {{ $products->links('pagination::bootstrap-5') }}
        </nav>
    </div>
@elseif($products->total() > 0)
    <div class="text-muted" style="font-size: 0.85rem;">
        Showing {{ $products->total() }} {{ Str::plural('product', $products->total()) }}
    </div>
@endif
