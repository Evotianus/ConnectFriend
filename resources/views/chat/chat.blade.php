<x-layout :title="$title" :auth="$auth">
    <div class="card p-3">
        <div class="chat-header">
            <h5>{{ __('messages.chat_header') }} ({{ auth()->user()->username }} & {{ $friend->username }})</h5>
        </div>
        <hr>
        <div class="card chat-section p-3">
            <div class="messages-section d-flex flex-column-reverse mb-3 gap-2"
                style="height: 60vh; max-height: 60vh; overflow: auto;">
                @foreach ($chats as $chat)
                    @if ($chat->user_id == auth()->user()->id)
                        <div class="message text-bg-primary align-self-end"
                            style="padding: 0.5em; width: fit-content; border-radius: 8px; max-width: 30vw">
                            <span class="small" style="opacity: 0.7">{{ __('messages.from') }}:
                                {{ auth()->user()->username }}</span>
                            <br>
                            <span>{{ $chat->message }}</span>
                            <br>
                            <span class="small" style="opacity: 0.7">{{ __('messages.sent') }}:
                                {{ $chat->created_at->diffForHumans() }}</span>
                        </div>
                    @else
                        <div class="message text-bg-secondary"
                            style="padding: 0.5em; width: fit-content; border-radius: 8px; max-width: 30vw">
                            <span class="small" style="opacity: 0.7">{{ __('messages.from') }}:
                                {{ $friend->username }}</span>
                            <br>
                            <span>{{ $chat->message }}</span>
                            <br>
                            <span class="small" style="opacity: 0.7">{{ __('messages.sent') }}:
                                {{ $chat->created_at->diffForHumans() }}</span>
                        </div>
                    @endif
                @endforeach
            </div>
            <form action="/chat/{{ $friend->id }}" method="POST" class="d-flex" id="chatForm">
                @csrf
                @method('POST')

                <textarea name="message" id="messageTextarea" cols="10" rows="3" class="p-2" style="width: 100%"
                    placeholder="{{ __('messages.type_message') }}"></textarea>
            </form>
        </div>
</x-layout>

<script>
    document.getElementById('messageTextarea').addEventListener('keydown', function(event) {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            document.getElementById('chatForm').submit();
        }
    });
</script>
