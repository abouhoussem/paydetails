<?php
// التحقق من إرسال النموذج
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // بيانات الدفع
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $amount = htmlspecialchars($_POST['amount']);
    $message = htmlspecialchars($_POST['message']);

    // رفع ملف وصل الدفع
    $uploadDir = 'uploads/';
    $uploadedFile = $uploadDir . basename($_FILES['receipt']['name']);
    $uploadOk = 1;

    if (move_uploaded_file($_FILES['receipt']['tmp_name'], $uploadedFile)) {
        $fileStatus = "تم رفع الملف بنجاح.";
    } else {
        $fileStatus = "حدث خطأ أثناء رفع الملف.";
        $uploadOk = 0;
    }

    // إرسال إشعار إلى البريد الإلكتروني
    $to = 'ha2502ha@gmail.com';
    $subject = 'تفاصيل عملية الدفع';
    $body = "تم استلام تفاصيل الدفع:\n\n" .
            "اسم العميل: $username\n" .
            "البريد الإلكتروني: $email\n" .
            "المبلغ المدفوع: $amount\n" .
            "رسالة العميل: $message\n" .
            "رابط الملف المرفوع: " . ($uploadOk ? $_SERVER['HTTP_HOST'] . '/' . $uploadedFile : "لم يتم رفع الملف") . "\n";

    $headers = "From: no-reply@yourdomain.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8";

    if (mail($to, $subject, $body, $headers)) {
        $mailStatus = "تم إرسال البيانات بنجاح إلى بريدك الإلكتروني.";
    } else {
        $mailStatus = "فشل في إرسال البريد الإلكتروني.";
    }

    // رسالة الرد للمستخدم
    echo "<h1>شكرًا لتقديم التفاصيل</h1>";
    echo "<p>$fileStatus</p>";
    echo "<p>$mailStatus</p>";
} else {
    echo "<h1>لم يتم إرسال أي بيانات!</h1>";
}
?>
