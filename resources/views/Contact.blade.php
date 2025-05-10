@extends('layouts.app')

@section('content')
<section data-bs-version="5.1" class="contacts1 cid-tFrNWP4BYh py-5" id="contacts1-c">
    <div class="container">
        <div class="mbr-section-head text-center mb-5">
            <h2 class="mbr-section-title display-4 fw-bold text-primary">
                <strong>Get in Touch</strong>
            </h2>
            <p class="text-muted mt-2">We’d love to hear from you — reach out anytime.</p>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Email Card -->
            <div class="col-12 col-lg-5">
                <div class="card h-100 shadow-lg border-0">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <span class="mbr-iconfont mobi-mbri-letter mobi-mbri fs-1 text-primary"></span>
                        </div>
                        <h4 class="mb-2 fw-bold">Email Us</h4>
                        <p class="text-muted">We usually respond within a few hours during working days.</p>
                        <a href="mailto:bester12@outlook.com" class="btn btn-outline-primary mt-3">
                            Send an Email
                        </a>
                    </div>
                </div>
            </div>

            <!-- Phone/WhatsApp Card -->
            <div class="col-12 col-lg-5">
                <div class="card h-100 shadow-lg border-0">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <span class="mbr-iconfont mobi-mbri-mobile-2 mobi-mbri fs-1 text-primary"></span>
                        </div>
                        <h4 class="mb-2 fw-bold">Call or WhatsApp</h4>
                        <p class="text-muted">Available Mon - Fri · 09:00 to 18:00</p>
                        <div class="d-flex flex-column gap-2">
                            <a href="tel:0606861764" class="btn btn-outline-primary">Call: (060) 6861-764</a>
                            <a href="https://wa.me/27606861764" target="_blank" class="btn btn-primary">
                                Chat on WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
