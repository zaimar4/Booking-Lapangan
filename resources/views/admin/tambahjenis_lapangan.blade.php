@extends('layouts.layout')

@section('title','Tambah Jenis Lapangan')

@section('content')
<div class="p-4 sm:p-6 max-w-xl mx-auto">

    <h1 class="text-2xl font-bold mb-6 text-gray-800">
        BUAT JENIS LAPANGAN ATAU KATEGORI LAPANGAN
    </h1>

    <div class="bg-white shadow-md rounded-lg p-6">

        <form action="{{ route('store-jenis') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="nama_jenis" class="block text-gray-700 font-medium mb-2">
                    Nama Jenis Lapangan
                </label>

                <input type="text"
                       name="nama_jenis"
                       id="nama_jenis"
                       required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg shadow">
                Simpan
            </button>

        </form>

    </div>

</div>
@endsection