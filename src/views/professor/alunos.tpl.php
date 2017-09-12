<script>
    $(document).ready(function () {
        $('.imprimirAluno').click(function () {
            printDiv();
        })
        function printDiv()
        {
            //var id = $('#imprimirAlunos');
            var conteudo = document.getElementById('imprimirAlunos').innerHTML;
            var win = window.open();
            win.document.write(conteudo);
            win.print();
            win.close();//Fecha após a impressão.
        }
    });
</script>

<div class="col-md-12">
    <div class="card border-primary m-0">
        <div class="card-body">
            <div id="imprimirAlunos">
            <label class="text-left"><strong>Título:</strong> <?= isset($prova)?$prova->getTitulo():"" ?></label><br>
            <label class="text-left"><strong>Disciplina:</strong> <?= isset($prova)?$prova->getDisciplina():"" ?></label>
            <label class="text-left"><strong>Valor:</strong> <?= isset($prova)? number_format($prova->getValor(), 1, ',', '.'):"" ?> </label><br>
            <?php if(isset($estProva) && !empty($estProva)){ ?>
            <table class="table table-responsive table-hover  table-questoes">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Matricula</th>
                    <th>Nota</th>
                    <th>Nota(%)</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($estProva as $est) { ?>
                <tr>
                    <td><?= $est->getNome_estudante() ?></td>
                    <th><?= $est->getMatricula_estudante() ?></th>
                    <td><?= number_format($est->getNota(), 1, ',', '.') ?></td>
                    <td><?= number_format((($est->getNota() / $prova->getValor()) * 100), 1, ',', '.')  ?></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
            </div>
            <button class="btn btn-default pull-right imprimirAluno">Imprimir</button>
            <?php }else{
                echo "<p class='text-center'><strong>Nenhum aluno encotrado</strong></p>";
            } ?>
        </div>
    </div>
</div>