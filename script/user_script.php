<script>
    function fetchUsers() {
        $.ajax({
            url: 'user_action.php',
            type: 'GET',
            success: function(response) {
                let itemRows = '';
                $.each(response, function(index, item) {
                    itemRows += `<tr>
                        <td>${item.id}</td>
                        <td>${item.username}</td>
                        <td>
                            <button class="btn btn-info btn-sm edit-btn" data-id="${item.id}">อัปเดท</button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="${item.id}">ลบ</button>
                        </td>
                    </tr>`;
                });
                $('#userTable').html(itemRows);
            },
            error: function() {
                alert('Failed to fetch users.');
            }
        });
    }

    $(document).ready(function() {
        // Fetch and display users
        fetchUsers();

        // delete user
        $(document).on('click', '.delete-btn', function() {
            let id = $(this).data('id');
            if (confirm('คุณแน่ใจว่าต้องการลบสินค้านี้หรือไม่')) {
                $.ajax({
                    url: 'user_action.php',
                    type: 'DELETE',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        alert(response.message);
                        fetchUsers();
                    },
                    error: function() {
                        alert('Failed to delete user.');
                    }
                });
            }
        });


        // form submit users
        $('#userForm').on('submit', function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: 'user_action.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    alert(response.message);
                    fetchUsers();
                    $('#userForm')[0].reset(); // Reset form
                },
                error: function() {
                    alert('Failed to process request.');
                }
            });
        });

        // Handle edit user
        $(document).on('click', '.edit-btn', function() {
            let id = $(this).data('id');
            $.ajax({
                url: 'user_action.php',
                type: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    $('#id').val(response.id);
                    $('#username').val(response.username);
                },
                error: function() {
                    alert('Failed to fetch user details.');
                }
            });
        });


    });
</script>