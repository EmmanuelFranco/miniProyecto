<?php
session_start();
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recopila los datos del formulario
    $new_email = $_POST["new_email"];
    $new_password = $_POST["new_password"];

    // Validación de datos (puedes agregar más validaciones según tus requisitos)
    if (empty($new_email) || empty($new_password)) {
        $error = "Por favor, complete todos los campos obligatorios.";
    } else {
        // Verifica si el correo electrónico ya está en uso
        $existing_user_check = $conexion->prepare("SELECT * FROM usuarios WHERE email = ?");
        $existing_user_check->bind_param("s", $new_email);
        $existing_user_check->execute();
        $existing_user_result = $existing_user_check->get_result();

        if ($existing_user_result->num_rows > 0) {
            $error = "El correo electrónico ya está registrado. Intente con otro.";
        } else {
            // Hashea la contraseña antes de almacenarla en la base de datos
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Inserta el nuevo usuario en la tabla "usuarios", incluyendo email y contrasena
            $insert_user_sql = "INSERT INTO usuarios (email, contrasena) VALUES (?, ?)";
            $insert_user_query = $conexion->prepare($insert_user_sql);
            $insert_user_query->bind_param("ss", $new_email, $hashed_password);

            if ($insert_user_query->execute()) {
                // Usuario registrado con éxito
                $_SESSION["mensaje"] = "¡Registro exitoso! Ahora puedes iniciar sesión.";
                header("Location: login.php");
                exit();
            } else {
                $error = "Error al registrar el usuario. Por favor, inténtelo de nuevo.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="/style/login.css">
    <style>
    /* Estilo para el modo oscuro */
    .dark-mode {
        background-color: #333;
        /* Cambia el color de fondo a oscuro */
        color: #fff;
        /* Cambia el color del texto a claro */
        /* Agrega otros estilos oscuros según tus preferencias */
    }
    </style>
    <script>
    function toggleDarkMode() {
        // Obtén el elemento <body> y cambia su clase para habilitar o deshabilitar el modo oscuro
        document.body.classList.toggle("dark-mode");
    }
    </script>
    <title>Registro de Usuario</title>
</head>

<body>
    <div class="todo">

        <div class="centrar">

            <div class="chall" onclick="toggleDarkMode()">
                <!-- Agregamos un evento onclick para activar el modo oscuro -->
                <img id="dev" src="/assets/devchallenges.svg" alt="">
            </div>

            <h2 class="texto">
                Join thousands of learners from around the world
            </h2>

            <p class="parrafo">
                Master web development by making real-life projects.
                There are multiple paths for you to
                choose
            </p>

            <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <form method="post" action="register.php">
                <div class="">
                    <input type="text" name="new_email" placeholder="Email" required class="input-container">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                        <path
                            d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z">
                        </path>
                    </svg>
                </div>
                <div class="">
                    <input type="password" name="new_password" placeholder="Password" required class="input-container">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                        <path
                            d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z">
                        </path>
                    </svg>
                </div>
                <input type="submit" value="Start coding now " class="boton">
            </form>

            <spam class="spam1">or continue with these social profiles</spam>

            <div class="svg">
                <img class="goo" src="/assets/Google.svg" alt="">
                <img class="face" src="/assets/Facebook.svg" alt="">
                <img class="twi" src="/assets/Twitter.svg" alt="">
                <img class="gih" src="/assets/Gihub.svg" alt="">
            </div>

            <p>Already a member? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>

</html>