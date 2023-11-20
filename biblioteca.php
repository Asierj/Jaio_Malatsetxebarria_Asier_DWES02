
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8"> <!-- Para evitar problemas con caracteres -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
    <link rel="stylesheet" href="styles.css"> 
</head>

<body>

<h1>Resultado del alquiler</h1>

<div class="contenedor" id="resultados"> <!-- Mostraremos aquí los resultados -->

<?php 
    
		/*Recogida de datos */
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$nombre = $_POST["nombre"];
			$apellido = $_POST["apellido"];
			$libro = $_POST["libro"];
			$email = $_POST["email"];
			$fecha_alquiler = $_POST["fecha_alquiler"];
			$numlibros = $_POST["numlibros"];
			$dni = $_POST["dni"];
		

		/*Procesado de datos*/
			 
		//Generamos un array en el que iremos guardando los posibles errores en los campos, para mostrarlos segun haga falta.
		$errores_campos = array();
		
		//Solo nos preocupamos de que nombre, apellido y libro existan, porque no nos indican nada mas al respecto

	    if (!isset($nombre) || $nombre == '') {
		$errores_campos[] = "Campo Nombre sin rellenar";
		}

	    if (!isset($apellido) || $apellido == '') {
		$errores_campos[] = "Campo Apellido sin rellenar";
	    }

	    if (!isset($libro) || $libro == '') {
		$errores_campos[] = "Campo Nombre del libro sin rellenar";
	    }
		
            
		//El correo debe existir y ser validado
	    if (!isset($email) || $email == '') {
			$errores_campos[] = "Campo Email sin rellenar";
	    }
	    else 
	    {
			//Ahora debemos saber si el email es correcto. Usaremos FILTER_VALIDATE EMAIL para ello.	
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$errores_campos[] = "El email es incorrecto.";
			}
		}

	    //La fecha de alquiler necesita ser presente o futura, aparte de existir

		if (!isset($fecha_alquiler) || $fecha_alquiler == '') 
		{
			$errores_campos[] = "Campo Fecha de Alquiler sin rellenar";
		} 
		else {
			// Si no es un campo vacio, verificar si la fecha es la actual o futura
			$fecha_actual = date("Y-m-d");
			if ($fecha_alquiler < $fecha_actual) {
				$errores_campos[] = "La fecha debe ser la actual o una posterior.";
			}
		}


	     //Este es el campo propio propuesto. Vamos a detectar si libros ya alquilados tiene datos y luego controlar si es un numero y si es menor de 3

	    if (!isset($numlibros) || $numlibros == '') {
		$errores_campos[] = "Campo Número de libros sin rellenar";
	    }
		else
			{
			//Primero si es un valor numerico
			if(is_numeric($numlibros)==false || $numlibros < 0 ) {
				$errores_campos[] = "El número de libros debe ser un valor numérico igual o mayor que cero.";
			}
			// Luego, si ha alguilado ya demasiados libros.
			else if ($numlibros > 3) {
					$errores_campos[] = "Ha superado el número máximo de libros en préstamo";
				}
			}
		}	


		//Control de rellenado y adecuacion dni
		if (!isset($dni) || $dni == '') {
			$errores_campos[] = "DNI sin rellenar";                               
		}
		else {
			//Algoritmo modulo 23 (tambien valdria hacerlo con array)
			//Sacar letra y numeros
			$letra = substr($dni, -1);
			$nums = substr($dni, 0, -1);

			if(is_numeric($nums)==false)
			{
				$errores_campos[] = "El DNI debe tener 8 primeras cifras, sin otros caracteres";
			}
			else if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $nums % 23, 1) != $letra || strlen($letra) != 1 || strlen($nums) != 8){
			 $errores_campos[] = "El DNI es incorrecto.";
			 //Diferenciar el caso de que solo la letra sea la incorrecta y ofrecer la letra correcta.
			 if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $nums % 23, 1) != $letra && strlen($letra) == 1 && strlen($nums) == 8){
			 //Quitar el mensaje de error anterior
			 array_pop($errores_campos);
			 //Otiene la letra correcta y sumarla al arrau
			 $letracor = substr("TRWAGMYFPDXBNJZSQVHLCKE", $nums % 23, 1);
			 $errores_campos[] = "El DNI es incorrecto. El correcto, con la letra correspondiente a ese número es: $nums$letracor";
			 }
			}
		    }

    

		/*Resultados propiamente dichos*/	

	    //Si el array de errores contiene datos, lo mostraremos como lista
		if (!empty($errores_campos)) {
			echo "<h2>Se han producido los siguientes errores de verificación:</h2>";
			echo "<ul>";	
			foreach ($errores_campos as $campo) {
				echo "<li>  $campo </li>";
			}
			echo "</ul>";
		} 

		//En otro caso, todo es correcto y lo mostramos
		else{  
			echo "<h2>Información de Alquiler:</h2>";
			echo "<p>Nombre: $nombre</p>";
			echo "<p>DNI: $dni</p>";
			// Calcular y mostrar la fecha final de alquiler (fecha introducida + 10 dias)
			$fecha_final_alquiler = date('d-m-Y', strtotime($fecha_alquiler . ' + 10 days'));
			echo "<p>Fecha límite para devolver el libro: $fecha_final_alquiler</p>";
		}
    ?>

    <!-- Un simple boton para volver a la pagina principal -->
    <form>
	<input type="button" value="Atrás" onClick="history.back();return true;"></form>
    </form>
</div>



</body>
</html>
