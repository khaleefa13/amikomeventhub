<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-[2rem] shadow-xl border border-slate-100 overflow-hidden">
        <div class="p-8 text-center bg-indigo-600">
            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg text-indigo-600 font-black text-2xl">
                AH
            </div>
            <h2 class="text-2xl font-black text-white">AmikomEventHub</h2>
            <p class="text-indigo-200 text-sm font-medium mt-1">Silakan masuk ke panel admin</p>
        </div>

        <div class="p-8">
            <form action="{{ route('login.process') }}" method="POST" class="space-y-6">
                @csrf
                
                @error('email')
                <div class="p-4 bg-rose-50 text-rose-600 rounded-xl text-sm font-bold text-center border border-rose-100">
                    {{ $message }}
                </div>
                @enderror

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium text-slate-700">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider">Password</label>
                    <input type="password" name="password" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium text-slate-700">
                </div>

                <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-lg shadow-indigo-200 hover:bg-indigo-700 active:scale-95 transition-all">
                    Masuk ke Dashboard
                </button>
            </form>
        </div>
    </div>

</body>
</html>