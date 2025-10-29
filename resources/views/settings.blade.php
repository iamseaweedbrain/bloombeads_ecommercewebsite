@extends('layouts.app')

@section('title', 'Account Settings')

@section('content')
<div class="bg-white min-h-screen text-gray-800">
    <!-- Header -->
    <header class="flex items-center justify-between px-10 py-4 border-b shadow-sm">
        <h1 class="text-2xl font-extrabold text-pink-500">Bloombeads</h1>
        <nav class="space-x-6 text-gray-700 font-medium">
            <a href="{{ route('dashboard') }}" class="hover:text-pink-500">Dashboard</a>
            <a href="{{ route('logout') }}" class="hover:text-pink-500">Logout</a>
        </nav>
    </header>

    <div class="max-w-3xl mx-auto mt-10">
        <h2 class="text-3xl font-bold text-gray-700 mb-6">Account Settings</h2>

        <!-- Success / Error Messages -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded-lg mb-4">{{ session('error') }}</div>
        @endif

        <!-- PROFILE UPDATE FORM -->
        <div class="bg-gray-50 p-6 rounded-2xl shadow mb-8">
            <h3 class="text-xl font-semibold mb-4 text-pink-500">Profile Information</h3>

            <form method="POST" action="{{ route('settings.profile.update') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Full Name</label>
                    <input type="text" name="fullName" value="{{ old('fullName', session('user')->fullName ?? '') }}" 
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-pink-400">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', session('user')->email ?? '') }}" 
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-pink-400">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Phone (optional)</label>
                    <input type="text" name="phone" value="{{ old('phone', session('user')->phone ?? '') }}" 
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-pink-400">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Birthday (optional)</label>
                    <input type="date" name="birthday" value="{{ old('birthday', session('user')->birthday ?? '') }}" 
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-pink-400">
                </div>

                <button type="submit" 
                    class="bg-pink-500 hover:bg-pink-600 text-white font-medium px-5 py-2 rounded-lg transition">
                    Update Profile
                </button>
            </form>
        </div>

        <!-- PASSWORD UPDATE FORM -->
        <div class="bg-gray-50 p-6 rounded-2xl shadow">
            <h3 class="text-xl font-semibold mb-4 text-pink-500">Change Password</h3>

            <form method="POST" action="{{ route('settings.password.update') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Current Password</label>
                    <input type="password" name="current_password" 
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-pink-400">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">New Password</label>
                    <input type="password" name="new_password" 
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-pink-400">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" 
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-pink-400">
                </div>

                <button type="submit" 
                    class="bg-pink-500 hover:bg-pink-600 text-white font-medium px-5 py-2 rounded-lg transition">
                    Update Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
