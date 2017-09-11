<form action="?acao=finalizarprova&modulo=aluno" name="formprova" method="POST">
	<?=$prova?>
</form>
<script type="text/javascript">
	var pagina = new Number();
	pagina = 0;
	function proximo()
	{
		$("#questao"+pagina).hide('slow/400/fast');
		pagina++;
		$("#questao"+pagina).show('slow/400/fast');
	}

	function anterior()
	{
		$("#questao"+pagina).hide('slow/400/fast');
		pagina--;
		$("#questao"+pagina).show('slow/400/fast');
	}
</script>