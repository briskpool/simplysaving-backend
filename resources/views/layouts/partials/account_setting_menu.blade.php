<div class="col-xl-3 col-md-4">
    <div class="card settings_menu">
        <div class="card-header">
            <h4 class="card-title">Settings</h4>
        </div>
        <div class="card-body">
            <ul>
                <li class="nav-item">
                    <a href="{{ route('account') }}" class="nav-link {{ request()->is('account') ? 'active' : '' }}">
                        <i class="mdi mdi-account"></i>
                        <span>Edit Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('security') }}" class="nav-link {{ request()->is('security') ? 'active' : '' }}">
                        <i class="la la-lock"></i>
                        <span>Security</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
