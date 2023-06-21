<?php

namespace Controller\Admin;

class UploadFile {
    public function __construct()
    {
        $this->uploadImage();
    }

    public function uploadImage()
    {
        // file upload.php xử lý upload file
        if  ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            // Dữ liệu gửi lên server không bằng phương thức post
            echo json_encode(0);
        }

        // Kiểm tra có dữ liệu fileupload trong $_FILES không
        // Nếu không có thì dừng
        if (!isset($_FILES['thumbnail_image'])) {
            echo json_encode(0);
        }

        // Kiểm tra dữ liệu có bị lỗi không
        if ($_FILES['thumbnail_image']['error'] != 0) {
            echo json_encode(0);
        }

        // Đã có dữ liệu upload, thực hiện xử lý file upload
        $target_dir    = "assets/Upload/";
        //Vị trí file lưu tạm trong server (file sẽ lưu trong uploads, với tên giống tên ban đầu)
        $target_file = $target_dir . basename($_FILES['thumbnail_image']['name']);
        $allowUpload = true;

        //Lấy phần mở rộng của file (jpg, png, ...)
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        // Cỡ lớn nhất được upload (bytes)
        $maxfilesize   = 800000;

        ////Những loại file được phép upload
        $allowtypes = array('jpg', 'png', 'jpeg', 'gif');

        if (isset($_POST['submit'])) {
            //Kiểm tra xem có phải là ảnh bằng hàm getimagesize
            $check = getimagesize($_FILES['thumbnail_image']['tmp_name']);
            if ($check !== false) {
                $result = 0;
                $allowUpload = true;
            } else {
                $result = 0;
                $allowUpload = false;
            }
        }

        // Kiểm tra nếu file đã tồn tại thì không cho phép ghi đè
        // Bạn có thể phát triển code để lưu thành một tên file khác
        if (file_exists($target_file)) {
            $result = ROOT_URL . '/' . $target_file;;
            $allowUpload = false;
        }
        // Kiểm tra kích thước file upload cho vượt quá giới hạn cho phép
        if ($_FILES['thumbnail_image']['size'] > $maxfilesize) {
            $result = 0;
            $allowUpload = false;
        }

        // Kiểm tra kiểu file
        if (!in_array($imageFileType,$allowtypes)) {
            $result = "Chỉ được upload các định dạng JPG, PNG, JPEG, GIF";
            $allowUpload = false;
        }

        if ($allowUpload) {
            // Xử lý di chuyển file tạm ra thư mục cần lưu trữ, dùng hàm move_uploaded_file
            if (move_uploaded_file($_FILES["thumbnail_image"]["tmp_name"], $target_file)) {
                $result = ROOT_URL . '/' . $target_file;
            } else {
                $result = 0;
            }
        }

        echo json_encode($result);
    }
}

//call class
$uploadFile = new UploadFile();
