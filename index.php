<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> <!-- Para evitar problemas con caracteres -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio de Evaluación PHP (DWES02)</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>

    <h1>Formulario de solicitud de libros en préstamo</h1>

    <!-- Contenedor para nuestro formulario  -->
    <div class="contenedor" id="formulario">
  
        <form action="biblioteca.php" method="POST"> 
             
            <label for="nombre" style="color: white;">Nombre:</label> 
            <input type="text" id="nombre" name="nombre">  
            <label for="apellido" style="color: white;">Apellido:</label>
            <input type="text" id="apellido" name="apellido">

            <label for="libro" style="color: white;">Libro:</label>
            <input type="text" id="libro" name="libro">

            <label for="email" style="color: white;">Email:</label>
            <input type="text" id="email" name="email">

            <label for="fecha_alquiler" style="color: white;">Fecha de Alquiler:</label>
            <input type="date" id="fecha_alquiler" name="fecha_alquiler">
			
            <!--Este es el nuevo campo. Representa el numero de libros que ya ha aluqiado esta persona
            Controlaremos que sea efectivamente un numero y que sea igual o menor que 3 (y mayor que 0)  -->
            <label for="numlibros" style="color: white;">Número de libros ya alquilados:</label>
            <input type="text" id="numlibros" name="numlibros">

            <label for="dni" style="color: white;">DNI:</label>
            <input type="text" id="dni" name="dni">
            
            <input type="submit" value="Enviar" name="enviar"/>
        </form>

    </div>

   
</body>
</html>



