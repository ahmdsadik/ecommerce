<x-front title="Payment" >

    <x-slot:breadcrumb>
        <!-- Start Breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Login</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li>Shop</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbs -->
    </x-slot:breadcrumb>

    <div class="container">
        <div class="row py-4">

            <div id="payment-message" class="alert alert-danger d-none">
            </div>

            <form action="" id="payment-form" method="post">
                <div id="payment-element">

                </div>
                <button type="submit" class="btn btn-primary rounded-0 mt-4 w-100" id="submit">
                    <div class="spinner-border d-none" id="spinner" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div id="button-text">Pay</div>
                </button>
            </form>
        </div>
    </div>



    <script src="https://js.stripe.com/v3/"></script>

    @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>

        <script>
            // This is your test publishable API key.
            const stripe = Stripe("{{ config('services.stripe.publishable_key') }}");

            // The items the customer wants to buy
            // const items = [{id: "xl-tshirt"}];

            let elements;

            initialize();

            document
                .querySelector("#payment-form")
                .addEventListener("submit", handleSubmit);

            // Fetches a payment intent and captures the client secret
            async function initialize() {
                const {clientSecret} = await fetch("{{ route('front.stripe.intent.create',$order) }}", {
                    method: "POST",
                    headers: {"Content-Type": "application/json"},
                    body: JSON.stringify(
                        {
                            '_token': '{{ csrf_token() }}'
                        }
                    ),
                }).then((r) => r.json());

                elements = stripe.elements({clientSecret});

                const paymentElementOptions = {
                    layout: "tabs",
                };

                const paymentElement = elements.create("payment", paymentElementOptions);
                paymentElement.mount("#payment-element");
            }

            async function handleSubmit(e) {
                e.preventDefault();
                setLoading(true);

                const {error} = await stripe.confirmPayment({
                    elements,
                    confirmParams: {
                        // Make sure to change this to your payment completion page
                        return_url: "{{ route('front.stripe.complete-payment',$order) }}",
                    },
                });

                // This point will only be reached if there is an immediate error when
                // confirming the payment. Otherwise, your customer will be redirected to
                // your `return_url`. For some payment methods like iDEAL, your customer will
                // be redirected to an intermediate site first to authorize the payment, then
                // redirected to the `return_url`.
                if (error.type === "card_error" || error.type === "validation_error") {
                    showMessage(error.message);
                } else {
                    showMessage("An unexpected error occurred.");
                }

                setLoading(false);
            }

            // ------- UI helpers -------

            function showMessage(messageText) {
                const messageContainer = document.querySelector("#payment-message");

                messageContainer.classList.remove("d-none");
                messageContainer.textContent = messageText;

                setTimeout(function () {
                    messageContainer.classList.add("d-none");
                    messageContainer.textContent = "";
                }, 4000);
            }

            // Show a spinner on payment submission
            function setLoading(isLoading) {
                if (isLoading) {
                    // Disable the button and show a spinner
                    document.querySelector("#submit").disabled = true;
                    document.querySelector("#spinner").classList.remove("d-none");
                    document.querySelector("#button-text").classList.add("d-none");
                } else {
                    document.querySelector("#submit").disabled = false;
                    document.querySelector("#spinner").classList.add("d-none");
                    document.querySelector("#button-text").classList.remove("d-none");
                }
            }
        </script>
    @endpush

    @push('styles')
    @endpush
</x-front>
