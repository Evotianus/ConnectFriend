<x-layout :title="$title" :auth="$auth">
    <div class="card p-3">
        <h4>{{ __('messages.notifications') }}</h4>
        <div class="d-flex flex-column gap-2">
            @foreach ($notifications as $notification)
                @if ($notification->notification_id == 1)
                    <div class="card">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="p-2">
                                    <i
                                        class="fa fa-user-plus text-primary"></i>&nbsp;&nbsp;&nbsp;{{ $notification->message }}
                                    -<small
                                        class="text-secondary">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="card-button">
                                    <form action="/notifications/{{ $notification->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-primary">
                                            <i class="fa fa-check"></i> Mark as Read
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif ($notification->notification_id == 2)
                    <div class="card">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="p-2">
                                    <i
                                        class="fa fa-comment text-primary"></i>&nbsp;&nbsp;&nbsp;{{ $notification->message }}
                                    -<small
                                        class="text-secondary">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="card-button">
                                    <form action="/notifications/{{ $notification->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-primary">
                                            <i class="fa fa-check"></i> Mark as Read
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</x-layout>
