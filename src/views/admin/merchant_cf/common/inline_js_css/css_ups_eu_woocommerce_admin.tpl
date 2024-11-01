<style type="text/css">
    {literal}
        /**
        * Bootstrap override
        */
        .modal{z-index: 9999}
        .datepicker-dropdown{
            margin-top: 50px!important;
            padding: 20px!important;
        }
        .datepicker-dropdown table tr td.active{
            border: 1px solid #adadad;
            background-color: #514943;
            color: white;
        }
        .datepicker-dropdown table tr td{
            cursor: pointer;
            padding: 10px;
            border: 1px solid #adadad;
            background: transparent;
            text-align: center;
        }
        .datepicker-dropdown table tr th.next,.datepicker-dropdown table tr th.prev{
            cursor: pointer;
            width: 15px;
            height: 15px;
            display: block;
            transform: rotate(45deg);
        }
        .datepicker-dropdown table tr th.next{
            border-top: 1px solid #514943;
            border-right: 1px solid #514943;
            float: left;
        }
        .datepicker-dropdown table tr th.prev{
            border-bottom: 1px solid #514943;
            border-left: 1px solid #514943;
            float: right;
        }
        .datepicker-dropdown table tr th.dow{
            font-weight: normal;
            text-align: center;
        }
        .datepicker-switch{
            text-align: center!important;
            font-weight: normal!important;
        }

        .ups-shipping-container h1{
            font: 20pt "Open Sans",Helvetica,Arial,sans-serif;
            font-weight: 400;
            color: #23282d;
        }
        .ups-shipping-container input[type="text"]{
            width: 100%;
        }
        .ups-shipping-container input[type="text"].width-with-tooltip, div.width-with-tooltip{
            width: 90%;
        }
        .ups-shipping-container .notice ul {
            padding-top: 10px;
            margin-bottom: 0px;
        }
        .ups-shipments {
            background-color: #FFF;
            padding: 20px;
            margin-right: 0px;
            min-width: 1020px;
        }
        .left-10 {
            margin-left: 10px;
        }

        @media screen and (max-width: 576px) {
            .ups-shipping-container input[type="text"].width-with-tooltip-sm, div.width-with-tooltip-sm{
                width: 90%;
            }
        }

        .ups-shipping-container select{
            height: 26px;
            font-size: inherit;
        }
        .ups-shipping-container label.strong {
            font-weight: 600;
        }

        .ups-shipping-container .small, .ups-shipping-container small {
            font-size: 95%;
        }
        .ups-shipping-container strong {
            font-weight: 600;
            color: #23282d;
        }

        .ups-shipping-container strong.title3 {
            font-size: 14px;
        }


        .ups-shipping-container .w-80 {
            width: 80%!important;
        }

        ::-webkit-input-placeholder {
            font-style: italic;
        }
        :-moz-placeholder {
            font-style: italic;
        }
        ::-moz-placeholder {
            font-style: italic;
        }
        :-ms-input-placeholder {
            font-style: italic;
        }


        @media screen and (max-width: 575px) {
            .ups-shipping-container .w-xs-100 {
                width: 100%!important;
            }

            .ups-shipping-container .w100-xs {
                width: 100px!important;
            }
        }

        /*@media (min-width: $screen-xs-min) {
        .col-xs-auto { width: auto; }
        }
        */


        /**
        * Bootstrap override end
        */
        /**
        * jQuery validate
        */
        input.error, input:focus.error{
            border: solid #dc3545 1px;
            -moz-box-shadow: 0 0 3px #dc3545;
            -webkit-box-shadow: 0 0 3px #dc3545;
            box-shadow: 0px 0 3px #dc3545;
        }
        label.error{
            color: #dc3545;
            top: -40px;
            position: absolute;
            border: solid 1px #dc3545;
            padding: 5px;
            border-radius: 4px;
            background: whitesmoke;
            -moz-box-shadow: 0 0 3px #dc3545;
            -webkit-box-shadow: 0 0 3px #dc3545;
            box-shadow: 0px 0 3px #dc3545;
        }
        label.error:before{
            content: '';
            position: absolute;
            bottom: -6px;
            background: whitesmoke;
            left: 12px;
            width: 10px;
            height: 10px;
            border-right: 1px solid red;
            border-bottom: 1px solid red;
            transform: rotate(45deg);
        }

        /**
        * jQuery validate end
        */



        /**
        * All of the CSS for your admin-specific functionality should be
        * included in this file.
        */

        body {
            background: #f1f1f1;
            color: #444;
            font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
            font-size: 13px;
            line-height: 1.4em;
        }

        h1, h2, h3, h4, h5, h6 {
            display: block;
            font-weight: 600;
        }
        h2, h3 {
            font-size: 1.3em;
            margin: 1em 0;
        }
        .card{
            padding: 0;
            margin: 0 auto;
        }
        .ups-full-width{
            width: 100%;
            max-width: calc(100% - 20px);
            margin-right : 20px;
        }
        .ups-header{
            margin: 15px;
        }
        .btn-step {
            color: #32373c;
        }
        .btn-step:hover {
            text-decoration: none;
            color: #32373c;
            font-weight: inherit;
        }

        .ups-header-title {
            margin-left: 10px;
            margin-top: 10px;
        }
        /*.ups-header-title .img-logo {
        font-size: 15pt;
        }*/
        .ups-header-title img{
            width: 50px;
        }
        .pull-right{
            float: right;
        }
        .pull-left{
            float: left;
        }
        .ups-default-border{
            border: 1px solid rgba(0,0,0,.125);
        }
        .wp-admin select.custom-select{
            height: calc(2.25rem + 2px);
            padding: .375rem 1.75rem .375rem .75rem;
            line-height: 1.5;
        }
        .more-info-area, .ups-input-group{
            position: relative;
        }
        .more-info-icon, .ups-input-append{
            position: absolute;
            right: -5px;
            top: 5px;
            z-index: 10;
        }

        /* The switch - the box around the slider
        https://www.w3schools.com/howto/howto_css_switch.asp
        */
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 25px;
        }

        /* Hide default HTML checkbox */
        .switch input {display:none;}

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #999;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 3px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #79a22e;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #79a22e;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(21px);
            -ms-transform: translateX(21px);
            transform: translateX(21px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
        .modal-dialog{
            max-width: 800px;
            top: 5%;
        }
        .more-info-text{
            position: absolute;
            top: -20px;
            left: 15px;
        }

        .form-checkbox label {
            margin-bottom: 0.2rem;
        }

        /*Tooltip*/
        .bs-tooltip-top .arrow, .bs-tooltip-bottom .arrow {
            left: 50%;
            margin-left: 0rem;
        }

        .bs-tooltip-left .arrow, .bs-tooltip-right .arrow {
            top: 50%;
            margin-top: -0.5rem;
        }
        a[data-toggle="tooltip"] {
            color: #666;
            font-size: 1.1em;
            font-style: normal;
            width: 13px;
            height: 13px;
            cursor: help;
            line-height: 0px;
            margin-left: 5px;
        }
        a[data-toggle="tooltip"]:focus  {
            outline: none;
            box-shadow: none;
        }

        a[data-toggle="tooltip"] i{
            font-size: 13px;
            font-weight: 700;
            font-style: normal;
            width: 13px;
        }

        .tooltip-inner {
            color: #fff;
            font-size: .8em;
            max-width: 150px;
            background: #333;
            text-align: center;
            border-radius: 3px;
            padding: .618em 1em;
            box-shadow: 0 1px 3px rgba(0,0,0,.2);
        }

        .tooltip.bs-tooltip-auto[x-placement^=top] .arrow::before, .tooltip.bs-tooltip-top .arrow::before {
            border-top-color: #333;
        }
        .tooltip.bs-tooltip-auto[x-placement^=right] .arrow::before, .tooltip.bs-tooltip-right .arrow::before {

            border-right-color: #333;
        }
        .tooltip.bs-tooltip-auto[x-placement^=bottom] .arrow::before, .tooltip.bs-tooltip-bottom .arrow::before {

            border-bottom-color: #333;
        }
        .tooltip.bs-tooltip-auto[x-placement^=left] .arrow::before, .tooltip.bs-tooltip-left .arrow::before {
            border-left-color: #333;
        }
        .table, .table td, .table td p, .table th{
            font-size: 14px;
        }
        .table th {
            vertical-align: top;
            width: 200px;
            line-height: 1.3;
            font-weight: 600;
            white-space: nowrap;
        }

        .formValidate{
            border: solid 1px #dc3545 !important;
            -moz-box-shadow: 0 0 3px #dc3545 !important;
            -webkit-box-shadow: 0 0 3px #dc3545 !important;
            box-shadow: 0px 0 3px #dc3545 !important;
        }

        .warningValidate{
            border: solid 1px #ffc107 !important;
            -moz-box-shadow: 0 0 3px #ffc107 !important;
            -webkit-box-shadow: 0 0 3px #ffc107 !important;
            box-shadow: 0px 0 3px #ffc107 !important;
        }
        .validateTitle{
            color: #dc3545  !important;
            display: block;
        }
        .ups-shipping-container .label-fix {
            margin-bottom: 0px;
            line-height: 25px;
        }
        .ups-shipping-container .label-fix-mb-3 {
            margin-bottom: .2rem;
        }

        .ups-shipping-container .label-fix-- {
            margin-bottom: 0px;
        }

        @media screen and (max-width: 782px) and (min-width: 576px) {
            .ups-shipping-container .label-fix {
                line-height: 30px;
            }
        }
        @media (min-width: 768px) and (max-width: 1024px) {
            .ups-shipping-container{
                display: block;
                overflow-x: scroll!important;
            }
        }
        @media screen and (min-width: 992px) and (max-width: 1199px) {
            .col-first-fix {
                -ms-flex: 0 0 22.5%;
                flex: 0 0 22.5%;
                max-width: 22.5%;
            }
            .col-mid-fix {
                -ms-flex: 0 0 35%;
                flex: 0 0 35%;
                max-width: 35%;
                padding-left: 2px;
                padding-right: 2px;
            }
            .col-last-fix {
                -ms-flex: 0 0 42.5%;
                flex: 0 0 42.5%;
                max-width: 42.5%;
                padding-left: 5px!important;
                padding-right: 0px!important;
            }
        }

        @media (min-width: 1200px) and (max-width: 1230px) {
            .col-first-fix {
                -ms-flex: 0 0 18%;
                flex: 0 0 18%;
                max-width: 18%;
            }
            /* .col-mid-fix {
            -ms-flex: 0 0 20%;
            flex: 0 0 20%;
            max-width: 20%;
            }*/
            .col-last-fix {
                -ms-flex: 0 0 48%;
                flex: 0 0 48%;
                max-width: 48%;
            }
        }

        @media (min-width: 1200px) and (max-width: 1400px) {
            .xl-fix-none-account .left-fix {
                flex: 0 0 46%;
                max-width: 46%;
                padding-right: 2px;
            }

            .xl-fix-none-account .right-fix {
                flex: 0 0 54%;
                max-width: 54%;
            }

            .xl-fix-success-account .left-fix {
                flex: 0 0 26.8%;
                max-width: 26.8%;
                padding-right: 2px;
            }

            .xl-fix-success-account .right-fix {
                flex: 0 0 73.2%;
                max-width: 73.2%;
            }
        }

        @media (min-width: $screen-xs-min) {
            .col-xs-auto { width: auto; }
        }
        @media (min-width: $screen-sm-min) {
            .col-sm-auto { width: auto; }
        }
        @media (min-width: $screen-md-min) {
            .col-md-auto { width: auto; }
        }
        @media (min-width: $screen-lg-min) {
            .col-lg-auto { width: auto; }
        }
        .title-tab,
        .title-tab i,
        .title-tab strong {
            font-size: 20px;
            font-weight: 400;
        }
        #content-print {
            color: #41362f;
            font-family: 'Open Sans','Helvetica Neue',Helvetica,Arial,sans-serif;
            font-style: normal;
            font-weight: 400;
            line-height: 1.36;
            font-size: 15px;
        }

        body.mobile.modal-open #wpwrap{
            position: initial;
        }



        /* - Chrome ≤56,
        - Safari 5-10.0
        - iOS Safari 4.2-10.2
        - Opera 15-43
        - Opera Mobile 12-12.1
        - Android Browser 2.1-4.4.4
        - Samsung Internet ≤6.2
        - QQ Browser */
        ::-webkit-input-placeholder {
            color: #ccc;
            font-weight: 400;
        }

        /* Firefox 4-18 */
        :-moz-placeholder {
            color: #ccc;
            font-weight: 400;
        }

        /* Firefox 19-50 */
        ::-moz-placeholder {
            color: #ccc;
            font-weight: 400;
        }

        /* - Internet Explorer 10–11
        - Internet Explorer Mobile 10-11 */
        :-ms-input-placeholder {
            color: #ccc !important;
            font-weight: 400 !important;
        }

        /* Edge (also supports ::-webkit-input-placeholder) */
        ::-ms-input-placeholder {
            color: #ccc;
            font-weight: 400;
        }

        /* CSS Pseudo-Elements Level 4 Editor's Draft
        - Browsers not mentioned in vendor prefixes
        - Browser of newer versions than mentioned in vendor prefixes */
        ::placeholder {
            color: #ccc;
            font-weight: 400;
        }
        .ml-shipping-ap {
            margin-left: 262px;
        }
        .ml-shipping-ad {
            margin-left: 300px;
        }
        .hr-shipping {
            border-top: 1px solid rgba(0, 0, 0, 0.28);
        }
        img.checkedCOD {
            text-indent: 25px;
            height: 16px;
            padding: 0px;
            margin: auto!important;
        }

        a.fa-sort,
        a.fa-sort-up,
        a.fa-sort-down {
            text-decoration: none;
            color: #000;
            outline: none;
            box-shadow: none;
        }

        #loadingDiv{
            position: fixed;
            width: 100%;
            z-index: 9999999;
            background-color: #000;
            opacity: .5;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }
        #loadingDiv img{
            left: 50%;
            position: absolute;
            top: 50%;
        }

        .modal-title {
            font-size: 1rem;
            text-indent: 38px;
            margin-left: 1rem;
            line-height: 36px;
            font-weight: bold;
        }

        .modal-body {
            padding: 2rem;
        }

        th.page-sort {
            cursor: pointer;
        }
        a.icon-sort {
            width: 5px;
        }
        /*.fa-sort-none:before {
        content: '\f105';
        width: 12px;
        white-space: pre;
        }*/
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

        #add-package {
            text-indent: 25px;
        }

        #remove-package {
            min-height: 25px;
        }
        .hidden{display: none;}

        table.info-shipment tr{
            vertical-align: top;
        }
        ._upsTitle{
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            color:#32373c;
            font-weight: 400;
        }
    {/literal}
    img.checkedCOD {
        background: url({$img_url}checked.png) no-repeat center left;
    }
    #add-package {
        background: url({$img_url}add.png) no-repeat center left;
    }
    #remove-package {
        background: url({$img_url}removePackage.png) no-repeat center left;
    }
    .modal-title {
        background: url({$img_url}UPS_logo2.svg) no-repeat 0px 0px;
    }
</style>
