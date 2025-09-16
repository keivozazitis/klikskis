<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwipeApp</title>
    @vite(['resources/css/welcome.css','resources/js/welcome.js'])
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <h1 class="logo">Klikšķis</h1>
            <nav class="nav">
                <a href="/">Sākums</a>
                <a href="/login_register">Reģistrēties</a>
            </nav>
        </div>
    </header>
    <section class="cards-section">
    <div class="cards-container">
        <!-- Card 1 -->
        <div class="card">
            <div class="card-images">
            <img src="{{ asset('storage/download.jpg') }}" class="active" alt="Bild1">
            <img src="{{ asset('storage/images.jpg') }}"  alt="Bild2">
        </div>
        <div class="card-info">
            <h3>Anna, 16</h3>
            <p>Intereses: Aldis Zabadskis, Roberts Mačs, Fitness</p>
        </div>
        <div class="card-actions">
            <button class="prev">⟨</button>
            <button class="next">⟩</button>
            <button class="dislike">✖</button>
            <button class="like">❤</button>
        </div>
    </div>


        <!-- Card 2 -->
        <div class="card">
            <div class="card-images">
            <img src="{{ asset('storage/C492C96C-89EB-4CC3-9675-3B0A3046610A.png') }}" class="active" alt="Bild1">
            <img src="{{ asset('storage/F30ED56D-6903-4B5F-8AE7-3404FB69F2B9.png') }}" alt="Profilbild">
            <img src="{{ asset('storage/F30E54C2-1D74-4AB1-B461-47C92887C7B6.png') }}" alt="Profilbild">
            <img src="{{ asset('storage/BD9F46B9-C41B-4AC3-A7E0-F2B8AC03679C.png') }}" alt="Profilbild">

            </div>
            <div class="card-info">
                <h3>Aldis Zabadskis, 27</h3>
                <p>Intereses: Freak, kefīrs, dj bobo</p>
            </div>
            <div class="card-actions">
                <button class="prev">⟨</button>
                <button class="next">⟩</button>
                <button class="dislike">✖</button>
                <button class="like">❤</button>
            </div>
        </div>
        <div class="card">
            <img src="{{ asset('storage/461710730_8378060218974229_7977418704910948490_n.jpg') }}" alt="Profilbild">
            <div class="card-info">
                <h3>Roberts Mačs, 22</h3>
                <p>Intereses: Basketbols, zem tupeles, maisini</p>
            </div>
            <div class="card-actions">
                <button class="dislike">✖</button>
                <button class="like">❤</button>
            </div>
        </div>
        <!-- Vari vairākas kartes pēc vajadzības -->
    </div>
    </section>
    <!-- Footer -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} Klikšķis. Visas tiesības paturētas.</p>
    </footer>
</body>
</html>
