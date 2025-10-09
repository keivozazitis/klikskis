<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klikšķis – Lietotāji</title>
    @vite([
        'resources/css/welcome.css',
        'resources/css/sidebar.css',
        'resources/js/main.js'
    ])
</head>
<body>
    <!-- Sidebar toggle -->
    <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <h2>Klikšķis</h2>
        <nav>
            <a href="" class="highlight-link">FreakClick</a>
            @guest
                <a href="{{ route('register.form') }}">Reģistrēties</a>
                <a href="{{ route('login.form') }}">Ielogoties</a>
            @endguest
            <a href="#">Čati</a>
            <a href="{{ route('profile.edit') }}">Profils</a>
            @auth
                <form action="{{ route('logout') }}" method="POST" style="margin-top:320px; text-align:center; font-size:30px">
                    <p style="margin:10px 0;">Sveiki, {{ auth()->user()->first_name }}!</p>
                    @csrf
                    <button type="submit" style="padding:16px 80px; font-size:20px; background:#9e36f4; color:white; border:none; border-radius:5px; cursor:pointer;">
                        Logout
                    </button>
                </form>
            @endauth
        </nav>
    </aside>

    <!-- Galvenais saturs -->
    <div class="main-content">
        <header class="header">
            <div class="container">
                <a href="" class="logo">
                    <img src="{{ asset('storage/Screenshot_2025-10-04_172333-removebg-preview.png') }}" alt="Klikšķis logo" style="height:60px;">
                </a>
                <nav class="nav">
                    
                    @auth
                        <a href="{{ route('profile.edit') }}">Profils</a>
                    @endauth
                </nav>
            </div>
        </header>

        <section class="cards-section">
            <div class="cards-container">
                @foreach ($users as $user)
                    <div class="card">
                        <div class="card-images">
                            @php
                                $images = $user->images ? json_decode($user->images, true) : [];
                            @endphp

                            @if(!empty($images))
                                @foreach($images as $i => $img)
                                    <img src="{{ asset('storage/' . $img) }}" 
                                         class="{{ $i === 0 ? 'active' : '' }}" 
                                         alt="Lietotāja bilde">
                                @endforeach
                            @else
                                <img src="{{ asset('storage/default-avatar.png') }}" class="active" alt="Bez bildes">
                            @endif

                            <button class="prev">⟨</button>
                            <button class="next">⟩</button>
                            <div class="image-indicators">
                                @foreach($images as $i => $img)
                                    <span class="indicator {{ $i === 0 ? 'active' : '' }}"></span>
                                @endforeach
                            </div>
                        </div>

                        <div class="card-info">
                            <h3>{{ $user->first_name }} {{ $user->last_name }}, 
                                {{ \Carbon\Carbon::parse($user->birth_date)->age }}</h3>
                            <p>
                                @if($user->bio)
                                    {{ $user->bio }}
                                @else
                                    <em>Nav apraksta</em>
                                @endif
                            </p>
                            <p><strong>Svars:</strong> {{ $user->weight ?? '-' }} kg</p>
                            <p><strong>Augums:</strong> {{ $user->augums ?? '-' }} cm</p>
                            <p><strong>Novads:</strong> {{ $user->region->name ?? '-' }}</p>
                        </div>

                        <div class="card-actions">
                            <button class="dislike">✖</button>
                            <button class="like">❤</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <footer class="footer">
            <p>&copy; {{ date('Y') }} Klikšķis. Visas tiesības paturētas.</p>
        </footer>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }
    </script>
</body>
</html>
