<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
    data-accordion="false">
    <li class="nav-item">
        <a href="index.php?page=dashboard" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
                Dashboard
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="index.php?page=sales" class="nav-link">
            <i class="nav-icon fas fa-cart-plus"></i>
            <p>
                การขาย
            </p>
        </a>
    </li>

    <?php if ($_SESSION['role'] == 'admin'): ?>
        <li class="nav-header">ข้อมูลพื้นฐาน</li>
        <li class="nav-item">
            <a href="index.php?page=products" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>สินค้า</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="index.php?page=cat" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>หมวดหมู่</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="index.php?page=users" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>แอดมิน</p>
            </a>
        </li>
    <?php endif ?>

    <li class="nav-header"></li>
    <li class="nav-item">
        <a href="logout.php" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
                ออกจากระบบ
            </p>
        </a>
    </li>
    </ul>