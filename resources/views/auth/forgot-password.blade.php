<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
          <div style="margin-top:50px;">
              <a href="/">
                <img src="/image/fav180.png" alt="logo" width="100" class="shadow-light rounded-circle" style="background-color: #ffffff;box-shadow: 0 5px 8px #c3d5e4;border-radius:50%;">
              </a>
          </div>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            비밀번호를 잊어버리셨습니까?
            <br>
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-jet-label value="{{ __('Email') }}" />
                <x-jet-input class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    비밀번호 변경 이메일 보내기
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
