<div class="header">
    <div class="header-left">
        <div class="menu-icon bi bi-list"></div>

    </div>
    <div class="header-right">


        <div class="user-info-dropdown">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                    <span class="user-icon" style="display: -webkit-inline-box; width: 50px; height: 50px; overflow: hidden; border-radius: 50%;">
                        <img style="width: 100%; height: auto; display: block; border-radius: 0;" src="{{ auth()->user()->user_img ? asset(auth()->user()->user_img) : asset('src/images/default-avatar.jpg') }}" alt="">
                    </span>
                    <span class="user-name">{{ auth()->user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">

                    <a class="dropdown-item" href="{{ route('user.setting') }}"><i class="dw dw-settings2"></i> Setting</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"><i class="dw dw-logout"></i> Log Out</a>
                </div>
            </div>
        </div>

    </div>
</div>