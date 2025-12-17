@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
<div class="container py-5">
    
    {{-- Header Section (Igual ao About Us) --}}
    <div class="text-center mb-5">
        <h1 class="fw-bold">FAQ</h1>
        <p class="lead text-muted mt-2">
            Frequently Asked Questions
        </p>
        <p class="text-muted">
            These are the answers to the questions people ask the most.
        </p>
    </div>

    {{-- FAQ Accordion --}}
    <div class="row justify-content-center">
        <div class="col-lg-10"> <div class="accordion" id="faqAccordion">

                {{-- Item 1 --}}
                <div class="accordion-item border-0 shadow-sm mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <i class="bi bi-question-circle-fill me-2 text-primary"></i>
                            How do auctions work?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            You place bids on items. When the timer hits zero, the highest bid wins. Pretty simple. If someone bids in the last 15 minutes, the auction automatically extends by 30 minutes to give others a fair chance.
                        </div>
                    </div>
                </div>

                {{-- Item 2 --}}
                <div class="accordion-item border-0 shadow-sm mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <i class="bi bi-person-fill-add me-2 text-primary"></i>
                            Do I need an account?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Yes. You need one to bid, sell, or save items. It only takes a minute to register.
                        </div>
                    </div>
                </div>

                {{-- Item 3 --}}
                <div class="accordion-item border-0 shadow-sm mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <i class="bi bi-cloud-upload-fill me-2 text-primary"></i>
                            How do I upload an item?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            You go to your dashboard, hit “Create Auction”, fill the form, and submit. The item shows up right away.
                        </div>
                    </div>
                </div>

                {{-- Item 4 --}}
                <div class="accordion-item border-0 shadow-sm mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            <i class="bi bi-trophy-fill me-2 text-primary"></i>
                            What happens if I win an auction?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            The payment is automatically processed, and then the seller contacts you. Alternatively, you can also contact the seller directly.
                        </div>
                    </div>
                </div>

                {{-- Item 5 --}}
                <div class="accordion-item border-0 shadow-sm mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            <i class="bi bi-pencil-square me-2 text-primary"></i>
                            Can I edit my auction after posting?
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            You can edit things like the image or description, even if someone has already placed a bid. However, you cannot change the starting price or other core auction details.
                        </div>
                    </div>
                </div>

                {{-- Item 6 --}}
                <div class="accordion-item border-0 shadow-sm mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingSix">
                        <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            <i class="bi bi-hammer me-2 text-primary"></i>
                            How do bids work?
                        </button>
                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            You need to bid at least 10% higher than the starting price. The system blocks bids that are too low.
                        </div>
                    </div>
                </div>

                {{-- Item 7 --}}
                <div class="accordion-item border-0 shadow-sm mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingSeven">
                        <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                            <i class="bi bi-x-circle-fill me-2 text-primary"></i>
                            Can I cancel my bid?
                        </button>
                    </h2>
                    <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            No. Once you bid, it stays. This keeps the auction fair for everyone.
                        </div>
                    </div>
                </div>

                {{-- Item 8 --}}
                <div class="accordion-item border-0 shadow-sm mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingEight">
                        <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                            <i class="bi bi-wallet-fill me-2 text-primary"></i>
                            How do I get more credit?
                        </button>
                    </h2>
                    <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            You can recharge it in your wallet page. It updates instantly.
                        </div>
                    </div>
                </div>

                {{-- Item 9 --}}
                <div class="accordion-item border-0 shadow-sm mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingNine">
                        <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                            <i class="bi bi-box-seam-fill me-2 text-primary"></i>
                            What items can I sell?
                        </button>
                    </h2>
                    <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            You can sell almost anything legal. We don't allow dangerous items or things that break copyright rules.
                        </div>
                    </div>
                </div>

                {{-- Item 10 --}}
                <div class="accordion-item border-0 shadow-sm mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingTen">
                        <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                            <i class="bi bi-slash-circle-fill me-2 text-primary"></i>
                            Why can't I bid on my own auction?
                        </button>
                    </h2>
                    <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Because it's considered fake bidding. The system blocks it automatically.
                        </div>
                    </div>
                </div>

                {{-- Item 11 --}}
                <div class="accordion-item border-0 shadow-sm mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingEleven">
                        <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                            <i class="bi bi-trash3-fill me-2 text-primary"></i>
                            Why did my auction get removed?
                        </button>
                    </h2>
                    <div id="collapseEleven" class="accordion-collapse collapse" aria-labelledby="headingEleven" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Usually it's because it broke one of the rules. Sometimes it's because someone reported it.
                        </div>
                    </div>
                </div>

                {{-- Item 12 --}}
                <div class="accordion-item border-0 shadow-sm mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingTwelve">
                        <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">
                            <i class="bi bi-shield-lock-fill me-2 text-primary"></i>
                            Why did my account get blocked?
                        </button>
                    </h2>
                    <div id="collapseTwelve" class="accordion-collapse collapse" aria-labelledby="headingTwelve" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Accounts may be blocked if they violate rules or suspicious activity is detected. Contact support for more details.
                        </div>
                    </div>
                </div>

                {{-- Item 13 --}}
                <div class="accordion-item border-0 shadow-sm mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingThirteen">
                        <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThirteen" aria-expanded="false" aria-controls="collapseThirteen">
                            <i class="bi bi-exclamation-triangle-fill me-2 text-primary"></i>
                            What if I have a problem with a seller?
                        </button>
                    </h2>
                    <div id="collapseThirteen" class="accordion-collapse collapse" aria-labelledby="headingThirteen" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            You can report the auction or contact support. We try to handle disputes quickly.
                        </div>
                    </div>
                </div>

                {{-- Item 14 --}}
                <div class="accordion-item border-0 shadow-sm mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingFourteen">
                        <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourteen" aria-expanded="false" aria-controls="collapseFourteen">
                            <i class="bi bi-star-fill me-2 text-primary"></i>
                            Can I feature my auction?
                        </button>
                    </h2>
                    <div id="collapseFourteen" class="accordion-collapse collapse" aria-labelledby="headingFourteen" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            You can, but only after it's approved. Featuring helps it show up on the homepage.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="text-center my-5 pt-4">
        <h4 class="fw-bold">Have another question?</h4>
        <p class="text-muted mb-3">If something still feels unclear, you can reach out to us directly.</p>

        <a href="{{ route('contact') }}" class="btn btn-primary px-4 rounded-pill">
            Contact Support
        </a>
    </div>
</div>
@endsection