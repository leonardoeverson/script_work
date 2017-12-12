<?php
date_default_timezone_set('America/Fortaleza');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


?>
<!doctype html>
<html lang="en">
<head>
	<title>Itens</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.12/jquery.mask.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/easytimer@1.1.1/src/easytimer.min.js"></script>
</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-light bg-light">

		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav">
				<li class="nav-item active">
					<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="results.php">Resultados</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="cadastro.php">Cadastro Item</a>
				</li>
			</ul>
		</div>
	</nav>
	
	<div id="container" class="container">
		<!-- Modal -->
		<div class="modal fade" id="exampleModalLabel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">

		      	
		      </div>

		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
		        <button type="button" class="btn btn-primary" onclick="enviar_lance(valor.value, $('.modal-dialog').find('#valor').attr('data-id'),nome.value)">Enviar lance</button>
		      </div>
		    </div>
		  </div>
		</div>
	</div>

	<script type="text/javascript">
		var result = '';
		element_timers = [];
		var contador = 0;

		$.ajax({
			method: "POST",
			url: "insert.php?op=1"
		}).done(function( msg ) {
			result = JSON.parse(msg);
			console.log(result)
			for (var i = 0; i < result.length; i++) {
				var tmp_result = result[i].hora_criacao.split(' ');

				$("#container").append("<div class='card' style='width: 30rem;'><div class='card-body'><div class='form-group'><label for='hora_dia'>Hora de Criação</label><input type='text' class='form-control hora_dia' id='hora_dia' name='hora_dia' value="+tmp_result[1]+" disabled></div><div class='form-group'><label for='hora'>Tempo Restante</label><input type='text' class='form-control hora' id='hora' name='hora' disabled value="+result[i].timer.replace('-','')+"></div><h5 class='card-title'>Nome do produto: "+ result[i].nome_item+"</h5><p class='card-text'>Descrição do produto: "+ result[i].descricao +"</p><button type='button' class='btn btn-primary' data-toggle='modal' onclick='show_modal("+i +','+ result[i].id+")' data-id='"+result[i].id +"' >Atribuir Lance</button></div></div>");
			}
			//

			var size = document.getElementsByClassName('hora').length;
			console.log(size)
			for( i = 0; i < size ; i++){
				var param1 = $('.hora')[i];
				var param2 = $('.hora')[i].value;

				element_timers[i] = [param1, param2]; 
				
				
			}

			setInterval(function(){countdown()},1000);
		});




		function show_modal(indice, id){
			indice = Number(indice)
			//console.log(nome_item)
			$('#exampleModalLabel').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget) // Button that triggered the modal
			  var recipient = result[indice].nome_item // Extract info from data-* attributes
			  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
			  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
			  var modal = $(this)
			  modal.find('.modal-title').html('');
			  modal.find('.modal-body').text('');
			  modal.find('.modal-body').html('');
			  modal.find('.modal-title').text('Atribuir lance para o(a) ' + recipient)
			  modal.find('.modal-body').append("<b>Descrição do item:</b><br>" + result[indice].descricao)
			  modal.find('.modal-body').append("<br><div class='form-group'><label for='valor'><b>Valor do Lance:</b><br></label><input type='text' class='form-control' id='valor' data-id='"+id+"' aria-describedby='emailHelp'></div>");

			  modal.find('.modal-body').append("<br><br><div class='form-group'><label for='nome'><b>Nome:</b><br></label><input type='text' class='form-control' id='nome' ></div>");

			  modal.find('#valor').text('');
			  //modal.find('.modal-body input').val(recipient)
			})

			$('#exampleModalLabel').modal('show')
			$('#valor').mask('#.##0.00', {reverse: true});

		}

		function enviar_lance(param, id, nome){
			$('#exampleModalLabel').modal('hide');
			$.ajax({
				url: 'insert.php?op=3',
				type: 'POST',
				dataType: 'html',
				data: {valor_lance: param, id: id, nome:nome},
			})
			.done(function(data_result) {
				console.log(data_result)
				var result = JSON.parse(data_result);
				alert(result.msg_text);
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
			
		}

		function countdown(){
			//console.log(contador)
			contador++;
			var tmp = $('.hora');
			for(i = 0; i < tmp.length;i++){
				var times = tmp[i].value.split(":");
				
				var hour = Number(times[0]);
				var minutes = Number(times[1]);
				var seconds = Number(times[2]);
				seconds = seconds - 1;	

				if(seconds < 0){
					seconds = 59;
				}

				if(seconds == 0){
					minutes--;

				}

				if(minutes == 0){
					if(hour > 0){
						hour--;
					}
				}

				if(hour <= 0 && minutes <= 0 && seconds <= 0){
					location.reload(true)
				}

				tmp[i].value = hour + ":"+ minutes +":"+ seconds;


			}

			if(contador > 100){
				console.log("atualizando...")
				location.reload(true);
				contador = 0;
			}
		}



	</script>
	<style>
	.card{
		margin-top:20px;
		margin-left:20px;
		display: -webkit-inline-flex
	}

	#hora{
		width:120px;
		float: right
	}

	#hora_dia{
		width:120px;
		float: right
	}
</style>
</body>
</html>