@props(['auth'])

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container container-fluid">
        <a class="navbar-brand" href="/"><i class="fa fa-link"></i> ConnectFriend</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">{{ __('messages.navbar.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/notifications">{{ __('messages.navbar.notifications') }}</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ __('messages.navbar.socials') }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/profile">{{ __('messages.navbar.chats') }}</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/payment">{{ __('messages.navbar.top_up') }}</a>
                </li>
            </ul>
            <div class="d-flex align-items-center gap-4">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{ __('messages.navbar.language') }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item"
                                    href="{{ route('locale.switch', ['locale' => 'en']) }}">English</a>
                            </li>
                            <li><a class="dropdown-item"
                                    href="{{ route('locale.switch', ['locale' => 'id']) }}">Indonesian</a></li>
                        </ul>
                    </li>
                </ul>
                @if (auth()->user())
                    <div class="d-flex align-items-center coin gap-2">
                        <i class="fa fa-coins"></i>
                        <span>{{ auth()->user()->coin_amount }}</span>
                    </div>
                    <div class="dropdown">
                        <div class="profile dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <img src="{{ asset('assets/profile/cat-portrait.png') }}" alt="">
                            <span><strong>{{ auth()->user()->username }}</strong></span>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/profile">{{ __('messages.navbar.profile') }}</a></li>
                            <hr class="dropdown-divider">
                            <li>
                                <form action="/logout" method="POST">
                                    @csrf
                                    @method('POST')

                                    <button class="dropdown-item text-danger" type="submit"><i
                                            class="fa fa-sign-out-alt"></i>
                                        {{ __('messages.navbar.logout') }}</button>
                                </form>
                            </li>
                        </ul>
                    </div>
            </div>
        @else
            <div class="d-flex align-items-center gap-4" role="search">
                <a href="/login" class="d-flex align-items-center gap-2 btn-register">
                    <span>{{ __('messages.navbar.sign_in') }}</span>
                </a>
                <a href="/register" class="btn-login">
                    <span><strong>{{ __('messages.navbar.sign_up') }}</strong></span>
                </a>
            </div>
            @endif
        </div>
    </div>
</nav>
