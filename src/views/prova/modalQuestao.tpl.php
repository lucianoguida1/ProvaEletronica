<form name="form-questao" action="acao=cadastrarQuestaoAjax&modulo=prova" method="post">
	<input type="hidden" name="questao_id" value="<?= isset($questao)?$questao->getId():"" ?>">

	<div class="form-group">
		<label for="enunciado">Enunciado</label>
		<textarea class="form-control form-questao" id="enunciado" name="enunciado" rows="3" required=""><?= isset($questao)? $questao->getEnunciado():"" ?></textarea>
</div>
	<div class="form-row">
		<button type="button" class="btn btn-primary btn-sm j_adicinar_alternativa">+ Adicionar Alternativa</button>
		<div class="col-md-2">
			<div class="input-group input-group-sm">
				<span class="input-group-addon" id="ordem">Nº</span>
				<input type="number" class="form-control" placeholder="Questão" name="ordem" aria-label="ordem" aria-describedby="ordem" value="<?= isset($questao)? $questao->getOrdem():"" ?>" required="">
			</div>
		</div>
		<div class="col-md-4">
			<div class="input-group input-group-sm">
				<span class="input-group-addon" id="valor">Valor</span>
				<input type="number" class="form-control" placeholder="Questão" name="valor" aria-label="valor" aria-describedby="valor" value="<?= isset($questao)? $questao->getValor():"" ?>" required="">
			</div>
		</div>
	</div>
	<hr>
	<ul class="list-group j_lista_alternativa">
		<?php
		if (isset($alternativas)) :
			foreach ($alternativas as $alternativa) {
				?>
				<li id="<?= $alternativa->getId() ?>" class="list-group-item">
					<input type="hidden" name="id_alternativa<?= $alternativa->getId() ?>" value="<?= $alternativa->getId() ?>">
					<div class="form-check">
						<label class="form-check-label">
							<input class="form-check-input" type="checkbox" id="certa_alternativa<?= $alternativa->getId() ?>" name="certa_alternativa<?= $alternativa->getId() ?>"  value="true" aria-label="..."
							<?php
							if($alternativa->getAlternativa_certa() == 1) {
								echo "checked";
							}
							?>
							>
							<textarea class="form-control form-questao" id="alternativa_enun<?= $alternativa->getId() ?>" name="alternativa_enun<?= $alternativa->getId() ?>" rows="2" cols="80" required=""><?= $alternativa->getEnunciado_alter() ?></textarea>
						</label>
						<a id="<?= $alternativa->getId() ?>" href="acao=excluirAlternativa&modulo=prova&id=<?= $alternativa->getId() ?>" class="badge badge-danger excluir-alternativa">Excluir</a>
					</div>
				</li>
				<?php
			}
		endif;
		?>
	</ul>
	<div id="j_error_cadastro"><!-- ERROR PREENCHIDO VIA JAVASCRIPT--></div>

	<div class="modal-footer">
		<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">CANCELAR</button>
		<button type="submit" class="btn btn-primary btn-sm">SALVAR</button>
	</div>

</form>
 <script type="text/javascript" src="assets/js/app.js">