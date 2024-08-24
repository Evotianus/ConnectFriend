<x-layout :title="$title" :auth="$auth">
    <div class="profile-section mb-3"></div>
    <div class="card p-3">
        <h4>{{ __('messages.friend_list') }}</h4>
        <ol class="list-group list-group-numbered">
            @if (count($friendList) > 0)
                @foreach ($friendList as $friend)
                    <div class="d-inline">
                        @if ($friend->status == 'pending')
                            <li class="list-group-item">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="detail">
                                        {{ $friend->username }} -&nbsp;<span
                                            class="badge text-bg-secondary">{{ __('messages.pending') }}</span>
                                    </div>
                                    <div class="chat">
                                        <a href="/chat/{{ $friend->id }}">
                                            <button class="btn btn-primary">
                                                <i class="fa fa-comments"></i>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @else
                            <li class="list-group-item">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="detail">
                                        {{ $friend->username }} -&nbsp;<small
                                            class="text-secondary">{{ __('messages.friend_since') }}
                                            {{ $friend->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="chat">
                                        <a href="/chat/{{ $friend->id }}">
                                            <button class="btn btn-primary">
                                                <i class="fa fa-comments"></i>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endif
                    </div>
                @endforeach
            @else
                <p>{{ __('messages.no_friends') }}</p>
            @endif
        </ol>
    </div>
</x-layout>
