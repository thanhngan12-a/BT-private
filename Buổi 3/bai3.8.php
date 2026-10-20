<?php
$errors = [];
$data = ['name' => '', 'email' => '', 'subject' => '', 'message' => ''];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['name'] = trim($_POST['name'] ?? '');
    $data['email'] = trim($_POST['email'] ?? '');
    $data['subject'] = trim($_POST['subject'] ?? '');
    $data['message'] = trim($_POST['message'] ?? '');

    if ($data['name'] === '') $errors['name'] = 'Vui lòng nhập họ tên.';
    if ($data['message'] === '') $errors['message'] = 'Vui lòng nhập nội dung liên hệ.';
    if ($data['email'] === '') $errors['email'] = 'Vui lòng nhập email.';
    elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Email không hợp lệ.';

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['avatar'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if ($file['error'] !== UPLOAD_ERR_OK) $errors['avatar'] = 'Lỗi tải ảnh lên.';
        elseif ($file['size'] > 2097152) $errors['avatar'] = 'Ảnh không được vượt quá 2MB.';
        elseif (!in_array(mime_content_type($file['tmp_name']), $allowedTypes)) $errors['avatar'] = 'Chỉ nhận JPG, PNG, GIF.';
    } else {
        $errors['avatar'] = 'Vui lòng chọn ảnh đại diện.';
    }

    if (empty($errors)) $success = true;
}

function e($val) { return htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Form Liên Hệ</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; padding: 20px; flex-direction: column; }
        .form-container { background: white; padding: 30px 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 100%; max-width: 450px; margin-bottom: 20px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; font-size: 24px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: 600; margin-bottom: 8px; color: #555; font-size: 14px; }
        input[type="text"], textarea, input[type="file"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; font-size: 14px; transition: 0.3s; font-family: inherit; }
        input[type="text"]:focus, textarea:focus { border-color: #28a745; outline: none; box-shadow: 0 0 5px rgba(40,167,69,0.2); }
        .error { color: #dc3545; font-size: 13px; margin-top: 5px; display: block; font-style: italic; }
        button { width: 100%; padding: 12px; background-color: #28a745; color: white; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.3s; margin-top: 10px; }
        button:hover { background-color: #218838; }
        .success-box { text-align: center; padding: 20px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 8px; color: #155724; }
        .back-btn { padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; transition: 0.3s; }
        .back-btn:hover { background: #5a6268; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Gửi Liên Hệ</h2>
        <?php if ($success): ?>
            <div class="success-box"><h3>Gửi thành công!</h3><p>Cảm ơn bạn đã liên hệ.</p></div>
        <?php else: ?>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Họ tên</label>
                    <input type="text" name="name" value="<?= e($data['name']) ?>">
                    <?php if (isset($errors['name'])) echo "<span class='error'>{$errors['name']}</span>"; ?>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" value="<?= e($data['email']) ?>">
                    <?php if (isset($errors['email'])) echo "<span class='error'>{$errors['email']}</span>"; ?>
                </div>
                <div class="form-group">
                    <label>Chủ đề (Không bắt buộc)</label>
                    <input type="text" name="subject" value="<?= e($data['subject']) ?>">
                </div>
                <div class="form-group">
                    <label>Ảnh đại diện</label>
                    <input type="file" name="avatar" accept="image/*">
                    <?php if (isset($errors['avatar'])) echo "<span class='error'>{$errors['avatar']}</span>"; ?>
                </div>
                <div class="form-group">
                    <label>Nội dung</label>
                    <textarea name="message" rows="4"><?= e($data['message']) ?></textarea>
                    <?php if (isset($errors['message'])) echo "<span class='error'>{$errors['message']}</span>"; ?>
                </div>
                <button type="submit">Gửi Liên Hệ</button>
            </form>
        <?php endif; ?>
    </div>
    <a href="index.php" class="back-btn">&laquo; Quay về danh sách</a>
</body>
</html>