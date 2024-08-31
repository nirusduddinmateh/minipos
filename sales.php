<h3 class="mb-2">Sales Transactions</h3>
<div class="card">
    <div class="card-header">
        <b>Form Add/Edit Sale</b>
    </div>
    <div class="card-body">
        <form id="transactionForm" class="mb-4">
            <input type="hidden" id="transactionId" name="id">
            <div class="form-group">
                <label for="product">Product:</label>
                <select id="product" name="product_id" class="form-control">
                    <!-- รายการสินค้า -->
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" class="form-control">
            </div>
            <div class="form-group">
                <label for="total">Total:</label>
                <input type="text" id="total" name="total" class="form-control" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
<hr>
<h5>Sales Transaction</h5>
<table class="table table-sm table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Total</th>
        <th>Date</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody id="transactionTable">
        <!-- แสดงรายการ -->
    </tbody>
</table>
