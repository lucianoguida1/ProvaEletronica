<form action="?acao=finalizarprova&modulo=aluno" name="formprova" method="POST">
	<?=$questoes?>
</form>
<input  style="display: none;" id="id_estudante" value="<?=$_SESSION['prova_em_progresso']['estudante']?>" />
<input  style="display: none;" id="id_prova" value="<?=$_SESSION['prova_em_progresso']['prova'] ?>" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
<script src="assets/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<div style="position: fixed;
  left: 0;
  top: 20%;
  margin-top: -2.5em;
" id="sessao"></div>
<script type="text/javascript">
	
	$(document).ready(function($) {
		verificar();
	});
	var tempo = new Number();
	var pagina = new Number();
	pagina = 0;
 // Tempo em segundos
 
 function verificar()
 {
 	var prova = $("#id_prova").val(),estudante = $("#id_estudante").val();
 	var valor = 0;
 	$.ajax({
				url: '?acao=alunoResponderProvaCheckTempo&modulo=ajax',
				type: 'POST',
				dataType: 'html',
				data: "id_prova="+prova+"&id_estudante="+estudante,
				success: function(e){
					tempo = e;
					startCountdown();
				}
			});
 	
 }
 function duas_casas(numero){
 	if (numero <= 9){
 		numero = "0"+numero;
 	}
 	return numero;
 }
 function startCountdown(){
 	
     // Se o tempo não for zerado
     if((tempo - 1) >= 0){
 	        // Pega a parte inteira dos minutos
 	        var hr = duas_casas(Math.round(tempo/3600));
 	        var min = duas_casas(Math.round((tempo%3600)/60));
 	        var seg = duas_casas((tempo%3600)%60);
 	        
 	       
 	        
 	        var horaImprimivel = hr+':' + min + ':' + seg;
 	        
 	        $("#sessao").html("<span class='badge badge-warning pull-right'>Tempo "+horaImprimivel+"</span>");
 	        
 	        setTimeout('startCountdown()',1000);
 	        
 	        tempo--;
 	    } else {
         finalizarprova();
     }
 }
 function finalizarprova()
 {
 	//document.formprova.submit();
 }
 
 function proximo()
 {
 	$("#questao"+pagina).hide('slow/400/fast');
	pagina++;
	$("#questao"+pagina).show('slow/400/fast');
 }

 function anterior()
 {
 	$("#questao"+pagina).hide('slow/400/fast');
	pagina--;
	$("#questao"+pagina).show('slow/400/fast');
 }
</script>