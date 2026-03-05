@if($products->hasPages())
    <nav class="admin-pagination">
        {{ $products->links() }}
    </nav>
@else
    <div class="text-muted text-center" style="font-size: 0.8rem;">
        Showing {{ $products->total() }} {{ Str::plural('product', $products->total()) }}
    </div>
@endif
