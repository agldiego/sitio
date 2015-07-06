<?php
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

function permisos($perm, $acceso = 'r', $msg = true) {

    $permisos = $_SESSION['perms'];
    foreach ($permisos as $modulo) {
        if ($perm == $modulo[0]) {
            if ((strtolower($acceso) == 'r') && ($modulo[1] == '1')) {
                return true;
            }
            if ((strtolower($acceso) == 'w') && ($modulo[2] == '1')) {
                return true;
            }
            if ((strtolower($acceso) == 'u') && ($modulo[3] == '1')) {
                return true;
            }
            if ((strtolower($acceso) == 'd') && ($modulo[4] == '1')) {
                return true;
            }
        }
    }
    
    if ($msg) {
        echo "<div class=\"warning\">No posee los suficientes permisos para esta acci&oacute;n.</div>";
        exit();
    } else {
    	return false;
    }
    return false;
}
?>