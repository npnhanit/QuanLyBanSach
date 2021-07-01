<?php
$keyword = $_GET["search-tt"];
require "lib/conDB.php";
//
//proc_get_sl

$get_sl = proc_get_sl($keyword);
$sl = mysqli_fetch_array($get_sl);
?>

<div class="demuc"><?php echo 'Tìm thấy '.$sl[0].' kết quả cho từ khoá '.'"'.$keyword.'"';  ?></div>
<div class="khungsp">
    <?php
    $total = $sl[0];
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit = 9;

    $total_page = ceil($total / $limit);

    if ($current_page > $total_page)
        $current_page = $total_page;
    else if ($current_page < 1)
        $current_page = 1;

    $start = ($current_page - 1) * $limit;
//
//func_search
//
    $tin = func_search($keyword, $start, $limit);
    if ($tin) {
        while ($tin_row = mysqli_fetch_array($tin)) {
    ?>
            <a style="text-decoration:none;" href="../QuanLyBanHang/index.php?p=thongtinsanpham&sp=<?php echo $tin_row['MSHH']; ?>" class="sanpham">
                <div class="hinh"><img src="<?php echo $tin_row['srcHinh']; ?>" alt=""></div>
                <div class="tensach"><?php echo $tin_row["TenHH"]; ?></div>
                <div class="giasach"><i class="fa fa-gg" aria-hidden="true"></i> <?php echo number_format($tin_row["Gia"]);   ?><sup>đ</sup> <i class="fa fa-gg" aria-hidden="true"></i></div>
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
        echo '<a class="phantrang" href="index.php?search-tt=' . $key . '&page=' . ($current_page - 1) . '"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i></a>';
    }
    for ($i = 1; $i <= $total_page; $i++) {
        # code...
        if ($i == $current_page)
            echo '<div class="phantrang">' . ($i) . '</div>';
        else {
            $space = ' ';
            $plus = '+';
            $key2 = str_replace($space, $plus, $keyword);
            echo '<a class="phantrang" href="index.php?search-tt=' . $key2 . '&page=' . ($i) . '">' . ($i) . '</a>';
        }
    }
    if ($current_page < $total_page && $total_page > 1) {
        $space = ' ';
        $plus = '+';
        $key1 = str_replace($space, $plus, $keyword);
        echo '<a class="phantrang" href="index.php?search-tt=' . $key1 . '&page=' . ($current_page + 1) . '"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>';
    }
    ?>
</div>