<?php
class Controlador {
    public function autenticarUsuario($usuario) {
        return $usuario->autenticar();
    }
}
?>