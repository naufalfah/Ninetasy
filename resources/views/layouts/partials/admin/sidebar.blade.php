<aside class="w-56 md:w-64 lg:w-72 xl:w-80 shrink-0">
    <div class="w-56 md:w-64 lg:w-72 xl:w-80 fixed top-24 md:top-28 lg:top-32 bottom-0 left-0 flex flex-col justify-between p-4 md:p-6 lg:p-8 bg-white shadow-2xl shadow-black/50 rounded-tr-[50px] md:rounded-tr-[70px] z-20">
        {{-- Menu List --}}
        <div class="flex flex-col gap-6 md:gap-8 overflow-y-auto pr-1">

            {{-- Utama --}}
            <div class="flex flex-col gap-3 md:gap-4">
                <span class="block text-xs md:text-sm font-bold text-gray-500 uppercase tracking-wider">Utama</span>

                {{-- Dashboard --}}
                <div class="flex flex-col gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 md:gap-5 lg:gap-8 py-2 md:py-2.5 px-3 md:px-4 rounded-xl transition duration-300 {{ request()->routeIs('admin.dashboard')
                        ? 'bg-gray-300 font-semibold text-gray-900'
                        : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                        <img src="{{ asset('images/icon/dashboard.png') }}" class="w-5 h-5 md:w-6 md:h-6 object-contain shrink-0" alt="">
                        <span class="text-xs md:text-sm truncate">Dashboard</span>
                    </a>
                </div>

                {{-- Produk --}}
                <div class="flex flex-col gap-3">
                    <a href="{{ route('admin.produk.index') }}" class="flex items-center gap-3 md:gap-5 lg:gap-8 py-2 md:py-2.5 px-3 md:px-4 rounded-xl transition duration-300 {{ request()->routeIs('admin.produk.*')
                        ? 'bg-gray-300 font-semibold text-gray-900'
                        : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                        <img src="{{ asset('images/icon/produk.png') }}" class="w-5 h-5 md:w-6 md:h-6 object-contain shrink-0" alt="">
                        <span class="text-xs md:text-sm truncate">Produk</span>
                    </a>
                </div>
            </div>

            {{-- Menu --}}
            <div class="flex flex-col gap-3 md:gap-4">
                <span class="block text-xs md:text-sm font-bold text-gray-500 uppercase tracking-wider">Menu</span>

                {{-- Kategori --}}
                <div class="flex flex-col gap-3">
                    <a href="{{ route('admin.kategori.index') }}" class="flex items-center gap-3 md:gap-5 lg:gap-8 py-2 md:py-2.5 px-3 md:px-4 rounded-xl transition duration-300 {{ request()->routeIs('admin.kategori.*')
                        ? 'bg-gray-300 font-semibold text-gray-900'
                        : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                        <img src="{{ asset('images/icon/kategori.png') }}" class="w-5 h-5 md:w-6 md:h-6 object-contain shrink-0" alt="">
                        <span class="text-xs md:text-sm truncate">Kategori</span>
                    </a>
                </div>

                {{-- Users --}}
                <div class="flex flex-col gap-3">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 md:gap-5 lg:gap-8 py-2 md:py-2.5 px-3 md:px-4 rounded-xl transition duration-300 {{ request()->routeIs('admin.users.*')
                        ? 'bg-gray-300 font-semibold text-gray-900'
                        : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                        <img src="{{ asset('images/icon/users.png') }}" class="w-5 h-5 md:w-6 md:h-6 object-contain shrink-0" alt="">
                        <span class="text-xs md:text-sm truncate">Data User</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Logout --}}
        <form action="{{ route('logout') }}" method="POST" class="mt-4 md:mt-6 shrink-0">
            @csrf
            <button type="submit" class="w-full rounded-xl bg-red-600 px-3 md:px-4 py-2 md:py-2.5 text-center text-xs md:text-sm font-semibold text-white transition hover:bg-red-800 cursor-pointer shadow-xs active:scale-[0.98]">
                Logout
            </button>
        </form>
    </div>
</aside>
