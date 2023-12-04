<?php
session_start();
include "conexion.php"; // Incluye un archivo de conexión a la base de datos

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php"); // Redirige al usuario a la página de inicio de sesión si no ha iniciado sesión
    exit();
}

$usuario_id = $_SESSION["usuario_id"];
$usuario_name = $_SESSION["usuario_nombre"];
$usuario_email = $_SESSION["usuario_email"];
$usuario_bio = $_SESSION["usuario_bio"];
$usuario_phone = $_SESSION["usuario_phone"];
$usuario_photo = $_SESSION["usuario_photo"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_name = $_POST["new_name"];
    $new_email = $_POST["new_email"];
    $new_bio = $_POST["new_bio"];
    $new_phone = $_POST["new_phone"];
    $new_password = $_POST["new_password"]; // Permitir cambiar la contraseña

    // Manejar la carga de una nueva foto de perfil
    if ($_FILES["new_photo"]["error"] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["new_photo"]["tmp_name"];
        $photo_name = $_FILES["new_photo"]["name"];

        // Ruta para guardar en la carpeta "perfil" dentro de "public"
        $photo_path = "public/perfil/" . $usuario_id . "_" . $photo_name;

        if (move_uploaded_file($tmp_name, $photo_path)) {
            // Si la carga de la foto de perfil fue exitosa, actualizar el campo "photo_url" en la base de datos
            $update_photo_sql = "UPDATE usuarios SET photo_url = '$photo_path' WHERE id = $usuario_id";

            $conexion->query($update_photo_sql);

            // Actualizar la URL de la foto en la sesión
            $_SESSION["usuario_photo"] = $photo_path;
        } else {
            $error = "Error al cargar la foto de perfil.";
        }
    }

    // Construir la consulta SQL para actualizar la información del usuario en la base de datos
    $update_sql = "UPDATE usuarios SET Name = '$new_name', email = '$new_email', bio = '$new_bio', phone = '$new_phone'";

    // Actualizar la contraseña solo si se proporciona una nueva contraseña
    if (!empty($new_password)) {
        // Hash de la nueva contraseña
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        // Actualizar la contraseña en la base de datos con la contraseña hasheada
        $update_sql .= ", contrasena = '$hashed_password'";
    }

    $update_sql .= " WHERE id = $usuario_id";

    // Ejecutar la consulta SQL para actualizar la base de datos
    if ($conexion->query($update_sql) === TRUE) {
        $_SESSION["usuario_nombre"] = $new_name;
        $_SESSION["usuario_email"] = $new_email;
        $_SESSION["usuario_bio"] = $new_bio;
        $_SESSION["usuario_phone"] = $new_phone;

        header("Location: index.php"); // Redirige al usuario a la página de inicio después de la actualización
        exit();
    } else {
        $error = "Error al actualizar la información. Por favor, intente de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <script>
        const trigger = document.getElementById('trigger');
        const options = document.getElementById('options');

        trigger.addEventListener('click', () => {
            options.style.display = options.style.display === 'block' ? 'none' : 'block';
        });
    </script>
    <link rel="stylesheet" type="text/css" href="/style/editarPerfil.css">
    <title>Editar Perfil</title>
</head>

<body>
    <div class="todo3">
        <div class="svg-container">
            <div class="dev2">
                <img id="" src="/assets/devchallenges.svg" alt="">
            </div>


            <div class="dropdown" id="trigger">

                <img src="<?php echo $usuario_photo; ?>" alt="Foto de perfil actual" width="50">
                <div class="nombreUsu"><?php echo $usuario_name; ?></div>
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512">
                    <path d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z" />
                </svg>

                <div class="dropdown-content" id="options">
                    <ul class="lista">
                        <li><a href="index.php">My Profile</a></li>
                        <li><a href="#">Group Chat</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>


        </div>
        <div>
            <a href="index.php" class="enlacevolver">Back</a>
            <div class="editInfo">
                <div class="chan">
                    <h2>Change Info</h2>
                    <p>Changes will be reflected to every services</p>
                </div>
                <div class="mitad">
                    <form method="post" action="editar_perfil.php" id="editForm" enctype="multipart/form-data">
                        <label style="margin-top: 10px; margin-left: 5rem;">Foto de Perfil:</label>
                        <input type="file" name="new_photo"><br>
                        <img src="<?php echo $usuario_photo; ?>" alt="Foto de perfil actual" width="100" style="margin-top: 10px; margin-left: 5rem;"><br>

                        <label style="margin-top: 10px; margin-left: 5rem;">Name</label><br>
                        <input type="text" name="new_name" required style="width: 416.93px; height: 52px; margin-top: 10px; margin-bottom: 10px; margin-left: 5rem; border-radius: 12px; border: 1px solid;"><br>

                        <label style="margin-top: 10px; margin-left: 5rem;">Bio</label><br>
                        <textarea name="new_bio" style="width: 416.93px; height: 91.58px; margin-top: 10px; margin-bottom: 10px; margin-left: 5rem; border-radius: 12px; border: 1px solid;"></textarea>
                        <br>

                        <label style="margin-top: 10px; margin-left: 5rem;">Phone</label><br>
                        <input type="text" name="new_phone" style="width: 416.93px; height: 52px; margin-top: 10px; margin-bottom: 10px; margin-left: 5rem; border-radius: 12px; border: 1px solid;"><br>

                        <label style="margin-top: 10px; margin-left: 5rem;">Email</label><br>
                        <input type="text" name="new_email" required style="width: 416.93px; height: 52px; margin-top: 10px; margin-bottom: 10px; margin-left: 5rem; border-radius: 12px; border: 1px solid;"><br>

                        <label style="margin-top: 10px; margin-left: 5rem;">PASSWORD</label><br>
                        <input type="password" name="new_password" style="width: 416.93px; height: 52px; margin-top: 10px; margin-bottom: 10px; margin-left: 5rem; border-radius: 12px; border: 1px solid;"><br>

                        <input type="submit" value="Save" style="width: 82px; height: 38px; margin-top: 10px; margin-bottom: 10px; margin-left: 5rem; border-radius: 8px; background-color: rgba(47, 128, 237, 1);">
                    </form>
                </div>
            </div>
        </div>

</body>

</html>