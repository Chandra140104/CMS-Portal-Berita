<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Lapor Kasus Narkoba</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,600&display=swap" rel="stylesheet" />

    @vite('resources/css/app.css')

    <style>
        * { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">

    <div class="max-w-4xl mx-auto px-4 py-10">
        <div class="flex items-center gap-3 mb-6">
            <img src="{{ asset('images/logo2.png') }}" class="w-10 h-10" alt="Logo">
            <div>
                <h1 class="text-2xl font-bold">Form Lapor Kasus Narkoba</h1>
                <p class="text-sm text-gray-500">Isi data dengan benar. Identitas pelapor akan dijaga.</p>
            </div>
        </div>

        {{-- SUCCESS --}}
        @if (session('success'))
            <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- ERROR SUMMARY --}}
        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                <div class="font-semibold mb-2">Terjadi kesalahan:</div>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('laporan-kasus.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-8">
            @csrf

            {{-- ===================== --}}
            {{-- IDENTITAS PELAPOR --}}
            {{-- ===================== --}}
            <div>
                <h2 class="text-lg font-semibold mb-4">Identitas Pelapor</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Nama Pelapor <span class="text-red-600">*</span></label>
                        <input type="text" name="pelapor_nama" value="{{ old('pelapor_nama') }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Nama lengkap" required>
                        @error('pelapor_nama') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Email Pelapor <span class="text-red-600">*</span></label>
                        <input type="email" name="pelapor_email" value="{{ old('pelapor_email') }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="contoh@email.com" required>
                        @error('pelapor_email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Nomor Telepon Pelapor <span class="text-red-600">*</span></label>
                        <input type="text" name="pelapor_telepon" value="{{ old('pelapor_telepon') }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Contoh: 081212345678" required>
                        @error('pelapor_telepon') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-1">Alamat Pelapor <span class="text-red-600">*</span></label>
                        <input type="text" name="pelapor_alamat" value="{{ old('pelapor_alamat') }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Nama jalan/gedung/lokasi, desa/kelurahan, kecamatan, kota, provinsi, kode pos" required>
                        @error('pelapor_alamat') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <hr>

            {{-- ===================== --}}
            {{-- IDENTITAS TERLAPOR --}}
            {{-- ===================== --}}
            <div>
                <h2 class="text-lg font-semibold mb-4">Identitas Terlapor</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Nama Terlapor <span class="text-red-600">*</span></label>
                        <input type="text" name="terlapor_nama" value="{{ old('terlapor_nama') }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Nama terlapor" required>
                        @error('terlapor_nama') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-1">Alamat Terlapor <span class="text-red-600">*</span></label>
                        <input type="text" name="terlapor_alamat" value="{{ old('terlapor_alamat') }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Nama jalan/gedung/lokasi, desa/kelurahan, kecamatan, kota, provinsi, kode pos" required>
                        @error('terlapor_alamat') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <hr>

            {{-- ===================== --}}
            {{-- UPLOAD FOTO --}}
            {{-- ===================== --}}
            <div>
                <h2 class="text-lg font-semibold mb-4">Upload Bukti (Opsional)</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Upload Foto Lokasi (jpg/png/webp, max 4MB)</label>
                        <input type="file" name="foto_lokasi" accept=".jpg,.jpeg,.png,.webp"
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        @error('foto_lokasi') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    
                </div>
            </div>

            <hr>

            {{-- ===================== --}}
            {{-- JENIS NARKOBA + JUMLAH --}}
            {{-- ===================== --}}
            <div>
                <h2 class="text-lg font-semibold mb-4">Informasi Narkoba</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Jenis Narkoba <span class="text-red-600">*</span></label>
                        <select name="jenis_narkoba" id="jenis_narkoba"
                                class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                            @php $jn = old('jenis_narkoba'); @endphp
                            <option value="">-- Pilih --</option>
                            @foreach (['Sabu','Ganja','Ekstasi','Heroin','Obat-obatan','Lainnya'] as $opt)
                                <option value="{{ $opt }}" {{ $jn === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                        @error('jenis_narkoba') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror

                        <div id="jenis_narkoba_lainnya_wrap" class="mt-3 hidden">
                            <label class="block text-sm font-medium mb-1">Keterangan Jenis Narkoba (Lainnya) <span class="text-red-600">*</span></label>
                            <input type="text" name="jenis_narkoba_lainnya" value="{{ old('jenis_narkoba_lainnya') }}"
                                   class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Tuliskan jenis narkoba lainnya">
                            @error('jenis_narkoba_lainnya') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Banyaknya/Jumlah Narkoba <span class="text-red-600">*</span></label>
                        <input type="text" name="jumlah_narkoba" value="{{ old('jumlah_narkoba') }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Contoh: 2 gram / 10 butir / 1 paket" required>
                        @error('jumlah_narkoba') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <hr>

            {{-- ===================== --}}
            {{-- PERAN + PROFESI + KANTOR --}}
            {{-- ===================== --}}
            <div>
                <h2 class="text-lg font-semibold mb-4">Informasi Terlapor</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Peran Terlapor <span class="text-red-600">*</span></label>
                        <select name="peran_terlapor" id="peran_terlapor"
                                class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                            @php $pt = old('peran_terlapor'); @endphp
                            <option value="">-- Pilih --</option>
                            @foreach (['Pengguna','Pengedar','Bandar','Kurir','Produsen','Lainnya'] as $opt)
                                <option value="{{ $opt }}" {{ $pt === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                        @error('peran_terlapor') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror

                        <div id="peran_terlapor_lainnya_wrap" class="mt-3 hidden">
                            <label class="block text-sm font-medium mb-1">Keterangan Peran (Lainnya) <span class="text-red-600">*</span></label>
                            <input type="text" name="peran_terlapor_lainnya" value="{{ old('peran_terlapor_lainnya') }}"
                                   class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Tuliskan peran lainnya">
                            @error('peran_terlapor_lainnya') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Profesi/Pekerjaan Terlapor <span class="text-red-600">*</span></label>
                        <input type="text" name="terlapor_profesi" value="{{ old('terlapor_profesi') }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Contoh: Wiraswasta / Pelajar / Karyawan" required>
                        @error('terlapor_profesi') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-1">Alamat Kantor Terlapor (Opsional)</label>
                        <input type="text" name="kantor_alamat" value="{{ old('kantor_alamat') }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Alamat kantor (jika ada)">
                        @error('kantor_alamat') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <hr>

            {{-- ===================== --}}
            {{-- KENDARAAN --}}
            {{-- ===================== --}}
            <div>
                <h2 class="text-lg font-semibold mb-4">Informasi Kendaraan</h2>

                <div>
                    <label class="block text-sm font-medium mb-1">Jenis Kendaraan & Nomor Plat <span class="text-red-600">*</span></label>
                    <input type="text" name="kendaraan_info_plat" value="{{ old('kendaraan_info_plat') }}"
                           class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Contoh: Motor Vario hitam N 1234 AB" required>
                    @error('kendaraan_info_plat') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <hr>

            {{-- ===================== --}}
            {{-- URAIAN --}}
            {{-- ===================== --}}
            <div>
                <h2 class="text-lg font-semibold mb-4">Detail Laporan</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Uraian Cara Pengedaran/Transaksi <span class="text-red-600">*</span></label>
                        <textarea name="uraian_transaksi" rows="4"
                                  class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Jelaskan kronologi / cara transaksi / pola peredaran" required>{{ old('uraian_transaksi') }}</textarea>
                        @error('uraian_transaksi') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Lokasi Penggunaan/Transaksi/Pengedaran <span class="text-red-600">*</span></label>
                        <textarea name="lokasi_transaksi" rows="3"
                                  class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Alamat lengkap / patokan lokasi" required>{{ old('lokasi_transaksi') }}</textarea>
                        @error('lokasi_transaksi') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Lokasi Terlapor Sering Terlihat <span class="text-red-600">*</span></label>
                        <textarea name="lokasi_sering_terlihat" rows="3"
                                  class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Contoh: warung A, kos B, kafe C" required>{{ old('lokasi_sering_terlihat') }}</textarea>
                        @error('lokasi_sering_terlihat') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Dari mana informasi didapat? <span class="text-red-600">*</span></label>
                        <textarea name="sumber_informasi" rows="3"
                                  class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Contoh: melihat langsung, info warga, rekan kerja, dll" required>{{ old('sumber_informasi') }}</textarea>
                        @error('sumber_informasi') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <hr>

            {{-- SUBMIT --}}
            <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
                <a href="{{ route('welcome') }}"
                   class="inline-flex justify-center rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                    Kembali ke Beranda
                </a>

                <button type="submit"
                        class="inline-flex justify-center rounded-lg bg-blue-700 px-6 py-2.5 text-sm font-semibold text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300">
                    Kirim Laporan
                </button>
            </div>
        </form>

        <p class="text-xs text-gray-400 mt-6">
            Catatan: Data yang Anda kirim akan digunakan untuk kebutuhan tindak lanjut. Harap isi dengan informasi yang valid.
        </p>
    </div>

    <script>
        // Toggle input "Lainnya"
        const jenisSelect = document.getElementById('jenis_narkoba');
        const jenisWrap = document.getElementById('jenis_narkoba_lainnya_wrap');

        const peranSelect = document.getElementById('peran_terlapor');
        const peranWrap = document.getElementById('peran_terlapor_lainnya_wrap');

        function toggleJenis() {
            if (jenisSelect.value === 'Lainnya') {
                jenisWrap.classList.remove('hidden');
            } else {
                jenisWrap.classList.add('hidden');
            }
        }

        function togglePeran() {
            if (peranSelect.value === 'Lainnya') {
                peranWrap.classList.remove('hidden');
            } else {
                peranWrap.classList.add('hidden');
            }
        }

        // init
        toggleJenis();
        togglePeran();

        // on change
        jenisSelect.addEventListener('change', toggleJenis);
        peranSelect.addEventListener('change', togglePeran);
    </script>
</body>
</html>
