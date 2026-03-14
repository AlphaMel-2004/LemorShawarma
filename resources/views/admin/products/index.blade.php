@extends('layouts.admin')

@section('title', 'Products')
@section('page-title', 'Products')

@section('content')
<div class="position-relative" id="productsContainer">
    <!-- Loading Overlay -->
    <div class="loading-overlay d-none" id="loadingOverlay">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div class="d-flex flex-wrap align-items-center gap-3">
            <div class="search-wrapper">
                <i class="bi bi-search"></i>
                <input type="text" class="admin-search" id="searchInput" placeholder="Search products..." value="{{ request('search') }}">
            </div>
            <select class="admin-form-select" id="statusFilter" style="width: auto; min-width: 140px;">
                <option value="">All Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <button class="btn-admin-primary" data-bs-toggle="modal" data-bs-target="#productModal" onclick="openCreateModal()">
            <i class="bi bi-plus-lg me-1"></i> Add Product
        </button>
    </div>

    <!-- Products Table -->
    <div class="admin-card">
        <div class="table-responsive">
            <table class="table admin-table">
                <thead>
                    <tr>
                        <th class="sortable-header" data-sort="id">
                            ID <i class="bi bi-chevron-expand sort-icon"></i>
                        </th>
                        <th>Image</th>
                        <th class="sortable-header" data-sort="name">
                            Name <i class="bi bi-chevron-expand sort-icon"></i>
                        </th>
                        <th>Description</th>
                        <th class="sortable-header" data-sort="price">
                            Price <i class="bi bi-chevron-expand sort-icon"></i>
                        </th>
                        <th class="sortable-header" data-sort="is_active">
                            Status <i class="bi bi-chevron-expand sort-icon"></i>
                        </th>
                        <th class="sortable-header" data-sort="created_at">
                            Created <i class="bi bi-chevron-expand sort-icon"></i>
                        </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="productsTableBody">
                    @include('admin.products._table', ['products' => $products])
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div id="paginationContainer" class="mt-3">
        @include('admin.products._pagination', ['products' => $products])
    </div>
</div>

