
<div class="col-md-12 ">
	<div class="form-login">
		<h2 class="text-center title-login">Prova Eletrônica</h2>
		<form action="?acao=login&modulo=usuario" method="POST">
			<div class="form-group">
				<label for="exampleInputEmail1">E-mail *</label>
				<div class="input-group margin-bottom-sm">
  					<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
					<input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Login">
				</div>
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Senha *</label>
				<div class="input-group">
  					<span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
					<input type="password" name="senha" class="form-control" id="exampleInputPassword1" placeholder="Password">
				</div>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block">Entrar</button>
			</div>
			<div class="form-group">
				<a class="btn btn-success btn-block" href="?acao=cadastro&modulo=index">Criar uma conta</a>
			</div>
			<a href="#" ><p class="text-dark text-center" >Esqueci minha senha<p></a>
		</form>
	</div>
</div>