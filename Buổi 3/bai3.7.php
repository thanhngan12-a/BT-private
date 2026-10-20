<?php
$errors = [];
$data = ['name' => '', 'email' => '', 'birthday' => ''];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['name'] = trim($_POST['name'] ?? '');
    $data['email'] = trim($_POST['email'] ?? '');
    $data['birthday'] = trim($_POST['birthday'] ?? '');

    if ($data['name'] === '') $errors['name'] = 'Vui lòng nhập họ tên';
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Email không hợp lệ';
    if ($data['birthday'] === '') $errors['birthday'] = 'Vui lòng nhập ngày sinh';

    if (!$errors) $success = true;
}

function e($v) { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký Sinh viên</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; flex-direction: column; }
        .form-container { background: white; padding: 30px 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 100%; max-width: 400px; margin-bottom: 20px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; font-size: 24px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: 600; margin-bottom: 8px; color: #555; font-size: 14px; }
        input[type="text"], input[type="date"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; font-size: 14px; transition: 0.3s; }
        input[type="text"]:focus, input[type="date"]:focus { border-color: #007bff; outline: none; box-shadow: 0 0 5px rgba(0,123,255,0.2); }
        .error { color: #dc3545; font-size: 13px; margin-top: 5px; display: block; font-style: italic; }
        button { width: 100%; padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.3s; margin-top: 10px; }
        button:hover { background-color: #0056b3; }
        .success-box { text-align: center; padding: 20px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 8px; color: #155724; }
        .back-btn { padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; transition: 0.3s; display: inline-block; }
        .back-btn:hover { background: #5a6268; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Đăng Ký Sinh Viên</h2>
        <?php if ($success): ?>
            <div class="success-box">
                <h3>Thành công!</h3>
                <p>Đăng ký sinh viên hoàn tất.</p>
            </div>
        <?php else: ?>
            <form method="post">
                <div class="form-group">
                    <label>Họ tên</label>
                    <input type="text" name="name" value="<?= e($data['name']) ?>" placeholder="Nhập họ tên...">
                    <?php if (isset($errors['name'])) echo "<span class='error'>{$errors['name']}</span>"; ?>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" value="<?= e($data['email']) ?>" placeholder="example@gmail.com">
                    <?php if (isset($errors['email'])) echo "<span class='error'>{$errors['email']}</span>"; ?>
                </div>
                <div class="form-group">
                    <label>Ngày sinh</label>
                    <input type="date" name="birthday" value="<?= e($data['birthday']) ?>">
                    <?php if (isset($errors['birthday'])) echo "<span class='error'>{$errors['birthday']}</span>"; ?>
                </div>
                <button type="submit">Đăng Ký</button>
            </form>
        <?php endif; ?>
    </div>
    <a href="index.php" class="back-btn">&laquo; Quay về danh sách</a>
</body>
</html>