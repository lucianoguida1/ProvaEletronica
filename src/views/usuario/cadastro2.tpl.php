<script type="text/javascript">
	$(document).ready(function() {
		$("#professor").click(function(){
			$("#2").hide();
			$("#1").show('fast');
		})
		$("#estudante").click(function(){
			$("#1").hide();
			$("#2").show('fast');
		})
	});
</script>

<div class="col-md-4 align-self-start">
	<button class="col-md-5 btn btn-primary" id="professor">Professor</button>
	<button class="col-md-5 btn btn-success" id="estudante">Estudante</button>
</div>
<div class="col-md-4" style="display: none" id="1">
	<form action="?acao=salvar&modulo=index" method="POST">
		<div class="form-group">
			<label for="exampleInputEmail1">E-mail</label>
			<input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
		</div>
		<div class="form-group">
			<label for="exampleInputEmail1">E-mail</label>
			<input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
		</div>
		<div class="form-group">
			<label for="exampleInputPassword1">Senha</label>
			<input type="password" name="senha" class="form-control" id="senha" placeholder="Senha">
		</div>
		<div class="form-group">
			<label for="exampleInputPassword1">Confirme a senha</label>
			<input type="password" class="form-control" id="senha2" placeholder="Confrime a senha">
		</div>
		<input type="checkbox" value="professor" name="tipo" checked=""> Eu sou professor<br>
		<button type="submit" class="btn btn-primary" id="envia">Cadastrar</button>
	</form>
</div>
<div class="col-md-4" style="display: none" id="2">
	<form action="?acao=salvar&modulo=index" method="POST">
		<div class="form-group">
			<label for="exampleInputEmail1">E-mail</label>
			<input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
		</div>
		<div class="form-group">
			<label for="exampleInputPassword1">Senha</label>
			<input type="password" name="senha" class="form-control" id="senha" placeholder="Senha">
		</div>
		<div class="form-group">
			<label for="exampleInputPassword1">Confirme a senha</label>
			<input type="password" class="form-control" id="senha2" placeholder="Confrime a senha">
		</div>
		<input type="checkbox" value="estudante" name="tipo" checked=""> Eu sou professor<br>
		<button type="submit" class="btn btn-primary" id="envia">Cadastrar</button>
	</form>
</div>