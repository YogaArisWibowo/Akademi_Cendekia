<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
</head>

@include('layouts.style')
{{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

<body
    class="bg-[linear-gradient(135deg,_var(--tw-gradient-from),_var(--tw-gradient-to))] from-primary-ungu to-primary-biru flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-xl shadow-lg flex shadow-xl">
        <div class="w-1/2">
            <img alt="Image of a purple building with a sign that reads 'Sample Hotel'" class="rounded-l-xl w-96"
                src="{{ asset('img/png/amikom-1.jpg') }}" />
        </div>
        <div class="w-1/2 p-8">
            @auth
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="w-full bg-primary-biru text-white py-2 px-4 rounded-lg">Logout</button>
            </form>
            @else
            <a class="w-full bg-primary-ungu text-white py-2 px-4 rounded-lg mb-4 flex items-center justify-center"
                href="{{ route('redirect') }}">
                <i class="fab fa-google mr-2"></i>
                Sign in with Google
            </a>
            @endauth
            <div class="flex items-center my-4">
                <hr class="flex-grow border-t border-primary-ungu" />
                <span class="mx-2 text-primary-ungu">
                    Or
                </span>
                <hr class="flex-grow border-t border-primary-ungu" />
            </div>
            <form>
                <div class="mb-4">
                    <label class="block text-primary-ungu" for="email">
                        Email Address
                    </label>
                    <input class="w-full border border-primary-ungu rounded-lg py-2 px-4 mt-1" id="email"
                        type="email" />
                </div>
                <div class="mb-4">
                    <label class="block text-primary-ungu" for="password">
                        Password
                    </label>
                    <input class="w-full border border-primary-ungu rounded-lg py-2 px-4 mt-1" id="password"
                        type="password" />
                </div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <input class="mr-2" id="remember" type="checkbox" />
                        <label class="text-primary-ungu" for="remember">
                            Remember me
                        </label>
                    </div>
                    <a class="text-primary-ungu" href="#">
                        Forgot password?
                    </a>
                </div>
                <button class="w-full bg-primary-ungu text-white py-2 px-4 rounded-lg" type="submit">
                    Login
                </button>
            </form>
        </div>
        @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Membuat elemen div untuk pesan
                let toast = document.createElement('div');
                toast.textContent = "{{ session('error') }}";
                toast.style.position = 'fixed';
                toast.style.top = '-100px'; /* Mulai di luar layar */
                toast.style.left = '50%';
                toast.style.transform = 'translateX(-50%)';
                toast.style.zIndex = '9999';
                toast.style.backgroundColor = '#f44336'; /* Warna merah */
                toast.style.color = 'white';
                toast.style.padding = '15px 20px';
                toast.style.borderRadius = '5px';
                toast.style.boxShadow = '0px 2px 10px rgba(0, 0, 0, 0.2)';
                toast.style.fontSize = '16px';
                toast.style.fontWeight = 'bold';
                toast.style.transition = 'top 0.5s ease-out'; /* Animasi smooth */

                // Menambahkan elemen ke body
                document.body.appendChild(toast);

                // Memunculkan pesan dengan animasi
                setTimeout(() => {
                    toast.style.top = '20px'; /* Posisikan di layar */
                }, 100);

                // Menghilangkan pesan setelah 3 detik
                setTimeout(() => {
                    toast.style.transition = 'top 0.5s ease-in, opacity 0.5s ease-in';
                    toast.style.top = '-100px'; /* Kembali keluar layar */
                    toast.style.opacity = '0';
                    setTimeout(() => document.body.removeChild(toast), 500);
                }, 3000);
            });
        </script>
        @endif
    </div>
    <!-- Main JS -->
    @include('layouts.script')
</body>

</html>