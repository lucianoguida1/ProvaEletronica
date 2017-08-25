<div class="col-md-8">
	<table class="table table-hover">
		<thead class="thead-default">
			<tr>
				<th>#</th>
				<th>Nome</th>
				<th>Tipo</th>
				<th>Ações</th>
			</tr>
		</thead>
		<tbody>
		<?php $i=1; foreach($user as $val){ 
			if($val->getTipo() == "professor")
			?>
			<tr>
				<th scope="row"><?=$i++?></th>
				<td><?=$val->getTipo()?></td>
				<td><?=""?></td>
				<td><?=""?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>