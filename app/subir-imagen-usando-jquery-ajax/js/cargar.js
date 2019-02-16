$(document).ready(function(){

	$('.btn_enviar').on("click", function(evt){

		evt.preventDefault();

		// declaro la variable formData e instancio el objeto nativo de javascript new FormData
		var formData = new FormData(document.getElementById("frmSubir"));

		// declaro la variable ruta
		var ruta = 'procesar-subida.php?nombre='+nombre;

		// iniciar el ajax
		$.ajax({

			url: ruta,

			// el metodo para enviar los datos es POST
			type: "POST",

			// colocamos la variable formData para el envio de la imagen
			data: formData,

			contentType: false,

			processData: false,

			beforeSend: function() 
			{
			    $('#mensaje').prepend('<img src="facebook.gif" />');
			},

			success: function(data)
			{
				$('#mensaje').fadeOut("fast",function(){

					$('#mensaje').html(data);

				});

				$('#mensaje').fadeIn("slow");
			} 


		});


	});

});