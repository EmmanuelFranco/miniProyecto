<?php
session_start();
include "conexion.php";

if (!isset($_SESSION["usuario_id"])) {
    header("location: /login.php");
    exit();
}

$usuario_id = $_SESSION["usuario_id"];
$usuario_name = $_SESSION["usuario_nombre"];
$usuario_email = $_SESSION["usuario_email"];
$usuario_photo = $_SESSION["usuario_photo"];
$usuario_bio = $_SESSION["usuario_bio"];
$usuario_phone = $_SESSION["usuario_phone"];
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="/style/index.css">
    <title>Página de Inicio</title>
    <script>
        const trigger = document.getElementById('trigger');
        const options = document.getElementById('options');

        trigger.addEventListener('click', () => {
            options.style.display = options.style.display === 'block' ? 'none' : 'block';
        });
    </script>
</head>

<body>
    <div class="todo1">
        <div class="svg-container">
            <div class="dev1">
                <img id="" src="/assets/devchallenges.svg" alt="">
            </div>

            <div class="dropdown" id="trigger">

                <img src="<?php echo $usuario_photo; ?>" alt="Foto de perfil actual" width="50">
                <div class="nombreUsu"><?php echo $usuario_name; ?></div>
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512">
                    <path d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z" />
                </svg>

                <div class="options" id="options">
                    <ul class="lista">
                        <li><a href="index.php">My Profile</a></li>
                        <li><a href="#">Group Chat</a></li>
                        <li><a href="logout.php">Logout</a></li> <!-- Updated path -->
                    </ul>
                </div>
            </div>

        </div>

        <div class="titulo">
            <h2>Personal info</h2>
            <p>Basic info, like your name and photo</p>
        </div>
        <div class="perfil">
            <div class="profil">
                <div class="">
                    <h3 class="pro">Profile</h3>
                    <p class="inf">Some info may be visible to other people</p>
                </div>
                <a href="/editar_perfil.php" class="boton_edit">Edit</a>
            </div>

            <div class="photo">
                <p>PHOTO</p>
                <div class="mitad"><img class="img" src="<?php echo $_SESSION['usuario_photo']; ?>" alt="Foto de perfil"></div>
            </div>

            <div class="name">
                <p>NAME</p>
                <div class="mitad"><?php echo $usuario_name; ?></div>
            </div>
            <div class="bio">
                <p>BIO</p>
                <div class="mitad"><?php echo $usuario_bio; ?></div>
            </div>
            <div class="phone">
                <p>PHONE</p>
                <div class="mitad"><?php echo $usuario_phone; ?></div>
            </div>
            <div class="email">
                <p>EMAIL</p>
                <div class="mitad"><?php echo $usuario_email; ?></div>
            </div>
            <div class="password">
                <p>PASSWORD</p>
                <div class="mitad">****</div>
            </div>
        </div>

</body>

</html>