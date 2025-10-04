<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwipeApp</title>
    @vite([
        'resources/css/welcome.css',
        'resources/css/sidebar.css',
        'resources/js/welcome.js'
    ])
</head>
<body>
    <!-- Sidebar toggle button -->
    <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <h2>Klikšķis</h2>
        <nav>
            <a href="/">Sākums</a>
            @guest
                <a href="{{ route('register.form') }}">Reģistrēties</a>
                <a href="{{ route('login.form') }}">Ielogoties</a>
            @endguest
            <a href="#" class="highlight-link">FreakClick</a>
            <a href="#">Čati</a>
            <a href="#">Profils</a>
            @auth
                <form action="{{ route('logout') }}" method="POST" style="margin-top:320px; text-align:center; font-size:30px">
                    <p style="margin:10px 0;">Sveiks, {{ auth()->user()->first_name }}!</p>
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
        <!-- Header -->
        <header class="header">
            <div class="container">
                <a href="/" class="logo">
                    <img src="{{ asset('storage/Screenshot_2025-10-04_172333-removebg-preview.png') }}" alt="Klikšķis logo" style="height:60px;">
                </a>
                <nav class="nav">
                    <a href="/">Sākums</a>
                    @guest
                        <a href="{{ route('login.form') }}">Ielogoties</a>
                        <a href="{{ route('register.form') }}">Reģistrēties</a>
                    @endguest
                    @auth
                        <a href="{{ route('profile.edit') }}">Profils</a>
                    @endauth
                </nav>
            </div>
        </header>

        <section class="cards-section">
            <div class="cards-container">
                <div class="card">
                    <div class="card-images">
                        <img src="{{ asset('storage/461710730_8378060218974229_7977418704910948490_n.jpg') }}" class="active" alt="Bild1">
                        <img src="{{ asset('storage/garumins.png') }}" alt="Bild2">
                        <button class="prev">⟨</button>
                        <button class="next">⟩</button>
                        <div class="image-indicators"></div> <!-- šis bija jāpieliek -->

                    </div>
                    <div class="card-info">
                        <h3>Roberts Mačs, 22</h3>
                        <p>Intereses: Basketbols, zem tupeles, maisini</p>
                    </div>
                    <div class="card-actions">
                        <button class="dislike">✖</button>
                        <button class="like">❤</button>
                    </div>
                </div>
                <!-- Card 1 -->
                <div class="card">
                    <div class="card-images">
                        <img src="{{ asset('storage/download.jpg') }}" class="active" alt="Bild1">
                        <img src="{{ asset('storage/images.jpg') }}" alt="Bild2">
                        <button class="prev">⟨</button>
                        <button class="next">⟩</button>
                        <div class="image-indicators">
                            <span class="indicator active"></span>
                            <span class="indicator"></span>
                        </div>
                    </div>
                    <div class="card-info">
                        <h3>Anna, 16</h3>
                        <p>Intereses: Aldis Zabadskis, Roberts Mačs, Fitness</p>
                    </div>
                    <div class="card-actions">
                        <button class="dislike">✖</button>
                        <button class="like">❤</button>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="card">
                    <div class="card-images">
                        <img src="{{ asset('storage/C492C96C-89EB-4CC3-9675-3B0A3046610A.png') }}" class="active" alt="Bild1">
                        <img src="{{ asset('storage/F30ED56D-6903-4B5F-8AE7-3404FB69F2B9.png') }}" alt="Bild2">
                        <img src="{{ asset('storage/F30E54C2-1D74-4AB1-B461-47C92887C7B6.png') }}" alt="Bild3">
                        <img src="{{ asset('storage/BD9F46B9-C41B-4AC3-A7E0-F2B8AC03679C.png') }}" alt="Bild4">
                        <button class="prev">⟨</button>
                        <button class="next">⟩</button>
                        <div class="image-indicators">
                            <span class="indicator active"></span>
                            <span class="indicator"></span>
                            <span class="indicator"></span>
                            <span class="indicator"></span>
                        </div>
                    </div>
                    <div class="card-info">
                        <h3>Aldis Zabadskis, 67</h3>
                        <p>Intereses: Freak, kefīrs, dj bobo</p>
                    </div>
                    <div class="card-actions">
                        <button class="dislike">✖</button>
                        <button class="like">❤</button>
                    </div>
                </div>

                <!-- Card 3 -->
                
            </div>
        </section>

        <!-- Footer -->
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
