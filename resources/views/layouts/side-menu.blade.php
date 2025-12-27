@php
$currentRoute = Route::currentRouteName();
@endphp

<div class="left-side-bar">
    <div class="brand-logo">
        <a href="{{ route('customer.dashboard') }}">
            <img src="{{ asset('vendors/images/logo.jpg') }}" alt="" class="dark-logo" />
            <img
                    src="{{ asset('vendors/images/new_logo.png') }}"
                    alt=""
                    style="max-width: 250px; max-height: 70px;"
                    class="light-logo"
            />
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li class="dropdown">
                    <a href="{{route('customer.dashboard')}}" class="dropdown-toggle no-arrow @if( $currentRoute == 'customer.dashboard' ) active @endif">
								<span class="micon bi bi-archive"></span
                                ><span class="mtext">Dashboard</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
								<span class="micon bi bi-app-indicator"></span
                                ><span class="mtext">Inquiry</span>
                    </a>
                    <ul class="submenu">
                        <li><a class="@if( $currentRoute == 'inquiries.index' ) active @endif" href="{{ route('inquiries.index') }}">List</a></li>
                        <li><a class="@if( $currentRoute == 'inquiries.create' ) active @endif" href="{{ route('inquiries.create') }}">Add</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
								<span class="micon bi bi-house"></span
                                ><span class="mtext">Address</span>
                    </a>
                    <ul class="submenu " >
                        <li ><a class="@if( $currentRoute == 'addresses.index' || $currentRoute == 'addresses.edit'  ) active @endif" href="{{ route('addresses.index') }}">List</a></li>
                        <li><a class="@if( $currentRoute == 'addresses.create' ) active @endif" href="{{ route('addresses.create') }}">Add</a></li>
                    </ul>
                </li>
                <!-- <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
								<span class="micon bi bi-journal-arrow-up"></span
                                ><span class="mtext">Bookings</span>
                    </a>
                    <ul class="submenu " >
                    <li><a class="@if( $currentRoute == 'bookings.index' ) active @endif" href="{{ route('bookings.index') }}">List</a></li>
                    </ul>
                </li>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
								<span class="micon bi bi-bag"></span
                                ><span class="mtext">Quotes</span>
                    </a>
                    <ul class="submenu " >
                    <li><a class="@if( $currentRoute == 'quotations.index' ) active @endif" href="{{ route('quotations.index') }}">List</a></li>
                    </ul>
                </li> -->
                <li>
                    <div class="dropdown-divider"></div>
                </li>

                <li>
                    <a href="{{ route('user.setting') }}" class="dropdown-toggle no-arrow">
								<span class="micon dw dw-settings1"></span
                                ><span class="mtext">Settings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-logout"></span>
                        <span class="mtext">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>