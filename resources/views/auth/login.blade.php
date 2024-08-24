<x-layout :title="$title" :auth="false">
    <div class="row justify-content-center">
        <div class="card p-3" style="width: 50%">
            <h3>{{ __('messages.login_form') }}</h3>
            <form action="/login" method="POST">
                @csrf
                @method('POST')

                <div class="mb-3">
                    <label for="username" class="form-label">{{ __('messages.username') }}</label>
                    <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp"
                        value="{{ old('username') }}">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('messages.password') }}</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                @if ($errors->has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ __('messages.error') }}
                    </div>
                @endif
                <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
            </form>
        </div>
    </div>
</x-layout>
