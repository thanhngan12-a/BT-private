<?php
// 1. Tạo mảng $students gồm 3 sinh viên với name, midterm, final[cite: 36]
$students = [
    ['name' => 'Nguyễn Văn A', 'midterm' => 7.0, 'final' => 8.0],
    ['name' => 'Trần Thị B', 'midterm' => 4.0, 'final' => 5.0],
    ['name' => 'Lê Văn C', 'midterm' => 9.0, 'final' => 9.5]
];

// 2. Viết hàm calculateAverage() tính điểm trung bình[cite: 36]
function calculateAverage(float $midterm, float $final): float {
    return ($midterm + $final) / 2;
}
?>

<table border="1" cellpadding="10">
    <tr>
        <th>Họ tên</th>
        <th>Giữa kỳ</th>
        <th>Cuối kỳ</th>
        <th>Trung bình</th>
        <th>Kết quả</th>
    </tr>
    <?php
    // 3. Dùng foreach để in bảng HTML[cite: 36]
    foreach ($students as $student) {
        $avg = calculateAverage($student['midterm'], $student['final']);
        
        // 4. Thêm cột kết quả: Đạt nếu điểm trung bình >= 5[cite: 36]
        $ketQua = ($avg >= 5) ? 'Đạt' : 'Không đạt';
        
        // 5. Mã hóa tên sinh viên bằng htmlspecialchars() trước khi in[cite: 36]
        $safeName = htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8');
        
        echo "<tr>
                <td>{$safeName}</td>
                <td>{$student['midterm']}</td>
                <td>{$student['final']}</td>
                <td>{$avg}</td>
                <td>{$ketQua}</td>
              </tr>";
    }
    ?>
</table>