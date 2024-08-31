<script>
    $(document).ready(function () {
        // Fetch and display transactions
        fetchTransactions();
        fetchProducts(); // Load products into the dropdown

        // Handle form submission for adding/updating transactions
        $('#transactionForm').on('submit', function (e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                url: 'sale_action.php',
                type: 'POST',
                data: formData,
                success: function (response) {
                    alert(response.message);
                    fetchTransactions();
                    $('#transactionForm')[0].reset();  // Reset form
                    $('#total').val('');  // Clear total field
                },
                error: function () {
                    alert('Failed to process request.');
                }
            });
        });

        // Handle edit transaction
        $(document).on('click', '.edit-btn', function () {
            let id = $(this).data('id');
            $.ajax({
                url: 'sale_action.php',
                type: 'GET',
                data: {id: id},
                success: function (response) {
                    $('#transactionId').val(response.id);
                    $('#product').val(response.product_id);
                    $('#quantity').val(response.quantity);
                    $('#total').val(response.total);
                },
                error: function () {
                    alert('Failed to fetch transaction details.');
                }
            });
        });

        // Handle delete transaction
        $(document).on('click', '.delete-btn', function () {
            let id = $(this).data('id');
            if (confirm('Are you sure you want to delete this transaction?')) {
                $.ajax({
                    url: 'sale_action.php',
                    type: 'DELETE',
                    data: {id: id},
                    success: function (response) {
                        alert(response.message);
                        fetchTransactions();
                    },
                    error: function () {
                        alert('Failed to delete transaction.');
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
            let quantity = $('#quantity').val();
            let productId = $('#product').val();

            if (quantity && productId) {
                $.ajax({
                    url: 'product_action.php',
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
        function fetchTransactions() {
            $.ajax({
                url: 'sale_action.php',
                type: 'GET',
                success: function (response) {
                    let transactionRows = '';
                    $.each(response, function (index, transaction) {
                        transactionRows += `<tr>
                                <td>${transaction.id}</td>
                                <td>${transaction.product_name}</td>
                                <td>${transaction.quantity}</td>
                                <td>${transaction.total}</td>
                                <td>${transaction.transaction_date}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-btn" data-id="${transaction.id}">Edit</button>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="${transaction.id}">Delete</button>
                                </td>
                            </tr>`;
                    });
                    $('#transactionTable').html(transactionRows);
                },
                error: function () {
                    alert('Failed to fetch transactions.');
                }
            });
        }

        // Function to fetch products for the dropdown
        function fetchProducts() {
            $.ajax({
                url: 'sale_action.php',
                type: 'GET',
                data: {type: 'products'},
                success: function (response) {
                    let productOptions = '<option value="">Select Product</option>';
                    $.each(response, function (index, product) {
                        productOptions += `<option value="${product.id}">${product.name}</option>`;
                    });
                    $('#product').html(productOptions);
                },
                error: function () {
                    alert('Failed to fetch products.');
                }
            });
        }
    });
</script>