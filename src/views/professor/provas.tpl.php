<div class="col-md-12">
	<div class="card border-primary m-0">
		<div class="card-header">
			Relação de Provas
		</div>
		<div class="card-body">
			<table class="diplay table-responsive compact table-questoes hover j_provas" cellspacing="0" width="100%" data-order='[[ 1, "asc" ]]' data-page-length='10'>
				<thead>
					<tr>
						<th>Cód</th>
						<th>Titulo da Prova</th>
						<th>Disciplina</th>
						<th>Inicio-Fim</th>
						<th>Data da Prova</th>
						<th>Qntd Questões</th>
						<th style="width:15%; overflow:auto;"></th>
					</tr>
				</thead>
				<tbody class="j_linha_tabela_questoes">
					<?php if(isset($provas)):
							foreach($provas as $prova) {
					?>
							<tr id="j_ <?=$prova->getId()?>">
								<th scope="row"><?=$prova->getId()?></th>
								<td><?=$prova->getTitulo()?></td>
								<td><?=$prova->getDisciplina()?></td>
								<td><?=$prova->getHorario_inicio()?> - <?=$prova->getHorario_fim()?> </td>
								<td><?=date('d/m/Y', strtotime($prova->getData_prova()))?></td>
								<td><?=$prova->getQtd_questoes()?></td>
								<td>
									<a  href="?acao=editarProva&modulo=professor&id=<?=$prova->getId()?>" class="badge badge-primary">Editar</a>
									<a id="<?=$prova->getId()?>" href="?acao=cancelarProva&modulo=professor&id=<?=$prova->getId()?>" class="badge badge-secondary">Cancelar</a>
									<a id="<?=$prova->getId()?>" href="acao=excluirProva&modulo=professor&id=<?=$prova->getId()?>" class="badge badge-danger j_excluir">Excluir</a>
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
</div>