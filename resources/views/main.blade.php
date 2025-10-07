<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main-Coming Soon</title>
    @vite(['resources/css/main.css'])
</head>
<body>

    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">Klikšķis</div>
            <nav class="nav">
                <a href="/">Sākums</a>
                <a href="#">Par mums</a>
                <a href="#">Kontakti</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <h2>🚧 Lapa drīzumā pieejama!</h2>
        <p>Mēs strādājam, lai izveidotu kaut ko lielisku. Sekojiet līdzi!</p>
        <div class="hero-buttons">
            <a href="#" class="btn">Uzzināt vairāk</a>
            <a href="#" class="btn btn-secondary">Sazināties</a>
        </div>
    </section>

    <!-- Countdown Section -->
    <section class="coming-soon">
        <div class="countdown">
            <div><span id="days">00</span><p>Dienas</p></div>
            <div><span id="hours">00</span><p>Stundas</p></div>
            <div><span id="minutes">00</span><p>Minūtes</p></div>
            <div><span id="seconds">00</span><p>Sekundes</p></div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} Mans Projekts — Visi tiesības aizsargātas</p>
    </footer>

    <script>
        // Vienkāršs countdown līdz konkrētam datumam
        const targetDate = new Date("2025-12-31T00:00:00").getTime();
        const countdown = () => {
            const now = new Date().getTime();
            const diff = targetDate - now;

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            document.getElementById("days").textContent = days.toString().padStart(2, "0");
            document.getElementById("hours").textContent = hours.toString().padStart(2, "0");
            document.getElementById("minutes").textContent = minutes.toString().padStart(2, "0");
            document.getElementById("seconds").textContent = seconds.toString().padStart(2, "0");
        };
        setInterval(countdown, 1000);
    </script>

</body>
</html>
