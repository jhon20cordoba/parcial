<?php
// Configuración de Supabase
define('SUPABASE_URL', 'https://isjrytlfjqiqosfnrbft.supabase.co'); 
define('SUPABASE_API_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImlzanJ5dGxmanFpcW9zZm5yYmZ0Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzMxOTk4MjgsImV4cCI6MjA0ODc3NTgyOH0.KO0Nm1MQ9gQ-MCgom8Pt2HX25lxR8wXmb8dJ8sAdOAM'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validar contraseñas coincidan
    if ($password !== $confirm_password) {
        die("Passwords do not match!");
    }

    // Hash de la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Preparar los datos
    $data = [
        "first_name" => $first_name,
        "last_name" => $last_name,
        "email" => $email,
        "password" => $hashed_password
    ];

    // Enviar datos a Supabase
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, SUPABASE_URL . '/rest/v1/users'); // Cambia 'users' por el nombre de tu tabla
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'apikey: ' . SUPABASE_API_KEY,
        'Authorization: Bearer ' . SUPABASE_API_KEY
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code === 201) {
        echo "Account created successfully!";
    } else {
        echo "Error: " . $response;
    }
}
?>
