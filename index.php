<?php

    include ('config/db-connect.php');

    $response = array();

    try {

        $cnn = new ConexionBD();
        $con = $cnn->conectaBD();

        $sttmt = $con->prepare("SELECT * FROM users ORDER BY id");
        $sttmt->execute();

        $rowCount = $sttmt->rowCount();

        if ($rowCount > 0) {

            $resultSet = $sttmt->fetchAll();
            $response["usuarios"] = $resultSet;
            $response['success'] = 1;
			$response['message'] = 'Contactos encontrados';
			echo json_encode($response);

        } else {
			$response['success'] = 0;
			$response['message'] = 'Contactos NO encontrados';
			echo json_encode($response);
        }

    } catch (Exception $e) {
        
        switch ($e->getCode()) {

			case 2002:
				$response['success'] = 0;
				$response['message'] =  'El servidor no responde, verifique el estado del servidor y puerto MySQL';
            break;
            
			case 1049:
				$response['success'] = 0;
				$response['message'] =  'La base de datos no existe, verifique el estado de la base de datos en el servidor MySQL';
            break;
                
			case 1045:
				$response['success'] = 0;
				$response['message'] =  'El usuario o la clave de acceso son incorrectos, verifique el estado del usuario de la base de datos en el servidor MySQL';
            break;
                
			case 23000:
				$response['success'] = 0;
				$response['message'] =  'La clave principal ya existe, intente de nuevo con otros datos';
            break;
                
			default:
				$response['success'] = 0;
				$response['message'] = 'Error en el servidor: ' . $e->getMessage();
        }
        
		echo json_encode($response);

    }

?>