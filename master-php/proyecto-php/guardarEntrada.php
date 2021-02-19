<?php

if(isset($_POST)){

    // Conexion a la base de datos
    require_once 'includes/conexion.php';

    $titulo = isset($_POST['titulo']) ? mysqli_real_escape_string($db, $_POST['titulo']) : false;
    $descripcion = isset($_POST['descripcion']) ? mysqli_real_escape_string($db, $_POST['descripcion']) : false;
    $categoria = isset($_POST['categoria']) ? (int)$_POST['categoria'] : false;
    // Recoger el id del usuario iniciado
    $usuario = $_SESSION['usuario']['id'];

    // Array de errores
    $errores = array();

    // Validar los datos antes de guardarlos en la base de datos
    
    // Validar campo nombre 
    if(empty($titulo)){
        $errores['titulo'] = 'El titulo no es valido';
    }

    // Validar campo descripcion
    if(empty($descripcion)){
        $errores['descripcion'] = 'La descripcion no es valida';
    }
    
    // Validar campo categoria
    if(empty($categoria) && !is_numeric($categoria)){
        $errores['categoria'] = 'La categoria no es valida';
    }

    // Contar errores para insertar
    if(count($errores) == 0){
        $sql = "INSERT INTO entradas VALUES (null, $usuario, $categoria, '$titulo', '$descripcion', CURDATE());";
        $guardar = mysqli_query($db, $sql);
        header("Location: index.php");
    }else{
        $_SESSION['errores_entrada'] = $errores;
        header("Location: crearEntradas.php");
    }

}
