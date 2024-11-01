<style type="text/css">
    .ups-menu-category {
        font-weight: bold;
        padding-left: 4px !important;
        color: #e5e5e5!important;
        cursor: context-menu;
    }
    a.ups-menu-category:hover,a.ups-menu-category:focus {
        text-decoration: none;
        color: #e5e5e5!important;
    }
</style>
<script type="text/javascript">
    const menu = document.querySelectorAll('ul.wp-submenu li a[href="javascript:;"]');
    for (i = 0; i < menu.length; i++) {
        menu[i].classList.add('ups-menu-category');
    }
</script>
<script type="text/javascript">
    (function ($) {
        'use strict';
        function sync_ups_shipping_update() {
            var d = new Date();
            var time = d.getTime();
            $.ajax({
                type: "POST",
                url: '{$dataObject->router_url->url_ajax_json}&method=sync_ups_shipping',
                data: "key_run={$dataObject->key_run}&time=" + time,
                success: function (data)
                {
                },
                error: function ()
                {
                    console.log("error");
                }
            });
        }
        $(document).ready(function () {
            window.sync_ups_shipping_update = sync_ups_shipping_update;
            sync_ups_shipping_update();
        });
    })(jQuery);
</script>
