<?php 
require_once 'config/config.php';
require_once 'helpers/funciones.php';
//verificar si existe la rura admin
$isAdmin = strpos($_SERVER['REQUEST_URI'], '/' . ADMIN)!== false;
// comprobar si existe GET para crear urls amigables
$ruta = empty($_GET['url']) ? 'principal/index' : $_GET['url'] ;
//crear un array apartir de la ruta 
$array =explode('/',$ruta);
//validar si nos encontramos en la ruta 
if ($isAdmin && (count($array)==1
 || (count($array)== 2 && empty ($array[1]))) 
 && $array[0]== ADMIN) {

// CREAR CONTROLADOR
$controller = 'Admin';
$metodo ='login';

} else {
    $indiceUrl =($isAdmin) ? 1 : 0;
    $controller =ucfirst($array[$indiceUrl]);
    $metodo = 'index';

}
//validar metodos 

$metodoIndice =($isAdmin) ? 2 : 1;
if (!empty($array[$metodoIndice]) && $array [$metodoIndice] !=''){
    $metodo = $array[$metodoIndice];
}
//validar parametro
$parametro = '';
$parametroIndice =($isAdmin) ? 3 : 2;
if (!empty($array[$parametroIndice]) && $array [$parametroIndice] !=''){
    for ($i = $parametroIndice; $i < count ($array); $i++) { 
        $parametro .=$array[$i] . ',';
    }
    $parametro = trim ($parametro, ',');
}
//llamar autoload
require_once 'config/app/Autoload.php';
//validar directorio de controladores
$dirControllers =($isAdmin) ? 'controllers/admin/'. $controller . '.php' : 'controllers/principal/'. $controller . '.php';
if (file_exists($dirControllers)) {
    require_once $dirControllers;
    $controller = new $controller();
    if (method_exists($controller, $metodo)) {
        $controller->$metodo($parametro);
    } else {
        echo 'METODO NO EXISTE';
    }
} else {
    echo 'CONTROLADOR NO EXISTE';
}

 ?>
 