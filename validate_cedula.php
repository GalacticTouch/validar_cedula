<?php
header("Content-Type: application/json");

// Función para validar cédula usando módulo 10
function validarCedula($cedula) {
    // Verifica que tenga 11 dígitos
    if (strlen($cedula) != 11 || !ctype_digit($cedula)) {
        return ["valido" => false, "mensaje" => "Cédula inválida. Debe tener 11 dígitos numéricos."];
    }

    $sum = 0;
    for ($i = 0; $i < 11; $i++) {
        $num = (int)$cedula[$i];
        $mult = ($i % 2 == 0) ? 1 : 2; // Alterna multiplicador 1 o 2
        $producto = $num * $mult;
        $sum += ($producto >= 10) ? ($producto - 9) : $producto;
    }

    // Verifica si el módulo 10 es válido
    $esValido = $sum % 10 === 0;
    return [
        "valido" => $esValido,
        "mensaje" => $esValido ? "Cédula válida." : "Cédula inválida."
    ];
}

// Capturar cédula desde el método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $cedula = $data['cedula'] ?? '';
    echo json_encode(validarCedula($cedula));
} else {
    echo json_encode(["error" => "Método no soportado. Usa POST."]);
}
?>
