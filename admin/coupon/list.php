<div class="container mt-3">
    <h2>Mã giảm giá</h2>
    <a href="./index.php?view=add-coupon" class="btn btn-primary mb-3">Thêm mã giảm giá <i class="fas fa-plus"></i></a>
    <table class="table table-bordered">
        <thead>
            <tr class="bg-primary text-white">
                <th class="text-center">#</th>
                <th class="text-center">Mã giảm giá</th>
                <th class="text-center">Phần trăm giảm giá</th>
                <th class="text-center">Số tiền giảm giá</th>
                <th class="text-center">Ngày hết hạn</th>
                <th class="text-center">Còn hiệu lực</th>
                <th class="text-center">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include_once "../config/DBUntil.php";
            $db = new DBUntil();
            $coupon = $db->select("SELECT * FROM coupons");

            foreach ($coupon as $coupons) {
                echo "<tr>";
                echo "<td class='text-center'>" . $coupons['id'] . "</td>";
                echo "<td class='text-center'>" . $coupons['code'] . "</td>";
                echo "<td class='text-center'>" . $coupons['phan_tram_giam'] . "%</td>";
                echo "<td class='text-center'>" . $coupons['so_tien_giam'] . "$</td>";
                echo "<td class='text-center'>" . $coupons['ngay_het_han'] . "</td>";
                if ($coupons['con_hieu_luc'] == 1) {
                    echo "<td class='text-center'><span class='badge text-bg-success'>Còn hiệu lực</span></td>";
                } else {
                    echo "<td class='text-center'><span class='badge text-bg-danger'>Đã hết hiệu lực</span></td>";
                }
                echo "<td class='text-center'><a href='index.php?view=delete-coupon&id=" . $coupons['id'] . "' class='btn btn-danger btn-sm'><i class='bi bi-trash'></i></a></td>";
            }
            ?>
        </tbody>
    </table>
</div>