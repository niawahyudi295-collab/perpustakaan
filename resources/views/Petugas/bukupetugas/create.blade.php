<style>
body {
    background: #f4f6f9;
    font-family: Arial, sans-serif;
}

.container {
    width: 500px;
    margin: 50px auto;
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 8px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

input:focus {
    border-color: #4a90e2;
    outline: none;
}

button {
    width: 100%;
    padding: 10px;
    background: #4CAF50;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
}

button:hover {
    background: #45a049;
}
</style>

<div class="container">
    <h2>Tambah Buku Baru</h2>

    <form action="{{ route('bukupetugas.create') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="judul" placeholder="Judul buku">
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <input type="text" name="kategori" placeholder="Kategori">
        </div>

        <div class="form-group">
            <label>Penulis</label>
            <input type="text" name="penulis" placeholder="Penulis">
        </div>

        <div class="form-group">
            <label>Penerbit</label>
            <input type="text" name="penerbit" placeholder="Penerbit">
        </div>

        <div class="form-group">
            <label>Tahun</label>
            <input type="number" name="tahun" placeholder="Tahun">
        </div>

        <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" placeholder="Jumlah stok">
        </div>

        <button type="submit">Simpan</button>
    </form>
</div>