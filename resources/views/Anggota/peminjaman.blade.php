@extends('Anggota.layouts')

@section('title', 'Peminjaman')
@section('header', 'PEMINJAMAN BUKU')

@section('content')

<style>
    .container {
        background: white;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 5px 10px rgba(0,0,0,0.1);
    }

    .judul {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th, table td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    table th {
        background: #b57aa1;
        color: white;
    }

    .btn {
        padding: 6px 15px;
        border-radius: 15px;
        text-decoration: none;
        color: white;
        font-size: 13px;
    }

    .btn-kembali {
        background: #4CAF50;
    }

    .btn-hapus {
        background: #e53935;
    }
</style>

<div class="container">

    <div class="judul">Daftar Peminjaman Buku</div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Denda</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
        @forelse($peminjaman as $i => $p)

            @php
                $today = \Carbon\Carbon::now();
                $tgl_kembali = \Carbon\Carbon::parse($p->tgl_kembali);

                $denda = 0;

                if($p->status == 'dipinjam' && $today->gt($tgl_kembali)) {
                    $terlambat = $today->diffInDays($tgl_kembali);
                    $denda = $terlambat * 1000;
                }
            @endphp

            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->judul }}</td>
                <td>{{ $p->tgl_pinjam }}</td>
                <td>{{ $p->tgl_kembali }}</td>

                <td>
                    @if($p->status == 'dipinjam')
                        <span style="color: orange;">Dipinjam</span>
                    @else
                        <span style="color: green;">Dikembalikan</span>
                    @endif
                </td>

                <td>
                    @if($denda > 0)
                        <span style="color:red;">
                            Rp {{ number_format($denda, 0, ',', '.') }}
                        </span>
                    @else
                        Rp 0
                    @endif
                </td>

                <td>
                    <a href="#" class="btn btn-kembali">Kembalikan</a>
                    <a href="#" class="btn btn-hapus">Hapus</a>
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="7">Belum ada data peminjaman</td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>

@endsection