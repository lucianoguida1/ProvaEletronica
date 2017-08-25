
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Editar Ferramentas</h3>
        </div>
        <div class="panel-body">
            <form action="?acao=Editar&modulo=home&id=<?=$_GET['id']?>&alterar=true" method="post">
                <div class="form-group">
                    <label for="exampleInputtext1">Descrição</label>
                    <input type="text" class="form-control" name="descricao" required="" value="<?=$ferramenta->descricao?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputtext1">Quantidade</label>
                    <input type="number" class="form-control" name="qtd" required="" value="<?=$ferramenta->qtd?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputtext1">Especificação</label>
                    <input type="text" class="form-control" name="especificacao" required="" value="<?=$ferramenta->especificacao?>">
                </div>
                <button class="btn btn-success">Cadastrar</button>   
            </form>
        </div>
    </div>
</div>