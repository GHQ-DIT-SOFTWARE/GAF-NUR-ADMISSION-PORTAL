<header class="navbar pcoded-header navbar-expand-lg navbar-light header-blue">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
        <a href="#!" class="b-brand">
            <!-- Change your logo here -->
            {{-- <img src="{{ asset('gaflogo.png') }}" alt="Logo" class="logo"> --}}
        </a>
        <a href="#!" class="mob-toggler" aria-label="Toggle mobile menu">
            <i class="feather icon-more-vertical"></i>
        </a>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">

            <li>
                <div class="dropdown drp-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <img src="{{ !empty($user->image) ? asset('upload/profile/' . $user->image) : asset('user.png') }}"
                            class="img-radius" alt="User Profile Image" style="width: 40px; margin-left: 1px;">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-notification">
                        <ul class="pro-body">
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="feather icon-lock"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                </div>
            </li>
        </ul>
    </div>
</header>
