<x-guest-layout>
    <x-jet-authentication-card>
        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <main class="bg-white max-w-lg mx-auto px-8 py-2 md:px-8 md:py-6 my-10 rounded-lg shadow-2xl">
            <!--
            <section>
                <p class="text-gray-900 pt-2 font-bold">Ingresa tu cuenta</p>
            </section>
            -->

            <section class="">
                <form class="flex flex-col" method="POST" action="{{ route('login') }}">
                    @csrf

                <div class="mt-4">
                    <x-jet-label value="{{ __('Usuario') }}" />
                
                    <x-jet-input class="block mt-1 w-full" type="text"  name="user" :value="old('user')" required autofocus />
                </div>
                <div class="mt-4">
                    <x-jet-label value="{{ __('Password') }}" />
                    <x-jet-input class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                </div>
                <div class="mt-6 w-full flex justify-end"> 
                    <button class="px-6 bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200" type="submit">Log in</button>
                </div>
                </form>
            </section>
        </main>
    </x-jet-authentication-card>
</x-guest-layout>
