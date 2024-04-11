<?php
//Restricciones para tipo de usuarios
function accesoAdmin(): bool
{
    session_start();

    $acceso = $_SESSION['acceso'];
    if ($acceso) {
        return true;
    }
    return false;
}

?>