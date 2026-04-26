@php
    $layout = auth()->user()->hasAnyRole(['admin', 'editor', 'writer']) ? 'layouts.admin' : 'layouts.blog';
@endphp

@extends($layout)

@section('title', 'Profil Saya - ' . config('app.name'))
@section('page_title', 'Pengaturan Profil')

@section('content')
<div class="{{ $layout == 'layouts.blog' ? 'max-w-3xl mx-auto px-4 sm:px-6 lg:px-8' : '' }} py-4">
    @if($layout == 'layouts.blog')
    <header class="mb-12 text-center">
        <h1 class="text-3xl font-extrabold font-heading text-gray-900 tracking-tight flex items-center justify-center gap-3">
             <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white italic shadow-lg shadow-blue-100 uppercase font-black text-xl">
                 {{ substr(Auth::user()->name, 0, 1) }}
             </div>
             Pengaturan Profil
        </h1>
        <p class="text-gray-500 mt-3 text-sm">Kelola informasi dasar akun dan keamanan kamu di sini.</p>
    </header>
    @endif

    <div class="space-y-10">
        <!-- Profile Info -->
        <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm transition hover:shadow-md">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Password Update -->
        <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm transition hover:shadow-md">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account -->
        <div class="bg-red-50/30 p-8 rounded-[2rem] border border-red-100 border-dashed transition hover:bg-red-50/50">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
