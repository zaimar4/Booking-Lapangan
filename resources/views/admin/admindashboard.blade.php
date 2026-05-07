@extends('layouts.layout')
@section('title', 'Dashboard Admin')
@section('content')

<div class="flex">
    <x-sidenavbar />
    
    <div class="flex-1 p-8 ml-60"> 
        <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

        
      <div class="flex flex-row gap-4">
    <div class="flex flex justify-center items-center bg-slate-400 rounded-xl border border-black px-2 py-4 ">
        <p>Total Lapangan : <span class="text-black fonnt-bold">{{ $totalLapangan }}</span></p>
    </div>

    <div class="flex flex justify-center items-center bg-slate-400 rounded-xl border border-black p-4">
        <p>Total Booking : <span class="text-black font-bold">{{ $totalLapangan }}</span></p> 
    </div>
</div>
       

    </div>
</div>

@endsection