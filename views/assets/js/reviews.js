document.addEventListener('DOMContentLoaded', async () => {
    const spaceSelect = document.querySelector('select[name="space_id"]');
    const reviewsContent = document.getElementById('reviews-content');

    spaceSelect.addEventListener('change', async (e) => {
        if (e.target.value) {
            const response = await fetch(`/api/reviews?space_id=${e.target.value}`);
            const reviews = await response.json();
            renderReviews(reviews);
        }
    });

    document.getElementById('review-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);

        try {
            const response = await fetch('/reviews', {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                e.target.reset();
                const spaceId = spaceSelect.value;
                if (spaceId) {
                    const updatedReviews = await fetch(`/api/reviews?space_id=${spaceId}`).then(r => r.json());
                    renderReviews(updatedReviews);
                }
            } else {
                alert('Ошибка при отправке отзыва');
            }
        } catch (err) {
            console.error('Review submission error:', err);
        }
    });

    function renderReviews(reviews) {
        reviewsContent.innerHTML = reviews.map(review => `
            <div class="review-item">
                <h4>${review.username} - ${'★'.repeat(review.rating)}${'☆'.repeat(5 - review.rating)}</h4>
                <p>${review.comment}</p>
                <small>${new Date(review.createdAt).toLocaleDateString()}</small>
            </div>
        `).join('');
    }
});