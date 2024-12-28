<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $message = htmlspecialchars($_POST['message']);
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['receipt']['name']);

    if (move_uploaded_file($_FILES['receipt']['tmp_name'], $uploadFile)) {
        echo "تم رفع الوصل بنجاح. شكرًا لك، $username!";
    } else {
        echo "حدث خطأ أثناء رفع الملف. يرجى المحاولة مرة أخرى.";
    }
}
?>
