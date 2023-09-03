<!DOCTYPE HTML>
<html>
<head>
    <!-- definimos la tabla de caracteres UTF-8 para admitir tildes y eñes -->
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">

    <!-- definimos datos de AUTOR DE PÁGINA, DESCRIPCIÓN, PALABRAS CLAVE (Para Buscadores) y TÍTULO DE LA PÁGINA --><!-- REEMPLACE O AJUSTE ESTAS LÍNEAS SEGUN LOS DATOS Y CONTENIDOS DE SU PÁGINA WEB -->
    <meta name="author" content="Uriel Castañeda Sierra">
    <meta name="description" content="Pagina WEB de la empresa de consultoria en Diseño y Desarrollo de sistemas de Información">
  
    <meta name="keywords" content="Aasesoría informática, Hardware, Software,  Diseño web">
    <title>Asesorías en ADSI - UCS</title>
    <link rel="stylesheet" href="css/estilo.css">
    <style type="text/css">   
    </style>
 
</head>
<body>
       <!-- iniciamos las instrucciones en PHP para:                -->
       <!-- validar datos, construir y enviar el mensaje de correo  -->
<?php 
  //***********************************************************************
  // ********* PRIMERO: TRANSFERIMOS EL CONTENIDO DE LAS VARIABLES CAPTURADAS EN EL FORMULARIO PREVIO
  // A continuación el codigo que procesa la información para recuperar los datos introducidos en el formulario de captura.    

  $Nombre = $_GET['nombre'];
  $Apellido = $_GET['apellidos'];
  $Email = $_GET['correoe'];
  $Telefono = $_GET['telefono'];
  $TipoMensaje = $_GET['tipo_comentario'];
  $Mensaje = $_GET['mensaje'];

  //  en caso de no estar seleccionado el check_Box de enviar respuesta, el sistema no transfiere la variable
  //  por lo tanto se asigna directamente CON LA INSTRUCCIÓN:   $SolicitaRespuesta = "off";
  if (isset($_GET['solicitarespuesta']))
    {
     $SolicitaRespuesta = $_GET['solicitarespuesta'];
    }
  else {
     $SolicitaRespuesta = "off";
    }

    
  //**************************************************************************
  //****** SEGUNDO: Validamos que el usuario haya ingresados los datos mínimos 
  //                requeridos para el envío del mensaje.
  //                si LLEGA a faltaR un campo por llenar, EL Proceso se cancela y
  //                SISTEMA devuelve error mostrando el mensaje correspondiente.
  //                EN CASO CONTRARIO, contrario continúa el proceso con el PASO TRES
  //**************************************************************************    
  if (!$Nombre || !$Apellido || !$Telefono || !$Email || !$Mensaje )
  {
  $MensajeResultadoEnvio =  "No has completado todos los campos obligatorios.<br>" .
                            "Por favor vuelve e inténtalo de nuevamente. " .
                            "&nbsp;&nbsp;&nbsp;...[<span class='a:link'><a href='javascript:history.back()'>Regresar</a></span>]";
  $ControlErrorMailing = FALSE;
  //   exit;
  }
   
  else {
  // ***********************************************************************
  // ****** TERCERO: Construimos y enviamos el mensaje
  //                 Si hay datos para enviar, entonces se arma la estructura del
  //                 mensaje y luego se ejecuta el envío, en el siguiente orden:
  //    
  //      3.1 Definimos los parámetros la zona horaria del país de origen
  //      3.2 Definimos los parámetros básicos para identificar destinatarios
  //      3.3 Definimos los parámetros para identificar el remitente del correo    
  //      3.4 Definimos los parámetros del servidor de correos y protocolo de envío
  //      3.5 Definimos variables para controlar el resultado del envío. 
  //      3.6 Finalmente Armamos el cuerpo del mensaje a transmitir, juntando los 
  //          diferentes campos ingresados en el formulario de entrada de datos.
  //----- 3.7 En forma alternativa para los casos en que se requiera el mensaje en 
  //          formato HTML, se pueden incorporar imágenes y estilos. 
  // 
  //      IMPORTANTE *******   
  //      Asegurarse de definir correctamente los correos destinatarios y los datos
  //      del servidor de correos SMTP para que el proceso opere correctamente
  //      y para que los correos sean enviado al buzón correcto     
  //      en caso contrario podría saturar correos que no correspondan a su proyecto
  //---------------------------------------------------   
    
    //----- 3.1 Definimos los parámetros la zona horaria del país de origen 
    date_default_timezone_set('America/Bogota');
    $FechaHoraActual = date('Y-m-d H:i:s',time());
    
    //----- 3.2 Definimos los parámetros básicos para identificar destinatarios
    //          Asunto del correo y correo para recibir respuesta
    //           
    //  ********* REEMPLAZAR ESTAS CUENTAS DE CORREO Según su proyecto ********
    $Email_Destino1 = 'morerahernandezhelbertdubler@gmail.com';  // por Ej:  'serviciotecnico1@misena.edu.co'
    $Nombre_Destino1 = 'Helbert Morera';      // por Ej:  'Oficina de servicio tecnico1 EMPRESA'

    $Email_Destino2 = '';    // en caso de requerir SEGUNDO o más detinatarios
    $Nombre_Destino2 = '';

    // ************************************************************************* 
    $Asunto_Mensaje = 'Contacto SERVICIOS EMPRESARIALES';

    $Copia_Destino1 = '';          
    $CopiaOculta_Destino1 = '';

    // dato opcional en caso que se requiera respuesta a otro correo
    $Respuesta_Destino1 = $Email;             
    $RespuestaNombre_Destino1 = $Nombre . " " . $Apellido;

    //----- 3.3 Definimos los parámetros para identificar el remitente del correo  
    //      (CORREO ORIGEN debe ser un correo compatible POP3)
    //    Se utilizará como servidor SMTP una cuenta de correo GMAIL
    //    Esta cuenta debe estar habilitada con esquema de VERIFICACÓN DE 2 pasos (Seguridad)
    //    de acuerdo con procedimiento indicado en video..  https://youtu.be/ExqdE1IzpZ0
    //    "Cómo enviar emails con el SMTP de GMAIL a partir de Junio de 2022"  

    $NombreEmail_Origen = 'SERVIDOR CORREOS CONTACTENOS';  
    $Email_Origen = 'correoserviciosadsi1@gmail.com'; 
    $Password_Email_Origen = 'naderxekiokdiybn';  // Esta es la nueva clave de 16 dígitos para acceder al servidor  

    //----- 3.4 Definimos los parámetros del servidor de correos y protocolo de envío y cuenta origen del correo
    //      utilizaremos El servidor gratuito de correo GMAIL
    $Formato_mensaje_HTML = true;
    $ProtocoloSMTP_Uso = true;
    $ProtocoloSMTP_Automatico = true;
      
    //  para seguridad *ssl* el puerto es 465   
    // $ProtocoloSMTP_Seguridad = "ssl";    
    //  $ServidorCorreo_Host = "smtp.gmail.com";  
    //  $ServidorCorreo_Port = 465;
      
    // para seguridad *tls* el puerto es 587  
    $ProtocoloSMTP_Seguridad = "tls";  
    $ServidorCorreo_Host = "smtp.gmail.com";        
    $ServidorCorreo_Port = 587;
    
    //----- 3.5 Definimos variables para controlar el resultado del envío. 
    $MensajeResultadoEnvio =  "";
    $ControlErrorMailing = FALSE;
    
    //----- 3.6 Finalmente Armamos el cuerpo del mensaje a transmitir, juntando los 
    //          diferentes campos ingresados en el formulario de entrada de datos.
    $TextMensajeCompleto  = "Enviado por: $Nombre $Apellido \r\nE-mail: $Email \r\n";
    $TextMensajeCompleto .= "Telefono: $Telefono \r\nTipo de Mensaje: $TipoMensaje \r\n";
    if ($SolicitaRespuesta == "on") {
        $TextMensajeCompleto .= "Solicita Respuesta: SI \r\n";
    }
    else {
        $TextMensajeCompleto .= "Solicita Respuesta: NO \r\n";
    }
    $TextMensajeCompleto .= "Fecha y Hora de envío: $FechaHoraActual \r\n \r\n";
    $TextMensajeCompleto .= "Asunto: ". $Asunto_Mensaje . " (" . $Nombre . " " . $Apellido . ")" . "\r\n \r\n";
    $TextMensajeCompleto .= "Mensaje: --- \r\n$Mensaje";

      
    //----- 3.7 En forma alternativa construimos el cuerpo del mensaje
    //          utilizando formato HTML para cuando deseemos un mensaje de correo
    //          con estas características. mostramos en una tabla todos los campos  
    $Msg_HTML  = '';
    $Msg_HTML .= "<table width='450px' cellpadding='2' border='0'>";
    $Msg_HTML .= "<tr><td align='center' colspan='2'>";
    $Msg_HTML .= "<div style='background-image: url(".chr(34)."http://adso1cdae.infinityfreeapp.com/imagenes/". chr(34) . "); ";
    $Msg_HTML .= "background-size: 100px 100px; background-repeat: no-repeat; ";
    $Msg_HTML .= "background-position: center center; position: relative;'>";
    $Msg_HTML .= "<br>&nbsp;<h2 style='color: #00f;'>MENSAJE DE PRUEBA</h2>&nbsp;</div></td></tr>";
    $Msg_HTML .= "<tr><td colspan='2'>";
    $Msg_HTML .= "<table cellspacing='1' cellpadding='1' width='100%' height='100%' border='1'>";
    $Msg_HTML .= "<tr><th align='center' scope='row'>Dato: </th>";
    $Msg_HTML .= "<th>Valor ...</th></tr>";
    $Msg_HTML .= "<tr><th align='center'>Nombre</th>";
    $Msg_HTML .= "<td>".trim($Nombre,"\r\n")."</td></tr>";  
    $Msg_HTML .= "<tr><th align='center'>Texto</th>";
    $Msg_HTML .= "<td>".nl2br($Mensaje)."</td></tr>";                
    $Msg_HTML .= "</table>";
    $Msg_HTML .= "</td></tr>";
    $Msg_HTML .= "<tr><td>";
    $Msg_HTML .= "<img style='width: 75px; height: 75px;' alt='correo enviado'  src='http://adso1cdae.infinityfreeapp.com/imagenes/'></td>";
    $Msg_HTML .= "<td align='right'><img style='width: 75px; height: 75px;' alt='correo enviado'  src='http://adso1cdae.infinityfreeapp.com/imagenes/'>";
    $Msg_HTML .= "</td></tr>";
    $Msg_HTML .= "</table>";
 
     
    // ***********************************************************************
    // ****** CUARTO:  Carga la CLASE [class.phpmailer.php] 
    //                 especial para envío de correos.
    //                 Se crea la variable $mail,  
    //                 esta se utilizará para CONSTRUIR y ENVIAR el mensaje.
    // *****************************************
    require 'phpmailer/class.phpmailer.php';
    // include('phpmailer/class.phpmailer.php');  // instrucción alterna paa incorporar la   librería phpmailer.php

        $mail = new PHPMailer();  
        $mail->IsHTML($Formato_mensaje_HTML);
        // --- identifica la ruta donde se encuentra el archivo del LENGUAJE español
        $mail->setLanguage('es', 'phpmailer/');  
        // --- Establecemos la tabla de caracteres para el idioma español
        //     con estas dos líneas aseguramos que los acentos (TILDES) y eñes se vean correctos.
        $mail->CharSet = 'UTF-8';   
        $mail->Encoding = "quoted-printable";           
        // --- Establecemos datos protocolo, Servidor y Cuenta de correo origen
        if ($ProtocoloSMTP_Uso) {
            $mail->IsSMTP();
            //$mail->Mailer = "smtp"; //inst.Alterna protocolo para envío de correos
        }
        $mail->SMTPAuth = $ProtocoloSMTP_Automatico;
        $mail->SMTPSecure = $ProtocoloSMTP_Seguridad;
        $mail->Host = $ServidorCorreo_Host;
        $mail->Port = $ServidorCorreo_Port;
        $mail->Username = $Email_Origen;
        $mail->Password = $Password_Email_Origen;
        $mail->From = $Email_Origen;
        $mail->FromName = $NombreEmail_Origen;    
        // también se puede usar forma alternativa que abrevia los dos pasos anteriores    
        // $mail->SetFrom($Email_Origen, $NombreEmail_Origen); 
        // Para establecer la candidad máxima de caracteres del mensaje (default=0)
        // $mail->WordWrap = 0;                                 
        // --- Establecemos los destinatarios del correo
        // $To = trim($Email_Destino1,"\r\n");  // para asignación directa
        $mail->addAddress($Email_Destino1, $Nombre_Destino1); //use esta para añadir
        $mail->addAddress($Email_Destino2, $Nombre_Destino2);  
        // --- Establece los destinatario con copia y con copia oculta y redireccionamiento para respuesta
        $mail->addCC($Copia_Destino1);  
        $mail->addBCC($CopiaOculta_Destino1);   
        $mail->addReplyTo($Respuesta_Destino1, $RespuestaNombre_Destino1);  // 

        // --- Asunto del email - le unimos el nombre del remitente para diferenciarlo en el buzón de llegada
        $mail->Subject = $Asunto_Mensaje . " (" . $Nombre . " " . $Apellido . ")";

        // --- Transferimos el contenido del mensaje. 
        //     se usa la función nl2br() para que no se pierdan los saltos de línea
        $mail->Body    = nl2br($TextMensajeCompleto)."<br><hr>\r\n".$Msg_HTML;    

        // --- definimos la prioridad:  1 = High, 3 = Normal, 5 = low
        $mail->set('X-Priority', '1'); 

        // --- OPCIONAL....  Usar la siguiente instrucción si se desea el mensaje 
        //     en formato de texto para clientes que no dispongan de correo html;
        //$mail->AltBody = '....';                          

        // --- para importar texto desde un documento html
        //$mail->MsgHTML(file_get_contents('contents.html'));  
        // --- Para añadir archivos anexos
        //$mail->AddAttachment('images/phpmailer.gif');               
    
    
    // ***********************************************************************
    // ****** QUINTO:  Se realiza el proceso de ENVÍO del mensaje con [phpmailer] 
    //                 Se controla la ocurrencia de ERRORES
    //                 Se muestran los mensajes resultante del proceso
        try {
            // ******* AQUÍ realizamos el envío del correo ******
            $mail->Send();
            $ControlErrorMailing = FALSE;
            $MensajeResultadoEnvio = "Tu mensaje ha sido enviado Satisfactoriamente.".
                "&nbsp;&nbsp;&nbsp;....[<span  class='a:link'><a href='javascript:history.back()'>Regresar</a></span>]";
            
            } 
            //En caso de un error generado por PHPMailer
            catch (phpmailerException $e) { 
                $ControlErrorMailing = TRUE;
                $MensajeResultadoEnvio = $e->errorMessage().
                    "&nbsp;&nbsp;&nbsp;...[<span class='a:link'><a href='javascript:history.back()'>Regresar</a></span>]";
            }
            // Genera el error cuando ocurre cualquier otra falla!
            catch (Exception $e) {  
                $ControlErrorMailing = TRUE;
                $MensajeResultadoenvio = $e->getMessage().
                    "&nbsp;&nbsp;&nbsp;...[<span class='a:link'><a href='javascript:history.back()'>Regresar</a></span>]";
            }
        }  
