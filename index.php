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

		$.ajax({
			method: "POST",
			url: "insert.php?op=1"
		}).done(function( msg ) {
			result = JSON.parse(msg);
			console.log(result)
			for (var i = 0; i < result.length; i++) {
				$("#container").append("<div class='card' style='width: 20rem;'><img class='card-img-top' src='data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22318%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20318%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_16046348fb8%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A16pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_16046348fb8%22%3E%3Crect%20width%3D%22318%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22118.01666641235352%22%20y%3D%2297.5%22%3E318x180%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E' alt='Card image cap'><div class='card-body'><h4 class='card-title'>"+ result[i].nome_item+"</h4><p class='card-text'>"+ result[i].descricao +"</p><button type='button' class='btn btn-primary' data-toggle='modal' onclick='show_modal("+i +','+ result[i].id+")' data-id='"+result[i].id +"' >Atribuir Lance</button></div></div>");
			}
			//
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
			  modal.find('.modal-body').append("<br><br><div class='form-group'><label for='valor'><b>Valor do Lance:</b><br></label><input type='text' class='form-control' id='valor' data-id='"+id+"' aria-describedby='emailHelp'></div>");

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
				var result = JSON.stringify(data_result);
				alert(result.mensagem)
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
			
		}
	</script>
	<style>
	.card{
		margin-top:20px;
		margin-left:20px;
		display: -webkit-inline-flex
	}
</style>
</body>
</html>