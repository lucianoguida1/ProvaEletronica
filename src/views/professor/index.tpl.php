<script type="text/javascript">
	$(document).ready(function() {
		var offset = 0;
		var conteudoFinalizados = $('.j_finalizados');

		$('.j_proximo').click(function(){
			offset += 15;
			listarFinalizados(offset);
		})
		$('.j_anterior').click(function(){
			if(offset != 0) {
				offset -= 15;
			}
			listarFinalizados(offset);
		})
		var dadosAjax;
		function listarFinalizados(val){
			$.ajax({
				url: "http://localhost/provaeletronica/web/index.php",
				type: 'get',
				data: "acao=pagFinalizados&modulo=professor&limit=15&offset=" + val,
				dataType: 'json',
				error: function(){
					msgAjax('danger', 'Error de comunicação');
				},
                success: function (data) {
                    conteudoFinalizados.empty();
                    $.each(data, function (index, el) {
                        conteudoFinalizados.append('<tr><td>' + el.id + '</td><td>' + el.titulo + '</td><td>' + el.disciplina + '</td><td><span class="badge badge-danger pull-right">Finalizado</span></td><td>' + el.qtd_questoes + '</td><td>' + el.valor + '</td><td>' + el.qtdEst + '</td><td>' + el.data_prova + '</td><td><a href="?acao=alunosProva&modulo=professor&id=' + el.id + '"><i class="fa fa-search"></i></a></td></tr>');
                    });
                    if (data.length == 0) {
                        $('#provasfinalizadas').empty();
                        $('#provasfinalizadas').html("<p class='text-center'>Nenhuma prova finalizada</p>");
                        $('.j_proximo').fadeOut("fast");
                        $('.j_proximo').fadeOut("fast");
                    } else {
                        if (data.length < 15) {
                            $('.j_proximo').fadeOut("fast");
                        } else {
                            $('.j_proximo').fadeIn("fast");
                        }
                    }

                }
            })
        }
		listarFinalizados(0);
	});
