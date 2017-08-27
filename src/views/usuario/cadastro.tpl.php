<script type="text/javascript">
	$(document).ready(function() {
		$("#senha2").blur(function(){
			if($(this).val() == $("#senha").val()){
				$(this).css('border', '1px solid green');
				$("#envia").removeAttr('disabled');
			}else{
				$(this).css('border', '1px solid red');
				$("#envia").attr('disabled', '');
			}
		})
	});
</script>
<div class="col-md-6">
	<form action="?acao=cadastrar&modulo=index" method="POST">
		<div class="form-group">
			<label for="exampleInputEmail1">E-mail</label>
			<input type="email" name="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email" required="">
		</div>
		<div class="form-group">
			<label for="exampleInputPassword1">Senha</label>
			<input type="password" name="senha" class="form-control" id="senha" placeholder="Senha" required="">
		</div>
		<div class="form-group">
			<label for="exampleInputPassword1">Confirme a senha</label>
			<input type="password" class="form-control" id="senha2" placeholder="Confrime a senha" required="">
		</div>
		<div class="form-group">
			<div class="form-check">
				<label class="form-check-label">
					<input class="form-check-input" type="radio" name="tipo" value="professor" checked>
					Sou professor
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input class="form-check-input" type="radio" name="tipo" value="estudante">
					Sou estudante
				</label>
			</div>
		</div>
		<div class="form-group">
			<label for="exampleInputPassword1">Nome completo</label>
			<input type="text" class="form-control" name="nome" placeholder="Nome" required="">
		</div>
		<div class="form-group">
			<label for="exampleInputPassword1">Matricula</label>
			<input type="text" class="form-control" name="matricula" placeholder="Matricula" required="">
		</div>
		<div class="form-group">
			<label for="exampleInputPassword1">CPF</label>
			<input type="text" class="form-control" name="cpf" placeholder="CPF" required="">
		</div>
		<div class="form-group">
			<label class="mr-sm-2" for="inlineFormCustomSelectPref">Sexo</label>
			<select class="custom-select mb-2 mr-sm-2 mb-sm-0" name="sexo" id="inlineFormCustomSelectPref" required="">
				<option value="M" selected="">Masculino</option>
				<option value="F">Feminino</option>
			</select>
		</div>
		<button type="submit" class="btn btn-primary form-control" id="envia">Cadastrar</button>

	</form>
</div>