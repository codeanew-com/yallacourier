<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8" />
    <title>@hasSection('title')@yield('title') · @endif Yalla Courier Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    @include('partials.favicons')

    <!-- DataTables -->
    <link href="{{ asset('a_assets/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('a_assets/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('a_assets/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="{{ asset('a_assets/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('a_assets/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('a_assets/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Admin design layer (shared components: page header, KPI tiles, pills, filters) -->
    <link href="{{ asset('a_assets/assets/css/admin-modern.css')}}?v=20261020d" rel="stylesheet" type="text/css" />

    <!-- App js -->
    <script src="{{ asset('a_assets/assets/js/plugin.js')}}"></script>
    <!-- Summer Note -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" rel="stylesheet" type="text/css" />
    <style>
        .gallery-item-wrapper {
            position: relative;
        }

        .gallery-item-wrapper .btn-close {
            background-color: #f46a6a;
            height: 20px;
            width: 20px;
            line-height: 24px;
            display: block;
            color: var(--bs-gray-200);
            text-align: center;
            position: absolute;
            top: 5px;
            right: 5px;
            opacity: 1;
        }
    </style>
    @stack('styles')
</head>

<body data-sidebar="dark">
    @php
        // [label, route name, active route pattern(s), icon, badge]
        $adminMenu = [
            'Operations' => [
                ['Dashboard', 'admin.home', 'admin.home', 'bx-home-circle', null],
                ['Orders', 'admin.order.index', ['admin.order.*', 'admin.view.order', 'admin.search.orders'], 'bx-package', [$pendingOrdersCount ?? 0, 'bg-warning text-dark', 'pending order(s) waiting for action', route('admin.order.index', ['status' => 'pending'])]],
                ['Customers', 'admin.view.customer', ['admin.view.customer', 'admin.single.customer'], 'bx-user', null],
                ['Business Leads', 'admin.businessleads', 'admin.businessleads*', 'bx-briefcase-alt-2', [$unreadLeadsCount ?? 0, 'bg-info', 'unread business lead(s)', route('admin.businessleads', ['view' => 'unread'])]],
                ['Wallet Top-ups', 'admin.view.transactions', 'admin.view.transactions', 'bx-wallet', null],
            ],
            'Website content' => [
                ['Pages', 'admin-pages.index', ['admin-pages.*', 'admin.pagemeta'], 'bx-file', null],
                ['FAQs', 'admin-faq.index', 'admin-faq.*', 'bx-help-circle', null],
                ['Customer Reviews', 'admin-review.index', 'admin-review.*', 'bx-star', null],
                ['Country Pages', 'admin-country.index', 'admin-country.*', 'bx-world', null],
            ],
            'Configuration' => [
                ['Couriers & Rates', 'admin-couriers.index', 'admin-couriers.*', 'bx-car', null],
                ['Notifications', 'admin.settings.notifications', 'admin.settings.notifications*', 'bx-bell', null],
                ['Robots.txt', 'admin.robots', 'admin.robots', 'bx-bot', null],
                ['Sitemap', 'admin.sitemap', 'admin.sitemap', 'bx-sitemap', null],
            ],
        ];
    @endphp
    <!-- Begin page -->
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="{{ route('admin.home') }}" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{asset('front_assets/images/header-logo.svg')}}" alt="Yalla Courier" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{asset('front_assets/images/header-logo.svg')}}" alt="Yalla Courier" height="49">
                            </span>
                        </a>
                        <a href="{{ route('admin.home') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{asset('front_assets/images/header-logo.svg')}}" alt="Yalla Courier" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{asset('front_assets/images/header-logo.svg')}}" alt="Yalla Courier" height="49">
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn" aria-label="Toggle menu">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                    {{-- Global order lookup: order #, name, phone, email or AWB --}}
                    <form class="app-search d-none d-lg-block" method="get" action="{{ route('admin.order.index') }}" role="search">
                        <div class="position-relative">
                            <input type="search" name="q" class="form-control" placeholder="Find order: #, name, phone, email, AWB…" aria-label="Search orders" value="{{ request()->routeIs('admin.order.index') ? request('q') : '' }}">
                            <span class="bx bx-search-alt"></span>
                        </div>
                    </form>
                </div>
                <div class="d-flex">
                    <div class="dropdown d-inline-block d-lg-none ms-2">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Search orders">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                            <form class="p-3" method="get" action="{{ route('admin.order.index') }}" role="search">
                                <div class="input-group">
                                    <input type="search" name="q" class="form-control" placeholder="Order #, name, phone, AWB…" aria-label="Search orders">
                                    <button class="btn btn-primary" type="submit" aria-label="Search"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <a href="{{ url('/') }}" target="_blank" rel="noopener" class="btn header-item d-none d-sm-flex align-items-center" title="Open the public website">
                        <i class="bx bx-link-external font-size-18 me-1"></i><span class="d-none d-xl-inline">View site</span>
                    </a>
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="avatar-xs d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white fw-semibold" style="width:32px;height:32px;" aria-hidden="true">{{ strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}</span>
                            <span class="d-none d-xl-inline-block ms-1">{{ Auth::user()->name }}</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <span class="dropdown-item-text text-muted small">{{ Auth::user()->email }}</span>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span>Log out</span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">
            <div data-simplebar class="h-100">
                <div id="sidebar-menu">
                    <ul class="metismenu list-unstyled" id="side-menu">
                        @foreach($adminMenu as $section => $items)
                            <li class="menu-title">{{ $section }}</li>
                            @foreach($items as [$label, $routeName, $pattern, $icon, $badge])
                                @php
                                    $isActive = request()->routeIs(...(array) $pattern);
                                    // A badge links straight to the filtered queue it counts.
                                    $href = $badge && $badge[0] > 0 ? $badge[3] : route($routeName);
                                @endphp
                                <li class="{{ $isActive ? 'mm-active' : '' }}">
                                    <a href="{{ $href }}" class="waves-effect {{ $isActive ? 'active' : '' }}" @if($isActive) aria-current="page" @endif>
                                        <i class="bx {{ $icon }}"></i>
                                        <span>{{ $label }}</span>
                                        @if($badge && $badge[0] > 0)
                                            <span class="badge rounded-pill {{ $badge[1] }} adm-menu-badge" title="{{ $badge[0] }} {{ $badge[2] }}"><span aria-hidden="true">{{ $badge[0] > 99 ? '99+' : $badge[0] }}</span><span class="visually-hidden">{{ $badge[0] }} {{ $badge[2] }}</span></span>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!-- Left Sidebar End -->

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @include('admin.partials.flash')
                    @yield('content')
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">{{ date('Y') }} © Yalla Courier.</div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">Design &amp; Develop by <a href="https://codeanew.com" target="_blank" rel="noopener">Codeanew</a></div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- END layout-wrapper -->

    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('a_assets/assets/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('a_assets/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('a_assets/assets/libs/metismenu/metisMenu.min.js')}}"></script>
    <script src="{{ asset('a_assets/assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{ asset('a_assets/assets/libs/node-waves/waves.min.js')}}"></script>
    <!-- Required datatable js -->
    <script src="{{ asset('a_assets/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('a_assets/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('a_assets/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('a_assets/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('a_assets/assets/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{ asset('a_assets/assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{ asset('a_assets/assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
    <script src="{{ asset('a_assets/assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('a_assets/assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{ asset('a_assets/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('a_assets/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('a_assets/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

    <!-- Datatable init js -->
    <script src="{{ asset('a_assets/assets/js/pages/datatables.init.js')}}"></script>

    <script src="{{ asset('a_assets/assets/js/app.js')}}"></script>
    <!-- SummerNote JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
    <script>
        // Shared admin behaviour (2026-10-20).
        (function ($) {
            // 1. Every DELETE form, and anything marked data-confirm, asks first.
            $(document).on('submit', 'form', function (e) {
                var $form = $(this);
                var message = $form.data('confirm');
                if (!message && $form.find('input[name="_method"][value="DELETE"]').length) {
                    message = 'Delete this item? This cannot be undone from the admin panel.';
                }
                if (message && !$form.data('confirmed') && !window.confirm(message)) {
                    e.preventDefault();
                    return false;
                }
                // 2. Lock the submit button so a double click can't send the form twice.
                if (!e.isDefaultPrevented()) {
                    var $btn = $form.find('[type="submit"]').not('[formnovalidate]');
                    setTimeout(function () {
                        $btn.addClass('is-loading').attr('aria-busy', 'true');
                        $btn.filter('button').each(function () {
                            if (!$(this).find('.spinner-border').length) {
                                $(this).prepend('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>');
                            }
                        });
                    }, 0);
                }
            });
            $(document).on('click', 'a[data-confirm]', function (e) {
                if (!window.confirm($(this).data('confirm'))) {
                    e.preventDefault();
                }
            });
            // 3. Success messages fade on their own; errors stay until dismissed.
            setTimeout(function () {
                $('[data-autodismiss]').each(function () {
                    bootstrap.Alert.getOrCreateInstance(this).close();
                });
            }, 6000);
            // 4. Move focus to the first invalid field after a failed submit.
            $(function () {
                var $invalid = $('.is-invalid').first();
                if ($invalid.length) { $invalid.trigger('focus'); }
            });
            // Restore buttons if the user comes back via the browser's back button.
            window.addEventListener('pageshow', function () {
                $('.is-loading').removeClass('is-loading').removeAttr('aria-busy').find('.spinner-border').remove();
            });
        })(jQuery);
    </script>
    @stack('scripts')
</body>

</html>
