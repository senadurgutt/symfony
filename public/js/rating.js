document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('.star');
    const productId = document.getElementById('rating').dataset.productId;

    // Load the current rating from the server
    fetch(`/rating/current/${productId}`)
        .then(response => response.json())
        .then(data => {
            if (data.rating) {
                stars.forEach(star => {
                    if (parseInt(star.getAttribute('data-value')) <= data.rating) {
                        star.classList.add('active');
                    }
                });
            }
        });

    stars.forEach(star => {
        star.addEventListener('click', function () {
            const value = this.getAttribute('data-value');

            stars.forEach(s => {
                s.classList.remove('active');
                if (s.getAttribute('data-value') <= value) {
                    s.classList.add('active');
                }
            });

            // Save the rating
            fetch('/rating/submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ product_id: productId, rating: value })
            });
        });
    });
});
