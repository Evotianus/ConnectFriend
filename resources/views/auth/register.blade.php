<x-layout :title="$title" :auth="false">
    <div class="row justify-content-center">
        <div class="card p-3" style="width: 50%">
            <h3 class="mb-3">{{ __('messages.register_form') }}</h3>
            <form action="/register" method="POST" enctype="multipart/form-data" class="register-form">
                @csrf
                @method('POST')
                <input type="hidden" name="balance" class="calc-input" value="0">

                <div class="mb-3">
                    <label for="username" class="form-label">{{ __('messages.username') }}</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                        name="username" value="{{ old('username') }}">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('messages.email') }}</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('messages.password') }}</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <span class="form-label mb-2">{{ __('messages.gender') }}</span>
                <br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender"
                        id="radio-btn-male" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}>
                    <label class="form-check-label" for="radio-btn-male">{{ __('messages.male') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender"
                        id="radio-btn-female" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                    <label class="form-check-label" for="radio-btn-female">{{ __('messages.female') }}</label>
                </div>
                @error('gender')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror

                <div class="mb-3 mt-3">
                    <label for="phone" class="form-label">{{ __('messages.phone') }}</label>
                    <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone"
                        name="phone" value="{{ old('phone') }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="linkedin_url" class="form-label">{{ __('messages.linkedin_url') }}</label>
                    <input type="text" class="form-control @error('linkedin_url') is-invalid @enderror"
                        id="linkedin_url" name="linkedin_url" aria-describedby="emailHelp"
                        value="{{ old('linkedin_url') }}">
                    <small class="text-secondary">The input will be appended to the URL:
                        https://www.linkedin.com/in/[input]</small>
                    @error('linkedin_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="field_of_work" class="form-label">{{ __('messages.field_of_work') }}</label>
                    <div class="form-check">
                        <input class="form-check-input" name="field_of_work[]" type="checkbox" value="1"
                            id="web_dev">
                        <label class="form-check-label" for="web_dev">
                            {{ __('messages.web_developer') }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="field_of_work[]" type="checkbox" value="2"
                            id="mob_dev">
                        <label class="form-check-label" for="mob_dev">
                            {{ __('messages.mobile_developer') }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="field_of_work[]" type="checkbox" value="3"
                            id="des-dev">
                        <label class="form-check-label" for="des-dev">
                            {{ __('messages.desktop_developer') }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="field_of_work[]" type="checkbox" value="4"
                            id="dev_eng">
                        <label class="form-check-label" for="dev_eng">
                            {{ __('messages.devops_engineer') }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="field_of_work[]" type="checkbox" value="5"
                            id="dat_adm">
                        <label class="form-check-label" for="dat_adm">
                            {{ __('messages.database_administrator') }}
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label">{{ __('messages.profile') }}</label>
                    <input class="form-control @error('profile_url') is-invalid @enderror" name="profile_url"
                        type="file" id="formFile">
                    @error('profile_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- make divider --}}
                <hr>

                <div class="mb-3">
                    <h4>{{ __('messages.payment') }} :</h4>
                    <label for="payment">{{ __('messages.price') }}: {{ $registrationPrice }}</label>
                    <input class="form-control" type="number" name="payment" id="payment"
                        placeholder="{{ __('messages.input_amount_here') }}">
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        {{ __('messages.fix_errors') }}
                    </div>
                @endif

                <button type="button" class="btn btn-primary"
                    onclick="checkRegistrationPrice()">{{ __('messages.submit') }}</button>
            </form>
        </div>
    </div>
    <div class="warning">

    </div>
</x-layout>

<script>
    function checkRegistrationPrice() {
        const payment = document.getElementById('payment').value;
        const registrationPrice = {{ $registrationPrice }};
        const warningElement = document.querySelector('.warning');

        if (payment < registrationPrice) {
            alert(`You are still underpaid ${registrationPrice - payment}!`);
            event.preventDefault();
        } else if (payment > registrationPrice) {
            warningElement.innerHTML = `
                <div class="modal fade" id="overpaidModal" tabindex="-1" aria-labelledby="overpaidModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="overpaidModalLabel">Warning</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Sorry you overpaid ${payment - registrationPrice}, would you like to enter a balance?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="continueButton" onclick="submitBalance()">Yes</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            event.preventDefault();

            const overpaidModal = new bootstrap.Modal(document.getElementById('overpaidModal'));
            overpaidModal.show();

            document.getElementById('continueButton').addEventListener('click', function() {
                document.querySelector('form').submit();
            });
        }
    }

    function submitBalance() {
        const registerForm = document.querySelector('.register-form');
        const payment = document.getElementById('payment').value;
        const registrationPrice = {{ $registrationPrice }};
        const calcInput = document.querySelector('.calc-input');

        const balance = payment - registrationPrice;

        calcInput.value = balance;

        registerForm.submit();
    }
</script>
