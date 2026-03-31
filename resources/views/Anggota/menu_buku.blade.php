@extends('Anggota.layouts')

@section('title', 'Menu Buku')
@section('header', 'MENU BUKU')

@section('content')

<style>
    .search-container {
        display: flex;
        justify-content: center;
        margin-bottom: 40px;
    }

    .search-box {
        width: 60%;
        padding: 12px 20px;
        border-radius: 10px;
        border: 2px solid #4CAF50;
        outline: none;
    }

    .container-buku {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 60px;
    }

    .buku-item {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .buku-atas {
        display: flex;
        gap: 20px;
        align-items: center;
    }

    .buku-atas img {
        width: 130px;
        height: 190px;
        object-fit: cover;
        border-radius: 5px;
    }

    .detail {
        font-size: 14px;
    }

    .label {
        font-weight: bold;
        font-size: 13px;
    }

    .kategori {
        color: darkred;
        margin-bottom: 10px;
    }

    .judul {
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 10px;
    }

    .btn-pinjam {
        margin-top: 15px;
        background: #1e88e5;
        color: white;
        padding: 10px 30px;
        border-radius: 20px;
        text-decoration: none;
    }
</style>

<!-- SEARCH -->
<div class="search-container">
    <input type="text" class="search-box" placeholder="🔍 search">
</div>

<!-- LIST -->
<div class="container-buku">

@foreach($buku as $b)
    <div class="buku-item">

        <div class="buku-atas">

            <!-- GAMBAR (FIXED) -->
            @if($b->judul == 'Laskar Pelangi')
                <img src="{{ asset('images/Buku/laskar.png') }}">
            @elseif($b->judul == 'Bumi')
                <img src="{{ asset('images/Buku/bumi.png') }}">
            @endif

            <!-- DETAIL -->
            <div class="detail">
                <div class="judul">
                    {{ $b->judul ?? 'Tanpa Judul' }}
                </div>

                <div class="label">KATEGORI :</div>
                <div class="kategori">
                    {{ $b->kategori ?? 'Fiksi' }}
                </div>

                <div class="label">JUMLAH BUKU :</div>
                <div>
                    {{ $b->jumlah ?? '0' }}
                </div>

                <!-- OPTIONAL -->
                <div class="label">PENULIS :</div>
                <div>
                    {{ $b->penulis ?? 'Andrea' }}
                </div>

                <div class="label">TAHUN :</div>
                <div>
                    {{ $b->tahun ?? '2005' }}
                </div>
            </div>

        </div>

        <a href="/buku/pinjam/{{ $b->id_buku }}" class="btn-pinjam">
            Pinjam
        </a>

    </div>
@endforeach

</div>

@endsection