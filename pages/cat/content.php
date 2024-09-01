<div class="container-fluid">
    <div class="card">
        <form id="searchForm" >
            <div class="card-header">
                <h3 class="card-title">
                    รายการหมวดหมู่
                </h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 190px;">
                        <input type="text" id="search" name="search" class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#modal-<?php echo basename(__DIR__) ?>">
                                <i class="fas fa-plus"></i>
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
                    <th>Name</th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="<?php echo basename(__DIR__) ?>Table">
                </tbody>
            </table>
        </div>

    </div>
</div>

<div class="modal fade" id="modal-<?php echo basename(__DIR__) ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="<?php echo basename(__DIR__) ?>Form" enctype="multipart/form-data">
                <div class="modal-header bg-pink">
                    <h4 class="modal-title">แบบฟอร์ม</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="name">ชื่อหมวดหมู่</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>