<?php
$basename = basename(__DIR__);
$fileAPI = "pages/" . $basename . "/api.php";
?>
<script>
    $(document).ready(function () {
        // การดึงและแสดงรายการ
        fetch<?php echo $basename; ?>();
        fetchCat();

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
                url: '<?php echo $fileAPI; ?>',
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
                url: '<?php echo $fileAPI; ?>',
                type: 'GET',
                data: {id: id},
                success: function (response) {
                    $('#id').val(response.id);
                    $('#cat_id').val(response.cat_id);
                    $('#name').val(response.name);
                    $('#description').val(response.description);
                    $('#price').val(response.price);

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
                    url: '<?php echo $fileAPI; ?>',
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
            url: '<?php echo $fileAPI; ?>',
            type: 'GET',
            data: {
                search: search
            },
            success: function (response) {
                let rows = '';
                $.each(response, function (index, item) {
                    let image = 'No image';
                    if (item.image) {
                        image = `<img src="uploads/${item.image}" alt="" width="40">`
                    }
                    rows += `
                    <tr>
                        <td style="width: 100px">${item.id}</td>
                        <td>${image}</td>
                        <td>${item.cat.name}</td>
                        <td>${item.name}</td>
                        <td>${nl2br(item.description)}</td>
                        <td>${item.price}</td>
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

    function fetchCat() {
            $.ajax({
                url: 'pages/cat/api.php',
                type: 'GET',
                success: function (response) {
                    let options = '<option value="">Select Cat</option>';
                    $.each(response, function (index, item) {
                        options += `<option value="${item.id}">${item.name}</option>`;
                    });
                    $('#cat_id').html(options);
                },
                error: function () {
                    toastr.error('ดึงข้อมูลไม่สำเร็จ');
                }
            });
        }

    function nl2br (str, replaceMode, isXhtml) {
        let breakTag = (isXhtml) ? '<br />' : '<br>';
        let replaceStr = (replaceMode) ? '$1'+ breakTag : '$1'+ breakTag +'$2';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, replaceStr);
    }
</script>