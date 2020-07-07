@if (
    $reinabatataMetaData
    && $reinabatataMetaData->subscription_bar_content
    || core()->getConfigData('customer.settings.newsletter.subscription')
)
    <div class="newsletter-subscription">
        <div class="newsletter-wrapper row col-12">
            @if ($reinabatataMetaData && $reinabatataMetaData->subscription_bar_content)
                {!! $reinabatataMetaData->subscription_bar_content !!}
            @endif

            @if (core()->getConfigData('customer.settings.newsletter.subscription'))
                <div class="subscribe-newsletter col-12 col-md-6">
                    <div class="form-container">
                        <form action="{{ route('shop.subscribe') }}">
                            <div class="subscriber-form-div">
                                <div class="control-group d-md-flex">
                                    <input
                                        type="email"
                                        name="subscriber_email"
                                        class="form-control"
                                        placeholder="{{ __('reinabatata::app.customer.login-form.your-email-address') }}"
                                        required />

                                    <button class="btn btn-primary btn-suscription">
                                        {{ __('shop::app.subscription.subscribe') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif
