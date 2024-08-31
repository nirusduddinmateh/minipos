<script>
    function fetchProducts() {
        $.ajax({
            url: 'product_action.php',
            type: 'GET',
            success: function(response) {
                let productRows = '';
                $.each(response, function(index, product) {
                    productRows += `<tr>
                        <td>${product.id}</td>
                        <td>${product.name}</td>
                        <td>${product.description}</td>
                        <td>${product.price}</td>
                        <td>
                            <button class="btn btn-info btn-sm edit-btn" data-id="${product.id}">อัปเดท</button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="${product.id}">ลบ</button>
                        </td>
                    </tr>`;
                });
                $('#productTable').html(productRows);
            },
            error: function() {
                alert('Failed to fetch products.');
            }
        });
    }

    $(document).ready(function() {
        // Fetch and display products
        fetchProducts();

        // delete product
        $(document).on('click', '.delete-btn', function() {
            let id = $(this).data('id');
            if (confirm('คุณแน่ใจว่าต้องการลบสินค้านี้หรือไม่')) {
                $.ajax({
                    url: 'product_action.php',
                    type: 'DELETE',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        alert(response.message);
                        fetchProducts();
                    },
                    error: function() {
                        alert('Failed to delete product.');
                    }
                });
            }
        });


        // form submit products
        $('#productForm').on('submit', function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: 'product_action.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    alert(response.message);
                    fetchProducts();
                    $('#productForm')[0].reset(); // Reset form
                },
                error: function() {
                    alert('Failed to process request.');
                }
            });
        });

        // Handle edit product
        $(document).on('click', '.edit-btn', function() {
            let id = $(this).data('id');
            $.ajax({
                url: 'product_action.php',
                type: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    $('#id').val(response.id);
                    $('#name').val(response.name);
                    $('#description').val(response.description);
                    $('#price').val(response.price);
                },
                error: function() {
                    alert('Failed to fetch product details.');
                }
            });
        });


    });
</script>