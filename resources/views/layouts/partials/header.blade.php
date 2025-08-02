<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <nav class="navbar">

                    <div class="header-search d-flex align-items-center">
                        <a class="brand-logo mr-3"
                            href="{{ auth()->user()->is_admin ? route('clients.index') : route('trade-statement') }}">
                            <img src="{{ asset('images/logo.png') }}" height="40" alt="">
                        </a>
                    </div>


                    <div class="dashboard_log my-2">
                        <div class="d-flex align-items-center">
                            <div class="profile_log dropdown">
                                <div class="user" data-toggle="dropdown">
                                    @if (Auth::user()->profile_img == 'placeholder.jpg')
                                        <span class="thumb">
                                            <i class="mdi mdi-account"></i>
                                        </span>
                                    @else
                                        <img class="mr-3 rounded-circle shadow-sm mr-0 mr-sm-3"
                                            src="{{ Storage::disk('public')->exists('users/' . Auth::user()->profile_img) ? asset('storage/users/' . Auth::user()->profile_img) : '' }}"
                                            width="35" height="35" alt="">
                                    @endif
                                    <span class="name"
                                        style="line-height: 1;">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                                        @if (!Auth::user()->is_admin && Auth::user()->email_verified_at)
                                            <br>
                                            <span style="font-size: 12px; font-weight:400; color:#29294E; font-style:normal;">
                                                <i class="mdi mdi-check-circle mr-1"></i>
                                                Verified Account
                                            </span>
                                        @endif
                                    </span>
                                    <span class="arrow"><i class="la la-angle-down"></i></span>
                                </div>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="{{ route('account') }}" class="dropdown-item">
                                        <i class="mdi mdi-account"></i> Account
                                    </a>
                                    <a href="javascript:void(0)"
                                        onclick="document.getElementById('logout-form').submit()"
                                        class="dropdown-item logout">
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            @csrf
                                        </form>
                                        <i class="mdi mdi-power"></i> Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
