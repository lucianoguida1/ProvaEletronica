<div class="col-md-12">
    <div class="card border-primary m-0">
        <div class="card-body">
            <label class="text-left"><strong>Título:</strong> <?= isset($prova)?$prova->getTitulo():"" ?></label><br>
            <label class="text-left"><strong>Disciplina:</strong> <?= isset($prova)?$prova->getDisciplina():"" ?></label>
            <label class="text-left"><strong>Valor:</strong> <?= isset($prova)?$prova->getValor():"" ?> </label><br>
            <?php if(isset($estProva)){ ?>
            <table class="table table-responsive table-hover  table-questoes">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Matricula</th>
                    <th>Nota</th>
                    <th>Acertos(%)</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($estProva as $est) ?>
                <tr>
                    <td><?= $est->getNome_estudante() ?></td>
                    <th><?= $est->getMatricula_estudante() ?></th>
                    <td><?= $est->getNota() ?></td>
                    <td><?= number_format((($est->getNota() / $prova->getValor()) * 100), 1, ',', '.')  ?></td>
                </tr>
                </tbody>
            </table>
            <?php }else{
                echo "<p class='text-center'><strong>Nenhum aluno encotrado</strong></p>";
            } ?>
        </div>
    </div>
</div>