</script>
<div class="col-md-12">
	<div class="card border-primary m-0">
		<div class="card-body">
			<h4 class="title-nav">Informações</h4>
			<!-- Nav tabs -->
			<ul class="nav nav-tabs lista-nav" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link <?=isset($apublicarActive)?($apublicarActive)?'active':'':''?>" data-toggle="tab" href="#provasapublicar" role="tab">Provas a Publicar</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?=isset($publicadaActive)?($publicadaActive)?'active':'':''?>" data-toggle="tab" href="#provaspublicadas" role="tab">Provas Publicadas</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?=isset($finalizadaActive)?($finalizadaActive)?'active':'':''?>" data-toggle="tab" href="#provasfinalizadas" role="tab">Provas Finalizadas</a>
				</li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div class="tab-pane <?=isset($apublicarActive)?($apublicarActive)?'active':'':''?>" id="provasapublicar" role="tabpanel">
					<?php if(isset($provasAPublicar) && !empty($provasAPublicar)) {  ?>
					<table class="table table-responsive table-sm table-questoes table-hover"">
						<thead>
							<tr>
								<th>Cód.</th>
								<th>Título</th>
								<th>Disciplina</th>
								<th></th>
								<th>Qtd. Questões</th>
								<th>Valor Prova</th>
								<th>Inicio-Fim</th>
								<th>Data da Prova</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($provasAPublicar as $provaAPublicar) { ?>
							<tr>
								<td><?=$provaAPublicar->getId()?></td>
								<td><?=$provaAPublicar->getTitulo()?></td>
								<td><?=$provaAPublicar->getDisciplina()?></td>
								<td><span class="badge badge-success pull-right">Aberto</span></td>
								<td><?=$provaAPublicar->getQtd_questoes()?></td>
								<td><?=$provaAPublicar->getValor()?></td>
								<td><?=$provaAPublicar->getHorario_inicio(). " - " . $provaAPublicar->getHorario_fim() ?></td>
								<td><?=date('d/m/Y',strtotime($provaAPublicar->getData_prova()))?></td>
								<td><a href="?acao=publicarProva&modulo=professor&id=<?=$provaAPublicar->getId()?>" class="btn btn-secondary btn-sm pull-right">Publicar</a></td>
							</tr>
							<?php } ?>

						</tbody>
					</table>
					<?php    } else {
						echo "<p class='text-center'>Nenhuma prova à publicar</p>";
					} ?>
				</div>
				<div class="tab-pane <?=isset($publicadaActive)?($publicadaActive)?'active':'':''?>" id="provaspublicadas" role="tabpanel">
					<?php if(isset($provasPublicadas) && !empty($provasPublicadas)) {  ?>
					<table class="table table-responsive table-sm table-questoes table-hover"">
						<thead>
							<tr>
								<th>Cód.</th>
								<th>Título</th>
								<th>Disciplina</th>
								<th></th>
								<th>Qtd. Questões</th>
								<th>Valor Prova</th>
								<th>Inicio-Fim</th>
								<th>Data da Prova</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($provasPublicadas as $provaPublicada) { ?>
							<tr>
								<td><?= $provaPublicada->getId() ?></td>
								<td><?= $provaPublicada->getTitulo() ?></td>
								<td><?= $provaPublicada->getDisciplina() ?></td>
								<td>
									<?php
									$dataAtual = date('Y-m-d');
									$horaAtual = date('H:i:s');
									if($provaPublicada->getData_prova() == $dataAtual && $provaPublicada->getHorario_inicio() < $horaAtual
										&& $provaPublicada->getHorario_fim() > $horaAtual) {?>
									<span class="badge badge-warning pull-right">Em Andamento</span>
									<?php }elseif ($provaPublicada->getData_prova() == $dataAtual && $provaPublicada->getHorario_inicio() < $horaAtual
										&& $provaPublicada->getHorario_fim() < $horaAtual) { ?>
										<span class="badge badge-dark pull-right">Realizado</span>
									<?php }else{ ?>
										<span class="badge badge-info pull-right">A Realizar</span>
									<?php } ?>
								</td>
								<td><?=$provaPublicada->getQtd_questoes()?></td>
								<td><?=$provaPublicada->getValor()?></td>
								<td><?=$provaPublicada->getHorario_inicio(). " - " . $provaPublicada->getHorario_fim() ?></td>
								<td><?=date('d/m/Y',strtotime($provaPublicada->getData_prova()))?> </td>
								<td><a href="?acao=estProva&modulo=professor&id=<?=$provaPublicada->getId()?>" ><i class="fa fa-search"></i></a></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<?php  } else {
						echo "<p class='text-center'>Nenhuma prova publicada</p>";
					} ?>
				</div>
				<div class="tab-pane <?=isset($finalizadaActive)?($finalizadaActive)?'active':'':''?>" id="provasfinalizadas" role="tabpanel">
					<table id="finalizados" class="table table-responsive table-sm table-questoes table-hover"">
						<thead>
							<tr>
								<th>Cód.</th>
								<th>Título</th>
								<th>Disciplina</th>
								<th></th>
								<th>Qtd. Questões</th>
								<th>Valor Prova</th>
								<th>Qtd. Alunos</th>
								<th>Data da Prova</th>
								<th></th>
							</tr>
						</thead>
						<tbody class="j_finalizados">
							<?php if(isset($provasFinalizadas) && !empty($provasFinalizadas)){
							foreach ($provasFinalizadas as $provaFinalizada) { ?>
							<tr>
								<td><?= $provaFinalizada->getId() ?></td>
								<td><?= $provaFinalizada->getTitulo() ?></td>
								<td><?= $provaFinalizada->getDisciplina() ?></td>
								<td><span class="badge badge-danger pull-right">Finalizado</span></td>
								<td><?= $provaFinalizada->getQtd_questoes() ?></td>
								<td><?=$provaFinalizada->getValor()?></td>
								<td><?=$provaFinalizada->getQtdEst()?></td>
								<td><?=date('d/m/Y',strtotime($provaFinalizada->getData_prova()))?></td>
								<td><a href="?acao=estProva&modulo=professor&id=<?=$provaFinalizada->getId()?>"><i class="fa fa-search"></i></a></td>
							</tr>
							<?php }} ?>
						</tbody>
					</table>
					<div class="text-right j_pag">
						<button class="btn btn-dark j_anterior"><</button>
						<button class="btn btn-dark j_proximo">></button>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>




<!-- <tr><td>'+data.id+'</td><td>'+data.titulo+'</td><td>'+data.disciplina+'</td><td><span class="badge badge-danger pull-right">Finalizado</span></td><td>'+data.qtd_questoes+'</td><td>'+data.valor+'</td><td></td><td>'+data.data_prova+'</td><td><a href="?acao=alunosProva&modulo=professor&id='+data.id+'"><i class="fa fa-search"></i></a></td></tr> -->