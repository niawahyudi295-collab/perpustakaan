@extends('Anggota.layouts')

@section('title', 'Menu Buku')
@section('header', 'MENU BUKU')

@section('content')

<style>
body {
    background: linear-gradient(to bottom, #e9c6d3, #b57aa1);
    font-family: Arial, sans-serif;
}

/* SEARCH */
.search-container {
    display: flex;
    justify-content: center;
    margin: 30px 0;
}

.search-box {
    width: 60%;
    padding: 12px 20px;
    border-radius: 20px;
    border: 2px solid #4CAF50;
    outline: none;
}

/* GRID */
.buku-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 50px;
    padding: 20px 80px;
}

/* CARD */
.buku-card {
    display: flex;
    gap: 20px;
    align-items: center;
}

/* IMAGE */
.buku-card img {
    width: 120px;
    height: 170px;
    object-fit: cover;
}

/* TEXT */
.buku-info {
    font-size: 14px;
}

.buku-info p {
    margin: 5px 0;
}

.kategori {
    color: #a52a2a;
}

/* BUTTON */
.btn-pinjam {
    margin-top: 10px;
    padding: 8px 25px;
    background-color: #1e88e5;
    color: white;
    border: none;
    border-radius: 20px;
    cursor: pointer;
}

.btn-pinjam:hover {
    background-color: #1565c0;
}
</style>

<div class="search-container">
    <input type="text" class="search-box" placeholder="search">
</div>

<div class="buku-container">

    @foreach($buku as $b)
    <div class="buku-container">

    <!-- Buku 1 -->
    <div class="buku-card">
        <img src="/images/laskar.png" width="120">


        <div class="buku-info">
            <p><b>KATEGORI :</b></p>
            <p class="kategori">Fiksi</p>

            <p><b>JUMLAH BUKU :</b></p>
            <p>50</p>

            <button class="btn-pinjam">Pinjam</button>
        </div>
    </div>

    <!-- Buku 2 -->
    <div class="buku-card">
        <img src="/images/bumi.png" width="120">

        <div class="buku-info">
            <p><b>KATEGORI :</b></p>
            <p class="kategori">Fiksi</p>

            <p><b>JUMLAH BUKU :</b></p>
            <p>45</p>

            <button class="btn-pinjam">Pinjam</button>
        </div>
    </div>

</div>
    @endforeach

</div>

@endsection