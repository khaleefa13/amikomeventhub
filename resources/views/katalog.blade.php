<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Event - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans text-gray-800">

    <div class="max-w-5xl mx-auto p-6 mt-10">
        
        <nav class="flex flex-wrap justify-center gap-4 mb-10">
            <a href="/home" class="px-5 py-2 bg-white text-blue-600 font-semibold rounded-lg shadow hover:bg-blue-600 hover:text-white transition duration-300">Home</a>
            <a href="/profil" class="px-5 py-2 bg-white text-purple-600 font-semibold rounded-lg shadow hover:bg-purple-600 hover:text-white transition duration-300">Profil</a>
            <a href="/katalog" class="px-5 py-2 bg-purple-600 text-white font-semibold rounded-lg shadow hover:bg-purple-700 transition duration-300">Katalog</a>
            <a href="/bantuan" class="px-5 py-2 bg-white text-purple-600 font-semibold rounded-lg shadow hover:bg-purple-600 hover:text-white transition duration-300">Bantuan</a>
            <a href="/kontak" class="px-5 py-2 bg-white text-purple-600 font-semibold rounded-lg shadow hover:bg-purple-600 hover:text-white transition duration-300">Kontak</a>
        </nav>

        <h1 class="text-3xl font-bold mb-8 text-center text-purple-700">AmikomEventHub</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <div class="h-40 bg-purple-200"></div>
                <div class="p-5">
                    <h3 class="font-bold text-lg mb-2">Seminar Teknologi AI</h3>
                    <p class="text-sm text-gray-600 mb-4">Membahas perkembangan AI di tahun 2024.</p>
                    <button class="bg-purple-100 text-purple-700 px-4 py-2 rounded font-medium hover:bg-purple-200 w-full transition">Detail Event</button>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <div class="h-40 bg-blue-200"></div>
                <div class="p-5">
                    <h3 class="font-bold text-lg mb-2">Workshop Laravel 11</h3>
                    <p class="text-sm text-gray-600 mb-4">Belajar framework Laravel dari dasar hingga mahir.</p>
                    <button class="bg-purple-100 text-purple-700 px-4 py-2 rounded font-medium hover:bg-purple-200 w-full transition">Detail Event</button>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <div class="h-40 bg-green-200"></div>
                <div class="p-5">
                    <h3 class="font-bold text-lg mb-2">Lomba E-Sports Mobile</h3>
                    <p class="text-sm text-gray-600 mb-4">Turnamen tahunan antar mahasiswa. Siapkan timmu!</p>
                    <button class="bg-purple-100 text-purple-700 px-4 py-2 rounded font-medium hover:bg-purple-200 w-full transition">Detail Event</button>
                </div>
            </div>

        </div>
    </div>
</body>
</html>