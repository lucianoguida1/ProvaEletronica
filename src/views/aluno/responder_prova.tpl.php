<p>
	greuiwfklçejwhfwegjfklsjdgaFLÇAKGFasjbghaLKJFVJHNBAFJKLWEABHljkçdvçbahqFKLÇJABLifuajkFHDSJKAFHVBWCJEHFUIhuiawehf
</p>

<div class="form-check">
  <label class="form-check-label">
    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
    Option one is this and that&mdash;be sure to include why it's great
  </label>
</div>
<div class="form-check">
  <label class="form-check-label">
    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
    Option two can be something else and selecting it will deselect option one
  </label>
</div>
<div class="form-check">
  <label class="form-check-label">
    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
    Option one is this and that&mdash;be sure to include why it's great
  </label>
</div>
<div class="form-check">
  <label class="form-check-label">
    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
    Option two can be something else and selecting it will deselect option one
  </label>
</div>
<div id="sessao"></div>
<div style="display: none;" id="tempo"><?php //(); ?></div>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
<script src="assets/js/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

<script type="text/javascript">

$(document).ready(function($) {
	var ver = $("#tempo").val();
	verificar(ver)
});
var tempo = new Number();
// Tempo em segundos

function verificar(tempo_exist)
{
	if(tempo_exist != 0 || tempo_exist != ""){
		tempo = tempo_exist;
	}
	else
	{
		tempo = 55;
	}
	startCountdown();
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
        
        $("#sessao").html(horaImprimivel);
		$("#tempo").html(tempo);
        
        setTimeout('startCountdown()',1000);
        
        tempo--;
    } else {
        //window.open('../controllers/logout.php', '_self');
    }
}


</script>
