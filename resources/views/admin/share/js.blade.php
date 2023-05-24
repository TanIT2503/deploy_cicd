<!-- BEGIN: Vendor JS-->
<script src="/assets_admin_vuxy/app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="/assets_admin_vuxy/app-assets/vendors/js/ui/jquery.sticky.js"></script>
{{-- <script src="/assets_admin_vuxy/app-assets/vendors/js/extensions/toastr.min.js"></script> --}}
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="/assets_admin_vuxy/app-assets/js/core/app-menu.min.js"></script>
<script src="/assets_admin_vuxy/app-assets/js/core/app.min.js"></script>
<script src="/assets_admin_vuxy/app-assets/js/scripts/customizer.min.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
{{-- <script src="/assets_admin_vuxy/app-assets/js/scripts/pages/dashboard-ecommerce.min.js"></script> --}}
<!-- END: Page JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.1.3/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    });
</script>
<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000",
        "extendedTimeOut": "2000",
    }
</script>
<style>
    .toast-top-right {
        top: 65px !important;
    }
</style>

