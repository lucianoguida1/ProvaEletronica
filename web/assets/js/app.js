$(function(){
	var url_post = 'http://localhost/provaeletronica/web/index.php';
	//var url_post = '../index.php';
	var msg_error = $('#j_error_cadastro');
	var msgAjaxx = $('#j_msgAjax');
 	msg_error.hide();
 	msgAjaxx.hide();
 	$('#modal-adicionar-questao').modal('handleUpdate');

 	//FUNCÇÃO DE MENSSAGEM PADRÃO MODAL CADASTRO QUESTÃO
 	function msgModalQuestao(tipo, msg) {
 		msg_error.addClass("alert alert-"+ tipo).text(msg);
 		msg_error.fadeIn("slow")
		window.setTimeout(function(){ msg_error.fadeOut("slow") }, 3000);
 	}

 	function msgAjax(tipo, msg) {
 		msgAjaxx.addClass("alert alert-"+ tipo).text(msg);
 		msgAjaxx.fadeIn('fast');
 		window.setTimeout(function(){ msgAjaxx.fadeOut("slow") }, 2000);
 	}

 	function isEmpty(obj) {
		    for(var prop in obj) {
		        if(obj.hasOwnProperty(prop))
		            return false;
		   	 }
   			 return true;
	}


 	// SCRIPT QUE DA UM FADEOUT NO TAG DE MENSAGEM DO SISTEMA
 	$("#msgSistema:visible").delay(3000).fadeOut('slow');

   // INICIO AÇÃO QUE ADICIONA A QUESTÃO NA MODAL COM FORMULÁRIO DE CADASTRO DE ESQUESTÃO
    var listaAlternativa = $('.j_lista_alternativa');
	var botaoAdicionarQuestao = $('.j_adicionar_questao');
	var formProva = $('form[name="form-prova"]');
	var formQuestao = $('form[name="form-questao"]');
	botaoAdicionarQuestao.click(function(){
 		var idProva = formProva.find('input[name="id"]').val();

		if(idProva != "") {
			listaAlternativa.empty();
			formQuestao.find("input").val('');
			formQuestao.find("textarea").val('');
			$('#modal-adicionar-questao').modal("show");
		} else {
			$('.j_msg_modal_confirme').empty().html('Para adicionar questão é necessário salvar a prova!<p><strong>Deseja salvar a Prova?<strong></p>');
			$('#modal-confirme').modal('show');
		}
		return false;
	})
	// FIM AÇÃO QUE ADICIONA A QUESTÃO NA MODAL COM FORMULÁRIO DE CADASTRO DE ESQUESTÃO



	// INICIO ACAO DE EXCLUIR UMA QUESTÃO DA LISTA DE QUESTÃO
	var tabelaQuestoes = $('.j_linha_tabela_questoes');


	tabelaQuestoes.on('click', '.j_excluir', function() {
		var acaoDelete = $(this).attr('href');
		var aId = $(this).attr('id');
		var traction = $('tr[id="j_' + aId +'"]');

		traction.addClass('alert alert-danger');
		$.ajax({
			url: url_post,
			data: acaoDelete,
			type: 'POST',
			beforeSend: '',
			error: function(){
				msg_error('danger', 'Error na solicitação, procure Administrador!')
			},
			success: function(data){
				if(data == 1) {
					traction.fadeOut("slow");
				} else {
					alert('error.........Entre em contfsfato com Administrador!');
				}
			},
			complete: function(){
			}
		})

		return false;
	});
	// FIM ACAO DE EXCLUIR UMA QUESTÃO DA LISTA DE QUESTÃO

	// INICIO ACAO DE ANULA UMA QUESTÃO DA LISTA DE QUESTÃO
	tabelaQuestoes.on('click', '.j_anular', function() {
		var acaoDelete = $(this).attr('href');
		var aId = $(this).attr('id');
		var traction = $('tr[id="j_' + aId +'"]');
		var alink = $('.j_anular');


		$.ajax({
			url: url_post,
			data: acaoDelete,
			type: 'post',
			beforeSend: '',
			error: function(){
				msg_error('danger', 'Error na solicitação, procure Administrador!')
			},
			success: function(data){

				if(data == 1) {
					traction.addClass('alert alert-secondary');
					//alink.removeClass('badge badge-secondary');
					//alink.addClass('badge badge-success');
				} else {
					traction.removeClass('alert alert-secondary');
					//alink.removeClass('badge badge-success');
					//alink.addClass('badge badge-secondary');
				}
			},
			complete: function(){
			}
		})

		return false;
	});
	// FIM ACAO DE ANULA UMA QUESTÃO DA LISTA DE QUESTÃO

	//// INICIO ACAO DE EDITAR UMA QUESTÃO DA LISTA DE QUESTÃO
	var conteudoQuestao = $('#conteudo-modal');
	var tabelaQuestoes = $('.j_linha_tabela_questoes');

	tabelaQuestoes.on('click', '.j_editar', function() {
		var acaoEditar = $(this).attr('href');
		var aId = $(this).attr('id');
		var traction = $('tr[id="j_' + aId +'"]');

		$.ajax({
			url: url_post,
			data: acaoEditar,
			type: 'post',
			beforeSend: '',
			error: function(){
				msg_error('danger', 'Error na solicitação, procure Administrador!')
			},
			success: function(data){

				if(data == 0) {
					alert('error.........Entre em contato com Administrador!');
				} else {
					conteudoQuestao.empty().html(data);
					$('#modal-adicionar-questao').modal("show");
				}
			},
			complete: function(){
			}
		})

		return false;
	});
	//// FIM ACAO DE EDITAR UMA QUESTÃO DA LISTA DE QUESTÃO


	var botaoConfirme = $('.j_confirme-sim');

	botaoConfirme.click(function(){
		$('#modal-confirme').modal('hide');
		$('.j_salva_prova').trigger('click');
	})


	var botaoAdicionarAlternativa = $('.j_adicinar_alternativa');

    var idAlternativa = 20;

	botaoAdicionarAlternativa.click(function(){
		adicionarAlternativa();
	})

	function adicionarAlternativa() {
		listaAlternativa.append('<li id="'+idAlternativa+'" class="list-group-item"><div class="form-check"><label class="form-check-label"><input type="hidden" name="id_alternativa'+idAlternativa+'" value=""><input class="form-check-input" type="checkbox" id="certa_alternativa'+idAlternativa+'" name="certa_alternativa'+idAlternativa+'" value="true" aria-label="..."><textarea class="form-control form-questao" id="alternativa_enun'+idAlternativa+'" name="alternativa_enun'+idAlternativa+'" rows="2" cols="80" required=""></textarea></label><a id="'+idAlternativa+'" href="" class="badge badge-danger excluir-alternativa">Excluir</a></div></li>');
		idAlternativa +=1;
	}

	//var botaoExcluirAlternativa = $('.excluir-alternativa');

	listaAlternativa.on('click', '.excluir-alternativa', function(event) {
		var idExcluir = $(this).attr('id');
		var liExcluir = listaAlternativa.find('li[id="'+idExcluir+'"]');
		var sender = $(this).attr('href');

		if(sender == "") {
			liExcluir.remove();
		} else {
				$.ajax({
				url: url_post,
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

	function removerAlternativa(data) {

	}


	//SCRIPT DE CADASTRO DA QUESTÃO
	//FORMQUESTÃO FOI ENCAPSULADA ACIMA

	formQuestao.submit(function() {
		var idProva = formProva.find('input[name="id"]').val();
		var idQuestao = $(this).find('input[name="questao_id"]').val();
		var dados = $(this).serialize();
		var action = $(this).attr('action');
		var sender = action + '&' + dados + '&prova_id=' + idProva;
		var trquestao = tabelaQuestoes.find('tr[id="j_'+idQuestao+'"]');
		var ordem = $(this).find('input[name="ordem"]');
		 $.ajax({
			url: url_post,
			type: "post",
			data: sender,
			//dataType: "json",
			beforeSend: "",
			error: function() {
				msgModalQuestao('danger', 'Valor inválido, verifique se campos foram preenchidos corretamente!');
			},
			success: function(data) {

				if(data == 0) {
					msgModalQuestao('info', 'Defina a resposta correta!');
				} else {
					if (data == 1) {
						msgModalQuestao('danger', 'Error ao salvar a questão, verifique as campos!');
					} else {
						if(data==2) {
							ordem.css('border', '1px solid red');
							msgModalQuestao('danger', 'Ordem já cadastrada escolha outra numeração!');
						} else {
							if (isEmpty(idQuestao)) {

							formQuestao.find("input").val('');
							formQuestao.find("textarea").val('');
							$('#modal-adicionar-questao').modal("hide");
							$('.j_linha_tabela_questoes').append(data);
						} else {

							formQuestao.find("input").val('');
							formQuestao.find("textarea").val('');
							$('#modal-adicionar-questao').modal("hide");
							trquestao.empty();
							trquestao.html(data);
							window.setTimeout(function(){ $('.j_carregando').empty().html('<i  class="fa fa-check" aria-hidden="true"></i>');
							}, 1000);
						}
						}
					}
				}
			},
			complete: function(){

			}

			});

		 return false;
	});

	formProva.on('submit', function(event) {
		var action = $(this).attr('action');
		var dados = $(this).serialize();
		var sender = action + '&' + dados;
		var id = $(this).find('input[name="id"]');

		$.ajax({
			url: url_post,
			type: "post",
			data: sender,
			dataType: "json",
			beforeSend: "",
			error: function(){
				msgAjax('danger', 'Error de comunicação!');
			},
			success: function(data) {
				msgAjax(data[0], data[1]);
				id.val(data[2]);
			}
		})
		return false;
	});

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
			url: url_post,
			type: 'get',
			data: "acao=pagFinalizados&modulo=professor&limit=15&offset=" + val,
			dataType: 'json',
			error: function(){
				msgAjax('danger', 'Error de comunicação');
			},
			success: function(data){
				conteudoFinalizados.empty();
				 $.each(data, function(index, el) {
				 	conteudoFinalizados.append('<tr><td>'+el.id+'</td><td>'+el.titulo+'</td><td>'+el.disciplina+'</td><td><span class="badge badge-danger pull-right">Finalizado</span></td><td>'+el.qtd_questoes+'</td><td>'+el.valor+'</td><td></td><td>'+el.data_prova+'</td><td><a href="?acao=alunosProva&modulo=professor&id='+el.id+'"><i class="fa fa-search"></i></a></td></tr>');
				 });

				if(data.length < 15) {
					$('.j_proximo').fadeOut("fast");
				} else {
					$('.j_proximo').fadeIn("fast");
				}
			}
		})
	}
})