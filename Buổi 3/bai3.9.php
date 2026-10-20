<?php
$errors = [];
$data = ['project_name' => '', 'members_count' => '', 'description' => ''];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Làm sạch dữ liệu
    $data['project_name'] = trim($_POST['project_name'] ?? '');
    $data['members_count'] = trim($_POST['members_count'] ?? '');
    $data['description'] = trim($_POST['description'] ?? '');

    // Kiểm tra hợp lệ
    if ($data['project_name'] === '') {
        $errors['project_name'] = 'Vui lòng nhập tên đề tài.';
    } elseif (mb_strlen($data['project_name']) < 5) {
        $errors['project_name'] = 'Tên đề tài phải có ít nhất 5 ký tự.';
    }

    if ($data['members_count'] === '') {
        $errors['members_count'] = 'Vui lòng nhập số lượng thành viên.';
    } elseif (!filter_var($data['members_count'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 5]])) {
        $errors['members_count'] = 'Số lượng thành viên phải là số từ 1 đến 5.';
    }

    if ($data['description'] === '') {
        $errors['description'] = 'Vui lòng nhập mô tả chi tiết.';
    }

    if (empty($errors)) $success = true;
}

// Mã hóa chống XSS
function e($val) { return htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký đề tài</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; padding: 20px; flex-direction: column; }
        .form-container { background: white; padding: 30px 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 100%; max-width: 450px; margin-bottom: 20px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; font-size: 24px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: 600; margin-bottom: 8px; color: #555; font-size: 14px; }
        input[type="text"], input[type="number"], textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; font-size: 14px; transition: 0.3s; font-family: inherit; }
        input[type="text"]:focus, input[type="number"]:focus, textarea:focus { border-color: #6f42c1; outline: none; box-shadow: 0 0 5px rgba(111,66,193,0.2); }
        .error { color: #dc3545; font-size: 13px; margin-top: 5px; display: block; font-style: italic; }
        button { width: 100%; padding: 12px; background-color: #6f42c1; color: white; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.3s; margin-top: 10px; }
        button:hover { background-color: #59339d; }
        .success-box { text-align: center; padding: 20px; background: #e2d9f3; border: 1px solid #cbb8ea; border-radius: 8px; color: #43227e; }
        .back-btn { padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; transition: 0.3s; }
        .back-btn:hover { background: #5a6268; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Đăng Ký Đề Tài Bài Tập Lớn</h2>
        <?php if ($success): ?>
            <div class="success-box">
                <h3>Thành công!</h3>
                <p>Đề tài <strong><?= e($data['project_name']) ?></strong> đã được ghi nhận.</p>
            </div>
        <?php else: ?>
            <form method="post">
                <div class="form-group">
                    <label>Tên đề tài</label>
                    <input type="text" name="project_name" value="<?= e($data['project_name']) ?>" placeholder="Nhập tên đề tài...">
                    <?php if (isset($errors['project_name'])) echo "<span class='error'>{$errors['project_name']}</span>"; ?>
                </div>
                <div class="form-group">
                    <label>Số lượng thành viên (1-5)</label>
                    <input type="number" name="members_count" value="<?= e($data['members_count']) ?>">
                    <?php if (isset($errors['members_count'])) echo "<span class='error'>{$errors['members_count']}</span>"; ?>
                </div>
                <div class="form-group">
                    <label>Mô tả chi tiết</label>
                    <textarea name="description" rows="4" placeholder="Mô tả ngắn gọn về đề tài..."><?= e($data['description']) ?></textarea>
                    <?php if (isset($errors['description'])) echo "<span class='error'>{$errors['description']}</span>"; ?>
                </div>
                <button type="submit">Đăng Ký</button>
            </form>
        <?php endif; ?>
    </div>
    <a href="index.php" class="back-btn">&laquo; Quay về danh sách</a>
</body>
</html>