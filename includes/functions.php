<?php
    require_once __DIR__ .'/../config/database.php';

    function obtenerClientes() {
        global $tasksCollection;
        return $tasksCollection->find();
    }
    // function obtenerUsuario($nombre, $correo, $contraseña) {
    //     global $tasksCollection2;
    //     return $tasksCollection2->findOne([
    //         '$and' => [
    //             ['usuario' => $nombre],
    //             ['correo' => $correo],
    //             ['contraseña' => $contraseña]
    //         ]
    //     ]);
    // }
    function formatDate($date) {
        return $date->toDateTime()->format('Y-m-d');
    }
    function sanitizeInput($input) {
        $input = htmlspecialchars(strip_tags(trim($input)));
        if (is_numeric($input)) {
            $input = max(0, $input);
        }
        return $input;
    }
    function crearCliente($nombre, $correo, $telefono, $direccion) {
        global $tasksCollection;
        $resultado = $tasksCollection->insertOne([
            'nombre' => sanitizeInput($nombre),
            'correo' => sanitizeInput($correo),
            'telefono' => sanitizeInput($telefono),
            'direccion' => sanitizeInput($direccion),
            // 'fechaNacimiento' => new MongoDB\BSON\UTCDateTime(strtotime($fechaNacimiento) * 1000),
        ]);
        return $resultado->getInsertedId();
    }
    // function crearUsuario($nombre_usuario, $correo, $contraseña) {
    //     global $tasksCollection2;
    //     $usuarioExistente = $tasksCollection2->findOne(['usuario' => sanitizeInput($nombre_usuario)]);
    
    //     if (!$usuarioExistente) { 
    //         $resultado = $tasksCollection2->insertOne([
    //             'usuario' => sanitizeInput($nombre_usuario),
    //             'correo' => sanitizeInput($correo),
    //             'contraseña' => sanitizeInput($contraseña)
    //         ]);
    
    //         return $resultado->getInsertedId();
    //     } else {
    //         return false;
    //     }
    // }
    function obtenerClientePorId($id) {
        global $tasksCollection;
        return $tasksCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    }
    function actualizarCliente($id, $nombre, $correo, $telefono, $direccion) {
        global $tasksCollection;
        $resultado = $tasksCollection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($id)],
            ['$set' => [
                'nombre' => sanitizeInput($nombre),
                'correo' => sanitizeInput($correo),
                'telefono' => sanitizeInput($telefono),
                'direccion' => sanitizeInput($direccion),
                // 'fechaNacimiento' => new MongoDB\BSON\UTCDateTime(strtotime($fechaNacimiento) * 1000),
            ]]
        );
        return $resultado->getModifiedCount();
    }
    function eliminarCliente($id) {
        global $tasksCollection;
        $resultado = $tasksCollection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
        return $resultado->getDeletedCount();
    }
    
?>