@if ($cart)
    <script type="text/x-template" id="coupon-component-template">
        <div class="coupon-container">
            <div class="discount-control mt-3 mb-4">
                <div class="applied-coupon-details" v-if="applied_coupon">
                    <label>{{ __('shop::app.checkout.total.coupon-applied') }}</label>

                    <label class="right" style="display: inline-flex; align-items: center;">
                        <b>@{{ applied_coupon }}</b>

                        <i class="rango-close ml-3 text-primary fs18" title="{{ __('shop::app.checkout.total.remove-coupon') }}" v-on:click="removeCoupon"></i>
                    </label>
                </div>
                <form  class="d-flex flex-column align-items-end" method="post" @submit.prevent="applyCoupon">
                    <div class="control-group w-100" :class="[error_message ? 'has-error' : '']">
                        <input
                            type="text"
                            name="code"
                            class="form-control"
                            v-model="coupon_code"
                            placeholder="{{ __('shop::app.checkout.onepage.enter-coupon-code') }}" />
                        </div>
                        <div class="control-error">@{{ error_message }}</div>

                    <button class="theme-btn btn w-50 d-block light" :disabled="disable_button">{{ __('shop::app.checkout.onepage.apply-coupon') }}</button>
                </form>
            </div>

        </div>
    </script>

    <script>
        Vue.component('coupon-component', {
            template: '#coupon-component-template',

            inject: ['$validator'],

            data: function() {
                return {
                    coupon_code: '',
                    error_message: '',
                    applied_coupon: "{{ $cart->coupon_code }}",
                    route_name: "{{ request()->route()->getName() }}",
                    disable_button: ("{{ $cart->coupon_code }}" == "" ? false : true),
                }
            },

            methods: {
                applyCoupon: function() {
                    if (! this.coupon_code.length)
                        return;

                    this.error_message = null;
                    this.disable_button = true;

                    let code = this.coupon_code;
                    axios.post(
                        '{{ route('shop.checkout.cart.coupon.apply') }}', {code}
                    ).then(response => {
                        if (response.data.success) {
                            this.$emit('onApplyCoupon');
                            this.applied_coupon = this.coupon_code;
                            this.coupon_code = '';

                            window.flashMessages = [{'type': 'alert-success', 'message': response.data.message}];

                            this.$root.addFlashMessages();

                            this.redirectIfCartPage();
                        } else {
                            this.error_message = response.data.message;
                        }

                        this.disable_button = false;
                    }).catch(error => {
                        this.error_message = error.response.data.message;

                        this.disable_button = false;
                    });
                },

                removeCoupon: function () {
                    var self = this;

                    axios.delete('{{ route('shop.checkout.coupon.remove.coupon') }}')
                    .then(function(response) {
                        self.$emit('onRemoveCoupon')

                        self.applied_coupon = '';
                        self.disable_button = false;

                        window.flashMessages = [{'type': 'alert-success', 'message': response.data.message}];

                        self.$root.addFlashMessages();

                        self.redirectIfCartPage();
                    })
                    .catch(function(error) {
                        window.flashMessages = [{'type': 'alert-error', 'message': error.response.data.message}];

                        self.$root.addFlashMessages();
                    });
                },

                redirectIfCartPage: function() {
                    if (this.route_name != 'shop.checkout.cart.index')
                        return;

                    setTimeout(function() {
                        window.location.reload();
                    }, 700);
                }
            }
        });
    </script>
@endif