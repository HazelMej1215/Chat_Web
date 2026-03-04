<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-900 via-blue-800 to-blue-600">

        <div class="w-full max-w-md bg-white shadow-2xl rounded-2xl p-8">

            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-blue-700">💬 ChatApp</h1>
                <p class="text-gray-500 text-sm mt-1">Inicia sesión para continuar</p>
            </div>

            {{-- Mostrar contraseña generada tras registro --}}
            @if(session('generated_password'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl">
                <p class="text-green-700 font-semibold text-sm mb-1">✅ ¡Cuenta creada exitosamente!</p>
                <p class="text-gray-600 text-sm">Tu correo: <strong>{{ session('registered_email') }}</strong></p>
                <p class="text-gray-600 text-sm">Tu contraseña generada:</p>
                <div class="flex items-center gap-2 mt-2">
                    <code class="bg-gray-100 px-3 py-1 rounded-lg font-mono text-blue-700 text-lg font-bold tracking-widest flex-1 text-center">
                        {{ session('generated_password') }}
                    </code>
                    <button onclick="navigator.clipboard.writeText('{{ session('generated_password') }}')"
                            class="text-xs bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded-lg transition">
                        Copiar
                    </button>
                </div>
                <p class="text-xs text-red-500 mt-2">⚠️ Guarda esta contraseña, no se mostrará de nuevo.</p>
            </div>
            @endif

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <x-input-label for="email" :value="__('Correo electrónico')" />
                    <x-text-input id="email"
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        type="email"
                        name="email"
                        :value="old('email', session('registered_email'))"
                        required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="password" :value="__('Contraseña')" />
                    <x-text-input id="password"
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        type="password"
                        name="password"
                        required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition duration-200 text-base">
                    Iniciar Sesión
                </button>

                <div class="text-center mt-6">
                    <span class="text-sm text-gray-600">¿No tienes cuenta?</span>
                    <a href="{{ route('register') }}"
                       class="text-blue-600 hover:underline font-semibold ml-1">
                        Regístrate aquí
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
