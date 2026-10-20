<?php
// Viết hàm isValidScore() và finalScore()[cite: 37]
function isValidScore(float $score): bool {
    return $score >= 0 && $score <= 10;
}

function finalScore(float $cc, float $mid, float $final): float {
    // Tính điểm tổng kết: 10% chuyên cần, 30% giữa kỳ, 60% cuối kỳ[cite: 37]
    return $cc * 0.10 + $mid * 0.30 + $final * 0.60;
}

$errors = [];
$data = ['name' => '', 'cc' => '', 'mid' => '', 'final' => ''];
$result = null;

// Dùng POST để gửi form[cite: 37]
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['name'] = trim($_POST['name'] ?? '');
    $data['cc'] = trim($_POST['cc'] ?? '');
    $data['mid'] = trim($_POST['mid'] ?? '');
    $data['final'] = trim($_POST['final'] ?? '');

    if ($data['name'] === '') {
        $errors['name'] = 'Vui lòng nhập họ tên';
    }

    $cc = (float)$data['cc'];
    $mid = (float)$data['mid'];
    $final = (float)$data['final'];

    // Hiển thị lỗi nếu điểm không nằm trong khoảng 0-10[cite: 37]
    if ($data['cc'] === '' || !isValidScore($cc)) $errors['cc'] = 'Điểm chuyên cần phải từ 0-10';
    if ($data['mid'] === '' || !isValidScore($mid)) $errors['mid'] = 'Điểm giữa kỳ phải từ 0-10';
    if ($data['final'] === '' || !isValidScore($final)) $errors['final'] = 'Điểm cuối kỳ phải từ 0-10';

    if (!$errors) {
        $tongKet = finalScore($cc, $mid, $final);
        
        // Xếp loại: giỏi, khá, trung bình, chưa đạt[cite: 37]
        if ($tongKet >= 8) $xepLoai = 'Giỏi';
        elseif ($tongKet >= 6.5) $xepLoai = 'Khá';
        elseif ($tongKet >= 5) $xepLoai = 'Trung bình';
        else $xepLoai = 'Chưa đạt';

        $result = "Điểm tổng kết của {$data['name']} là: <b>{$tongKet}</b> - Xếp loại: <b>{$xepLoai}</b>";
    }
}
?>

<!-- Tạo form nhập họ tên, điểm chuyên cần, điểm giữa kỳ, điểm cuối kỳ[cite: 37] -->
<form method="post">
    <!-- Giữ lại dữ liệu đã nhập khi có lỗi[cite: 37] -->
    <label>Họ tên:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($data['name']) ?>">
    <?php if (isset($errors['name'])) echo "<span style='color:red'>{$errors['name']}</span>"; ?>
    <br><br>

    <label>Điểm chuyên cần (10%):</label><br>
    <input type="number" step="0.1" name="cc" value="<?= htmlspecialchars($data['cc']) ?>">
    <?php if (isset($errors['cc'])) echo "<span style='color:red'>{$errors['cc']}</span>"; ?>
    <br><br>

    <label>Điểm giữa kỳ (30%):</label><br>
    <input type="number" step="0.1" name="mid" value="<?= htmlspecialchars($data['mid']) ?>">
    <?php if (isset($errors['mid'])) echo "<span style='color:red'>{$errors['mid']}</span>"; ?>
    <br><br>

    <label>Điểm cuối kỳ (60%):</label><br>
    <input type="number" step="0.1" name="final" value="<?= htmlspecialchars($data['final']) ?>">
    <?php if (isset($errors['final'])) echo "<span style='color:red'>{$errors['final']}</span>"; ?>
    <br><br>

    <button type="submit">Tính điểm tổng kết</button>
</form>

<?php if ($result): ?>
    <p><?= $result ?></p>
<?php endif; ?>