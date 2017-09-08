$(function(){
    //var url_posts = 'http://localhost/provaeletronica/web/index.php';
    var url_posts = 'index.php';
    function isEmpty(obj) {
            for(var prop in obj) {
                if(obj.hasOwnProperty(prop))
                    return false;
             }
             return true;
    }
    var msg_error = $('#j_error_cadastro');
    function msgModalQuestao(tipo, msg) {
        msg_error.addClass("alert alert-"+ tipo).text(msg);
        msg_error.fadeIn("slow")
        window.setTimeout(function(){ msg_error.fadeOut("slow") }, 3000);
    }

    var botaoAdicionarAlternativas = $('.j_adicinar_alternativas');
    var listaAlternativas = $('.j_lista_alternativas');
    botaoAdicionarAlternativas.click(function(){
        adicionarAlternativass();
    })

 var idAlternativas = 100;
function adicionarAlternativass() {
        listaAlternativas.append('<li id="'+idAlternativas+'" class="list-group-item"><div class="form-check"><label class="form-check-label"><input type="hidden" name="id_alternativa'+idAlternativas+'" value=""><input class="form-check-input" type="radio" id="resposta'+idAlternativas+'" name="resposta" value="'+idAlternativas+'" aria-label="..."><textarea class="form-control form-questoes" id="alternativa_enun'+idAlternativas+'" name="alternativa_enun'+idAlternativas+'" rows="2" cols="80" required=""></textarea></label><a id="'+idAlternativas+'" href="" class="badge badge-danger excluir-alternativas">Excluir</a></div></li>');
        idAlternativas +=1;
    }
listaAlternativas.on('click', '.excluir-alternativas', function(event) {
        var idExcluir = $(this).attr('id');
        var liExcluir = listaAlternativas.find('li[id="'+idExcluir+'"]');
        var sender = $(this).attr('href');

        if(sender == "") {
            liExcluir.remove();
        } else {
                $.ajax({
                url: url_posts,
                data: $(this).attr('href'),
                type: "post",
                beforeSend: '',
                erro: function(){
                    msgModalQuestao('danger', 'Erro na solicitação, procure o Administrador.');
                },
                success: function(data){
                    if(data == 0) {
                        msgModalQuestao('danger', 'Erro na solicitação, procure o Administrador.');
                    } else {
                        liExcluir.remove();
                        msgModalQuestao('success', 'Alternativa excluida do banco de dados.');
                    }
                }
            })
        }
        return false;
    })
var tabelaQuestoes = $('.j_linha_tabela_questoes');
var formQuestoes = $('form[name="form-questoes"]');
var formProva = $('form[name="form-prova"]');
formQuestoes.submit(function() {
        var idProva = formProva.find('input[name="id"]').val();
        var idQuestao = $(this).find('input[name="questao_id"]').val();
        var dados = $(this).serialize();
        var action = $(this).attr('action');
        var sender = action + '&' + dados + '&prova_id=' + idProva;
        var trquestao = tabelaQuestoes.find('tr[id="j_'+idQuestao+'"]');
        var quantidade = formProva.find('input[name="quantidade"]');
         $.ajax({
            url: url_posts,
            type: "post",
            data: sender,
            dataType: "json",
            beforeSend: "",
            error: function() {
                msgModalQuestao('danger', 'Valor inválido, verifique se campos foram preenchidos corretamente!');
            },
            success: function(data) {

                if((data[0] == 'info') || (data[0] == 'danger')) {
                    msgModalQuestao(data[0], data[1]);
                } else {
                    if (isEmpty(idQuestao)) {
                        formQuestoes.find("input").val('');
                        formQuestoes.find("textarea").val('');
                        $('#modal-adicionar-questao').modal("hide");
                        $('.j_linha_tabela_questoes').append(data[2]);
                        var qtd = parseInt(quantidade.val()) ;
                        quantidade.val(qtd+1);
                    } else {

                        formQuestoes.find("input").val('');
                        formQuestoes.find("textarea").val('');
                        $('#modal-adicionar-questao').modal("hide");
                        trquestao.empty();
                        trquestao.html(data[2]);
                        window.setTimeout(function(){ $('.j_carregando').empty().html('<i  class="fa fa-check" aria-hidden="true"></i>');
                    }, 1000);
                    }

                }
            },
            complete: function(){
            }
            });
         return false;
    });

var botaoAdicionarQuestao = $('.j_adicionar_questao');

botaoAdicionarQuestao.click(function(){
        var idProva = formProva.find('input[name="id"]').val();

        if(idProva != "") {
            listaAlternativas.empty();
            formQuestoes.find("input").val('');
            formQuestoes.find("textarea").val('');
            $('#modal-adicionar-questao').modal("show");
        } else {
            $('.j_msg_modal_confirme').empty().html('Para adicionar questão é necessário salvar a prova!<p><strong>Deseja salvar a Prova?<strong></p>');
            $('#modal-confirme').modal('show');
        }
        return false;
    })
})