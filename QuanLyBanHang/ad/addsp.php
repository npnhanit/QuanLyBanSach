<div id="addsp">
    <form action="lib/insert_hh.php" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Nhập thông tin sản phẩm</legend>
            <div class="ndform">
                <div class="la">Nhập tên sản phẩm</div>
                <input required id="tensanpham" type="text" tabindex="1" name="tensanpham" class="khungadd ads" placeholder=" Nhập tên sản phẩm bạn muốn thêm vào">
                <br>
                <div class="la">Giá sản phẩm</div>
                <input required type="number" name="giasanpham" tabindex="2" class="khungadd ads" placeholder=" Nhập giá sản phẩm">
                <br>
                <div class="la">Số lượng</div>
                <input min=1 max=100 required type="number" name="soluongsanpham" tabindex="3" class="khungadd ads" placeholder=" Nhập số lượng sản phẩm">
                <br>
                <div class="la">Thể loại</div>
                <select name="theloai" class="khungadd ads" tabindex="4">
                    <optgroup label="Văn học">
                        <option value="Tiểu thuyết">Tiểu thuyết</option>
                        <option value="Truyện ngắn">Truyện ngắn</option>
                        <option value="Ngôn tình">Ngôn tình</option>
                    </optgroup>
                    <optgroup label="Thiếu nhi">
                        <option value="Truyện thiếu nhi">Truyện thiếu nhi</option>
                        <option value="Manga - Comic">Manga - Comic</option>
                        <option value="Tô màu, luyện chữ">Tô màu, luyện chữ</option>
                    </optgroup>
                    <optgroup label="Ngoại ngữ">
                        <option value="Tiếng Anh">Tiếng Anh</option>
                        <option value="Tiếng Nhật">Tiếng Nhật</option>
                        <option value="Tiếng Hoa">Tiếng Hoa</option>
                    </optgroup>
                    <optgroup label="Kỹ năng sống">
                        <option value="Rèn luyện nhân cách">Rèn luyện nhân cách</option>
                        <option value="Sách cho tuổi mới lớn">Sách cho tuổi mới lớn</option>
                        <option value="Hạt giống tâm hồn">Hạt giống tâm hồn</option>
                    </optgroup>
                </select>
                <br>
                <div class="la">Mô tả</div>
                <textarea required type="text" name="mota" class="khungadd ads" tabindex="5" cols="30" rows="7" placeholder=" Nhập mô tả sản phẩm"></textarea>
                <br>
                <input required type="file" class="khungadd ads" name="file[]" multiple="multiple" tabindex="6" placeholder="  Ảnh sản phẩm" />
                <br>
                <input type="submit" name="submit" value="Upload" class="fa fa-plus-square khungadd" tabindex="7" />
            </div>
        </fieldset>
    </form>
    <script>
        document.getElementById("tensanpham").focus();
    </script>
</div>