<?php
$fileAction = "pages/" . basename(__DIR__) . "/api.php";
$fileProductAPI = "pages/products/api.php";
?>
<script>
    $(document).ready(function () {
        // Fetch and display transactions
        fetch<?php echo basename(__DIR__); ?>();
        fetchProducts(); // Load products into the dropdown

        $('#searchForm').on('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            fetch<?php echo basename(__DIR__); ?>(formData.get('search'));
        });

        // Handle form submission for adding/updating transactions
        $('#<?php echo basename(__DIR__)?>Form').on('submit', function (e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                url: '<?php echo $fileAction; ?>',
                type: 'POST',
                data: formData,
                success: function (response) {
                    toastr.success(response.message);
                    fetch<?php echo basename(__DIR__); ?>();
                    $('#<?php echo basename(__DIR__)?>Form')[0].reset();  // Reset form
                    $('#total').val('');  // Clear total field
                },
                error: function () {
                    toastr.error('ล้มเหลวในการดำเนินการตามคำขอ');
                }
            });
        });

        // Handle edit transaction
        $(document).on('click', '.edit-btn', function () {
            let id = $(this).data('id');
            $.ajax({
                url: '<?php echo $fileAction; ?>',
                type: 'GET',
                data: {id: id},
                success: function (response) {
                    $('#id').val(response.id);
                    $('#product').val(response.product_id);
                    $('#quantity').val(response.quantity);
                    $('#total').val(response.total);
                },
                error: function () {
                    toastr.error('ดึงรายละเอียดข้อมูลล้มเหลว');
                }
            });
        });

        // Handle delete transaction
        $(document).on('click', '.delete-btn', function () {
            let id = $(this).data('id');
            if (confirm('คุณแน่ใจว่าต้องการลบรายการนี้หรือไม่?')) {
                $.ajax({
                    url: '<?php echo $fileAction; ?>',
                    type: 'DELETE',
                    data: {id: id},
                    success: function (response) {
                        toastr.success(response.message);
                        fetch<?php echo basename(__DIR__); ?>();
                    },
                    error: function () {
                        toastr.error('ล้มเหลวในการดำเนินการตามคำขอ');
                    }
                });
            }
        });

        // Update total based on quantity and product price
        $('#quantity').on('input', function () {
            updateTotal();
        });

        $('#product').on('change', function () {
            updateTotal();
        });

        function updateTotal() {
            let quantity  = $('#quantity').val();
            let productId = $('#product').val();

            if (quantity && productId) {
                $.ajax({
                    url: '<?php echo $fileProductAPI; ?>',
                    type: 'GET',
                    data: {id: productId},
                    success: function (response) {
                        let price = response.price;
                        let total = (quantity * price).toFixed(2);
                        $('#total').val(total);
                    }
                });
            } else {
                $('#total').val('');
            }
        }

        // Function to fetch and display transactions
        function fetch<?php echo basename(__DIR__); ?>(search = null) {


            $.ajax({
                url: '<?php echo $fileAction; ?>',
                type: 'GET',
                data: {
                    search: search
                },
                success: function (response) {
                    
                    let transactionRows = '';
                    $.each(response, function (index, item) {
                        const dateth = moment(item.transaction_date).fromNow();
                        transactionRows += `<tr>
                                <td style="width: 100px">${item.id}</td>
                                <td>${item.product.name}</td>
                                <td>${item.quantity}</td>
                                <td>${item.total}</td>
                                <td>${dateth}</td>
                                <td style="width: 100px">
                                    <button class="btn bg-gradient-primary btn-xs edit-btn" data-id="${item.id}">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </button>
                                    <button class="btn bg-gradient-danger btn-xs delete-btn" data-id="${item.id}">
                                        <i class="fas fa-fw fa-trash"></i>
                                    </button>
                                </td>
                            </tr>`;
                    });
                    $('#<?php echo basename(__DIR__)?>Table').html(transactionRows);
                },
                error: function () {
                    toastr.error('ดึงข้อมูลไม่สำเร็จ');
                }
            });
        }

        // Function to fetch products for the dropdown
        function fetchProducts() {
            $.ajax({
                url: '<?php echo $fileProductAPI; ?>',
                type: 'GET',
                success: function (response) {
                    let productOptions = '<option value="">Select Product</option>';
                    $.each(response, function (index, product) {
                        productOptions += `<option value="${product.id}">${product.name}</option>`;
                    });
                    $('#product').html(productOptions);
                },
                error: function () {
                    toastr.error('ดึงข้อมูลไม่สำเร็จ');
                }
            });
        }
    });
</script>