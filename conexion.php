<?php

$host = "localhost";
$usuario = "root";
$password ="";
$database = "login_db";

$conexion = new mysqli($host, $usuario, $password, $database);

if ($conexion-> connect_error) {
    die('Error de conección: ' . $conexion->connect_error);
}

