<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans text-gray-800">

    <div class="max-w-5xl mx-auto p-6 mt-10">

        <nav class="flex flex-wrap justify-center gap-4 mb-10">
            <a href="/home" class="px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition duration-300">Home</a>
            <a href="/profil" class="px-5 py-2 bg-white text-blue-600 font-semibold rounded-lg shadow hover:bg-blue-600 hover:text-white transition duration-300">Profil</a>
            <a href="/katalog" class="px-5 py-2 bg-white text-blue-600 font-semibold rounded-lg shadow hover:bg-blue-600 hover:text-white transition duration-300">Katalog</a>
            <a href="/bantuan" class="px-5 py-2 bg-white text-blue-600 font-semibold rounded-lg shadow hover:bg-blue-600 hover:text-white transition duration-300">Bantuan</a>
            <a href="/kontak" class="px-5 py-2 bg-white text-blue-600 font-semibold rounded-lg shadow hover:bg-blue-600 hover:text-white transition duration-300">Kontak</a>
        </nav>

        <div class="bg-white p-8 md:p-12 rounded-xl shadow-lg border-t-4 border-blue-500">
            
            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold mb-4 text-gray-900">Selamat Datang di AmikomEventHub!</h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Platform pusat untuk menemukan dan mengelola event-event menarik di kampus. Jelajahi katalog, temukan event favoritmu, dan mari berpartisipasi aktif!
                </p>
            </div>

            <div class="flex flex-col md:flex-row items-center justify-center bg-blue-50/50 border border-blue-100 p-6 rounded-xl mb-10 shadow-sm">
                <div class="w-16 h-16 bg-blue-200 rounded-full flex items-center justify-center text-blue-700 font-bold text-xl shadow-inner mb-4 md:mb-0 md:mr-6">
                    MK </div>
                <div class="text-center md:text-left">
                    <p class="text-sm text-gray-500 font-medium mb-1">Login sebagai Praktikan:</p>
                    <h2 class="text-2xl font-bold text-gray-800">Muhammad Dihya Khalifa</h2>
                    <p class="text-blue-600 font-semibold">NIM: 24.12.3272</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="/profil" class="block p-6 bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md hover:border-blue-300 hover:bg-blue-50 transition duration-300 group">
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 group-hover:text-blue-700">Profil Lengkap &rarr;</h5>
                    <p class="text-gray-600 text-sm">Lihat dan lengkapi data diri Anda sebagai praktikan di sistem ini.</p>
                </a>
                
                <a href="/katalog" class="block p-6 bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md hover:border-blue-300 hover:bg-blue-50 transition duration-300 group">
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 group-hover:text-blue-700">Jelajahi Katalog &rarr;</h5>
                    <p class="text-gray-600 text-sm">Temukan puluhan event dan seminar menarik yang akan datang.</p>
                </a>
                
                <a href="/bantuan" class="block p-6 bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md hover:border-blue-300 hover:bg-blue-50 transition duration-300 group">
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 group-hover:text-blue-700">FAQ & Bantuan &rarr;</h5>
                    <p class="text-gray-600 text-sm">Cari jawaban untuk pertanyaan umum seputar pendaftaran event.</p>
                </a>
            </div>

        </div>
    </div>
</body>
</html>