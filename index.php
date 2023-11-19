
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> <!-- Para evitar problemas con caracteres -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio Evaluativo PHP</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>

	<!-- Contenedor para nuestro formulario  -->
    <div class="contenedor" id="formulario">
  
        <form action="" method="post"> <!-- Al hacer clic, el formulario llama a la misma pagina -->
             
            <!--Nota: con el valor guardado por PHP no se borran valores al enviar formulario.-->
            <label for="nombre" style="color: white;">Nombre:</label> 
            <input type="text" id="nombre" name="nombre" value="<?php echo $_POST['nombre']??''; ?>">

            <label for="apellidos" style="color: white;">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" value="<?php echo $_POST['apellidos']??''; ?>">

            <label for="libro" style="color: white;">Libro:</label>
            <input type="text" id="libro" name="libro" value="<?php echo $_POST['libro']??''; ?>">

            <label for="email" style="color: white;">Email:</label>
            <input type="text" id="email" name="email" value="<?php echo $_POST['email']??''; ?>">

            <label for="fecha_alquiler" style="color: white;">Fecha de Alquiler:</label>
            <input type="date" id="fecha_alquiler" name="fecha_alquiler" value="<?php echo $_POST['fecha_alquiler']??''; ?>">
			
            <label for="numlibros" style="color: white;">Número de libros ya alquilados:</label>
            <input type="text" id="numlibros" name="numlibros" value="<?php echo $_POST['numlibros']??''; ?>">

            <label for="dni" style="color: white;">DNI:</label>
            <input type="text" id="dni" name="dni" value="<?php echo $_POST['dni']??''; ?>">

            <input type="submit" name="Enviar"/>
        </form>

    </div>

    <div class="contenedor" id="resultados" style="visibility: hidden"> <!-- Es invisible hasta que hacemos clic -->

    <?php 
    
		// Recogemos la informacion enviada
		
		if (isset($_POST['Enviar'])){
			$nombre = $_POST["nombre"];
			$apellidos = $_POST["apellidos"];
			$libro = $_POST["libro"];
			$email = $_POST["email"];
			$fecha_alquiler = $_POST["fecha_alquiler"];
			$numlibr = $_POST["numlibros"];
			$dni = $_POST["dni"];
		
		// Hacemos visible el div de resultados 
					
		echo '<style>#resultados{visibility: visible !important;}</style>';
		
		// Estas variables registran si hay errores con dni, email y num libros alquilados. 
		// Por defecto, tienen valor 1(supondremos que hay errores excepto si comprobamos que no)
		$errordni = 1;
		$erroremail = 1;
		$errornumlibr = 1; 
							 
		//Generamos un array en el que iremos guardando los posibles campos que falten para mostrar una lista.
		$campos_faltantes = array();
		
		//Solo nos preocupamos de que nombre y apellidos existan, porque no nos indican nada mas al respecto

	    if (!isset($nombre) || $nombre == '') {
		$campos_faltantes[] = "Nombre";
		}

	    if (!isset($apellidos) || $apellidos == '') {
		$campos_faltantes[] = "Apellidos";
	    }

	    if (!isset($libro) || $libro == '') {
		$campos_faltantes[] = "Libro";
	    }

	    if (!isset($email) || $email == '') {
		$campos_faltantes[] = "Email";
	    }
	    else 
	    {
			//Ahora debemos saber si el email es correcto. Usaremos FILTER_VALIDATE EMAIL para ello.	
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$erroremail = true;
				echo "<h2>El email es incorrecto.</h2>";
			}
			else {
				$erroremail = 0; //Porque ha validado
			}
		}

		if (!isset($fecha_alquiler) || $fecha_alquiler == '') {
			$campos_faltantes[] = "Fecha de Alquiler";
		} 
		else {
			// Si no es un campo vacio, verificar si la fecha es la actual o futura
			$fecha_actual = date("Y-m-d");
			if ($fecha_alquiler < $fecha_actual) {
				echo "<h2>La fecha debe ser la actual o una posterior.</h2>";
				$campos_faltantes[] = "Fecha de Alquiler";
			}
		}

		//Vamos a detectar si libros alquilados es correcto
	    if (!isset($numlibr) || $numlibr == '') {
		$campos_faltantes[] = "Número de libros";
	    }
		else
		{
		//Primero si es un valor numerico
		if(is_numeric($numlibr)==false) {
			echo "<h2>El número de libros debe ser un valor numérico.</h2>";
		}
		// Luego, si ha alguilado ya demasiados libros.
		else {if ($numlibr > 3) {
				echo "<h2>No puede alquilar más libros.</h2>";
			}
			else{
				//Es correcto, cambiamos el error a false
				$errornumlibr = 0; 
			}
		}
		}	

		if (!isset($dni) || $dni == '') {
			$campos_faltantes[] = "DNI";                               
		}
		else {
			//Algoritmo modulo 23 (tambien valdria hacerlo con array)
			//Sacar letra y numeros
			$letra = substr($dni, -1);
			$nums = substr($dni, 0, -1);

			if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $nums % 23, 1) != $letra || strlen($letra) != 1 || strlen($nums) != 8){
			 echo "<h2>DNI incorrecto.</h2>";
			 //Diferenciar el caso de que solo la letra sea la incorrecta y ofrecer la letra correcta.
			 if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $nums % 23, 1) != $letra && strlen($letra) == 1 && strlen($nums) == 8){
			 //Para ello, se obtiene la letra correcta y se muestra con las cifras ofrecidas
			 $letracor = substr("TRWAGMYFPDXBNJZSQVHLCKE", $nums % 23, 1);
			 echo "<h2>El DNI completo, con la letra correspondiente a ese número es: $nums$letracor </h2>";
			 }
			}
			else {
				 //El DNI es correcto en este caso, por lo que quitamos su error
				$errordni = 0;
				}
			 
			}
		
	    
	    //Si el array de campos faltantes no es nulo, tendremos que mostrar dichos campos en una lista
		if (!empty($campos_faltantes)) {
			echo "<h2>Los siguientes campos no están rellenados:</h2>";
			echo "<ul>";	
			foreach ($campos_faltantes as $campo) {
				echo "<li>  $campo </li>";
			}
			echo "</ul>";
		} 
		
		
		/* Mostrar la informacion final si, y solo si, se cumplen todas las condiciones
		Esto significa que errordni, erroremail y errornumlibr son todos falsos*/
		if ($errordni == 0 && $erroremail == 0 && $errornumlibr == 0 ) {  
			echo "<h2>Información de Alquiler:</h2>";
			echo "<p>Nombre y apellidos: $nombre $apellidos</p>";
			echo "<p>Libro Alquilado: $libro</p>";

			// Calcular y mostrar la fecha final de alquiler (fecha introducida + 10 dias)
			$fecha_final_alquiler = date('Y-m-d', strtotime($fecha_alquiler . ' + 10 days'));
			echo "<p>Fecha límite para devolver el libro: $fecha_final_alquiler</p>";
			}
			
		}
    ?>
	
	</div>
</body>
</html>


