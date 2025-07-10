<?php
// Tệp PHP đơn giản để kiểm tra máy chủ
echo '<h1>Test Simple PHP</h1>';
echo '<p>Thời gian hiện tại: ' . date('Y-m-d H:i:s') . '</p>';
echo '<p>PHP Version: ' . phpversion() . '</p>';

// Hiển thị thông tin về $_SERVER
echo '<h2>$_SERVER Information</h2>';
echo '<pre>';
print_r($_SERVER);
echo '</pre>';