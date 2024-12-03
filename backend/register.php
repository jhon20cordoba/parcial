<?php
// Configuración de Supabase
define('SUPABASE_URL', 'https://isjrytlfjqiqosfnrbft.supabase.co');
define('SUPABASE_API_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImlzanJ5dGxmanFpcW9zZm5yYmZ0Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTczMzE5OTgyOCwiZXhwIjoyMDQ4Nzc1ODI4fQ.iwvfCUodF_gh7A1_74x89pyfNRrK3xaALcBHKK-NgOk');

// Obtener datos del formulario
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Verificar si las contraseñas coinciden
if ($password !== $confirm_password) {
    echo "Las contraseñas no coinciden.";
    exit;
}

// Encriptar la contraseña
$password_hashed = password_hash($password, PASSWORD_DEFAULT);

// Datos a enviar a Supabase
$data = [
    "first_name" => $first_name,
    "last_name" => $last_name,
    "email" => $email,
    "password" => $password_hashed
];

// Configurar cURL
$ch = curl_init(SUPABASE_URL . '/rest/v1/users');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer " . SUPABASE_API_KEY
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Ejecutar la solicitud y manejar la respuesta
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($http_code === 201) {
    echo "Usuario registrado correctamente.";
} else {
    echo "Error al registrar el usuario: $response";
}

curl_close($ch);
?>
