document.addEventListener('DOMContentLoaded', () => {
    const cards = Array.from(document.querySelectorAll('.card'));

    cards.forEach(card => {
        // ======================
        // Swipe karte + redirect
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
                    window.location.href = '/login_register';
                }
            }, 300);
        };

        likeBtn?.addEventListener('click', () => swipeCard('like'));
        dislikeBtn?.addEventListener('click', () => swipeCard('dislike'));

        // ======================
        // Image slider + loģika bultiņām
        // ======================
        const images = card.querySelectorAll('.card-images img');
        console.log('Found', images.length, 'images in this card');

        const prevBtn = card.querySelector('.prev');
        const nextBtn = card.querySelector('.next');
        let indicatorsContainer = card.querySelector('.image-indicators');
        let current = 0;

        // ===== Automātiski ģenerē indikatorus =====
        if (!indicatorsContainer) {
            // Ja indikatoru bloks nav HTML, izveido to
            indicatorsContainer = document.createElement('div');
            indicatorsContainer.classList.add('image-indicators');
            card.querySelector('.card-images').appendChild(indicatorsContainer);
        }
        indicatorsContainer.innerHTML = ''; // notīra vecos

        images.forEach((_, i) => {
            const span = document.createElement('span');
            span.classList.add('indicator');
            if (i === 0) span.classList.add('active');
            indicatorsContainer.appendChild(span);
        });

        const indicators = card.querySelectorAll('.image-indicators .indicator');

        // Ja tikai 1 bilde — paslēp bultiņas un indikatorus
        if (images.length <= 1) {
            if (prevBtn) prevBtn.style.display = 'none';
            if (nextBtn) nextBtn.style.display = 'none';
            if (indicatorsContainer) indicatorsContainer.style.display = 'none';
        }

        // Funkcija, kas rāda bildes
        const showImage = (index) => {
            images.forEach((img, i) => img.classList.toggle('active', i === index));
            indicators.forEach((ind, i) => ind.classList.toggle('active', i === index));
        };

        // Ja vairākas bildes — pievieno click notikumus
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

        // Parāda pirmo bildi uzreiz
        showImage(current);
    });
});