?>      <!-- Aquí finaliza la primara estructura en lenguaje PHP
        <!-- Ahora construimos la página en HTML para mostrar resultados

<!-- **************************************************************** -->
<!-- ******* SEXTO:  Utilizamos código HTML para construir la página donde mostraremos los resultados y de confirmación del mensaje enviado -->
    <p align="center"><H3>Resultados del envío del mensaje v3;</H3></p>
<table align="center" width="960">
    <tbody>
    <tr>
      <td rowspan="3" width="200">
      <p><img src="imagenes/correo1a.jpg" alt="correo"></p>
      </td>
      <td width="525">&nbsp;<?php echo $MensajeResultadoEnvio;
	   ?> </td>
      <td rowspan="3" width="200">
      <p><img src="imagenes/correo1b.jpg" alt="correo"></p>
      </td>
    </tr>
    <tr>
      <td align="center"><?php echo "<textarea name='mensaje' cols='60' rows='8' readonly='readonly'>";
         echo $TextMensajeCompleto; 
         echo "</textarea>";
         echo "<hr>"; 
         echo $Msg_HTML; 
         echo "<hr>"; 
         ?>
      <br>
      </td>
    </tr>
    <tr>
      <td>&nbsp;<?php if (!$ControlErrorMailing) {
                 echo "Gracias por contactarnos, pronto te daremos respuesta....";
	         }
	       else {
		 echo "Lo sentimos! Tu mensaje no pudo ser recibido y procesado, por favor verifica los datos e intenta más tarde...";
	         }
	  ?>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    </tbody>
</table>

</body>
</html>