<!-- Create/Edit Product Modal -->
<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="productForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="productId" name="product_id">

                    <div class="mb-3">
                        <label class="admin-form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="admin-form-control form-control" id="productName" name="name" required placeholder="Enter product name">
                        <div class="invalid-feedback" id="nameError"></div>
                    </div>

                    <div class="mb-3">
                        <label class="admin-form-label">Description</label>
                        <textarea class="admin-form-control form-control" id="productDescription" name="description" rows="3" placeholder="Enter product description"></textarea>
                        <div class="invalid-feedback" id="descriptionError"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="admin-form-label">Price <span class="text-danger">*</span></label>
                            <input type="number" class="admin-form-control form-control" id="productPrice" name="price" step="0.01" min="0" required placeholder="0.00">
                            <div class="invalid-feedback" id="priceError"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="admin-form-label">Status <span class="text-danger">*</span></label>
                            <select class="admin-form-select form-select" id="productStatus" name="is_active">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <div class="invalid-feedback" id="is_activeError"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="admin-form-label">Product Image</label>
                        <input type="file" class="admin-form-control form-control" id="productImage" name="image" accept="image/*">
                        <div class="invalid-feedback" id="imageError"></div>
                        <div class="image-preview-wrapper mt-2" id="imagePreview">
                            <i class="bi bi-image placeholder-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-admin-primary" id="submitBtn">
                        <span id="submitText">Save Product</span>
                        <span class="spinner-border spinner-border-sm d-none" id="submitSpinner"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="confirm-icon">
                    <i class="bi bi-trash3"></i>
                </div>
                <h5 class="mb-2">Delete Product?</h5>
                <p class="text-muted mb-0" style="font-size: 0.9rem;">This action can be undone later.</p>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn" onclick="confirmDelete()">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentSort = '{{ request('sort', 'created_at') }}';
    let currentDirection = '{{ request('direction', 'desc') }}';
    let searchTimeout = null;
    let deleteProductId = null;

    // Search with debounce
    document.getElementById('searchInput').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => fetchProducts(), 400);
    });

    // Status filter
    document.getElementById('statusFilter').addEventListener('change', () => fetchProducts());

    // Sortable headers
    document.querySelectorAll('.sortable-header').forEach(header => {
        header.addEventListener('click', function() {
            const sort = this.dataset.sort;
            if (currentSort === sort) {
                currentDirection = currentDirection === 'asc' ? 'desc' : 'asc';
            } else {
                currentSort = sort;
                currentDirection = 'asc';
            }
            fetchProducts();
        });
    });

    function fetchProducts(page = 1) {
        const search = document.getElementById('searchInput').value;
        const status = document.getElementById('statusFilter').value;

        const params = new URLSearchParams({
            search, status,
            sort: currentSort,
            direction: currentDirection,
            page
        });

        document.getElementById('loadingOverlay').classList.remove('d-none');

        fetch(`{{ route('admin.products.index') }}?${params}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('productsTableBody').innerHTML = data.html;
            document.getElementById('paginationContainer').innerHTML = data.pagination;
            document.getElementById('loadingOverlay').classList.add('d-none');
            bindPaginationLinks();
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('loadingOverlay').classList.add('d-none');
            showToast('Failed to load products.', 'danger');
        });
    }

    function bindPaginationLinks() {
        document.querySelectorAll('#paginationContainer .page-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = new URL(this.href);
                const page = url.searchParams.get('page') || 1;
                fetchProducts(page);
            });
        });
    }

    // Initial bind
    bindPaginationLinks();

    // ── Modal Handling ──
    function openCreateModal() {
        document.getElementById('modalTitle').textContent = 'Add Product';
        document.getElementById('submitText').textContent = 'Save Product';
        document.getElementById('productForm').reset();
        document.getElementById('productId').value = '';
        resetImagePreview();
        clearErrors();
    }

    function openEditModal(id) {
        document.getElementById('modalTitle').textContent = 'Edit Product';
        document.getElementById('submitText').textContent = 'Update Product';
        clearErrors();

        fetch(`{{ route('admin.products.index') }}/${id}/edit`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('productId').value = data.product.id;
            document.getElementById('productName').value = data.product.name;
            document.getElementById('productDescription').value = data.product.description || '';
            document.getElementById('productPrice').value = data.product.price;
            document.getElementById('productStatus').value = data.product.is_active ? '1' : '0';

            if (data.image_url) {
                document.getElementById('imagePreview').innerHTML = `<img src="${data.image_url}" alt="Preview">`;
            } else {
                resetImagePreview();
            }

            new bootstrap.Modal(document.getElementById('productModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Failed to load product data.', 'danger');
        });
    }

    // Image preview
    document.getElementById('productImage').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('imagePreview').innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            };
            reader.readAsDataURL(file);
        }
    });

    function resetImagePreview() {
        document.getElementById('imagePreview').innerHTML = '<i class="bi bi-image placeholder-icon"></i>';
    }

    // Form submit
    document.getElementById('productForm').addEventListener('submit', function(e) {
        e.preventDefault();
        clearErrors();

        const id = document.getElementById('productId').value;
        const formData = new FormData(this);
        const isEdit = !!id;

        let url = '{{ route('admin.products.store') }}';
        if (isEdit) {
            url = `{{ route('admin.products.index') }}/${id}`;
            formData.append('_method', 'PUT');
        }

        document.getElementById('submitText').classList.add('d-none');
        document.getElementById('submitSpinner').classList.remove('d-none');
        document.getElementById('submitBtn').disabled = true;

        fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        })
        .then(response => response.json().then(data => ({ ok: response.ok, data })))
        .then(({ ok, data }) => {
            document.getElementById('submitText').classList.remove('d-none');
            document.getElementById('submitSpinner').classList.add('d-none');
            document.getElementById('submitBtn').disabled = false;

            if (!ok) {
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        const input = document.getElementById(`product${field.charAt(0).toUpperCase() + field.slice(1)}`);
                        const error = document.getElementById(`${field}Error`);
                        if (input) input.classList.add('is-invalid');
                        if (error) {
                            error.textContent = data.errors[field][0];
                            error.style.display = 'block';
                        }
                    });
                }
                return;
            }

            bootstrap.Modal.getInstance(document.getElementById('productModal'))?.hide();
            showToast(data.message);
            fetchProducts();
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('submitText').classList.remove('d-none');
            document.getElementById('submitSpinner').classList.add('d-none');
            document.getElementById('submitBtn').disabled = false;
            showToast('An error occurred. Please try again.', 'danger');
        });
    });

    function clearErrors() {
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => {
            el.textContent = '';
            el.style.display = 'none';
        });
    }

    // ── Delete ──
    function openDeleteModal(id) {
        deleteProductId = id;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }

    function confirmDelete() {
        if (!deleteProductId) return;

        fetch(`{{ route('admin.products.index') }}/${deleteProductId}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            bootstrap.Modal.getInstance(document.getElementById('deleteModal'))?.hide();
            showToast(data.message);
            fetchProducts();
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Failed to delete product.', 'danger');
        });
    }
</script>
@endpush
