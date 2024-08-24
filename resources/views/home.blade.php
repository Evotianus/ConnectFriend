<x-layout :title="$title" :auth="$auth">
    <h6>{{ __('messages.welcome', ['name' => 'Evo']) }}</h6>
    <h4>{{ __('messages.find_job_friends') }}</h4>
    <div class="friend-lists">
        <div class="row gap-4">
            <form action="" method="GET">
                <input class="form-control me-2" name="filter" type="search"
                    placeholder="{{ __('messages.search_by_gender') }}" aria-label="Search">
            </form>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link {{ request()->get('filter') === null ? 'active' : '' }}" aria-current="page"
                        href="/">{{ __('messages.all') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->get('filter') === 'male' ? 'active' : '' }}"
                        href="/?filter=male">{{ __('messages.male') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->get('filter') === 'female' ? 'active' : '' }}"
                        href="/?filter=female">{{ __('messages.female') }}</a>
                </li>
            </ul>
            @foreach ($users as $user)
                <div class="card mb-3 col-md-4" style="width: calc(96%/3); padding: 0;">
                    <div class="row g-0" style="height: 100%;">
                        <div class="col-md-4">
                            <img src="{{ asset('assets/profile/cat-portrait.png') }}"
                                class="img-fluid rounded-start friend-profile" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title">{{ $user->username }}</h5>
                                    @if (auth()->check() && auth()->user()->isFriendWith($user))
                                        <form action="/friend/{{ $user->id }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn-like active">
                                                <i class="fa fa-thumbs-up"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="/friend/{{ $user->id }}" method="POST">
                                            @csrf
                                            @method('POST')

                                            <button type="submit" class="btn-like">
                                                <i class="fa fa-thumbs-up"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach ($user->works as $work)
                                        <span class="badge text-bg-primary">{{ $work->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layout>
