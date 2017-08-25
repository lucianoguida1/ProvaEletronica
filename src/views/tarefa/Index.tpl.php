    <div class="container">

      
      <table>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
         <?php
         $tarefas = Tarefa::selecionar();
         foreach ($tarefas as $tarefa) : ?>
            <tr>
                <td><?php echo $tarefa->getId() ?></td>
                <td><?php echo $tarefa->getTitulo() ?></td>
                <td><?php echo $tarefa->getSituacao() ?></td>
                <td>
                    <a href="editar.php?id=<?php echo $tarefa->getId() ?>">editar</a> 
                    <a href="excluir.php?id=<?php echo $tarefa->getId() ?>">excluir</a> 
                </td>
            </tr>
         <?php endforeach; ?>
        </table>

    </div> <!-- /container -->
