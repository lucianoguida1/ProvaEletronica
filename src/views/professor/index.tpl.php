<div class="col-md-12">
           <div class="card border-primary m-0">
           	<div class="card-body">
           		<h4 class="title-nav">Informações</h4>
           		<!-- Nav tabs -->
           		<ul class="nav nav-tabs lista-nav" id="myTab" role="tablist">
           			<li class="nav-item">
           				<a class="nav-link active" data-toggle="tab" href="#provasapublicar" role="tab">Provas a Publicar</a>
           			</li>
           			<li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#provaspublicadas" role="tab">Provas Publicadas</a>
           			</li>
           			<li class="nav-item">
           				<a class="nav-link" data-toggle="tab" href="#provasfinalizadas" role="tab">Provas Finalizadas</a>
           			</li>
           		</ul>

           		<!-- Tab panes -->
                <div class="tab-content">
                 <div class="tab-pane active" id="provasapublicar" role="tabpanel">
                  <?php if(isset($provasAPublicar)) {  ?>
                   <table class="table table-responsive table-sm table-questoes hover"">
                       <thead>
                            <tr>
                              <th>Cód.</th>
                              <th>Título</th>
                              <th>Disciplina</th>
                              <th></th>
                              <th>Qtd. Questões</th>
                              <th>Valor Prova</th>
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
                                 <td><?=$provaAPublicar->getData_prova()?></td>
                                 <td><a href="?acao=publicarProva&modulo=professor&id=<?=$provaAPublicar->getId()?>" class="btn btn-secondary btn-sm pull-right">Publicar</a></td>
                              </tr>
                           <?php } ?>

                    </tbody>
              </table>
            <?php    } else {
                             echo "<p>Nenhuma prova publicada</p>";
                          } ?>
           </div>
           <div class="tab-pane" id="provaspublicadas" role="tabpanel">
            <table class="table  table-responsive table-sm table-questoes hover"">
             <thead>
              <?php if(isset($provasPublicadas)) {  ?>
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
            <?php } ?>
         </thead>
         <tbody>
           <?php if(isset($provasPublicadas) && !empty($provasFinalizadas)) {
             foreach ($provasPublicadas as $provaPublicada) { ?>
               <tr>
                <td><?= $provaPublicada->getId() ?></td>
                <td><?= $provaPublicada->getTitulo() ?></td>
                <td><?= $provaPublicada->getDisciplina() ?></td>
                <td>
                 <?php
                 $dataAtual = date('Y-m-d');
                 if($provaPublicada->getData_prova() <= $dataAtual) {?>
                 <span class="badge badge-info pull-right">Em Andamento</span>
                 <?php } else { ?>
                 <span class="badge badge-info pull-right">A Realizar</span>
                 <?php } ?>
              </td>
              <td><?=$provaPublicada->getQtd_questoes()?></td>
              <td><?=$provaPublicada->getValor()?></td>
              <td><?=$provaPublicada->getHorario_inicio(). " - " . $provaPublicada->getHorario_fim() ?></td>
              <td><?= $provaPublicada->getData_prova() ?> </td>
              <td><a href="" ><i class="fa fa-search"></i></a></td>
           </tr>
           <?php }
        } else {
          echo "<p>Nenhuma prova publicada</p>";
       } ?>
    </tbody>
 </table>
</div>
<div class="tab-pane" id="provasfinalizadas" role="tabpanel">
 <?php if(isset($provasFinalizadas) && !empty($provasFinalizadas)){ ?>
 <table class="table table-responsive table-sm table-questoes hover"">
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
      <tbody>
         <?php foreach ($provasFinalizadas as $provaFinalizada) { ?>
            <tr>
                 <td><?= $provaFinalizada->getId() ?></td>
                 <td><?= $provaFinalizada->getTitulo() ?></td>
                 <td><?= $provaFinalizada->getDisciplina() ?></td>
                 <td><span class="badge badge-danger pull-right">Finalizado</span></td>
                 <td><?= $provaFinalizada->getQtd_questoes() ?></td>
                 <td><?= $provaFinalizada->getValor() ?></td>
                 <td></td>
                 <td><?= $provaFinalizada->getData_prova() ?></td>
                 <td><a href="" ><i class="fa fa-search"></i></a></td>
           </tr>
          <?php } ?>
      </tbody>
</table>
<?php }else{
   echo "<p>Nenhuma prova publicada</p>";
} ?>
</div>
<div class="tab-pane" id="settings" role="tabpanel">...</div>
</div>
</div>
</div>
</div>