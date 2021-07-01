<?php
if (isset($_GET["q"]))
    $q = $_GET["q"];
else $q = "";
?>
<div class="admin">
    <?php require "block/quyenad.php"; ?>
    <div class="noidungad">
        <?php
        switch ($q) {
            case "addsp":
                require "ad/addsp.php";
                break;
            case "updatesp":
                require "ad/updatesp.php";
                break;
            case "addnv":
                require "ad/addnv.php";
                break;
            case "dsnv":
                require "ad/dsnv.php";
                break;
            case "duyet":
                require "ad/duyet.php";
                break;
            case "chuaduyet":
                require "ad/chuaduyet.php";
                break;
            case "phanhoi":
                require "ad/phanhoi.php";
                break;
            default:
                require "ad/addsp.php";
                break;
        }
        ?>
    </div>
</div>
