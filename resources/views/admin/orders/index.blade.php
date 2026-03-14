@extends('layouts.admin')

@section('title', 'Manage Orders')
@section('page-title', 'Manage Orders')

@section('content')
<style>
    .order-expand-btn {
        background: none;
        border: none;
        color: var(--admin-primary);
        cursor: pointer;
        font-size: 1rem;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        transition: background 0.2s;
    }

    .order-expand-btn:hover {
        background: rgba(57, 106, 255, 0.08);
    }

    .order-expand-btn i {
        transition: transform 0.2s;
    }

    .order-expand-btn.expanded i {
        transform: rotate(180deg);
    }

    .order-items-row {
        display: none;
    }

    .order-items-row.show {
        display: table-row;
    }

    .order-items-row td {
        padding: 0 !important;
    }

    .order-items-inner {
        padding: 0.75rem 1.25rem;
        background: var(--admin-bg);
        border-radius: 8px;
        margin: 0.5rem 1rem;
    }

    .order-items-table {
        width: 100%;
        font-size: 0.8rem;
    }

    .order-items-table th {
        font-weight: 600;
        color: var(--admin-muted);
        padding: 0.35rem 0.5rem;
        border-bottom: 1px solid var(--admin-border);
    }

    .order-items-table td {
        padding: 0.35rem 0.5rem;
        color: var(--admin-text);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-pending {
        background: rgba(255, 193, 7, 0.12);
        color: #d4a006;
    }

    .status-completed {
        background: rgba(40, 167, 69, 0.12);
        color: #28a745;
    }

    .order-number {
        font-weight: 700;
        font-family: 'SFMono-Regular', Consolas, monospace;
        font-size: 0.85rem;
        color: var(--admin-primary);
    }

    .empty-orders {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--admin-muted);
    }

    .empty-orders i {
        font-size: 3rem;
        margin-bottom: 1rem;
        display: block;
        opacity: 0.4;
    }
</style>

<div class="admin-card">
    @if($orders->total() > 0)
    <div class="table-responsive">
        <table class="table admin-table mb-0">
            <thead>
                <tr>
                    <th style="width: 40px;"></th>
                    <th>Order Number</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>
                        <button class="order-expand-btn" onclick="toggleOrderItems(this, 'orderItems{{ $order->id }}')">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </td>
                    <td><span class="order-number">{{ $order->order_number }}</span></td>
                    <td>{{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}</td>
                    <td><strong>₱{{ number_format($order->total_amount, 2) }}</strong></td>
                    <td>
                        <span class="status-badge status-{{ $order->status }}">
                            <i class="bi bi-{{ $order->status === 'completed' ? 'check-circle-fill' : 'clock-fill' }}"></i>
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                </tr>
                <tr class="order-items-row" id="orderItems{{ $order->id }}">
                    <td colspan="6">
                        <div class="order-items-inner">
                            <table class="order-items-table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th style="text-align: center;">Qty</th>
                                        <th style="text-align: right;">Unit Price</th>
                                        <th style="text-align: right;">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->product_name }}</td>
                                        <td style="text-align: center;">{{ $item->quantity }}</td>
                                        <td style="text-align: right;">₱{{ number_format($item->unit_price, 2) }}</td>
                                        <td style="text-align: right;">₱{{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
    <div class="d-flex justify-content-center mt-3 mb-2">
        {{ $orders->links() }}
    </div>
    @endif
    @else
    <div class="empty-orders">
        <i class="bi bi-receipt"></i>
        <h5>No orders yet</h5>
        <p class="mb-0">Orders placed from the mobile menu will appear here.</p>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function toggleOrderItems(btn, rowId) {
        var row = document.getElementById(rowId);
        if (row.classList.contains('show')) {
            row.classList.remove('show');
            btn.classList.remove('expanded');
        } else {
            row.classList.add('show');
            btn.classList.add('expanded');
        }
    }
</script>
@endpush
