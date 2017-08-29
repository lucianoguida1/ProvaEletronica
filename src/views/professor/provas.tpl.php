<div class="col-md-12">
	<div class="card border-primary m-0">
		<div class="card-header">
			Relação de Provas
		</div>
		<div class="card-body">
			<table id="j_provas" class="table table-responsive table-sm table-questoes hover" data-order='[[ 1, "asc" ]]' data-page-length='10'  >
				<thead>
					<tr>
						<th>Titulo da Prova</th>
						<th>Disciplina</th>
						<th>Data da Prova</th>
						<th>Qntd Questões</th>
						<th style="width:15%; overflow:auto;"></th>
					</tr>
				</thead>
				<tbody class="j_linha_tabela_questoes">
					<?php echo $provas; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>