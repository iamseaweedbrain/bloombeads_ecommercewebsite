<x-layout>
    <div class="p-8">
        <h1 class="text-2xl font-bold mb-4">Hello, {{ session('user')->fullName }}</h1>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="py-2 px-4 bg-red-500 text-white rounded hover:bg-red-600 transition">
                Logout
            </button>
        </form>
    </div>
</x-layout>
