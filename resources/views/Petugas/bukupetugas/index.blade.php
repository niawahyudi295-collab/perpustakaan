@extends('petugas.layouts')

@section('content')
<style>
    body {
        background: #d8cfd3;
        font-family: sans-serif;
    }

    
    .header {
    width: 100%;
    margin: 0; /* HAPUS JARAK ATAS */
    background: #b06c93;
    color: white;
    text-align: center;
    padding: 20px;
    font-size: 28px;
    font-weight: bold;
}

    .container {
        width: 80%;
        margin: auto; /* INI YANG BIKIN TENGAH */
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 5px 10px rgba(0,0,0,0.1);
    }

    .btn-tambah {
        background: #eee;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        color: black;
        display: inline-block;
        margin-bottom: 15px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #a69ca2;
        color: white;
        padding: 12px;
    }

    td {
        background: #f9f9f9;
        padding: 10px;
        text-align: center;
    }

    tr:nth-child(even) td {
        background: #eee;
    }

    .btn-edit {
        background: #4da6ff;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 5px;
    }

    .btn-hapus {
        background: red;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .logout {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #ccc;
        padding: 15px 25px;
        border-radius: 20px;
        color: red;
        font-weight: bold;
        text-decoration: none;
    }
</style>

<div class="header">DATA BUKU</div>

<div class="container">

   <a href="{{ route('bukupetugas.create') }}" class="btn-tambah">+ Tambah Buku</a>
   
    <table>
        <tr>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Penulis</th>
            <th>Penerbit</th>
            <th>Tahun</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        @foreach($buku as $b)
        <tr>
            <td>{{ $b->judul }}</td>
            <td>{{ $b->kategori }}</td>
            <td>{{ $b->penulis }}</td>
            <td>{{ $b->penerbit }}</td>
            <td>{{ $b->tahun }}</td>
            <td>{{ $b->stok }}</td>
            <td>
                <a href="{{ route('bukupetugas.edit', $b->id) }}" class="btn-edit">Edit</a>

                <form action="{{ route('bukupetugas.destroy', $b->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn-hapus">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

</div>

<a href="/logout" class="logout">LOGOUT</a>

@endsection