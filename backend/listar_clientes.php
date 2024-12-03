<?php
// Configuración de Supabase
define('SUPABASE_URL', 'https://isjrytlfjqiqosfnrbft.supabase.co');
define('SUPABASE_API_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImlzanJ5dGxmanFpcW9zZm5yYmZ0Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTczMzE5OTgyOCwiZXhwIjoyMDQ4Nzc1ODI4fQ.iwvfCUodF_gh7A1_74x89pyfNRrK3xaALcBHKK-NgOk');

// Configurar cURL para obtener los datos
$ch = curl_init(SUPABASE_URL . '/rest/v1/users');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer " . SUPABASE_API_KEY
]);

// Ejecutar la solicitud y obtener la respuesta
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

// Verificar si la respuesta fue exitosa
if ($http_code === 200) {
    $clients = json_decode($response, true); // Convertir la respuesta en un array asociativo
} else {
    echo "Error al obtener los usuarios.";
    exit;
}
?>
