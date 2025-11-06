<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreakClick</title>
    @vite([
        'resources/css/freakclick.css',
        'resources/js/main.js'
    ])
</head>
<body class="dark-theme">

    <!-- Main content -->
    <div class="main-content">
        <header class="header">
            <div class="container">
                <a href="{{ route('users.freakclick') }}" class="logo">
                    <img src="{{ asset('storage/Screenshot_2025-10-04_172333-removebg-preview.png') }}" 
                         alt="FreakClick logo" style="height:60px;">
                </a>
                <nav class="nav">
                    @auth
                        <a href="{{ route('profile.edit') }}"
                            href="{{ route('users.index') }}"
                        style="
                                background: linear-gradient(135deg, #000000, #7209b7);
                                color: #fff;
                                padding: 8px 20px;
                                border-radius: 12px;
                                text-decoration: none;
                                font-weight: bold;
                                box-shadow: 0 0 10px rgba(173, 90, 214, 0.7);
                                transition: 0.3s;
                                display: inline-block;
                        ">
                            Profils
                        </a>
                        <a href="{{ route('users.index') }}"
                        style="
                                background: linear-gradient(135deg, #000000, #7209b7);
                                color: #fff;
                                padding: 8px 20px;
                                border-radius: 12px;
                                text-decoration: none;
                                font-weight: bold;
                                box-shadow: 0 0 10px rgba(173, 90, 214, 0.7);
                                transition: 0.3s;
                                display: inline-block;
                        ">
                            Atpakaļ
                        </a>
                        
                    @endauth
                </nav>
            </div>
        </header>

        <h1 class="page-title">FreakClick Lietotāji</h1>

        <section class="cards-section">
            <div class="cards-container">
                @forelse ($users as $user)
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
                        </div>

                        <div class="card-info">
                            <h3>{{ $user->first_name }} {{ $user->last_name }}, 
                                {{ \Carbon\Carbon::parse($user->birth_date)->age }}</h3>
                            <p>{{ $user->bio ?? 'Nav apraksta' }}</p>
                            <p><strong>Svars:</strong> {{ $user->weight ?? '-' }} kg</p>
                            <p><strong>Augums:</strong> {{ $user->augums ?? '-' }} cm</p>
                            <p><strong>Novads:</strong> {{ $user->region->name ?? '-' }}</p>

                            @if(!empty($user->tags))
                                @php $tags = explode(',', $user->tags); @endphp
                                <div class="user-tags">
                                    @foreach($tags as $tag)
                                        <span class="tag">{{ trim($tag) }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="card-actions">
                            <button class="dislike">✖</button>
                            <button class="like">❤</button>
                        </div>
                    </div>
                @empty
                    <p class="no-users">Nav lietotāju ar FreakClick tagu.</p>
                @endforelse
            </div>
        </section>

        <footer class="footer">
            <p>&copy; {{ date('Y') }} FreakClick. Visas tiesības paturētas.</p>
        </footer>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }
    </script>

</body>
</html>
