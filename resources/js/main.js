document.addEventListener('DOMContentLoaded', () => {
    const cards = Array.from(document.querySelectorAll('.card'));

    cards.forEach(card => {
        // ======================
        // Swipe karte + redirect (tagad – paziņojums)
        // ======================
        const likeBtn = card.querySelector('.like');
        const dislikeBtn = card.querySelector('.dislike');

        const swipeCard = (direction) => {
            card.style.transform = direction === 'like'
                ? 'translateX(500px) rotate(20deg)'
                : 'translateX(-500px) rotate(-20deg)';
            card.style.opacity = 0;

            setTimeout(() => {
                card.remove();
                if (document.querySelectorAll('.card').length === 0) {
                    showAllViewedMessage();
                }
            }, 300);
        };

        likeBtn?.addEventListener('click', () => swipeCard('like'));
        dislikeBtn?.addEventListener('click', () => swipeCard('dislike'));

        // ======================
        // Image slider + loģika bultiņām
        // ======================
        const images = card.querySelectorAll('.card-images img');
        const prevBtn = card.querySelector('.prev');
        const nextBtn = card.querySelector('.next');
        let indicatorsContainer = card.querySelector('.image-indicators');
        let current = 0;

        // ===== Automātiski ģenerē indikatorus =====
        if (!indicatorsContainer) {
            indicatorsContainer = document.createElement('div');
            indicatorsContainer.classList.add('image-indicators');
            card.querySelector('.card-images').appendChild(indicatorsContainer);
        }
        indicatorsContainer.innerHTML = '';

        images.forEach((_, i) => {
            const span = document.createElement('span');
            span.classList.add('indicator');
            if (i === 0) span.classList.add('active');
            indicatorsContainer.appendChild(span);
        });

        const indicators = card.querySelectorAll('.image-indicators .indicator');

        // Ja tikai 1 bilde — paslēp bultiņas un indikatorus
        if (images.length <= 1) {
            prevBtn?.style.setProperty('display', 'none');
            nextBtn?.style.setProperty('display', 'none');
            indicatorsContainer?.style.setProperty('display', 'none');
        }

        // Funkcija, kas rāda bildes
        const showImage = (index) => {
            images.forEach((img, i) => img.classList.toggle('active', i === index));
            indicators.forEach((ind, i) => ind.classList.toggle('active', i === index));
        };

        if (images.length > 1) {
            prevBtn?.addEventListener('click', e => {
                e.stopPropagation();
                current = (current - 1 + images.length) % images.length;
                showImage(current);
            });

            nextBtn?.addEventListener('click', e => {
                e.stopPropagation();
                current = (current + 1) % images.length;
                showImage(current);
            });
        }

        showImage(current);
    });

    // ======================
    // Funkcija, kas rāda paziņojumu, kad visi lietotāji apskatīti
    // ======================
    function showAllViewedMessage() {
        const container = document.querySelector('.cards-container');
        container.innerHTML = `
            <div style="
                text-align:center;
                width:100%;
                padding:60px 20px;
                color:#fff;
                background:rgba(158,54,244,0.1);
                border-radius:16px;
                backdrop-filter:blur(8px);
            ">
                <h2 style="font-size:28px; margin-bottom:10px;">🎉 Visi lietotāji ir apskatīti!</h2>
                <p style="font-size:18px; opacity:0.8;">Atgriezies vēlāk, lai redzētu jaunus cilvēkus.</p>
            </div>
        `;
    }
});
