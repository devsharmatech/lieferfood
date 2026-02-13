@extends('external.frame')
@section('external-css')
<style>
    .terms-section {
        margin-bottom: 2.5rem;
    }
    .terms-subsection {
        margin-bottom: 1.8rem;
    }
    .terms-list {
        padding-left: 1.5rem;
    }
    .highlight-box {
        background-color: #f8f9fa;
        border-left: 4px solid #e23744;
        padding: 1rem;
        margin: 1.5rem 0;
    }
</style>
@endsection

@section('external-home-content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-0 border-0">
                <div class="card-body p-4">
                    <h1 class="text-center text-primary mb-4">Terms & Conditions</h1>
                    
                    <div class="highlight-box">
                        <h5 class="text-primary">IMPORTANT LEGAL NOTICE</h5>
                        <p>These terms govern your use of Lieferfood.de. By using our website or mobile app (together, "the Website"), you agree to these terms.</p>
                        <p><strong>Email:</strong> support@lieferfood.de<br>
                        <strong>Website:</strong> https://www.lieferfood.de</p>
                    </div>

                    <!-- I. Terms of Use and Sale -->
                    <div class="terms-section">
                        <h2 class="text-primary">I. TERMS AND CONDITIONS OF USE AND SALE</h2>

                        <div class="terms-subsection">
                            <h4>1. INTRODUCTION AND OUR ROLE</h4>
                            <p>1.1. Lieferfood.de provides a platform to order food from partner restaurants ("Businesses"). The contract for food supply is directly between you and the Business.</p>
                            <p>1.2. Delivery services may be provided by the Business or by us. Delivery fees apply as shown during checkout.</p>
                        </div>

                        <div class="terms-subsection">
                            <h4>2. WEBSITE ACCESS</h4>
                            <p>2.1. Most website areas are accessible without registration.</p>
                            <p>2.2. We may revise these terms at any time by updating this page.</p>
                        </div>

                        <div class="terms-subsection">
                            <h4>3. YOUR STATUS</h4>
                            <p>3.1. By ordering, you confirm:</p>
                            <ul class="terms-list">
                                <li>You are legally capable of entering contracts</li>
                                <li>You are at least 18 years old</li>
                            </ul>
                            <p>3.3. For age-restricted items (alcohol/tobacco):</p>
                            <ul class="terms-list">
                                <li>You must provide valid ID upon delivery</li>
                                <li>We reserve the right to refuse delivery if you appear intoxicated</li>
                            </ul>
                        </div>

                        <!-- Continue with all other sections... -->
                        <div class="terms-subsection">
                            <h4>4. ORDER PROCESSING</h4>
                            <p>4.1. Orders are binding once payment is authorized.</p>
                            <p>4.4. Businesses may reject orders due to capacity, weather, or other reasons.</p>
                            <p>4.5. If you're absent during delivery, we may leave food in a safe location.</p>
                        </div>

                        <div class="terms-subsection">
                            <h4>5. PRICE AND PAYMENT</h4>
                            <p>5.1. Prices include VAT. Delivery fees are extra.</p>
                            <p>5.5. Voucher discounts are applied when funds are transferred.</p>
                        </div>
                    </div>

                    <!-- II. Voucher Terms -->
                    <div class="terms-section">
                        <h2 class="text-primary">II. VOUCHER TERMS & CONDITIONS</h2>
                        <p>1. Vouchers are valid only for online orders through our Website.</p>
                        <p>5. Paycode vouchers must be redeemed before expiry dates.</p>
                        <p>9. Discount vouchers expire after 2,000 redemptions.</p>
                    </div>

                    <!-- III. StampCard Program -->
                    <div class="terms-section">
                        <h2 class="text-primary">III. STAMPCARD PROGRAM</h2>
                        <p>1. Earn 1 stamp per online order with participating restaurants.</p>
                        <p>7. Collect 5 stamps to receive a 10% discount on future orders.</p>
                        <p>15. Discounts must be redeemed within 90 days.</p>
                    </div>

                    <!-- IV. General -->
                    <div class="terms-section">
                        <h2 class="text-primary">IV. GENERAL TERMS</h2>
                        <h4>12. LIABILITY</h4>
                        <p>12.1. We're not liable for indirect losses (business interruption, data loss, etc.).</p>
                        
                        <h4>15. FORCE MAJEURE</h4>
                        <p>15.2. We're not responsible for delays caused by:</p>
                        <ul class="terms-list">
                            <li>Natural disasters</li>
                            <li>Pandemics</li>
                            <li>Transport failures</li>
                        </ul>

                        <h4>17. GOVERNING LAW</h4>
                        <p>17.1. These terms are governed by German law.</p>
                    </div>

                    <div class="text-center mt-5">
                        <p><strong>Last updated: {{ now()->format('F j, Y') }}</strong></p>
                        <p>For questions, contact <a href="mailto:support@lieferfood.de">support@lieferfood.de</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
