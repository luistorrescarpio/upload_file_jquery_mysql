<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Subir Archivo</title>
	<script src="js/jquery-1.9.1.js"></script>
</head>
<body>
	<center>
		<h2>Upload File Ajax - MYSQL</h2>
		<div style='font-size: 14px;'>Registro de archivos en base de datos y ficheros</div>
		<br>
		<a href="archivos_registrados.php">Ver archivos Registrados</a>
		<div style="background: #FBFFB8;width:400px;padding: 10px;box-shadow: 3px 3px 3px #999;">
		    Nombre de Referencia: <input type="text" id="referencia" value='Nombre Referencial' onclick="$(this).select();">
		    <br><br>
		    <input id="upload_file" type="file" onchange="readSize()"/>
		    <div id="detalleDeArchivo" style='color:blue;'></div>
		    <br>
			Progress: <progress value="0"></progress>
		    <br>
		    <br>
		    <button onclick="uploadExecute()">Subir y Registrar</button>			
		</div>

		<br>

		<div id="results"></div>
		
	</center>

	<script>

		var file, formData;
		function readSize(){
			file = document.getElementById("upload_file").files[0];
		    $("#detalleDeArchivo").html("FileName: "+file.name+", Size: "+file.size);
		}
		function uploadExecute(){
			//Preparamos el paquete a enviar
			formData = new FormData();
            //parametros a enviar
            formData.append("action","registerFile");
            formData.append("referencia", $("#referencia").val() );
            formData.append("filename", file.name );
            //imagen a guardar en galeria
            formData.append("uploaded_file",file);

            formData.append("enctype",'multipart/form-data');

		    $.ajax({
		        // Dirección del archivo a ejecutar en el servidor
		        // url: 'upload_file.php',
		        url: 'consultas.php',
		        type: 'POST',
		        
		        data: formData, //adjuntamos el paquete

		        cache: false,
		        contentType: false,
		        processData: false,

		        // Configuración Personalizada XMLHttpRequest
		        xhr: function() {
		            var myXhr = $.ajaxSettings.xhr();
		            if (myXhr.upload) {
		                // Obtenemos Progresivamente el nivel de carga del archivo
		                myXhr.upload.addEventListener('progress', function(e) {
		                    if (e.lengthComputable) {
		                    	//Actualizamos la etiqueta PROGRESS segun su nivel de carga del archivo
		                        $('progress').attr({
		                            value: e.loaded,
		                            max: e.total,
		                        });
		                    }
		                } , false);
		            }
		            return myXhr;
		        }
		        ,success: function(data, status, xhr) {
		        	//Imprimimos Resultados del archivo "upload_file.php" desde el servidor
				    $("#results").html(data);
				}
		    }).done(function() {
		    	//Mensaje que indica que se a finalizado
			    console.log("Upload finished.");
			});
		}
	</script>
</body>
</html>