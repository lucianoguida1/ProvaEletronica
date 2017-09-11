<div class="col-md-12">
	<div class="card border-primary m-0">
		<div class="card-header"> 
			Relação de Provas				
		</div>
		<div class="card-body">
			<table id="tabela" class="table table-responsive table-sm table-questoes">
			
				<thead>
					<tr>
						<th>Questões</th>
						<th>Aprovado/Reprovado</th>
						<th>Valor</th>
						<th></th>
					</tr>
				</thead>
				<tbody class="j_linha_tabela_questoes">					
					<?php echo $provas;?>
				</tbody>
			</table>
		</div>
	</div> 	
</div>		
<script type="text/javascript">
	$(document).ready(function($) {
		$("#tabela").DataTable();	
	});
</script>