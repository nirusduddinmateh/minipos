<h3 class="pl-1">User CRUD</h3>
<div class="card">
    <div class="card-header">
        <b>Form Add/Edit User</b>
    </div>
    <div class="card-body p-2">
        <form id="userForm" class="mb-4">
            <input type="hidden" id="id" name="id">
            <div class="form-group mb-1">
                <label for="username">username:</label>
                <input type="text" id="username" name="username" class="form-control">
            </div>
            <div class="form-group mb-1">
                <label for="password">password:</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
<hr>
<h5 class="pl-1">User List</h5>
<table class="table table-sm table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody id="userTable">
    <!-- display product list  -->
    </tbody>
</table>
