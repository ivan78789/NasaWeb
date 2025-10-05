<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../config/mailer.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $name = $input['name'] ?? '';
    $email = $input['email'] ?? '';
    $subject = $input['subject'] ?? '';
    $message = $input['message'] ?? '';
    
    // Валидация
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Все поля обязательны для заполнения'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Неверный формат email'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    try {
        // Сохраняем в базу данных
        $sql = "INSERT INTO feedback (name, email, message, created_at) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $name,
            $email,
            $message,
            date('Y-m-d H:i:s')
        ]);
        
        // Отправляем email (если настроен)
        $email_subject = "Новое сообщение с сайта: " . $subject;
        $email_message = "
            <h3>Новое сообщение с сайта Disaster Alert</h3>
            <p><strong>Имя:</strong> " . htmlspecialchars($name) . "</p>
            <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
            <p><strong>Тема:</strong> " . htmlspecialchars($subject) . "</p>
            <p><strong>Сообщение:</strong></p>
            <p>" . nl2br(htmlspecialchars($message)) . "</p>
            <hr>
            <p><small>Отправлено: " . date('Y-m-d H:i:s') . "</small></p>
        ";
        
        // Отправляем email администратору
        $admin_email = 'admin@terraalert.kg'; // Замените на ваш email
        $sent = sendMail($admin_email, $email_subject, $email_message);
        
        // Отправляем подтверждение пользователю
        $user_subject = "Ваше сообщение получено - Disaster Alert";
        $user_message = "
            <h3>Спасибо за ваше сообщение!</h3>
            <p>Мы получили ваше сообщение и свяжемся с вами в ближайшее время.</p>
            <p><strong>Ваше сообщение:</strong></p>
            <p>" . nl2br(htmlspecialchars($message)) . "</p>
            <hr>
            <p><small>Disaster Alert / TerraAlert Team</small></p>
        ";
        
        sendMail($email, $user_subject, $user_message);
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Сообщение успешно отправлено!'
        ], JSON_UNESCAPED_UNICODE);
        
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Ошибка отправки сообщения: ' . $e->getMessage()
        ], JSON_UNESCAPED_UNICODE);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Метод не поддерживается'
    ], JSON_UNESCAPED_UNICODE);
}
?>
