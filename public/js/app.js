


document.addEventListener('DOMContentLoaded', () => {
    
    const timers = document.querySelectorAll('.auction-timer[data-end]');

    if (timers.length === 0) return;

    function updateCountdowns() {
        const now = new Date().getTime();

        timers.forEach(timer => {
            
            const endDate = new Date(timer.getAttribute('data-end')).getTime();
            const distance = endDate - now;
            const display = timer.querySelector('.timer-text');

            
            if (distance < 0) {
                display.innerHTML = "Finished";
                timer.classList.add('text-danger', 'fw-bold');
                timer.classList.remove('text-muted');
                return;
            }

            // Cálculos matemáticos para Dias, Horas, Minutos, Segundos
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

           
            let text = "";
            if (days > 0) text += `${days}d `;
            text += `${hours}h ${minutes}m ${seconds}s`;

            
            display.innerText = text;

            // Estilo de Urgência (menos de 1 hora)
            if (days === 0 && hours < 1) {
                timer.classList.add('text-danger', 'fw-bold');
                timer.classList.remove('text-muted');
            }
        });
    }

    
    updateCountdowns();

    
    setInterval(updateCountdowns, 1000);
});


document.addEventListener('DOMContentLoaded', function() {
    var myModal = new bootstrap.Modal(document.getElementById('createCategoryModal'));
    myModal.show();
});
