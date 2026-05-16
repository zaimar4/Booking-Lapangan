@extends('layouts.layout')

@section('title', 'Profile')

@section('content')

<div class="p-4 sm:p-8">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-zinc-900">Profile</h1>
            <p class="text-zinc-500 text-sm mt-1">Kelola informasi akun dan keamanan kamu</p>
        </div>

        <div class="space-y-6">

            {{-- Update Profile Info --}}
            <div class="bg-white rounded-2xl border border-zinc-100 shadow-sm p-4 sm:p-8">
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- Update Password --}}
            <div class="bg-white rounded-2xl border border-zinc-100 shadow-sm p-4 sm:p-8">
                @include('profile.partials.update-password-form')
            </div>

            {{-- Delete Account --}}
            <div class="bg-white rounded-2xl border border-zinc-100 shadow-sm p-4 sm:p-8">
                @include('profile.partials.delete-user-form')
            </div>

        </div>
</div>

@endsection