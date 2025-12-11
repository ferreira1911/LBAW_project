document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('#starRating .star');
    const ratingInput = document.getElementById('rating');
    const ratingError = document.getElementById('ratingError');
    const reviewForm = document.getElementById('reviewForm');

    if (!stars.length || !ratingInput || !reviewForm) {
        return;
    }

    stars.forEach(star => {
        star.addEventListener('mouseover', () => {
            paintStars(star.dataset.value);
        });
        
        star.addEventListener('mouseout', () => {
            paintStars(ratingInput.value);
        });
        
        star.addEventListener('click', () => {
            ratingInput.value = star.dataset.value;
            paintStars(star.dataset.value);
            if (ratingError) {
                ratingError.style.display = 'none';
            }
        });
    });

    function paintStars(value) {
        stars.forEach(star => {
            if (star.dataset.value <= value) {
                star.classList.remove('bi-star');
                star.classList.add('bi-star-fill', 'text-warning');
            } else {
                star.classList.remove('bi-star-fill', 'text-warning');
                star.classList.add('bi-star');
            }
        });
    }

    reviewForm.addEventListener('submit', function(e) {
        if (!ratingInput.value) {
            e.preventDefault();
            if (ratingError) {
                ratingError.style.display = 'block';
            }
            document.getElementById('starRating').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
        }
    });

    if (ratingInput.value) {
        paintStars(ratingInput.value);
    }
});