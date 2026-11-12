<aside class="w-82">
    <div class="w-82 fixed top-32 bottom-0 left-0 flex flex-col justify-between p-8 bg-white shadow-2xl shadow-black/50 rounded-tr-[70px]">
        {{-- Transaksi --}}
        <div class="flex flex-col items-stretch gap-8 overflow-y-auto">

            {{-- Utama --}}
            <div class="flex flex-col gap-4">
                <span class="block text-sm font-bold text-gray-600">Utama</span>
                <div class="flex flex-col gap-5">
                    <a href="{{ route('user.transaksi.index') }}" class="flex items-center gap-10 py-2 px-4 rounded-lg transition duration-300 {{ request()->routeIs('user.transaksi.index')
                        ? 'bg-gray-300'
                        : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                        <img src="{{ asset('images/icon/transaksi.png') }}" width="25px" alt=""> Transaksi
                    </a>
                </div>
            </div>

            {{-- Menu --}}
            <div class="flex flex-col gap-4">
                <span class="block text-sm font-bold text-gray-600">Menu</span>
                <div class="flex flex-col gap-5">
                    <a href="{{ route('user.transaksi.riwayat') }}" class="flex items-center gap-10 bg-gray-100 py-2 px-4 rounded-lg hover:bg-gray-200 transition duration-300 {{ request()->routeIs('user.transaksi.riwayat')
                        ? 'bg-gray-200'
                        : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                        <img src="{{ asset('images/icon/riwayat.png') }}" width="25px" alt=""> Riwayat Transaksi
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