@extends('layouts.app')

@section('title', 'Pages Management')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Pages Management</h4>
            <p class="text-muted mb-0">Manage all website pages and content</p>
        </div>
        <a href="{{ route('pages.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Create New Page
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fas fa-check-circle me-2 fs-5"></i>
            <div class="flex-grow-1">{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fas fa-exclamation-circle me-2 fs-5"></i>
            <div class="flex-grow-1">{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card bg-primary bg-opacity-10 border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary text-white rounded-circle me-3">
                            <i class="fas fa-file-alt fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="stat-label text-muted mb-1">Total Pages</h6>
                            <h4 class="stat-value mb-0">{{ $pages->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card bg-success bg-opacity-10 border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success text-white rounded-circle me-3">
                            <i class="fas fa-check-circle fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="stat-label text-muted mb-1">Published</h6>
                            <h4 class="stat-value mb-0">{{ $pages->where('status', 'published')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card bg-warning bg-opacity-10 border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning text-white rounded-circle me-3">
                            <i class="fas fa-pause-circle fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="stat-label text-muted mb-1">Draft</h6>
                            <h4 class="stat-value mb-0">{{ $pages->where('status', 'draft')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card bg-info bg-opacity-10 border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-info text-white rounded-circle me-3">
                            <i class="fas fa-calendar-alt fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="stat-label text-muted mb-1">This Month</h6>
                            <h4 class="stat-value mb-0">{{ $pages->where('created_at', '>=', now()->startOfMonth())->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Filters & Search -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-8">
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-outline-primary active filter-btn" data-status="all">
                            <i class="fas fa-layer-group me-2"></i>All Pages
                        </button>
                        <button class="btn btn-outline-success filter-btn" data-status="published">
                            <i class="fas fa-check-circle me-2"></i>Published
                        </button>
                        <button class="btn btn-outline-warning filter-btn" data-status="draft">
                            <i class="fas fa-pause-circle me-2"></i>Draft
                        </button>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control" id="quickSearch" placeholder="Search pages...">
                        <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pages Table Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-file-alt me-2 text-primary"></i>
                    All Pages
                    <span class="badge bg-primary ms-2" id="pageCount">{{ $pages->count() }}</span>
                </h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm" id="refreshTable">
                        <i class="fas fa-sync-alt me-1"></i>Refresh
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-download me-1"></i>Export
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel me-2"></i>Excel</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2"></i>PDF</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-csv me-2"></i>CSV</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="pagesTable" class="table table-hover align-middle mb-0" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>Page Details</th>
                            <th>URL Slug</th>
                            <th width="120">Status</th>
                            <th width="140">Last Updated</th>
                            <th width="150" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $page)
                        <tr data-status="{{ $page->status }}">
                            <td class="fw-semibold">
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-circle p-2">
                                    {{ $loop->iteration }}
                                </span>
                            </td>
                            <td>
                                <div class="page-info">
                                    <div class="d-flex align-items-center mb-1">
                                        <div class="page-icon bg-primary bg-opacity-10 text-primary rounded-circle me-2">
                                            <i class="fas fa-file fs-6"></i>
                                        </div>
                                        <div>
                                            <h6 class="page-title mb-0">{{ $page->title }}</h6>
                                            <small class="text-muted">
                                                Created: {{ $page->created_at->format('M d, Y') }}
                                            </small>
                                        </div>
                                    </div>
                                    @if($page->excerpt)
                                    <p class="page-excerpt text-muted mb-0 small">
                                        {{ Str::limit($page->excerpt, 80) }}
                                    </p>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="slug-info">
                                    <code class="text-dark">/{{ $page->slug }}</code>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-link me-1"></i>
                                        <a href="{{ url($page->slug) }}" target="_blank" class="text-decoration-none">
                                            View Live
                                        </a>
                                    </small>
                                </div>
                            </td>
                            <td>
                                <div class="status-container">
                                    <span class="badge status-badge bg-{{ $page->status === 'published' ? 'success' : 'secondary' }}">
                                        <i class="fas fa-circle me-1 fs-6"></i>
                                        {{ ucfirst($page->status) }}
                                    </span>
                                    
                                </div>
                            </td>
                            <td>
                                <div class="date-info">
                                    <div class="fw-semibold">{{ $page->updated_at->format('M d, Y') }}</div>
                                    <small class="text-muted">{{ $page->updated_at->format('h:i A') }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <!-- View Button -->
                                    <a href="{{ url($page->slug) }}" 
                                       target="_blank"
                                       class="btn btn-sm btn-info text-white" 
                                       data-bs-toggle="tooltip" 
                                       title="View Live Page">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>

                                    <!-- Edit Button -->
                                    <a href="{{ route('pages.edit', $page->id) }}" 
                                       class="btn btn-sm btn-warning" 
                                       data-bs-toggle="tooltip" 
                                       title="Edit Page">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Quick Actions Dropdown -->
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" 
                                                type="button" 
                                                data-bs-toggle="dropdown"
                                                data-bs-toggle="tooltip"
                                                title="More Actions">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="fas fa-copy me-2"></i>Duplicate
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="fas fa-history me-2"></i>Version History
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <!-- <form action="{{ route('pages.destroy', $page->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure to delete this page?')">
                                                   @csrf @method('DELETE')
                                                    <button type="button" 
                                                            class="dropdown-item text-danger delete-page" 
                                                            data-page-title="{{ $page->title }}">
                                                        <i class="fas fa-trash me-2"></i>Delete Page
                                                    </button>
                                                </form> -->
                                                <form action="{{ route('pages.destroy', $page->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure to delete this page?');">
                                                    @csrf @method('DELETE')
                                                    <button class="dropdown-item text-danger delete-pag"><i class="fas fa-trash me-2"></i> Delete Page</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Empty State (if no pages) -->
    @if($pages->count() == 0)
    <div class="card shadow-sm border-0">
        <div class="card-body text-center py-5">
            <div class="empty-state-icon mb-4">
                <i class="fas fa-file-alt text-muted fs-1"></i>
            </div>
            <h4 class="text-muted mb-3">No Pages Created Yet</h4>
            <p class="text-muted mb-4">Get started by creating your first website page.</p>
            <a href="{{ route('pages.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Create Your First Page
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .stat-label {
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .stat-value {
        font-weight: 700;
        color: var(--text-dark);
    }
    
    .page-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .page-title {
        font-weight: 600;
        color: var(--text-dark);
    }
    
    .page-excerpt {
        font-size: 0.875rem;
        line-height: 1.4;
    }
    
    .slug-info code {
        font-size: 0.875rem;
        background: #f8f9fa;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
    }
    
    .status-badge {
        font-size: 0.75rem;
        font-weight: 500;
        padding: 0.35rem 0.75rem;
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--border-color);
        padding: 1rem 0.75rem;
    }
    
    .table td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }
    
    .btn-sm {
        padding: 0.375rem 0.5rem;
        border-radius: 0.375rem;
    }
    
    .filter-btn.active {
        background-color: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    
    .status-container {
        text-align: center;
    }
    
    .form-check-input:checked {
        background-color: var(--success);
        border-color: var(--success);
    }
    
    .form-check-input {
        width: 2.5em;
        height: 1.25em;
    }
    
    .date-info {
        text-align: center;
    }
    
    /* DataTables custom styling */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        padding: 1rem 1.25rem 0.5rem;
    }
    
    .dataTables_wrapper .dataTables_info {
        padding: 0.5rem 1.25rem;
    }
    
    .dataTables_wrapper .dataTables_paginate {
        padding: 0.5rem 1.25rem 1rem;
    }
    
    /* Card header styling */
    .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    /* Hover effects */
    #pagesTable tbody tr {
        transition: all 0.3s ease;
    }
    
    #pagesTable tbody tr:hover {
        background-color: rgba(var(--primary-rgb), 0.05);
        transform: translateY(-1px);
    }
    
    .empty-state-icon {
        opacity: 0.5;
    }
    
    .dropdown-menu {
        min-width: 200px;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    const pagesTable = $('#pagesTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        order: [[4, 'desc']], // Order by last updated date
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search pages...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ pages",
            infoEmpty: "Showing 0 to 0 of 0 pages",
            infoFiltered: "(filtered from _MAX_ total pages)",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            },
            emptyTable: "No pages available",
            zeroRecords: "No matching pages found"
        },
        columnDefs: [
            {
                targets: [0, 3, 5], // Index, Status, Actions columns
                orderable: false
            },
            {
                targets: 5, // Actions column
                searchable: false
            }
        ],
        initComplete: function() {
            // Add custom class to search input
            $('.dataTables_filter input').addClass('form-control form-control-sm');
            $('.dataTables_length select').addClass('form-select form-select-sm');
        },
        drawCallback: function() {
            // Initialize tooltips on each table draw
            $('[data-bs-toggle="tooltip"]').tooltip({
                trigger: 'hover',
                placement: 'top'
            });
            
            // Update page count
            $('#pageCount').text(pagesTable.rows({ filter: 'applied' }).count());
        }
    });

    // Filter buttons
    $('.filter-btn').on('click', function() {
        const status = $(this).data('status');
        
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
        
        if (status === 'all') {
            pagesTable.search('').draw();
        } else {
            pagesTable.column(3).search(status).draw();
        }
    });

    // Quick search
    $('#quickSearch').on('keyup', function() {
        pagesTable.search(this.value).draw();
    });

    $('#clearSearch').on('click', function() {
        $('#quickSearch').val('');
        pagesTable.search('').draw();
    });

    // Refresh table button
    $('#refreshTable').on('click', function() {
        pagesTable.ajax.reload();
        $(this).find('i').addClass('fa-spin');
        setTimeout(() => {
            $(this).find('i').removeClass('fa-spin');
        }, 1000);
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Auto-hide alerts
    setTimeout(function() {
        $('.alert').fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 5000);
});
</script>

<!-- SweetAlert2 for better confirmations -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush