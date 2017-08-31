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
		$('#organiza').DataTable();
		$(".salva").click(function(event) {
			var a = "";
			$(this).parent().parent().find('input').each(function(index, el) {
				if(!$(this).attr('disabled')){
					a += $(this).attr('id')+"='"+$(this).val()+"'&";
				}
			});
			$.ajax({
				url: '?acao=adminAltera&modulo=ajax',
				type: 'POST',
				dataType: 'html',
				data: a,
				success: function(e){
					alert(e);
				}
			});
		});
	});
</script>
<div id="re"></div>
<div class="col-md-10">
	<div class="card">
		<h4 class="card-header">Lista de professores</h4>
		<div class="card-body">
			<button id="atu" style="display: none;" type="button" class="btn btn-outline-info">Atualizar Tabela</button>
			<table class="table" id="organiza">
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
							<tr <?php if($val->getStatus() == 2){ echo "class='table-danger'"; }?>>
								<th scope="row"><?=$i++?></th>
								<th><?=$val->getTipo()?></th>
								<td><?=$val->getTipo()=="professor"?$val->getProfessor()->getNome_prof():$val->getEstudante()->getNome_estudante()?></td>
								<td><?=$val->getLogin()?></td>
								<td>
									<div class="btn-group" role="group" aria-label="Basic example">
										<?php if($val->getStatus() == 2){ ?>
										<button class="btn btn-success liberar" value="<?=$val->getId()?>">Liberar</button>
										<?php }else{ ?>
										<button class="btn btn-danger recusar" value="<?=$val->getId()?>">Desativar</button>
										<?php } ?>
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
													<div class="col-md-10" id="dadosSalva">
														<input type="text" id="id" value="<?=$val->getId()?>" style="display: none;">
														<div class="form-group">
															<label for="exampleInputEmail1">Nome</label>
															<input type="text" name="text" class="form-control" id="nome" required="" value="<?=$val->getProfessor()->getNome_prof()?>">
														</div>
														<div class="form-group">
															<label for="exampleInputEmail1">Matricula</label>
															<input type="text" name="text" class="form-control" id="matricula" required="" value="<?=$val->getProfessor()->getMatricula_prof()?>">
														</div>
														<div class="form-group">
															<label for="exampleInputEmail1">CPF</label>
															<input type="text" disabled="" name="text" class="form-control" id="cpf" required="" value="<?=$val->getProfessor()->getCpf_prof()?>">
														</div>
														<div class="form-group">
															<label for="exampleInputEmail1">E-mail</label>
															<input type="email" name="email" class="form-control" id="email" required="" value="<?=$val->getProfessor()->getEmail_prof()?>">
														</div>
														<div class="form-group">
															<label for="exampleInputEmail1">Sexo</label>
															<input type="text" disabled="" name="text" class="form-control" id="sexo" required="" value="<?=($val->getProfessor()->getSexo_prof()=="M")?"Masculino":"Feminino"?>">
														</div>
													</div>

												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-success salva" data-dismiss="modal">Salvar</button>
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
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