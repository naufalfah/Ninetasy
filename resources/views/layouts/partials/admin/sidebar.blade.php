<aside class="w-82 shrink-0">
    <div class="w-82 fixed top-32 bottom-0 left-0 flex flex-col justify-between p-8 bg-white shadow-2xl shadow-black/50 rounded-tr-[70px]">
        {{-- Menu List --}}
        <div class="flex flex-col gap-8 overflow-y-auto">

            {{-- Utama --}}
            <div class="flex flex-col gap-4">
                <span class="block text-sm font-bold text-gray-600">Utama</span>

                {{-- Dashboard --}}
                <div class="flex flex-col gap-5">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-10 py-2 px-4 rounded-lg transition duration-300 {{ request()->routeIs('admin.dashboard')
                        ? 'bg-gray-300 font-semibold'
                        : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                        <img src="{{ asset('images/icon/dashboard.png') }}" width="25px" alt=""> Dashboard
                    </a>
                </div>

                {{-- Produk --}}
                <div class="flex flex-col gap-5">
                    <a href="{{ route('admin.produk.index') }}" class="flex items-center gap-10 py-2 px-4 rounded-lg transition duration-300 {{ request()->routeIs('admin.produk.*')
                        ? 'bg-gray-300 font-semibold'
                        : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                        <img src="{{ asset('images/icon/produk.png') }}" width="25px" alt=""> Produk    
                    </a>
                </div>
            </div>

            {{-- Menu --}}
            <div class="flex flex-col gap-4">
                <span class="block text-sm font-bold text-gray-600">Menu</span>

                {{-- Kategori --}}
                <div class="flex flex-col gap-5">
                    <a href="{{ route('admin.kategori.index') }}" class="flex items-center gap-10 py-2 px-4 rounded-lg transition duration-300 {{ request()->routeIs('admin.kategori.*')
                        ? 'bg-gray-300 font-semibold'
                        : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                        <img src="{{ asset('images/icon/kategori.png') }}" width="25px" alt=""> Kategori
                    </a>
                </div>

                {{-- Users --}}
                <div class="flex flex-col gap-5">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-10 py-2 px-4 rounded-lg transition duration-300 {{ request()->routeIs('admin.users.*')
                        ? 'bg-gray-300 font-semibold'
                        : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                        <img src="{{ asset('images/icon/users.png') }}" width="25px" alt=""> Data User
                    </a>
                </div>
            </div>
        </div>

        {{-- Logout --}}
        <form action="{{ route('logout') }}" method="POST" class="mt-6 shrink-0">
            @csrf
            <button type="submit" class="w-full rounded-lg bg-red-600 px-4 py-2 text-center font-semibold text-white transition hover:bg-red-800 cursor-pointer transition duration-300">
                Logout
            </button>
        </form>
    </div>
</aside>
