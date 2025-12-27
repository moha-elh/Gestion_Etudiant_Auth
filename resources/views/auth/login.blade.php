<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Firebase SDK -->
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/9.22.0/firebase-app.js";
        import { getAuth, GoogleAuthProvider, signInWithPopup } from "https://www.gstatic.com/firebasejs/9.22.0/firebase-auth.js";

        // TODO: REPLACE WITH YOUR CONFIG
        const firebaseConfig = {
            apiKey: "AIzaSyCLNnsYl5DfWTVz9N7g3KRQE6BKHXRTUWM",
            authDomain: "tpauth-7cc38.firebaseapp.com",
            projectId: "tpauth-7cc38",
            storageBucket: "tpauth-7cc38.firebasestorage.app",
            messagingSenderId: "349918824724",
            appId: "1:349918824724:web:9e6cadf441a9ffef00da01"
        };

        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const provider = new GoogleAuthProvider();

        window.signInWithGoogle = function() {
            signInWithPopup(auth, provider)
                .then((result) => {
                    const user = result.user;
                    user.getIdToken().then((idToken) => {
                        // Send token to backend
                        fetch("{{ route('auth.firebase') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({ id_token: idToken })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.href = data.redirect_url;
                            } else {
                                alert("Login failed: " + data.error);
                            }
                        })
                        .catch(error => console.error("Error:", error));
                    });
                })
                .catch((error) => {
                    console.error("Firebase Error:", error);
                    alert("Google Sign-In failed: " + error.message);
                });
        }
    </script>

    <div class="text-center">
        <h2 class="text-xl font-bold mb-6">Welcome to ENSAT App</h2>
        
        <button onclick="signInWithGoogle()" 
                class="w-full flex items-center justify-center bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-3 px-4 rounded-lg shadow-sm transition ease-in-out duration-150">
            <svg class="w-6 h-6 mr-3" viewBox="0 0 48 48">
                <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
            </svg>
            Sign in with Google
        </button>

        <div class="mt-6 border-t border-gray-200 pt-6">
             <p class="text-sm text-gray-500">Or use standard login below (for legacy accounts)</p>
        </div>
    </div>

    <!-- Keep existing form as fallback for now, maybe hide it later -->
    <div class="mt-6 opacity-50 hover:opacity-100 transition-opacity">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
    
                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
    
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
    
            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>
    
            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
    
                <x-primary-button class="ml-3">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
