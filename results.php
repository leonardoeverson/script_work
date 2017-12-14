<!doctype html>
<html lang="en">
<head>
	<title>Encerrados</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-light bg-light">

		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav">
				<li class="nav-item active">
					<a class="nav-link" href="index.php">Itens<span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="results.php">Resultados</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="cadastro.php">Cadastro de itens</a>
				</li>
				<li class="nav-item">
		      <a class="nav-link" href="https://github.com/firebird-t/script_work">Github</a>
		    </li>
			</ul>
		</div>
	</nav>
	<div class="container">
		<table class="table table-hover">
			<thead>
				<tr>
					<th scope="col">Produto</th>
					<th scope="col">Ganhador</th>
					<th scope="col">Valor do lance</th>
				</tr>
			</thead>
			<tbody id="table_body">
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$.ajax({
		url: 'insert.php?op=4',
		type: 'POST',
		dataType: 'html',
	})
	.done(function(data) {
		var data_json = JSON.parse(data);
		console.log(data_json)
		for(i = 0; i < data_json.length; i++){
			$('#table_body').append("<tr><td>"+data_json[i].nome_item+"</td><td>"+data_json[i].nome_usuario+"</td><td>R$ "+data_json[i].lance+"</td></tr>");
		}
		
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
	

</script>
</body>
</html>