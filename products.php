<h3 class="pl-1">Product CRUD</h3>
<div class="card">
    <div class="card-header">
        <b>Form Add/Edit Product</b>
    </div>
    <div class="card-body p-2">
        <form id="productForm" class="mb-4">
            <input type="hidden" id="productId" name="id">
            <div class="form-group mb-1">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control">
            </div>
            <div class="form-group mb-1">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control"></textarea>
            </div>
            <div class="form-group mb-1">
                <label for="price">Price:</label>
                <input type="text" id="price" name="price" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
<hr>
<h5 class="pl-1">Product List</h5>
<table class="table table-sm table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody id="productTable">
    <!-- display product list  -->
    </tbody>
</table>
