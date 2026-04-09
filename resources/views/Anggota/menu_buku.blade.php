@extends('Anggota.layouts')

@section('title', 'Menu Buku')
@section('header', 'MENU BUKU')

@section('content')

{{-- Search --}}
<div class="flex justify-center mb-6">
    <input type="text" id="searchInput" placeholder="Cari judul buku..."
           class="w-2/3 px-5 py-3 rounded-full border-2 outline-none text-sm"
           style="border-color:#b57ba6;">
</div>

@if($jumlahDipinjam >= 2)
<div class="mb-5 px-4 py-3 rounded-lg text-sm font-semibold" style="background:#f8d7da; color:#721c24;">
    ⚠️ Anda sudah meminjam 2 buku. Kembalikan salah satu buku terlebih dahulu sebelum meminjam lagi.
</div>
@endif

{{-- Grid Buku --}}
<div class="grid grid-cols-3 gap-6 px-4" id="bukuGrid">
    @forelse($buku as $b)
    <div class="buku-card bg-white rounded-2xl p-4 flex gap-4 items-start shadow"
         data-judul="{{ strtolower($b->judul) }}">

        {{-- Cover --}}
        <div class="flex-shrink-0">
            @if($b->cover)
                <img src="{{ asset('images/' . $b->cover) }}" alt="{{ $b->judul }}"
                     class="rounded-lg object-cover"
                     style="width:110px; height:150px; object-fit:cover;">
            @else
                <div class="rounded-lg flex items-center justify-center text-4xl"
                     style="width:110px; height:150px; background:#f0e0ea;">📖</div>
            @endif
        </div>

        {{-- Info --}}
        <div class="flex-1 text-sm">
            <p class="font-bold text-gray-800 text-base mb-1">{{ $b->judul }}</p>
            <p class="text-gray-500 mb-1">{{ $b->penulis ?? $b->pengarang ?? '-' }}</p>

            <p class="text-xs text-gray-400 mb-1">
                <span class="font-semibold">Kategori:</span>
                <span style="color:#b57ba6;">{{ $b->kategori ?? '-' }}</span>
            </p>
            <p class="text-xs text-gray-400 mb-1">
                <span class="font-semibold">Penerbit:</span> {{ $b->penerbit ?? '-' }}
            </p>
            <p class="text-xs text-gray-400 mb-3">
                <span class="font-semibold">Stok:</span>
                <span class="{{ $b->stok > 0 ? 'text-green-600' : 'text-red-500' }} font-semibold">
                    {{ $b->stok > 0 ? $b->stok . ' tersedia' : 'Habis' }}
                </span>
            </p>

            @if($b->stok > 0 && $jumlahDipinjam < 2)
                <button onclick="window.location='{{ route('anggota.buku.pinjam', $b->id) }}'"
                        class="px-5 py-2 text-white rounded-full text-sm font-semibold hover:opacity-90 transition"
                        style="background-color:#b57ba6;">
                    Pinjam
                </button>
            @elseif($b->stok > 0 && $jumlahDipinjam >= 2)
                <span class="px-5 py-2 bg-gray-200 text-gray-400 rounded-full text-sm">Batas Pinjam</span>
            @else
                <span class="px-5 py-2 bg-gray-200 text-gray-400 rounded-full text-sm">Stok Habis</span>
            @endif
        </div>
    </div>
    @empty
    <div class="col-span-2 text-center text-gray-400 py-10">Belum ada buku tersedia.</div>
    @endforelse
</div>

{{-- Pesan tidak ditemukan --}}
<div id="notFound" class="hidden text-center text-gray-400 py-10">
    Buku tidak ditemukan.
</div>

<script>
document.getElementById('searchInput').addEventListener('input', function () {
    const keyword = this.value.toLowerCase();
    const cards   = document.querySelectorAll('.buku-card');
    let found = 0;

    cards.forEach(card => {
        const judul = card.dataset.judul || '';
        if (judul.includes(keyword)) {
            card.style.display = 'flex';
            found++;
        } else {
            card.style.display = 'none';
        }
    });

    document.getElementById('notFound').classList.toggle('hidden', found > 0);
});
</script>

@endsection
