<!DOCTYPE html>
<html lang="en">
<head>
  <title>@yield('title', 'Tour App')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    
  <style>
    :root {
      --primary: #3a57e8;
      --primary-dark: #2a46d8;
      --secondary: #6c757d;
      --success: #198754;
      --danger: #dc3545;
      --warning: #ffc107;
      --info: #0dcaf0;
      --light: #f8f9fa;
      --dark: #212529;
      --sidebar-bg: #1a2235;
      --sidebar-hover: #2a3650;
      --sidebar-active: #3a57e8;
      --topbar-bg: #ffffff;
      --topbar-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
      --content-bg: #f8fafc;
      --text-light: #8a94a6;
      --text-dark: #2d3748;
      --border-color: #e2e8f0;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--content-bg);
      color: var(--text-dark);
      overflow-x: hidden;
    }

    /* Topbar Styles */
    .topbar {
      background-color: var(--topbar-bg);
      box-shadow: var(--topbar-shadow);
      padding: 0.75rem 1.5rem;
      position: sticky;
      top: 0;
      z-index: 1020;
      transition: all 0.3s ease;
    }

    .topbar-brand {
      font-weight: 700;
      font-size: 1.5rem;
      color: var(--primary);
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .topbar-brand i {
      font-size: 1.75rem;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      color: var(--text-dark);
    }

    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: var(--primary);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
    }

    .mobile-toggle {
      border: none;
      background: transparent;
      color: var(--text-dark);
      font-size: 1.25rem;
      padding: 0.5rem;
      border-radius: 0.375rem;
      transition: all 0.2s ease;
    }

    .mobile-toggle:hover {
      background-color: var(--light);
    }

    /* Sidebar Styles */
    .sidebar {
      background-color: var(--sidebar-bg);
      color: white;
      min-height: 100vh;
      width: 250px;
      transition: all 0.3s ease;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1030;
      overflow-y: auto;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }

    .sidebar-header {
      padding: 1.5rem 1.25rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .sidebar-logo {
      font-weight: 700;
      font-size: 1.25rem;
      color: white;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .sidebar-logo i {
      font-size: 1.5rem;
      color: var(--primary);
    }

    .sidebar-close {
      background: transparent;
      border: none;
      color: var(--text-light);
      font-size: 1.25rem;
      display: none;
    }

    .sidebar-nav {
      padding: 1rem 0;
    }

    .nav-item {
      margin-bottom: 0.25rem;
    }

    .nav-link {
      color: var(--text-light);
      padding: 0.75rem 1.25rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      border-radius: 0;
      transition: all 0.2s ease;
      position: relative;
      font-weight: 500;
    }

    .nav-link i {
      font-size: 1.125rem;
      width: 20px;
      text-align: center;
    }

    .nav-link:hover, 
    .nav-link.active {
      color: white;
      background-color: var(--sidebar-hover);
    }

    .nav-link.active {
      color: white;
      background-color: var(--sidebar-active);
    }

    .nav-link.active::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      width: 4px;
      background-color: var(--primary);
    }

    .nav-link[data-bs-toggle="collapse"]::after {
      content: '\f107';
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
      margin-left: auto;
      transition: transform 0.3s ease;
    }

    .nav-link[data-bs-toggle="collapse"][aria-expanded="true"]::after {
      transform: rotate(180deg);
    }

    .submenu {
      background-color: rgba(0, 0, 0, 0.2);
      padding: 0.5rem 0;
    }

    .submenu .nav-link {
      padding-left: 3rem;
      font-size: 0.875rem;
    }

    .submenu .nav-link.active {
      background-color: transparent;
      color: var(--primary);
    }

    .submenu .nav-link.active::before {
      display: none;
    }

    /* Main Content */
    .main-content {
      margin-left: 250px;
      padding: 1.5rem;
      transition: all 0.3s ease;
      min-height: 100vh;
    }

    /* Mobile Styles */
    @media (max-width: 991.98px) {
      .sidebar {
        transform: translateX(-100%);
        width: 280px;
      }

      .sidebar.show {
        transform: translateX(0);
      }

      .sidebar-close {
        display: block;
      }

      .main-content {
        margin-left: 0;
      }

      .topbar {
        padding: 0.75rem 1rem;
      }
    }

    /* Content Card */
    .content-card {
      background-color: white;
      border-radius: 0.75rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      padding: 0.5rem;
      margin-bottom: 1.5rem;
    }

    /* DataTables Custom Styling */
    .dataTables_wrapper {
      padding: 0;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
      margin-bottom: 1rem;
    }

    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
      border: 1px solid var(--border-color);
      border-radius: 0.375rem;
      padding: 0.375rem 0.75rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
      border: 1px solid var(--border-color) !important;
      border-radius: 0.375rem !important;
      margin-left: 2px;
      padding: 0.375rem 0.75rem !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
      background: var(--primary) !important;
      border-color: var(--primary) !important;
      color: white !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
      background: var(--primary) !important;
      border-color: var(--primary) !important;
      color: white !important;
    }

    /* Custom Scrollbar */
    .sidebar::-webkit-scrollbar {
      width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
      background: rgba(255, 255, 255, 0.05);
    }

    .sidebar::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.2);
      border-radius: 3px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
      background: rgba(255, 255, 255, 0.3);
    }

    /* Animation for sidebar items */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateX(-10px); }
      to { opacity: 1; transform: translateX(0); }
    }

    .nav-item {
      animation: fadeIn 0.3s ease forwards;
    }

    .nav-item:nth-child(1) { animation-delay: 0.05s; }
    .nav-item:nth-child(2) { animation-delay: 0.1s; }
    .nav-item:nth-child(3) { animation-delay: 0.15s; }
    .nav-item:nth-child(4) { animation-delay: 0.2s; }
    .nav-item:nth-child(5) { animation-delay: 0.25s; }
    .nav-item:nth-child(6) { animation-delay: 0.3s; }
    .nav-item:nth-child(7) { animation-delay: 0.35s; }

    /* Loading Spinner */
    .dataTables_processing {
      background: rgba(255, 255, 255, 0.9) !important;
      border-radius: 0.5rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
  </style>

  @stack('styles')
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <div class="sidebar-logo">
        <i class="fas fa-map-marked-alt"></i>
        <span>CRK</span>
      </div>
      <button class="sidebar-close" id="sidebarClose">
        <i class="fas fa-times"></i>
      </button>
    </div>
    
    <nav class="sidebar-nav">
      <ul class="nav flex-column">
        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('/dashboard') }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <!-- Bookings -->
         <li class="nav-item">
            <a class="nav-link {{ request()->is('bookings*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#bookingsMenu" role="button" aria-expanded="false" aria-controls="bookingsMenu">
                <i class="fas fa-box"></i>
                <span>Bookings</span>
              </a>
              <div class="collapse submenu" id="bookingsMenu">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <a class="nav-link {{ request()->is('bookings') && !request()->is('bookings/create') ? 'active' : '' }}" href="{{ route('bookings.index') }}">All Bookings</a>
                  </li>
                  <li class="nav-item d-none">
                    <a class="nav-link {{ request()->is('bookings/create') ? 'active' : '' }}" href="{{ route('bookings.create') }}">Add bookings</a>
                  </li>
                </ul>
              </div>
        </li>


        <!-- Pages -->
        <li class="nav-item">
          <a class="nav-link {{ request()->is('pages*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#pagesMenu" role="button" aria-expanded="false" aria-controls="pagesMenu">
            <i class="fas fa-file-alt"></i>
            <span>Pages</span>
          </a>
          <div class="collapse submenu" id="pagesMenu">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link {{ request()->is('pages') && !request()->is('pages/create') ? 'active' : '' }}" href="{{ route('pages.index') }}">All Pages</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->is('pages/create') ? 'active' : '' }}" href="{{ route('pages.create') }}">Create Page</a>
              </li>
            </ul>
          </div>
        </li>

        <!-- Cities -->
        <li class="nav-item">
          <a class="nav-link {{ request()->is('cities*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#citiesMenu" role="button" aria-expanded="false" aria-controls="citiesMenu">
            <i class="fas fa-city"></i>
            <span>Cities</span>
          </a>
          <div class="collapse submenu" id="citiesMenu">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link {{ request()->is('cities') && !request()->is('cities/create') ? 'active' : '' }}" href="{{ route('cities.index') }}">All Cities</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->is('cities/create') ? 'active' : '' }}" href="{{ route('cities.create') }}">Add City</a>
              </li>
            </ul>
          </div>
        </li>

        <!-- Cabs -->
        <li class="nav-item">
          <a class="nav-link {{ request()->is('cabs*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#cabTypesMenu" role="button" aria-expanded="false" aria-controls="cabTypesMenu">
            <i class="fas fa-car"></i>
            <span>Cabs</span>
          </a>
          <div class="collapse submenu" id="cabTypesMenu">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link {{ request()->is('cabs') && !request()->is('cabs/create') ? 'active' : '' }}" href="{{ route('cabs.index') }}">All Cabs</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->is('cabs/create') ? 'active' : '' }}" href="{{ route('cabs.create') }}">Add Cab</a>
              </li>
            </ul>
          </div>
        </li>

        <!-- Routes -->
        <li class="nav-item">
          <a class="nav-link {{ request()->is('routes*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#routesMenu" role="button" aria-expanded="false" aria-controls="routesMenu">
            <i class="fas fa-car"></i>
            <span>Routes</span>
          </a>
          <div class="collapse submenu" id="routesMenu">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link {{ request()->is('routes') && !request()->is('routes/create') ? 'active' : '' }}" href="{{ route('routes.index') }}">All Routes</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->is('routes/create') ? 'active' : '' }}" href="{{ route('routes.create') }}">Add Routes</a>
              </li>
            </ul>
          </div>
        </li>

        <!-- Packages -->
        <li class="nav-item">
          <a class="nav-link {{ request()->is('packages*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#packagesMenu" role="button" aria-expanded="false" aria-controls="packagesMenu">
            <i class="fas fa-box"></i>
            <span>Packages</span>
          </a>
          <div class="collapse submenu" id="packagesMenu">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link {{ request()->is('packages') && !request()->is('packages/create') ? 'active' : '' }}" href="{{ route('packages.index') }}">All Packages</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->is('packages/create') ? 'active' : '' }}" href="{{ route('packages.create') }}">Add Package</a>
              </li>
            </ul>
          </div>
        </li>
       
        <!-- Airports -->
        <li class="nav-item">
            <a class="nav-link {{ request()->is('airports*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#airportsMenu" role="button" aria-expanded="false" aria-controls="airportsMenu">
                <i class="fas fa-box"></i>
                <span>Airports</span>
              </a>
              <div class="collapse submenu" id="airportsMenu">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <a class="nav-link {{ request()->is('airports') && !request()->is('airports/create') ? 'active' : '' }}" href="{{ route('airports.index') }}">All Airports</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link {{ request()->is('airports/create') ? 'active' : '' }}" href="{{ route('airports.create') }}">Add Airports</a>
                  </li>
                </ul>
              </div>
        </li>

        <!-- Vendors -->
        <li class="nav-item">
          <a class="nav-link {{ request()->is('vendors*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#vendorsMenu" role="button" aria-expanded="false" aria-controls="vendorsMenu">
            <i class="fas fa-taxi"></i>
            <span>Vendors</span>
          </a>
          <div class="collapse submenu" id="vendorsMenu">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link {{ request()->is('vendors') && !request()->is('vendors/create') ? 'active' : '' }}" href="{{ route('vendors.index') }}">All Vendors</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->is('vendors/create') ? 'active' : '' }}" href="{{ route('vendors.create') }}">Add Vendor</a>
              </li>
            </ul>
          </div>
        </li>

        <!-- Users -->
        <li class="nav-item">
          <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#usersMenu" role="button" aria-expanded="false" aria-controls="usersMenu">
            <i class="fas fa-taxi"></i>
            <span>Users</span>
          </a>
          <div class="collapse submenu" id="usersMenu">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link {{ request()->is('users') && !request()->is('users/create') ? 'active' : '' }}" href="{{ route('users.index') }}">All Users</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->is('users/create') ? 'active' : '' }}" href="{{ route('users.create') }}">Add User</a>
              </li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ request()->is('company-details*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#company-detailsMenu" role="button" aria-expanded="false" aria-controls="company-detailsMenu">
            <i class="fas fa-taxi"></i>
            <span>Company Details</span>
          </a>
          <div class="collapse submenu" id="company-detailsMenu">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link {{ request()->is('company-details') && !request()->is('company-details/create') ? 'active' : '' }}" href="{{ route('company-details.index') }}">Company Details</a>
              </li>     
            </ul>
          </div>
        </li>


        <!-- Logout -->
        <li class="nav-item mt-4">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link btn btn-link text-start w-100">
              <i class="fas fa-sign-out-alt"></i>
              <span>Logout</span>
            </button>
          </form>
        </li>
      </ul>
    </nav>
  </div>

  <!-- Topbar -->
  <nav class="topbar">
    <div class="container-fluid d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center">
        <button class="mobile-toggle me-3" id="sidebarToggle">
          <i class="fas fa-bars"></i>
        </button>
        <a class="topbar-brand" href="#">
          <!-- <i class="fas fa-map-marked-alt"></i> -->
          <!-- <span>CarRentalKolkata</span> -->
        </a>
      </div>
      
      <div class="user-info">
        <div class="user-avatar">
          @auth
            {{ substr(Auth::user()->name, 0, 1) }}
          @endauth
        </div>
        <div class="d-none d-md-block">
          @auth
            <div class="fw-medium">{{ Auth::user()->name }}</div>
            <small class="text-muted">Administrator</small>
          @endauth
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="main-content" id="mainContent">
    <div class="content-card">
      @yield('content')
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

  @stack('scripts')

  <script>
    // Sidebar toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
      const sidebar = document.getElementById('sidebar');
      const sidebarToggle = document.getElementById('sidebarToggle');
      const sidebarClose = document.getElementById('sidebarClose');
      const mainContent = document.getElementById('mainContent');
      
      // Toggle sidebar on mobile
      sidebarToggle.addEventListener('click', function() {
        sidebar.classList.toggle('show');
      });
      
      // Close sidebar on mobile when close button is clicked
      sidebarClose.addEventListener('click', function() {
        sidebar.classList.remove('show');
      });
      
      // Close sidebar when clicking outside on mobile
      document.addEventListener('click', function(event) {
        const isClickInsideSidebar = sidebar.contains(event.target);
        const isClickInsideToggle = sidebarToggle.contains(event.target);
        
        if (!isClickInsideSidebar && !isClickInsideToggle && window.innerWidth < 992) {
          sidebar.classList.remove('show');
        }
      });
      
      // Auto-collapse submenus when another main menu is clicked on mobile
      const navLinks = document.querySelectorAll('.nav-link[data-bs-toggle="collapse"]');
      navLinks.forEach(link => {
        link.addEventListener('click', function() {
          if (window.innerWidth < 992) {
            const target = this.getAttribute('href');
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            if (!isExpanded) {
              // Close other open submenus
              navLinks.forEach(otherLink => {
                if (otherLink !== this) {
                  const otherTarget = otherLink.getAttribute('href');
                  const otherCollapse = document.querySelector(otherTarget);
                  if (otherCollapse.classList.contains('show')) {
                    otherLink.setAttribute('aria-expanded', 'false');
                    otherCollapse.classList.remove('show');
                  }
                }
              });
            }
          }
        });
      });

      // Initialize all DataTables with enhanced configuration
      initializeDataTables();
    });

    // Enhanced DataTables initialization function
    function initializeDataTables() {
      $('table').each(function() {
        if ($(this).hasClass('dataTable')) return; // Skip if already initialized
        
        const tableId = $(this).attr('id');
        if (tableId) {
          $(this).DataTable({
            responsive: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            order: [],
            language: {
              search: "_INPUT_",
              searchPlaceholder: "Search...",
              lengthMenu: "Show _MENU_ entries",
              info: "Showing _START_ to _END_ of _TOTAL_ entries",
              infoEmpty: "Showing 0 to 0 of 0 entries",
              infoFiltered: "(filtered from _MAX_ total entries)",
              paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
              },
              processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div> Processing...'
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            initComplete: function() {
              console.log('DataTable initialized:', tableId);
            },
            drawCallback: function() {
              console.log('DataTable redrawn:', tableId);
            }
          });
        }
      });
    }

    // search city in create vendor
    $(document).ready(function () {
        $('#city').on('keyup', function () {
            let query = $(this).val();
            if (query.length > 1) {
                $.ajax({
                    url: '/cities/search',
                    type: 'GET',
                    data: { q: query },
                    success: function (data) {
                        let list = '';
                        if (data.length > 0) {
                            data.forEach(city => {
                                list += `<li class="list-group-item list-group-item-action" data-id="${city.id}" data-name="${city.name}">${city.name}</li>`;
                            });
                        } else {
                            list = '<li class="list-group-item disabled">No cities found</li>';
                        }
                        $('#cityList').html(list).show();
                    }
                });
            } else {
                $('#cityList').hide();
            }
        });

        $(document).on('click', '#cityList li', function () {
            $('#city').val($(this).data('name'));
            $('#city_id').val($(this).data('id'));
            $('#cityList').hide();
        });

        $(document).click(function (e) {
            if (!$(e.target).closest('#city, #cityList').length) {
                $('#cityList').hide();
            }
        });
    });

    // create packages
    $(document).ready(function() {
        $('#trip_type_id').on('change', function() {
            const selectedType = $(this).find('option:selected').text().toLowerCase();

            if (selectedType.includes('airport')) {
                $('.airport-fields').show();
                $('#to_city_group').hide();
            } else if (selectedType.includes('local')) {
                $('#to_city_group').hide();
                $('.airport-fields').hide();
            } else {
                $('#to_city_group').show();
                $('.airport-fields').hide();
            }
        });
    });

    function previewImage(event) {
        let reader = new FileReader();
        reader.onload = function(){
            let output = document.getElementById('profilePreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function handleScroll() {
      const mainContent = document.getElementById('mainContent');
      if (mainContent.scrollHeight > mainContent.clientHeight) {
        mainContent.style.overflowY = 'auto';
      } else {
        mainContent.style.overflowY = 'visible';
      }
    }
        // Call handleScroll on load and resize
      window.addEventListener('load', handleScroll);
      window.addEventListener('resize', handleScroll);

    // Global error handler for DataTables
    $.fn.dataTable.ext.errMode = 'throw';
  </script>

</body>
</html>