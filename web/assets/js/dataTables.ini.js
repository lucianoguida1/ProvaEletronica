$(document).ready(function() {
    $('#j_provas').DataTable({
        "language": {
                                        "decimal": ",",
                                        "thousands": ".",
                                        "sEmptyTable": "Nenhum registro encontrado",
                                        "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                                        "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                                        "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                                        "sInfoPostFix": "",
                                        "sInfoThousands": ".",
                                        "sLengthMenu": "_MENU_ resultados por página",
                                        "sLoadingRecords": "Carregando...",
                                        "sProcessing": "Processando...",
                                        "sZeroRecords": "Nenhum registro encontrado",
                                        "sSearch": "Pesquisar",
                                        "oPaginate": {
                                            "sNext": "Próximo",
                                            "sPrevious": "Anterior",
                                            "sFirst": "Primeiro",
                                            "sLast": "último"
                                        },
                                        "oAria": {
                                            "sSortAscending": ": Ordenar colunas de forma ascendente",
                                            "sSortDescending": ": Ordenar colunas de forma descendente"
                                        }

        }
        });
    $('.msg-provas').hide();
    function msgprovas(msg) {
        $('.msg-provas').text(msg);
        window.setTimeout(function(){ $('.msg-provas').fadeOut("slow") }, 3000);
    }

     var table = $('#j_provas').DataTable();

         $('#j_provas tbody').on('click', '.j_excluir', function () {
         	var tr = $(this).attr('id');
            window.setTimeout(function(){  table.row("#j_" + tr).remove().draw( false ) }, 100);

	return false;
             } );

});