<?php
/* Eid moubark
 * By Yousef Alharbi
 * YKSAlharbi2030@gmail.com
*/

require 'php-gd.php'; // تحديث المسار لمكان مكتبة 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_name = htmlspecialchars($_POST["employee_name"], ENT_QUOTES, 'UTF-8');
    $fgd = new FarsiGD(); // إنشاء كائن من FarsiGD

    // تحديد مسار الصورة الأصلية
    $image_path = "img/your-image.jpg";
    $image = imagecreatefromjpeg($image_path);

    // اللون الأخضر للنص
    $color = imagecolorallocate($image, 149, 123, 89); // RGB للأخضر (0, 255, 0)

    // تحديد مكان النص
    $font_path = "arial.ttf";
    $font_size = 50; // حجم الخط

    // معالجة النص للكتابة بالعربية
    $processed_text = $fgd->persianText($employee_name, 'fa', 'normal');
    $text_box = imagettfbbox($font_size, 0, $font_path, $processed_text);
    $text_width = $text_box[2] - $text_box[0];
    $x = (imagesx($image) - $text_width) / 2;
    $y = imagesy($image) - 200; // تقليل قيمة 'y' لرفع النص قليلاً

    // إضافة النص إلى الصورة
    imagettftext($image, $font_size, 0, $x, $y, $color, $font_path, $processed_text);

    // تحديد اسم الملف الفريد للصورة المحفوظة
    $timestamp = time();
    $saved_file_path = "up/employee_image_$timestamp.jpg";

    // حفظ الصورة في مجلد 'up'
    imagejpeg($image, $saved_file_path);
    imagedestroy($image);

    // عرض الصورة مباشرة على الصفحة
    echo "<img src='$saved_file_path' alt='Employee Image' />";
}
?>
