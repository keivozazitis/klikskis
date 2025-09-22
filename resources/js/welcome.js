document.addEventListener('DOMContentLoaded', () => {
    const cards = Array.from(document.querySelectorAll('.card'));

    cards.forEach(card => {
        // ======================
        // Swipe karte + pēdējās kartes redirect
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

                // Ja nav palikušas kartes, novirza uz register page
                if (document.querySelectorAll('.card').length === 0) {
                    window.location.href = '/login_register';
                }
            }, 300);
        };

        likeBtn.addEventListener('click', () => swipeCard('like'));
        dislikeBtn.addEventListener('click', () => swipeCard('dislike'));

        // ======================
        // Image slider ar indikatoriem
        // ======================
        const images = card.querySelectorAll('.card-images img');
        const indicators = card.querySelectorAll('.image-indicators .indicator');
        let current = 0;

        const showImage = (index) => {
            images.forEach((img, i) => img.classList.toggle('active', i === index));
            indicators.forEach((ind, i) => ind.classList.toggle('active', i === index));
        };

        const prevBtn = card.querySelector('.prev');
        const nextBtn = card.querySelector('.next');

        if (prevBtn) {
            prevBtn.addEventListener('click', e => {
                e.stopPropagation();
                current = (current - 1 + images.length) % images.length;
                showImage(current);
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', e => {
                e.stopPropagation();
                current = (current + 1) % images.length;
                showImage(current);
            });
        }

        // Parāda pirmo bildi uzreiz
        showImage(current);
    });
});
