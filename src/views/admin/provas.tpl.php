<script type="text/javascript">
	$(document).ready(function() {
		$('#modff').DataTable();
	});
</script>
<div id="re"></div>
<div class="col-md-12">
	<div class="card">
		<h4 class="card-header">Provas</h4>
		<div class="card-body">
			<table class="table" id="modff">
				<thead class="thead-default">
					<tr>
						<th>Titulo</th>
						<th>Disciplina</th>
						<th>Horario</th>
						<th>Data</th>
						<th>Professor</th>
						<th>Status</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>
					<?php if(empty($provas))
					echo "<th colspan='5' class='table-success'>Nenhum novo usuário encontrado!</th>";
					else{
						foreach ($provas as $val) {
							?>
							<tr>
								<th><?=$val->getTitulo()?></th>
								<th><?=$val->getDisciplina()?></th>
								<td><?=$val->getHorario_inicio()." - ".$val->getHorario_fim()?></td>
								<td><?=date('d/m/Y', strtotime($val->getData_prova()))?></td>
								<td><?=$val->getProfessor()->getNome_prof()?></td>
								<td><?=($val->getStatus()=="2"?"<span class='badge badge-danger'>Inativa</span>":"<span class='badge badge-success'>Ativa</span>")?></td>
								<td>
									<div class="btn-group" role="group" aria-label="Basic example">
										<button class="btn btn-info" data-toggle="modal" data-target="#exampleModal<?=$val->getId()?>">Visulaizar</button>
									</div>
									<div class="modal fade" id="exampleModal<?=$val->getId()?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-lg" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel"><?=$val->getProfessor()->getTipo()=="professor"?"Professor":"Estudante"?></h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<p><b>Titulo da Prova:</b> <?=$val->getTitulo()?></p>
													<p><b>Disciplina:</b> <?=$val->getDisciplina()?></p>
													<p><b>Data da Prova:</b> <?=date('d/m/Y', strtotime($val->getData_prova()))?></p>
													<p><b>Horario:</b> <?=$val->getHorario_inicio()." - ".$val->getHorario_fim()?></p>
												</div>
												<div class="modal-footer">
													<table class="table">
														<thead class="thead-inverse">
															<tr class="bg-success">
																<th>Questões</th>
																<th>Resposta</th>
															</tr>
														</thead>
														<tbody>
														<?php foreach($val->getQuestao() as $vall){?>
															<tr>
																<th><?=$vall->getEnunciado()?></th>
																<td><?php foreach($vall->getAlternativas() as $alter){?>
																	<p class="alert <?=$alter->getAlternativa_certa()?'alert-success':'alert-danger'?>"><?=$alter->getEnunciado_alter()?></p>
																<?php } ?></td>
															</tr>
														<?php } ?>
														</tbody>
													</table>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<?php }} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>