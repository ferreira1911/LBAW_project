document.addEventListener('DOMContentLoaded', function() {
    const bankRadio = document.getElementById('method_bank');
    const cardRadio = document.getElementById('method_card');
    const bankSection = document.getElementById('bank-info-section');
    const cardSection = document.getElementById('card-payment-section');
    
    if (!bankRadio || !cardRadio) return;

    const cardInputs = cardSection.querySelectorAll('input');

    function togglePaymentMethod() {
        if (cardRadio.checked) {
            cardSection.classList.remove('d-none');
            bankSection.classList.add('d-none');
            cardInputs.forEach(input => input.setAttribute('required', 'required'));
        } else {
            cardSection.classList.add('d-none');
            bankSection.classList.remove('d-none');
            cardInputs.forEach(input => input.removeAttribute('required'));
        }
    }

    bankRadio.addEventListener('change', togglePaymentMethod);
    cardRadio.addEventListener('change', togglePaymentMethod);

    togglePaymentMethod();
});