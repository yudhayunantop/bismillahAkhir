<aside class="control-sidebar control-sidebar-dark">
    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>
 
<footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
        Sistem Informasi Peramalan Tagihan  
    </div>
    <strong>Copyright © 2021<a href="<?= base_url('/'); ?>"> SIMAL </a>.</strong> All rights reserved.
</footer>
</div>
 

<!-- REQUIRED SCRIPTS -->
<!-- Bootstrap 4 -->
<script src="<?= base_url('themes/plugins'); ?>/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Datatables -->
<script src="<?= base_url('themes/plugins'); ?>/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('themes/plugins'); ?>/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<!-- gijgo datepicker -->
<script src="<?= base_url('themes/plugins'); ?>/gijgo/js/gijgo.min.js"></script>

<!-- AdminLTE App -->
<script src="<?= base_url('themes/dist'); ?>/js/adminlte.min.js"></script>

<script src="<?= base_url('themes/plugins'); ?>/summernote/summernote-bs4.min.js"></script>
<script>
    function darkmode() {
        $("#switch-dark").attr("checked", "checked");
        $('body').addClass('dark-mode');
        localStorage.setItem("mode", "dark");
    }

    function lightmode() {
        $("#switch-dark").removeAttr("checked");
        $('body').removeClass('dark-mode');
        localStorage.setItem("mode", "light");
    }

    $(function() {

        if (localStorage.getItem("mode") == "dark") {
            darkmode();
        } else {
            lightmode();
        }

        $("#switch-dark").on("change", function() {
            if ($(this).prop("checked")) {
                darkmode();
            } else {
                lightmode();
            }
        });

        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        // Tooltip
        $('[data-toggle="tooltip"]').tooltip()

        $("#summernote").summernote({
            height: "200px",
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['misc', ['fullscreen', 'codeview', 'help']],
            ],
            callbacks: {
                onImageUpload: function(image) {
                    uploadImage(image[0]);
                },
                onMediaDelete: function(target) {
                    deleteImage(target[0].src);
                }
            }
        });

        function uploadImage(image) {
            var data = new FormData();
            data.append("image", image);
            $.ajax({
                url: "<?= base_url('dashboard/upload_image') ?>",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                success: function(url) {
                    $("#summernote").summernote("insertImage", url);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function deleteImage(src) {
            $.ajax({
                data: {
                    src: src
                },
                type: "POST",
                url: "<?= base_url('dashboard/delete_image') ?>",
                cache: false,
                success: function(response) {
                    console.log(response);
                }
            });
        }

        // Datepicker
        $(".gijgo").datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd',
            footer: true,
            modal: true,
            header: true,
            showRightIcon: false
        });

        $(".gijgo2").datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd',
            footer: true,
            modal: true,
            header: true,
            showRightIcon: false
        });

        // Datatable   
        var table = $("#tabledata").DataTable({
            dom: "<'row px-2 px-md-4 pt-2'<'col-md-3'l><'col-md-5 text-center'><'col-md-4'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row px-2 px-md-4 py-3'<'col-md-5'i><'col-md-7'p>>",
            lengthMenu: [
                [10, 50, 100, -1],
                [10, 50, 100, "All"]
            ],
            columnDefs: [{
                type: 'html-num',
                targets: '_all',
                orderable: true,
                searchable: true
            }]
        });
    })
</script>

</body>
</html>