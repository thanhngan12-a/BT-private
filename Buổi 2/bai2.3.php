<?php
$diem = 7.5; // Bạn có thể thay đổi số điểm để kiểm tra

// Thứ tự kiểm tra từ cao xuống thấp[cite: 29]
if ($diem >= 8) {
    echo "Xếp loại: Giỏi";
} elseif ($diem >= 6.5) {
    echo "Xếp loại: Khá";
} elseif ($diem >= 5) {
    echo "Xếp loại: Trung bình";
} else {
    echo "Xếp loại: Chưa đạt";
}
?>
<br><br><hr style="border: 0; border-top: 1px solid #ccc; margin: 20px 0;">
<a href="index.php" style="display: inline-block; padding: 10px 20px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 5px; font-family: Arial, sans-serif; font-weight: bold;">
    &laquo; Quay về danh sách
</a>