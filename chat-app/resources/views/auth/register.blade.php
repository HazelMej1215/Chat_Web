<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600">
        
        <div class="w-full max-w-md bg-white shadow-2xl rounded-2xl p-8">
            
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-blue-600">Crear Cuenta</h1>
                <p class="text-gray-500 text-sm">Tu contraseña será generada automáticamente</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Nombre')" />
                    <x-text-input id="name"
                        class="block mt-1 w-full rounded-lg"
                        type="text"
                        name="name"
                        required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Correo')" />
                    <x-text-input id="email"
                        class="block mt-1 w-full rounded-lg"
                        type="email"
                        name="email"
                        required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
                    Registrarme
                </button>

                <div class="text-center mt-6">
                    <span class="text-sm text-gray-600">¿Ya tienes cuenta?</span>
                    <a href="{{ route('login') }}"
                       class="text-blue-600 hover:underline font-semibold">
                        Inicia sesión
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>