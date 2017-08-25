<form name="form-questao" action="acao=cadastrarQuestaoAjax&modulo=questao" method="post">
	<input type="hidden" name="questao_id" value="<?= isset($questao)?$questao->getId():"" ?>">
			<div class="form-group">
				<label for="enunciado">Enunciado</label>
				<textarea class="form-control form-questao" id="enunciado" name="enunciado" rows="3" required=""><?= isset($questao)? $questao->getEnunciado():"" ?></textarea>
			</div>
		<div class="form-row">											
			<button type="button" class="btn btn-primary btn-sm j_adicinar_alternativa">+ Adicionar Alternativa</button>
					<div class="col-md-4">
						<div class="input-group input-group-sm">
							<span class="input-group-addon" id="valor">Valor</span>
							<input type="text" class="form-control" placeholder="Questão" name="valor" aria-label="valor" aria-describedby="valor" value="<?= isset($questao)? $questao->getValor():"" ?>" required="">
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
												<div class="form-check">
													<label class="form-check-label">
														<input class="form-check-input" type="checkbox" id="resposta_alternativa<?= $alternativa->getId() ?>" name="resposta_alternativa<?= $alternativa->getId() ?>"  value="true" aria-label="..."
														<?php 
														if($alternativa->getAlternativa_certa() == 1) {
															echo "checked";
														} 
														?>	
														>
														<textarea class="form-control form-questao" id="alternativa<?= $alternativa->getId() ?>" name="alternativa<?= $alternativa->getId() ?>" rows="2" cols="80" required=""><?= $alternativa->getEnunciado_alter() ?></textarea>	
													</label>
													<a href="acao=excluirAlternativa&modulo=alternativa&id=<?= $alternativa->getId() ?>" class="badge badge-danger excluir-alternativa">Excluir</a>
												</div>	
											</li>
										<?php 
									}	
									endif	
									?>										
								</ul>										
		<div id="j_error_cadastro"><!-- ERROR PREENCHIDO VIA JAVASCRIPT--></div>
	
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">CANCELAR</button>
			<button type="submit" class="btn btn-primary btn-sm">SALVAR</button>
		</div>
</form>
<script type="text/javascript" src="assets/js/app.js"></script>