<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-pink">
                <div class="card-header">
                    <i class="fas fa-cart-plus"></i>
                    บันทึกการขาย
                </div>
                <form id="<?php echo basename(__DIR__)?>Form" method="post">
                    <div class="card-body">
                        <input type="hidden" id="id" name="id">
                        <div class="form-group">
                            <label for="name">เลือกสินค้า</label>
                            <select id="product" name="product_id" class="form-control" required>
                                <!-- รายการสินค้า -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="quantity">จำนวน</label>
                            <input type="number" id="quantity" name="quantity" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="total">ยอดเงิน</label>
                            <input type="text" id="total" name="total" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <form id="searchForm">
                    <div class="card-header">
                        <h3 class="card-title">
                            รายการขาย
                        </h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 190px;">
                                <input type="text" id="search" name="search" class="form-control float-right" placeholder="Search">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="card-body table-responsive p-0">
                    <table class="table table-head-fixed table-sm table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>สินค้า</th>
                            <th>จำนวน</th>
                            <th>ยอดเงิน</th>
                            <th>วันที่</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="<?php echo basename(__DIR__) ?>Table">
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>