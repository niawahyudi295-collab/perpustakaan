@extends('Anggota.layouts')

@section('title', 'Profil Saya')
@section('header', 'PROFIL SAYA')

@section('content')

<div class="max-w-lg mx-auto">

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4 text-sm">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 text-red-600 px-4 py-3 rounded mb-4 text-sm">
            <ul class="list-disc pl-4">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    {{-- Form Edit --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="font-bold text-gray-700 mb-5">Edit Profil</h3>

        <form action="{{ route('anggota.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            {{-- Foto Profile --}}
            <div class="flex flex-col items-center mb-6">
                <div class="relative">
                    @if($user->foto)
                        <img id="fotoPreview" src="{{ asset('images/' . $user->foto) }}"
                             class="w-24 h-24 rounded-full object-cover border-4"
                             style="border-color:#b57ba6;">
                    @else
                        <div id="fotoPlaceholder" class="w-24 h-24 rounded-full flex items-center justify-center text-white text-3xl font-bold border-4"
                             style="background-color:#b57ba6; border-color:#b57ba6;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <img id="fotoPreview" src="" class="w-24 h-24 rounded-full object-cover border-4 hidden"
                             style="border-color:#b57ba6;">
                    @endif

                    {{-- Tombol kamera --}}
                    <label for="fotoInput" class="absolute bottom-0 right-0 w-7 h-7 rounded-full flex items-center justify-center cursor-pointer text-white text-xs"
                           style="background-color:#b57ba6;">
                        📷
                    </label>
                </div>
                <input type="file" id="fotoInput" name="foto" accept="image/*" class="hidden"
                       onchange="previewFoto(this)">
                <p class="text-xs text-gray-400 mt-2">Klik ikon kamera untuk ganti foto</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-purple-400"
                       required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-600 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-purple-400"
                       required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-600 mb-1">No. Telepon</label>
                <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-purple-400"
                       required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-600 mb-1">Alamat</label>
                <textarea name="alamat" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-purple-400"
                          required>{{ old('alamat', $user->alamat) }}</textarea>
            </div>

            <hr class="my-5">
            <p class="text-xs text-gray-400 mb-3">Kosongkan jika tidak ingin mengubah password.</p>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-600 mb-1">Password Baru</label>
                <input type="password" name="password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-purple-400"
                       placeholder="Masukkan password baru">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-600 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-purple-400"
                       placeholder="Ulangi password baru">
            </div>

            <button type="submit"
                    class="w-full py-2 text-white rounded-lg font-semibold text-sm hover:opacity-90"
                    style="background-color:#b57ba6;">
                Simpan Perubahan
            </button>
        </form>
    </div>

</div>

<script>
function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const preview     = document.getElementById('fotoPreview');
            const placeholder = document.getElementById('fotoPlaceholder');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection
