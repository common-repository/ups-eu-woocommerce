<script type="text/javascript">
    (function ($) {
        'use strict';
        setTimeout(function () {
            $("input.shipping_method").each(function (e) {
                var str_id = this.id || "";
                if (str_id.indexOf("{$dataObject->ups_shipping_id}") > 0) {
                    if (this.checked === true) {
                        if ($("form.woocommerce-shipping-calculator a.shipping-calculator-button")) {
                            $("form.woocommerce-shipping-calculator a.shipping-calculator-button").attr("style", "display:none");
                        }
                    }
                }
            });
        }, 1);

    })(jQuery);
</script>