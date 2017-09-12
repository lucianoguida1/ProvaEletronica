<div class="col-md-12">
	<div class="card border-primary m-0">
		<div class="card-header"> 
			Relação de Provas				
		</div>
		<div class="card-body">
			<table id="tabela" class="table table-responsive table-sm table-questoes">
			
				<thead>
					<tr>
						<th>Titulo da Prova</th>
						<th>Disciplina</th>
						<th>Data da Prova</th>
						<th>Horario</th>
						<th>Status</th>
						<th></th>
						<th style="width:15%; overflow:auto;"></th>
					</tr>
				</thead>
				<tbody class="j_linha_tabela_questoes">					
					<?php (isset($provas) ? $provas : "");?>
				</tbody>
			</table>
		</div>
	</div> 	
</div>		
<script type="text/javascript">
	$(document).ready(function($) {
		$("#tabela").DataTable();	
	});
</script>>