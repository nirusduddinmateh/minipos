<?php
$basename = basename(__DIR__);
$fileAction = "pages/" . $basename . "/api.php";
?>
<script>
    $(document).ready(function () {

        // การดึงและแสดงรายการ
        fetch<?php echo $basename; ?>();

        $('#searchForm').on('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            fetch<?php echo $basename; ?>(formData.get('search'));
        });

        // การเพิ่ม/อัปเดต
        $('#<?php echo $basename; ?>Form').on('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: '<?php echo $fileAction; ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.message) {
                        fetch<?php echo $basename?>();
                        $('#modal-<?php echo $basename ?>').modal('hide'); // ปิด modal
                        $('#<?php echo $basename; ?>Form')[0].reset();  // Reset form
                    }
                    toastr.success(response.message);
                },
                error: function () {
                    toastr.error('ล้มเหลวในการดำเนินการตามคำขอ');
                }
            });
        });

        // เมื่อคลิกปุ่มอัปเดทข้อมูล
        $(document).on('click', '.edit-btn', function () {
            let id = $(this).data('id');
            $.ajax({
                url: '<?php echo $fileAction; ?>',
                type: 'GET',
                data: {id: id},
                success: function (response) {
                    $('#id').val(response.id);
                    $('#name').val(response.name);
                    $('#role').val(response.role);
                    $('#username').val(response.username);
                    $('#modal-<?php echo $basename ?>').modal('show'); // เปิด modal
                },
                error: function () {
                    toastr.error('ดึงรายละเอียดข้อมูลล้มเหลว');
                }
            });
        });

        $(document).on('click', '.delete-btn', function () {
            let id = $(this).data('id');
            if (confirm('คุณแน่ใจว่าต้องการลบรายการนี้หรือไม่')) {
                $.ajax({
                    url: '<?php echo $fileAction; ?>',
                    type: 'DELETE',
                    data: {id: id},
                    success: function (response) {
                        toastr.warning(response.message);
                        fetch<?php echo $basename; ?>();
                    },
                    error: function () {
                        toastr.error('ล้มเหลวในการดำเนินการตามคำขอ');
                    }
                });
            }
        });
    });

    function fetch<?php echo $basename; ?>(search = null) {
        const tableSelector = $('#<?php echo $basename; ?>Table');

        $.ajax({
            url: '<?php echo $fileAction; ?>',
            type: 'GET',
            data: {
                search: search
            },
            success: function (response) {
                let rows = '';
                $.each(response, function (index, item) {
                    rows += `
                    <tr>
                        <td style="width: 100px">${item.id}</td>
                        <td>${item.username}</td>
                        <td>${item.name}</td>
                        <td>${item.role}</td>
                        <td style="width: 100px">
                            <button class="btn bg-gradient-primary btn-xs edit-btn" data-id="${item.id}"><i class="fas fa-fw fa-edit"></i></button>
                            <button class="btn bg-gradient-danger btn-xs delete-btn" data-id="${item.id}"> <i class="fas fa-fw fa-trash"></i></button>
                        </td>
                    </tr>`;
                });
                tableSelector.html(rows);
            },
            error: function () {
                toastr.error('ดึงข้อมูลไม่สำเร็จ');
            }
        });
    }
</script>