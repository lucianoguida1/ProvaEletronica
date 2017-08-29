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
			<input type="email" value="<?=$usuario->getLogin()?>" name="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email" required="">
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
			<label for="exampleInputPassword1">Nome completo</label>
			<input type="text" value="<?=$estudante[0]->getNome_estudante()?>" class="form-control" name="nome" placeholder="Nome" required="">
		</div>
		<div class="form-group">
			<label for="exampleInputPassword1">Matricula</label>
			<input type="text" value="<?=$estudante[0]->getMatricula_estudante()?>" class="form-control" name="matricula" placeholder="Matricula" required="">
		</div>
		<div class="form-group">
			<label for="exampleInputPassword1">CPF</label>
			<input type="text" value="<?=$estudante[0]->getCpf_estudante()?>" class="form-control" name="cpf" placeholder="CPF" required="">
		</div>
		<div class="form-group">
			<label class="mr-sm-2" for="inlineFormCustomSelectPref">Sexo</label>
			<select class="custom-select mb-2 mr-sm-2 mb-sm-0" name="sexo" id="inlineFormCustomSelectPref" required="">
				<option value="M" selected="">Masculino</option>
				<option value="F">Feminino</option>
			</select>
		</div>
		<button type="submit" class="btn btn-primary form-control" id="envia">Salvar Alterações</button>

	</form>
</div>