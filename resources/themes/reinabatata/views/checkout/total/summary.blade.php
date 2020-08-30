<div class="order-summary fs16">
    <h5 class="fw6 mb-4">{{ __('reinabatata::app.checkout.cart.cart-summary') }}</h5>

    <div class="row">
        <span class="col-6">{{ __('reinabatata::app.checkout.sub-total') }}</span>
        <span class="col-6 text-right">{{ core()->currency($cart->base_sub_total) }}</span>
    </div>

    @if ($cart->selected_shipping_rate)
        <div class="row">
            <span class="col-6">{{ __('shop::app.checkout.total.delivery-charges') }}</span>
            <span class="col-6 text-right">{{ core()->currency($cart->selected_shipping_rate->base_price) }}</span>
        </div>
    @endif

    <!-- @if ($cart->base_tax_total)
        @foreach (Webkul\Tax\Helpers\Tax::getTaxRatesWithAmount($cart, true) as $taxRate => $baseTaxAmount )
            <div class="row">
                <span class="col-6" id="taxrate-{{ core()->taxRateAsIdentifier($taxRate) }}">{{ __('shop::app.checkout.total.tax') }} {{ $taxRate }} %</span>
                <span class="col-6 text-right" id="basetaxamount-{{ core()->taxRateAsIdentifier($taxRate) }}">{{ core()->currency($baseTaxAmount) }}</span>
            </div>
        @endforeach
    @endif -->

    @if (
        $cart->base_discount_amount
        && $cart->base_discount_amount > 0
    )
        <div
            id="discount-detail"
            class="row">

            <span class="col-6">{{ __('shop::app.checkout.total.disc-amount') }}</span>
            <span class="col-6 text-right">
                -{{ core()->currency($cart->base_discount_amount) }}
            </span>
        </div>
    @endif

    <div class="payable-amount row" id="grand-total-detail">
        <span class="col-6">{{ __('shop::app.checkout.total.grand-total') }}</span>
        <span class="col-6 text-right fw6" id="grand-total-amount-detail">
            ARS {{ core()->currency($cart->base_grand_total) }}
        </span>
    </div>
</div>