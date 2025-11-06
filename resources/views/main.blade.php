<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klikšķis – Lietotāji</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        <h2>FreakClick</h2>
        <nav>
            <a href="{{ route('users.freakclick') }}" class="highlight-link">FreakClick</a>
            @guest
                <a href="{{ route('register.form') }}">Reģistrēties</a>
                <a href="{{ route('login.form') }}">Ielogoties</a>
            @endguest
            <a href="{{ route('chat.index') }}" class="highlight-link chat-link">Chat</a>
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

                        <!-- REPORT poga -->
                        <form action="{{ route('user.report', $user->id) }}" method="POST" class="report-form">
                            @csrf
                            <select name="reason" class="report-select" required>
                                <option value="" disabled selected>⚠️ Ziņot...</option>
                                <option value="underage">Persona izskatās nepilngadīga</option>
                                <option value="impersonation">Persona uzdodas par kādu citu</option>
                                <option value="pornographic">Pornogrāfisks saturs</option>
                            </select>
                            <button type="submit" class="report-btn">Submit</button>
                        </form>

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

                            <!-- 🟣 Tagi -->
                            @if(!empty($user->tags))
                                @php
                                    $tags = explode(',', $user->tags);
                                @endphp
                                <div class="user-tags" style="margin-top:10px; display:flex; flex-wrap:wrap; gap:6px;">
                                    @foreach($tags as $tag)
                                        <span style="
                                            background-color:#ad5ad6;
                                            color:white;
                                            padding:4px 10px;
                                            border-radius:20px;
                                            font-size:13px;
                                            display:inline-block;
                                        ">
                                            {{ trim($tag) }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Like / Dislike pogas -->
                        <div class="card-actions">
                            <button class="dislike">✖</button>
                            <button class="like-btn" onclick="likeUser({{ $user->id }}, this)">❤</button>
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

        function likeUser(id, btn) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
            fetch(`/users/${id}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                // Vizuālais update pēc Like / Match

                const card = btn.closest('.card');

                if (data.message.includes('Match')) {
                    // Match: pievieno vizuālo indikāciju
                    card.classList.add('matched');
                    btn.textContent = '💜 Matched';
                    btn.disabled = true;
                } else {
                    // Vienkāršs like: swipe animācija un noņemšana no DOM
                    card.style.transition = 'transform 0.5s ease, opacity 0.5s ease';
                    card.style.transform = 'translateX(100vw) rotate(15deg)';
                    card.style.opacity = 0;
                    setTimeout(() => card.remove(), 500);
                }
            })
            .catch(err => console.error(err));
        }

    </script>
</body>
</html>
