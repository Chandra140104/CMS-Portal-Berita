<div class="flex flex-col justify-between fixed left-0 top-0 w-64 h-full bg-blue-900 p-4">
    <div>
        <a href="{{ route('admin') }}" class="flex item-center pb-4 border-b border-b-gray-800">
            <img src="/images/favicon2.png" alt="Portal Berita Logo" class="w-7 h-7 object-cover">
            <span class="text-lg font-bold text-white ml-3">BNN Kota Kediri</span>
        </a>

        <ul class="mt-4">

            {{-- DASHBOARD --}}
            <li class="mb-1">
                <a href="{{ route('admin') }}"
                   class="flex item-center py-2 px-4 text-gray-300 hover:text-gray-100 hover:bg-gray-950 rounded-md">
                    <svg class="mr-2 w-5 h-5" fill="none" stroke-width="1.5" stroke="currentColor"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12
                                 M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875
                                 c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504
                                 1.125 1.125V21h4.125c.621 0 1.125-.504
                                 1.125-1.125V9.75M8.25 21h8.25"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- BERITA (ADMIN & EDITOR) --}}
            <li class="mb-1">
                <a href="{{ route('berita') }}"
                   class="flex item-center py-2 px-4 text-gray-300 hover:text-gray-100 hover:bg-gray-950 rounded-md">
                    <svg class="mr-2 w-5 h-5" fill="none" stroke-width="1.5" stroke="currentColor"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5
                                 m-7.5 3h7.5m3-9h3.375
                                 c.621 0 1.125.504 1.125 1.125V18
                                 a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18
                                 a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875
                                 c0-.621-.504-1.125-1.125-1.125H4.125
                                 C3.504 3.75 3 4.254 3 4.875V18
                                 a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z"/>
                    </svg>
                    <span>Berita</span>
                </a>
            </li>

            {{-- KATEGORI (DITAMPILKAN UNTUK ADMIN & EDITOR - VIEW ONLY UNTUK EDITOR) --}}
            <li class="mb-1">
                <a href="{{ route('kategori') }}"
                   class="flex item-center py-2 px-4 text-gray-300 hover:text-gray-100 hover:bg-gray-950 rounded-md">
                    <svg class="mr-2 w-5 h-5" fill="none" stroke-width="1.5" stroke="currentColor"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9.568 3H5.25
                                 A2.25 2.25 0 0 0 3 5.25v4.318
                                 c0 .597.237 1.17.659 1.591l9.581 9.581
                                 c.699.699 1.78.872 2.607.33
                                 a18.095 18.095 0 0 0 5.223-5.223
                                 c.542-.827.369-1.908-.33-2.607
                                 L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6 6h.008v.008H6V6Z"/>
                    </svg>
                    <span>Kategori</span>
                </a>
            </li>

            {{-- LAPORAN KASUS (ADMIN ONLY) --}}
            @if(auth()->check() && auth()->user()->role === 'admin')
                <li class="mb-1">
                    <a href="{{ route('admin.laporan-kasus.index') }}"
                       class="flex item-center py-2 px-4 text-gray-300 hover:text-gray-100 hover:bg-gray-950 rounded-md">
                        <svg class="mr-2 w-5 h-5" fill="none" stroke-width="1.5" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19.5 14.25v-2.625
                                     a3.375 3.375 0 0 0-3.375-3.375h-1.5
                                     A1.125 1.125 0 0 1 13.5 7.125v-1.5
                                     A3.375 3.375 0 0 0 10.125 2.25H8.25
                                     A3.375 3.375 0 0 0 4.875 5.625v12.75
                                     A3.375 3.375 0 0 0 8.25 21.75h3.375"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M16.5 21.75 21 17.25
                                     m0 0-4.5-4.5M21 17.25H10.5"/>
                        </svg>
                        <span>Laporan Kasus</span>
                    </a>
                </li>
            @endif

            {{-- PENGGUNA (ADMIN ONLY) --}}
            @if(auth()->check() && auth()->user()->role === 'admin')
                <li class="mb-1">
                    <a href="{{ route('pengguna') }}"
                       class="flex item-center py-2 px-4 text-gray-300 hover:text-gray-100 hover:bg-gray-950 rounded-md">
                        <svg class="mr-2 w-5 h-5" fill="none" stroke-width="1.5" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15.75 6a3.75 3.75 0 1 1-7.5 0
                                     3.75 3.75 0 0 1 7.5 0ZM4.501 20.118
                                     a7.5 7.5 0 0 1 14.998 0
                                     A17.933 17.933 0 0 1 12 21.75
                                     c-2.676 0-5.216-.584-7.499-1.632Z"/>
                        </svg>
                        <span>Pengguna</span>
                    </a>
                </li>
            @endif

        </ul>
    </div>

    {{-- LOGOUT --}}
    <form action="{{ route('logout') }}">
        @csrf
        <button type="submit"
                onclick="return confirm('Apakah anda yakin ingin keluar?')"
                class="flex item-center w-full py-2 px-4 text-gray-300 hover:text-gray-100 hover:bg-red-500 rounded-md">
            <svg class="mr-2 w-5 h-5" fill="none" stroke-width="1.5" stroke="currentColor"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6
                         a2.25 2.25 0 0 1 2.25 2.25v13.5
                         A2.25 2.25 0 0 1 16.5 21h-6
                         a2.25 2.25 0 0 1-2.25-2.25V15
                         m-3 0-3-3m0 0 3-3m-3 3H15"/>
            </svg>
            <span>Logout</span>
        </button>
    </form>
</div>
