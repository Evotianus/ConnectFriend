<x-layout :title="$title" :auth="$auth">
    <div class="card p-3">
        <h4>{{ __('messages.top_up_page') }}</h4>
        <form action="/payment" method="POST" class="d-flex">
            @csrf
            @method('POST')

            <button type="submit" class="btn btn-primary"
                style="width: 100%">{{ __('messages.top_up_100_coins') }}</button>
        </form>
    </div>
</x-layout>
