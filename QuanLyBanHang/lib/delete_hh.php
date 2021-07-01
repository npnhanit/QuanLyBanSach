<?php>
$keyword = $_GET["s-xoasp"];
require "lib/conDB.php";
?>
<div class="khungsp">
    <?php
    $total_query = mysqli_query($conn, "      
        select a.MSHH
        from hanghoa a, hinh c, nhomhanghoa b
        where a.MaNhom = b.MaNhom and 
            (a.TenHH REGEXP '$keyword' or a.TenHH like '%$keyword%' or 
            b.TenNhom REGEXP '$keyword' or b.TenNhom like '%$keyword%') and 
            a.MSHH = c.MaHinh  
        group by a.TenHH    
        order by MSHH ASC
    ");
    $total = mysqli_num_rows($total_query);
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit = 6;

    $total_page = ceil($total / $limit);

    if ($current_page > $total_page)
        $current_page = $total_page;
    else if ($current_page < 1)
        $current_page = 1;

    $start = ($current_page - 1) * $limit;
    $tin = search($keyword, $start, $limit);
    // $row = mysqli_num_rows($tin)
    if ($tin) {
        while ($tin_row = mysqli_fetch_array($tin)) {

    ?>
            <a href="#" class="sanpham">
                <div class="hinh"><img src="<?php echo $tin_row['srcHinh']; ?>" alt=""></div>
                <div class="tensach"><?php echo $tin_row["TenHH"]; ?></div>
                <div class="giasach"><i class="fa fa-gg" aria-hidden="true"></i> <?php echo $tin_row["Gia"];   ?> đồng <i class="fa fa-gg" aria-hidden="true"></i></div>
            </a>
    <?php
        }
    } else echo "Không tìm thấy kết quả";
    ?>

</div>
<div class="splitpage">
    <?php
    if ($current_page > 1 && $total_page > 1) {
        $space = ' ';
        $plus = '+';
        $key = str_replace($space, $plus, $keyword);
        echo '<a class="phantrang" href="index.php?s-xoasp=' . $key . '&page=' . ($current_page - 1) . '"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i></a>';
    }
    for ($i = 1; $i <= $total_page; $i++) {
        if ($i == $current_page)
            echo '<div class="phantrang">' . ($i) . '</div>';
        else {
            $space = ' ';
            $plus = '+';
            $key2 = str_replace($space, $plus, $keyword);
            echo '<a class="phantrang" href="index.php?s-xoasp=' . $key2 . '&page=' . ($i) . '">' . ($i) . '</a>';
        }
    }

    if ($current_page < $total_page && $total_page > 1) {
        $space = ' ';
        $plus = '+';
        $key1 = str_replace($space, $plus, $keyword);
        echo '<a class="phantrang" href="index.php?s-xoasp=' . $key1 . '&page=' . ($current_page + 1) . '"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>';
    }
    ?>
</div>