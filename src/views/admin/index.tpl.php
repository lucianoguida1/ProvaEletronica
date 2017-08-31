<script type="text/javascript">
	$(document).ready(function() {
		$(".liberar").click(function(event) {
			var a = $(this).parent().parent().parent();
			$.ajax({
				url: '?acao=adminAceita&modulo=ajax',
				type: 'POST',
				dataType: 'html',
				data: "id="+$(this).val(),
				success: function(e){
					if(e){
						a.removeAttr('class');
						a.addClass('table-success');
						$("#atu").show("fast");
					}else{
						a.removeAttr('class');
						a.addClass('table-warning');
					}
				}
			});
		});
		$(".recusar").click(function(event) {
			var a = $(this).parent().parent().parent();
			$.ajax({
				url: '?acao=adminRecusa&modulo=ajax',
				type: 'POST',
				dataType: 'html',
				data: "id="+$(this).val(),
				success: function(e){
					if(e){
						a.removeAttr('class');
						a.addClass('table-danger');
						$("#atu").show("fast");
					}else{
						a.removeAttr('class');
						a.addClass('table-warning');
					}
				}
			});
		});
		$('#atu').click(function() {
		    location.reload();
		});
		$('.table').DataTable();
	});
</script>
<div id="re"></div>
<div class="col-md-10">
	<div class="card">
		<h4 class="card-header">Solicitação de cadastro</h4>
		<div class="card-body">
			<button id="atu" style="display: none;" type="button" class="btn btn-outline-info">Atualizar Tabela</button>
			<table class="table">
				<thead class="thead-default">
					<tr>
						<th>#</th>
						<th>Tipo</th>
						<th>Nome</th>
						<th>E-mail</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>
					<?php if(empty($usuarios))
					echo "<th colspan='5' class='table-success'>Nenhum novo usuário encontrado!</th>";
					else{ $i=1;
						foreach ($usuarios as $val) {
							?>
							<tr>
								<th scope="row"><?=$i++?></th>
								<th><?=$val->getTipo()?></th>
								<td><?=$val->getTipo()=="professor"?$val->getProfessor()->getNome_prof():$val->getEstudante()->getNome_estudante()?></td>
								<td><?=$val->getLogin()?></td>
								<td>
									<div class="btn-group" role="group" aria-label="Basic example">
										<button class="btn btn-success liberar" value="<?=$val->getId()?>">Liberar</button>
										<button class="btn btn-danger recusar" value="<?=$val->getId()?>">Recusar</button>
										<button class="btn btn-info" data-toggle="modal" data-target="#exampleModal<?=$val->getId()?>">+ Informação</button>
									</div>
									<div class="modal fade" id="exampleModal<?=$val->getId()?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-lg" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel"><?=$val->getTipo()=="professor"?"Professor":"Estudante"?></h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<table class="table">
														<thead class="thead-default">
															<tr>
																<th>Nome</th>
																<th>Matricua</th>
																<th>CPF</th>
																<th>E-mail</th>
																<th>Sexo</th>
															</tr>
														</thead>
														<tbody>
															<th scope="row"><?=$val->getTipo()=="professor"?$val->getProfessor()->getNome_prof():$val->getEstudante()->getNome_estudante()?></th>
															<td><?=$val->getTipo()=="professor"?$val->getProfessor()->getMatricula_prof():$val->getEstudante()->getMatricula_estudante()?></td>
															<td><?=$val->getTipo()=="professor"?$val->getProfessor()->getCpf_prof():$val->getEstudante()->getCpf_estudante()?></td>
															<td><?=$val->getLogin()?></td>
															<td><?=($val->getTipo()=="professor"?$val->getProfessor()->getSexo_prof():$val->getEstudante()->getSexo_estudante())=="M"?"Masculino":"Feminino"?></td>
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