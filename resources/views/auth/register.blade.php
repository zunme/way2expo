<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
          <div class="login-brand">
            <img src="/image/fav180.png" alt="logo" width="100" class="shadow-light " style="background-color: #ffffff;box-shadow: 0 5px 8px #c3d5e4;border-radius:50%;">
          </div>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label value="{{ __('이름') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('이메일') }}" />
                <x-jet-input class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>
            <div class="mt-4">
                <x-jet-label value="{{ __('전화번호') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="tel" :value="old('tel')"  />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('암호') }}" />
                <x-jet-input class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('암호 확인') }}" />
                <x-jet-input class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>
            <div class="mt-4">
                <x-jet-label value="SMS 수신 동의" />
                <div class="flex">
                  <label style="margin-left:10px;margin-right:10px;">
                    <input type="radio" class="form-checkbox" name="agree_sms" value="Y" required>
                      <span class="ml-2 text-sm text-gray-600">동의</span>
                  </label>
                  <label>
                    <input type="radio" class="form-checkbox"  name="agree_sms" value="N">
                      <span class="ml-2 text-sm text-gray-600">비동의</span>
                  </label>
                </div>
            </div>
            <div class="mt-4">
                <x-jet-label value="Email 수신 동의" />
                <div class="flex">
                  <label style="margin-left:10px;margin-right:10px;">
                    <input type="radio" class="form-checkbox" name="agree_email" value="Y" required>
                      <span class="ml-2 text-sm text-gray-600">동의</span>
                  </label>
                  <label>
                    <input type="radio" class="form-checkbox"  name="agree_email" value="N">
                      <span class="ml-2 text-sm text-gray-600">비동의</span>
                  </label>
                </div>
            </div>
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('이미 회원가입을 하셨습니까?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('회원가입') }}
                </x-jet-button>
            </div>

        </form>
    </x-jet-authentication-card>
</x-guest-layout>
