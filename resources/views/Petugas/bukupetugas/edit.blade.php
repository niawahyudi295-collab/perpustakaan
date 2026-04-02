<form action="{{ route('bukupetugas.edit', $buku->id) }}" method="POST" class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-md">
    @csrf
    @method('PUT')

    <h2 class="text-2xl font-bold text-center mb-6 text-[#5C7F9C]">Edit Buku</h2>

    <!-- Judul -->
    <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-1" for="judul">Judul</label>
        <input type="text" name="judul" id="judul" value="{{ $buku->judul }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    <!-- Kategori -->
    <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-1" for="kategori">Kategori</label>
        <input type="text" name="kategori" id="kategori" value="{{ $buku->kategori }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    <!-- Penulis -->
    <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-1" for="penulis">Penulis</label>
        <input type="text" name="penulis" id="penulis" value="{{ $buku->penulis }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    <!-- Penerbit -->
    <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-1" for="penerbit">Penerbit</label>
        <input type="text" name="penerbit" id="penerbit" value="{{ $buku->penerbit }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    <!-- Tahun -->
    <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-1" for="tahun">Tahun</label>
        <input type="number" name="tahun" id="tahun" value="{{ $buku->tahun }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    <!-- Stok -->
    <div class="mb-6">
        <label class="block text-gray-700 font-medium mb-1" for="stok">Stok</label>
        <input type="number" name="stok" id="stok" value="{{ $buku->stok }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    <!-- Submit Button -->
    <div class="text-center">
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg transition-colors">
            Update
        </button>
    </div>
</form>