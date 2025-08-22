<?php
$conn = oci_connect("PROYECTOLENGUAJES", "123", "localhost/XEPDB1");

if ($_POST) {
   $nombre = $_POST['contactNombre'];
   $email = $_POST['contactEmail'];
   $asunto = $_POST['contactAsunto'];
   $mensaje = $_POST['contactMensaje'];
   
   $mensaje_completo = "Nombre: $nombre\nEmail: $email\nMensaje: $mensaje";
   
   $sql = "INSERT INTO PROYECTOLENGUAJES.FIDE_CONTACTO_TB (ASUNTO, MENSAJE, FECHA_CREACION, CREADO_POR) 
           VALUES ('$asunto', '$mensaje_completo', SYSDATE, 'WEB')";
   
   $stmt = oci_parse($conn, $sql);
   
   if (oci_execute($stmt)) {
       oci_commit($conn);
       echo "<div style='text-align:center; margin-top:50px;'>
               <h2 style='color:green;'>¡ÉXITO!</h2>
               <p>Mensaje guardado correctamente.</p>
               <a href='contacto.html' style='background:#0066cc; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;'>Volver al Formulario</a>
             </div>";
   } else {
       $error = oci_error($stmt);
       echo "<div style='text-align:center; margin-top:50px;'>
               <h2 style='color:red;'>Error</h2>
               <p>" . $error['message'] . "</p>
               <a href='contacto.html' style='background:#0066cc; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;'>Volver al Formulario</a>
             </div>";
   }
}
?>