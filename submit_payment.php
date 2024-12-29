<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // استلام البيانات من النموذج
    $customerName = htmlspecialchars($_POST['customerName']);
    $customerAccount = htmlspecialchars($_POST['customerAccount']);
    
    // معالجة ملف وصل الدفع
    $uploadDir = "uploads/";
    $fileName = basename($_FILES["paymentReceipt"]["name"]);
    $targetFilePath = $uploadDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $uploadSuccess = false;

    // التحقق من صيغة الملف
    $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];
    if (in_array(strtolower($fileType), $allowedTypes)) {
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true); // إنشاء مجلد التحميل إذا لم يكن موجودًا
        }

        // رفع الملف
        if (move_uploaded_file($_FILES["paymentReceipt"]["tmp_name"], $targetFilePath)) {
            $uploadSuccess = true;
        } else {
            $error = "حدث خطأ أثناء رفع الملف.";
        }
    } else {
        $error = "صيغة الملف غير مدعومة. يرجى رفع ملفات بصيغة JPG, PNG, أو PDF.";
    }

    // عرض رسالة النجاح أو الخطأ
    if ($uploadSuccess) {
        echo "<h1>تم استلام البيانات بنجاح</h1>";
        echo "<p>شكرًا لك، $customerName.</p>";
        echo "<p>رقم الحساب الذي دفعت منه: $customerAccount</p>";
        echo "<p>تم رفع وصل الدفع بنجاح.</p>";
        echo "<a href='$targetFilePath' target='_blank'>عرض وصل الدفع</a>";
    } else {
        echo "<h1>حدث خطأ</h1>";
        echo "<p>$error</p>";
    }
} else {
    echo "<h1>الدخول غير مسموح</h1>";
}
?>
