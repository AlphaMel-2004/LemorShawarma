@extends('layouts.admin')

@section('title', 'Products')
@section('page-title', 'Products')

@section('content')
    <!-- Header Row -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div class="search-wrapper">
                <i class="bi bi-search"></i>
                <input type="text"
                       class="admin-search"
                       id="productSearch"
                       placeholder="Search products..."
                       value="{{ request('search') }}">
            </div>
            <select class="form-select admin-form-select" id="statusFilter" style="width: auto; font-size: 0.85rem; padding: 0.6rem 2rem 0.6rem 0.85rem;">
                <option value="">All Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <button class="btn btn-admin-primary" data-bs-toggle="modal" data-bs-target="#productModal" onclick="openCreateModal()">
            <i class="bi bi-plus-lg me-1"></i> Add Product
        </button>
    </div>

    <!-- Products Table Card -->
    <div class="admin-card position-relative">
        <div class="loading-overlay d-none" id="tableLoading">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table admin-table">
                <thead>
                    <tr>
                        <th class="sortable-header" data-sort="id">ID <i class="bi bi-chevron-expand sort-icon"></i></th>
                        <th>Image</th>
                        <th class="sortable-header" data-sort="name">Name <i class="bi bi-chevron-expand sort-icon"></i></th>
                        <th>Description</th>
                        <th class="sortable-header" data-sort="price">Price <i class="bi bi-chevron-expand sort-icon"></i></th>
                        <th class="sortable-header" data-sort="is_active">Status <i class="bi bi-chevron-expand sort-icon"></i></th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    @include('admin.products._table')
                </tbody>
            </table>
        </div>
        <div class="p-3" id="productPagination">
            @include('admin.products._pagination')
        </div>
    </div>

    {{-- Product Create / Edit Modal --}}
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="productForm" enctype="multipart/form-data" novalidate>
                    @csrf
                    <input type="hidden" id="productId" name="product_id">

                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">Add Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        {{-- Name --}}
                        <div class="mb-3">
                            <label for="productName" class="admin-form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control admin-form-control" id="productName" name="name" placeholder="e.g. Classic Chicken Shawarma" required>
                            <div class="invalid-feedback" id="error-name"></div>
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="productDescription" class="admin-form-label">Description</label>
                            <textarea class="form-control admin-form-control" id="productDescription" name="description" rows="3" placeholder="Short description of the product..."></textarea>
                            <div class="invalid-feedback" id="error-description"></div>
                        </div>

                        {{-- Price --}}
                        <div class="mb-3">
                            <label for="productPrice" class="admin-form-label">Price ($) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control admin-form-control" id="productPrice" name="price" step="0.01" min="0" placeholder="0.00" required>
                            <div class="invalid-feedback" id="error-price"></div>
                        </div>

                        {{-- Image --}}
                        <div class="mb-3">
                            <label for="productImage" class="admin-form-label">Product Image</label>
                            <input type="file" class="form-control admin-form-control" id="productImage" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                            <div class="invalid-feedback" id="error-image"></div>
                            <div class="image-preview-wrapper mt-2" id="imagePreviewWrapper">
                                <span class="placeholder-icon" id="imagePlaceholder"><i class="bi bi-image"></i></span>
                                <img src="" alt="Preview" id="imagePreview" class="d-none">
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="mb-3">
                            <label for="productStatus" class="admin-form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select admin-form-select" id="productStatus" name="is_active" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <div class="invalid-feedback" id="error-is_active"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-admin-primary" id="productSubmitBtn">
                            <span class="spinner-border spinner-border-sm d-none me-1" id="submitSpinner"></span>
                            <span id="submitBtnText">Save Product</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content text-center">
                <div class="modal-body py-4">
                    <div class="confirm-icon">
                        <i class="bi bi-trash3"></i>
                    </div>
                    <h5 class="mb-2">Delete Product?</h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">This action can be undone later. The product will be soft-deleted.</p>
                </div>
                <div class="modal-footer justify-content-center border-0 pt-0">
                    <button type="button" class="btn btn-sm btn-outline-secondary px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-danger px-3" id="confirmDeleteBtn" onclick="confirmDelete()">
                        <span class="spinner-border spinner-border-sm d-none me-1" id="deleteSpinner"></span>
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const productModal = new bootstrap.Modal(document.getElementById('productModal'));
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    let deleteProductId = null;
    let currentSort = 'created_at';
    let currentDirection = 'desc';

    /**
     * Open modal for creating a new product.
     */
    function openCreateModal() {
        document.getElementById('productForm').reset();
        document.getElementById('productId').value = '';
        document.getElementById('productModalLabel').textContent = 'Add Product';
        document.getElementById('submitBtnText').textContent = 'Save Product';
        resetImagePreview();
        clearValidationErrors();
    }

    /**
     * Open modal pre-filled with product data for editing.
     */
    function openEditModal(id) {
        clearValidationErrors();
        document.getElementById('productForm').reset();
        document.getElementById('productModalLabel').textContent = 'Edit Product';
        document.getElementById('submitBtnText').textContent = 'Update Product';

        fetch(`/admin/products/${id}/edit`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            const p = data.product;
            document.getElementById('productId').value = p.id;
            document.getElementById('productName').value = p.name;
            document.getElementById('productDescription').value = p.description || '';
            document.getElementById('productPrice').value = p.price;
            document.getElementById('productStatus').value = p.is_active ? '1' : '0';

            if (data.image_url) {
                document.getElementById('imagePreview').src = data.image_url;
                document.getElementById('imagePreview').classList.remove('d-none');
                document.getElementById('imagePlaceholder').classList.add('d-none');
            } else {
                resetImagePreview();
            }

            productModal.show();
        })
        .catch(() => showToast('Failed to load product data.', 'danger'));
    }

    /**
     * Submit create or update form via AJAX.
     */
    document.getElementById('productForm').addEventListener('submit', function(e) {
        e.preventDefault();
        clearValidationErrors();

        const id = document.getElementById('productId').value;
        const isEdit = id !== '';
        const url = isEdit ? `/admin/products/${id}` : '/admin/products';

        const formData = new FormData(this);
        if (isEdit) {
            formData.append('_method', 'PUT');
        }

        toggleSubmitLoading(true);

        fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: formData,
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                throw { status: response.status, data };
            }
            return data;
        })
        .then(data => {
            productModal.hide();
            showToast(data.message);
            refreshTable();
        })
        .catch(err => {
            if (err.status === 422 && err.data.errors) {
                showValidationErrors(err.data.errors);
            } else {
                showToast('Something went wrong. Please try again.', 'danger');
            }
        })
        .finally(() => toggleSubmitLoading(false));
    });

    /**
     * Open delete confirmation modal.
     */
    function openDeleteModal(id) {
        deleteProductId = id;
        deleteModal.show();
    }

    /**
     * Confirm and execute the deletion.
     */
    function confirmDelete() {
        if (!deleteProductId) return;

        document.getElementById('deleteSpinner').classList.remove('d-none');
        document.getElementById('confirmDeleteBtn').disabled = true;

        fetch(`/admin/products/${deleteProductId}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            deleteModal.hide();
            showToast(data.message);
            refreshTable();
        })
        .catch(() => showToast('Failed to delete product.', 'danger'))
        .finally(() => {
            document.getElementById('deleteSpinner').classList.add('d-none');
            document.getElementById('confirmDeleteBtn').disabled = false;
            deleteProductId = null;
        });
    }

    /**
     * Refresh the products table via AJAX with sorting and filtering.
     */
    function refreshTable(page = 1) {
        const search = document.getElementById('productSearch').value;
        const status = document.getElementById('statusFilter').value;
        const params = new URLSearchParams({
            search,
            status,
            sort: currentSort,
            direction: currentDirection,
            page,
        });

        document.getElementById('tableLoading').classList.remove('d-none');

        fetch(`/admin/products?${params}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('productTableBody').innerHTML = data.html;
            document.getElementById('productPagination').innerHTML = data.pagination;
        })
        .catch(() => showToast('Failed to refresh table.', 'danger'))
        .finally(() => document.getElementById('tableLoading').classList.add('d-none'));
    }

    /**
     * Search with debounce.
     */
    let searchTimer;
    document.getElementById('productSearch').addEventListener('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => refreshTable(), 400);
    });

    /**
     * Status filter change.
     */
    document.getElementById('statusFilter').addEventListener('change', function() {
        refreshTable();
    });

    /**
     * Column sorting.
     */
    document.querySelectorAll('.sortable-header').forEach(header => {
        header.style.cursor = 'pointer';
        header.addEventListener('click', function() {
            const field = this.dataset.sort;
            if (currentSort === field) {
                currentDirection = currentDirection === 'asc' ? 'desc' : 'asc';
            } else {
                currentSort = field;
                currentDirection = 'asc';
            }

            document.querySelectorAll('.sortable-header .sort-icon').forEach(icon => {
                icon.className = 'bi bi-chevron-expand sort-icon';
            });
            const activeIcon = this.querySelector('.sort-icon');
            activeIcon.className = currentDirection === 'asc'
                ? 'bi bi-chevron-up sort-icon'
                : 'bi bi-chevron-down sort-icon';

            refreshTable();
        });
    });

    /**
     * Handle pagination clicks.
     */
    document.getElementById('productPagination').addEventListener('click', function(e) {
        const link = e.target.closest('.page-link');
        if (!link || link.closest('.disabled') || link.closest('.active')) return;
        e.preventDefault();

        const url = new URL(link.href);
        const page = url.searchParams.get('page') || 1;
        refreshTable(page);
    });

    /**
     * Image preview.
     */
    document.getElementById('productImage').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('d-none');
                document.getElementById('imagePlaceholder').classList.add('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            resetImagePreview();
        }
    });

    function resetImagePreview() {
        document.getElementById('imagePreview').src = '';
        document.getElementById('imagePreview').classList.add('d-none');
        document.getElementById('imagePlaceholder').classList.remove('d-none');
    }

    function toggleSubmitLoading(loading) {
        document.getElementById('submitSpinner').classList.toggle('d-none', !loading);
        document.getElementById('productSubmitBtn').disabled = loading;
    }

    function showValidationErrors(errors) {
        for (const [field, messages] of Object.entries(errors)) {
            const input = document.querySelector(`[name="${field}"]`);
            const errorDiv = document.getElementById(`error-${field}`);
            if (input) input.classList.add('is-invalid');
            if (errorDiv) {
                errorDiv.textContent = messages[0];
                errorDiv.style.display = 'block';
            }
        }
    }

    function clearValidationErrors() {
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => {
            el.textContent = '';
            el.style.display = '';
        });
    }
</script>
@endpush
