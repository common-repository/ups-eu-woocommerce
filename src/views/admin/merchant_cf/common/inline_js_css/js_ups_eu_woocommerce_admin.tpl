<script type="text/javascript">
    {literal}
        (function ($) {
            'use strict';
            function alertError(message, title) {
                //Error
                $('#ups-alert-modal #ups-alert-modal-title').html(title);
                $('#ups-alert-modal .modal-body .alert').html(message);
                $('#ups-alert-modal').modal('show');
            }
            function alertMessage(message, title) {
                //Notification
                $('#ups-message-modal #ups-message-modal-title').html(title);
                $('#ups-message-modal .modal-body').html(message);
                $('#ups-message-modal').modal('show');
            }
            function alertConfirm(message, title) {
                //Confirm
                $('#ups-confirm-modal #ups-confirm-modal-title').html(title);
                $('#ups-confirm-modal .modal-body').html(message);
                $('#ups-confirm-modal').modal('show');
            }

            function hideAlertMessage() {
                $('#ups-confirm-modal').modal('hide');
            }

            function removeParams(sParam, link)
            {
                var url = link.split('?')[0] + '?';
                var sPageURL = decodeURIComponent(link.split('?')[1]),
                        sURLVariables = sPageURL.split('&'),
                        sParameterName,
                        i;

                for (i = 0; i < sURLVariables.length; i++) {
                    sParameterName = sURLVariables[i].split('=');
                    if ($.inArray(sParameterName[0], sParam) == -1) {
                        url = url + sParameterName[0] + '=' + sParameterName[1] + '&'
                    }
                }
                return url.substring(0, url.length - 1);
            }

            function repalceParams(sParam, link)
            {
                var url = link.split('?')[0] + '?';
                var sPageURL = decodeURIComponent(link.split('?')[1]),
                        sURLVariables = sPageURL.split('&'),
                        sParameterName,
                        i;

                for (i = 0; i < sURLVariables.length; i++) {
                    var check = true;
                    sParameterName = sURLVariables[i].split('=');
                    if (sParameterName[0] in sParam) {
                        if (sParam[sParameterName[0]] != false) {
                            sParameterName[1] = sParam[sParameterName[0]];
                        }
                        else {
                            check = false;
                        }

                        delete sParam[sParameterName[0]];
                    }

                    if (check) {
                        url = url + sParameterName[0] + '=' + sParameterName[1] + '&';
                    }

                }

                $.each(sParam, function (index, value) {
                    if (value != false) {
                        url = url + index + '=' + value + '&'
                    }
                });

                return url.substring(0, url.length - 1);
            }

            $(document).ready(function () {
                window.alertError = alertError;
                window.alertMessage = alertMessage;
                window.alertConfirm = alertConfirm;
                window.repalceParams = repalceParams;
                window.hideAlertMessage = hideAlertMessage;
                $(".formValidate").keypress(function (e) {
                    $(this).removeClass("formValidate");
                });

                $('meta[name="viewport"]').attr('content', 'width=1024');
                $('ul.wp-submenu li a[href="javascript:;"]').addClass('ups-menu-category');

                $('input[readonly="true"]').focus(function () {
                    $(this).trigger('blur');
                });

                // Set icon sort for page list
                $.urlParam = function (name) {
                    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                    if (results == null) {
                        return null;
                    }
                    return decodeURI(results[1]) || 0;
                }
                var sort_by = ($.urlParam('sort_by'));
                if (sort_by != '') {
                    var thSort = $('.page-sort[field-sort="' + sort_by + '"]');
                    var itemSort = thSort.find('a.icon-sort');
                    itemSort.removeClass('fa-sort fa-sort-down fa-sort-up');

                    (($.urlParam('sort_type')) == 'desc') ? itemSort.addClass('fa-sort-down') : itemSort.addClass('fa-sort-up');
                }

                // $('.page-sort[field-sort!="'+sort_by+'"]').addClass('fa-sort');

                var currentClassSort = 'fa-sort-none';
                var clickSort = false;
                $("th.page-sort")
                        .on("mouseenter", function () {
                            var itemSort = $(this).find('a.icon-sort');
                            var nextClassSort = '';
                            if (itemSort.hasClass('fa-sort-none')) {
                                currentClassSort = 'fa-sort-none';
                                var defaultSort = $(this).attr('default-sort');

                                if (defaultSort == undefined || defaultSort == 'up') {
                                    nextClassSort = 'fa-sort-up';
                                }
                                else {
                                    nextClassSort = 'fa-sort-down';
                                }

                            }
                            if (itemSort.hasClass('fa-sort-up')) {
                                currentClassSort = 'fa-sort-up';
                                nextClassSort = 'fa-sort-down';
                            }
                            if (itemSort.hasClass('fa-sort-down')) {
                                currentClassSort = 'fa-sort-down';
                                nextClassSort = 'fa-sort-up';
                            }

                            itemSort.removeClass(currentClassSort).addClass(nextClassSort);
                        })
                        .on("click", function (event) {
                            clickSort = true;
                        })
                        .on("mouseleave", function () {
                            if (clickSort == false) {
                                var itemSort = $(this).find('a.icon-sort');
                                itemSort.removeClass('fa-sort-none fa-sort-down fa-sort-up').addClass(currentClassSort);
                            }
                        });

                // Click sort
                $('.page-sort').click(function () {
                    var fieldSort = $(this).attr('field-sort');
                    var typeSort = 'desc';
                    var currentTypeSort = 'asc';
                    var itemSort = $(this).find('a.icon-sort');

                    if (itemSort.hasClass('fa-sort-up')) {
                        typeSort = 'asc';
                    }
                    else if (itemSort.hasClass('fa-sort-down')) {
                        typeSort = 'desc';
                    }

                    window.location = repalceParams({'sort_by': fieldSort, 'sort_type': typeSort, '__page': false}, window.location.href);
                });
            });

        })(jQuery);
    {/literal}
</script>