@php
    $customerNavItems = [
        ['route' => 'frontend.customer.dashboard.index', 'icon' => 'menu-icon-1.svg', 'label' => 'Dashboard'],
        ['route' => 'frontend.customer.shipmentsetting.index', 'icon' => 'menu-icon-2.svg', 'label' => 'My Shipments'],
        ['route' => 'frontend.customer.ebilling.index', 'icon' => 'menu-icon-4.svg', 'label' => 'eBilling'],
        // Custom Products removed (2026-10-18) — was a static placeholder with no backend. Add back once a real feature exists.
        // ['route' => 'frontend.customer.customproducts.index', 'icon' => 'menu-icon-6.svg', 'label' => 'Custom Products'],
        ['route' => 'frontend.customer.setting.index', 'icon' => 'menu-icon-5.svg', 'label' => 'Profile'],
    ];
@endphp

{{-- Desktop sidebar --}}
<nav class="customer-sidebar d-none d-lg-block">
    <ul>
        @foreach($customerNavItems as $item)
            <li>
                <a href="{{ route($item['route']) }}" class="{{ request()->routeIs($item['route']) ? 'active' : '' }}">
                    <img src="{{ asset('front_assets/images/'.$item['icon']) }}" alt="">
                    {{ $item['label'] }}
                </a>
            </li>
        @endforeach
        <li class="logout-item">
            <a href="{{ route('frontend.customer.logout') }}">
                <img src="{{ asset('front_assets/images/menu-icon-3.svg') }}" alt="">
                Logout
            </a>
        </li>
    </ul>
</nav>

{{-- Mobile horizontal tab bar --}}
<nav class="customer-tabbar d-lg-none">
    @foreach($customerNavItems as $item)
        <a href="{{ route($item['route']) }}" class="{{ request()->routeIs($item['route']) ? 'active' : '' }}">
            <img src="{{ asset('front_assets/images/'.$item['icon']) }}" alt="">
            {{ $item['label'] }}
        </a>
    @endforeach
    <a href="{{ route('frontend.customer.logout') }}">
        <img src="{{ asset('front_assets/images/menu-icon-3.svg') }}" alt="">
        Logout
    </a>
</nav>
