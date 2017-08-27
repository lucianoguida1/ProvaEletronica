<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Cadastrar Usuario</h3>
        </div>
        <div class="panel-body">
            <form action="?acao=Cadastrar&modulo=home" method="post">
                <div class="form-group">
                    <label for="exampleInputtext1">Descrição</label>
                    <input type="text" class="form-control" name="descricao" required="">
                </div>
                <div class="form-group">
                    <label for="exampleInputtext1">Quantidade</label>
                    <input type="number" class="form-control" name="qtd" required="">
                </div>
                <div class="form-group">
                    <label for="exampleInputtext1">Especificação</label>
                    <input type="text" class="form-control" name="especificacao" required="">
                </div>
                <button class="btn btn-success">Cadastrar</button>
            </form>
        </div>
    </div>
</div>