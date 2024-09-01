<!-- jQuery -->
<script src="adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Toastr -->
<script src="adminlte/plugins/toastr/toastr.min.js"></script>
<script src="adminlte/plugins/select2/js/select2.full.min.js"></script>
<!-- AdminLTE App -->
<script src="adminlte/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.30.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.30.1/locale/th.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-basic').select2(); //
        // เมื่อปิด model ให้ reset form
        $('.modal').on('hidden.bs.modal', function (e) {
            var formElement = $(this).find("form");
            formElement[0].reset();
        });
    });
</script>