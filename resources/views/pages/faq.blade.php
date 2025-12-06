@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
<div class="container mt-4">
    <div class="d-flex align-items-end mb-4">
        <h2 class="me-3 mb-0">FAQ</h2>
        <p class="mb-0 text-muted">Frequently Asked Questions</p>
    </div>

    <p class="mb-4">These are the answers to the questions people ask the most.</p>

    <div class="faq-item mb-4">
        <h4>How do auctions work?</h4>
        <p>You place bids on items. When the timer hits zero, the highest bid wins. Pretty simple. If someone bids in the last 15 minutes, the auction automatically extends by 30 minutes to give others a fair chance.</p>
    </div>

    <div class="faq-item mb-4">
        <h4>Do I need an account?</h4>
        <p>Yes. You need one to bid, sell, or save items. It only takes a minute to register.</p>
    </div>

    <div class="faq-item mb-4">
        <h4>How do I upload an item?</h4>
        <p>You go to your dashboard, hit “Create Auction”, fill the form, and submit. The item shows up right away.</p>
    </div>

    <div class="faq-item mb-4">
        <h4>What happens if I win an auction?</h4>
        <p>The payment is automatically processed, and then the seller contacts you. Alternatively, you can also contact the seller directly.</p>
    </div>

    <div class="faq-item mb-4">
        <h4>Can I edit my auction after posting?</h4>
        <p>You can edit things like the image or description, even if someone has already placed a bid. However, you cannot change the starting price or other core auction details.</p>
    </div>

    <div class="faq-item mb-4">
        <h4>How do bids work?</h4>
        <p>You need to bid at least 10% higher than the starting price. The system blocks bids that are too low.</p>
    </div>

    <div class="faq-item mb-4">
        <h4>Can I cancel my bid?</h4>
        <p>No. Once you bid, it stays. This keeps the auction fair for everyone.</p>
    </div>

    <div class="faq-item mb-4">
        <h4>How do I get more credit?</h4>
        <p>You can recharge it in your wallet page. It updates instantly.</p>
    </div>

    <div class="faq-item mb-4">
        <h4>What items can I sell?</h4>
        <p>You can sell almost anything legal. We don't allow dangerous items or things that break copyright rules.</p>
    </div>

    <div class="faq-item mb-4">
        <h4>Why can't I bid on my own auction?</h4>
        <p>Because it's considered fake bidding. The system blocks it automatically.</p>
    </div>

    <div class="faq-item mb-4">
        <h4>Why did my auction get removed?</h4>
        <p>Usually it's because it broke one of the rules. Sometimes it's because someone reported it.</p>
    </div>
    
    <div class="faq-item mb-4">
        <h4>Why did my account get blocked?</h4>
        <p>Accounts may be blocked if they violate rules or suspicious activity is detected. Contact support for more details.</p>
    </div>

    <div class="faq-item mb-4">
        <h4>What if I have a problem with a seller?</h4>
        <p>You can report the auction or contact support. We try to handle disputes quickly.</p>
    </div>

    <div class="faq-item mb-4">
        <h4>Can I feature my auction?</h4>
        <p>You can, but only after it's approved. Featuring helps it show up on the homepage.</p>
    </div>

</div>

<hr class="my-5">

<div class="mt-4 text-center mb-5">
    <h4>Have another question?</h4>
    <p>If something still feels unclear, you can reach out to us directly.</p>

    <a href="{{ route('contact') }}" class="btn btn-primary mt-2">
        Contact Support
    </a>
</div>
@endsection
