<div class="col-md-12">
	<div class="card border-primary m-0">
		<div class="card-header">
			Informações da Prova
		</div>
		<div class="card-body">
			<form name="form-prova" action="?acao=salvarProva&modulo=prova" method="POST">
				<div class="form-row">
				<input type="hidden" name="id" value="<?= isset($prova)?$prova->getId():""  ?>">
					<div class="form-group col-md-4">
						<label for="titulo">Título da Prova</label>
						<input type="text" class="form-control form-control-sm" id="titulo" name="titulo" placeholder="Título da Prova" required=""
						value="<?= isset($prova)?$prova->getTitulo():""  ?>"
						>
					</div>
					<div class="form-group col-md-4">
						<label for="disciplina">Disciplina</label>
						<input type="text" class="form-control form-control-sm" id="disciplina" name="disciplina" placeholder="Disciplina" required="" value="<?= isset($prova)?$prova->getDisciplina():""  ?>">
					</div>
					<div class="form-group col-md-3">
						<label for="data_prova">Data da Prova</label>
						<input type="date" class="form-control form-control-sm" id="data_prova" name="data_prova" placeholder="Data da Prova" required="" value="<?= isset($prova)?$prova->getData_prova():""  ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-3">
						<label class="sr-only" for="inicio"></label>
						<div class="input-group input-group-sm">
							<div class="input-group-addon">Inicio</div>
							<input type="time" class="form-control form-control-sm" id="inicio" name="inicio" required="" value="<?= isset($prova)?$prova->getHorario_inicio():""  ?>">
						</div>
					</div>
					<div class="form-group col-md-3">
						<label class="sr-only" for="fim"></label>
						<div class="input-group input-group-sm">
							<div class="input-group-addon">Fim</div>
							<input type="time" class="form-control form-control-sm" id="fim" name="fim" required="" value="<?= isset($prova)?$prova->getHorario_fim():""  ?>">
						</div>
					</div>
					<div class="form-group col-md-3">
						<label class="sr-only" for="fim"></label>
						<div class="input-group input-group-sm">
							<div class="input-group-addon">Qtd.</div>
							<input type="number" class="form-control form-control-sm" id="quantidade" name="quantidade" placeholder="Questões" required="" value="<?= isset($prova)?$prova->getQtd_questoes():""  ?>">
						</div>
					</div>
				</div>

				<button type="submit" class="btn btn-success btn-sm j_salva_prova">Salvar Prova</button>

				<button type="button" class="btn btn-info btn-sm j_adicionar_questao">Adicionar Questão</button>
			</form>


			<table class="table table-responsive table-sm table-questoes">
				<thead>
					<tr>
						<th style="width:5%;  overflow:auto;">Questão</th>
						<th>Enunciado</th>
						<th style="width:16%; overflow:auto;"></th>

					</tr>
				</thead>
				<tbody class="j_linha_tabela_questoes">
					<?php
						if(isset($questoes)) :

							foreach ($questoes as $questao) {
					?>
						<tr id="j_<?= $questao->getId() ?>" class="<?= !$questao->getStatus()? "alert alert-secondary":"" ?>">
							<th scope="row"><?= $questao->getOrdem(); ?></th>
							<td><?= $questao->getEnunciado() ?></td>
							<td>
								<a id="<?= $questao->getId() ?>" href="acao=editarQuestao&modulo=prova&id=<?= $questao->getId() ?>" class="badge badge-primary j_editar">Editar</a>
								<a id="<?= $questao->getId() ?>" href="acao=anularQuestao&modulo=prova&id=<?= $questao->getId() ?>" class="badge badge-secondary j_anular">Anular</a>
								<a id="<?= $questao->getId() ?>" href="acao=excluirQuestao&modulo=prova&id=<?= $questao->getId() ?>" class="badge badge-danger j_excluir">Excluir</a>
								<i  class="fa fa-check" aria-hidden="true"></i>

							</td>

						</tr>
					<?php

							}
						endif;
					 ?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="modal fade" id="modal-adicionar-questao" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Questão</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
				</div>

				<div id="conteudo-modal" class="modal-body">
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
												<input class="form-check-input" type="checkbox" id="certa_alternativa<?= $alternativa->getId() ?>" name="certa_alternativa<?= $alternativa->getId() ?>"  value="true" aria-label="...">
												<?php
												if($alternativa->getAlternativa_certa() == 1) {
													echo "checked";
												}
												?>
												>
												<textarea class="form-control form-questao" id="alternativa_enun<?= $alternativa->getId() ?>" name="alternativa_enun<?= $alternativa->getId() ?>" rows="2" cols="80" required=""><?= $alternativa->getEnunciado() ?></textarea>
											</label>
											<a id="<?= $alternativa->getId() ?>" href="acao=excluirAlternativa&modulo=alternativa&id=<?= $alternativa->getId() ?>" class="badge badge-danger excluir-alternativa">Excluir</a>
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
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->



				<div class="modal" id="modal-confirme">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Confirme</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body j_msg_modal_confirme">
								<!-- CONTEÚDO PREENCHIDO VIA JAVASCRIPT-->
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-primary btn-sm j_confirme-sim">SIM</button>
								<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">NÃO</button>
							</div>
						</div>
					</div>
				</div>
</div>
