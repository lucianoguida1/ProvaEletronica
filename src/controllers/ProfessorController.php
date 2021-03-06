<?php

class ProfessorController extends Controller
{
    function __construct()
    {
        if (isset($_SESSION['login']) && $_SESSION['tipo'] != 'professor' || !isset($_SESSION['login'])) {
            $this->redirectCheck();
        }
    }

    public function index($msg = null)
    {
        $professor = Professor::selecionar("usuario_id=" . $_SESSION['user_id']);
        $data['provasPublicadas'] = Prova::getProvas("provas.professor_id=" . $professor[0]->getId() . " and provas.status= 1 and provas.data_prova >='" . date('Y-m-d') . "'", "data_prova");
        $data['provasAPublicar'] = Prova::getProvas("provas.professor_id=" . $professor[0]->getId() . " and provas.status=0", "data_prova");
        $data['apublicarActive'] = true;
        $this->render("professor/index", $data, $msg);
    }

    public function pagFinalizados()
    {
        $professor = Professor::selecionar("usuario_id=" . $_SESSION['user_id']);
        $provas = Prova::getArrayProvas("provas.professor_id=" . $professor[0]->getId() . " and provas.status= 1 and provas.data_prova <'" . date('Y-m-d') . "'", "data_prova", $_GET['limit'], $_GET['offset']);
        echo json_encode($provas);

    }

    public function perfil()
    {
        $usuario = Usuario::selecionarUm($_SESSION['user_id']);
        $professor = Professor::selecionar("usuario_id = " . $_SESSION['user_id']);

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $valid = new Validator($_POST);
            $valid->field_email('email');
            $valid->field_cadastropessoa('cpf');
            $valid->field_filledIn($_POST);
            if ($valid->valid) {
                $usuario->setLogin($_POST['email']);
                if (!empty($_POST['senha']))
                    $usuario->setSenha(md5($_POST['senha']));
                $usuario->save();
                $professor[0]->setNome_prof($_POST['nome']);
                $professor[0]->setMatricula_prof($_POST['matricula']);
                $professor[0]->setCpf_prof($_POST['cpf']);
                $professor[0]->setEmail_prof($_POST['email']);
                $professor[0]->setSexo_prof($_POST['sexo']);
                $professor[0]->setUsuario_id($usuario->getId());
                $professor[0]->save();
                $this->render('professor/perfil', ['professor' => $professor[0], 'usuario' => $usuario], array('title' => 'Prova Eletronica', 'msg' => array(
                    'success',
                    'Cadastro Atualizado com sucesso.',
                    ''
                )));
            } else {
                $this->render('professor/perfil', array(), array('title' => 'Prova Eletronica', 'msg' => $valid->getErrors()));
            }
        } else {
            $this->render("professor/perfil", ['professor' => $professor[0], 'usuario' => $usuario], []);
        }
    }

    public function publicarProva()
    {
        $p = Prova::getProvas("provas.id='" . $_GET['id'] . "'");
        if ($p[0]->getQtd_questoes() != 0) {
            $prova = Prova::selecionarUm($_GET['id']);
            $prova->setStatus(1);
            $prova->save();
            $this->redirectTo("professor/index", "publicar = true");
        } else {
            $this->index(['msg' => array(
                'info',
                'Prova não publicada',
                'Não é possível publicar uma prova sem questão!')]);
        }
    }

    public function cadastroProva()
    {
        $this->render("professor/cadastroProva", [], []);
    }

    public function editarProva()
    {
        if (isset($_GET['id'])) {
            $prova = Prova::getProvas("provas.id = " . $_GET['id']);
            if ($prova[0]->getData_prova() < date('Y-m-d') && $prova[0]->getStatus() == 1) {
                $data['provas'] = Prova::getProvas("provas.status <= 1");
                $this->render("professor/provas", $data, array('msg' => array(
                    'info',
                    'Edição não disponível',
                    'Não é possível editar uma prova finalizada ou publicada'
                )));

            } else {
                $data['prova'] = $prova[0];
                $data['questoes'] = Questao::selecionar("prova_id='" . $prova[0]->getId() . "'", 'ordem');
                $this->render("professor/cadastroProva", $data);
            }
        } else {
            $this->render("professor/provas", [], array('msg' => array(
                'danger',
                'Edição não disponível',
                'Prova não encontrada, atualize a página e click em editar novamente'
            )));
        }

    }

    public function excluirProva()
    {
        $prova = Prova::selecionarUm($_POST['id']);
        if ($prova->getData_prova() < date('Y-m-d') || $prova->getStatus() == 1) {
            echo '2';
        } else {
            $data['provas'] = Prova::selecionar("status <= 1");
            $prova->setStatus(2);
            $prova->save();
            echo "1";
        }
    }

    public function provas()
    {
        $professor = Professor::selecionar("usuario_id=" . $_SESSION['user_id']);
        $data['provas'] = Prova::getProvas("provas.professor_id=" . $professor[0]->getId() . " and provas.status <= 1");

        $this->render("professor/provas", $data, []);
    }

    public function salvarProva()
    {
        if (empty($_POST['id'])) unset($_POST['id']);
        $valid = new Validator($_POST);
        $valid->field_filledIn($_POST);
        if ($valid->valid) {

            if (strlen($_POST['disciplina']) > 45 || strlen($_POST['titulo']) > 45) {
                echo json_encode(array('danger', 'Os campos Título e Disciplina deve conter no máximo 45 caracteres!'));
            } elseif($_POST['inicio'] >= $_POST['fim']) {
                echo json_encode(array('info', 'O Inicio não pode ser maior ou igual ao Fim!'));
            } else {
                if (isset($_POST['id'])) $prov['id'] = $_POST['id'];
                $professor = Professor::selecionar("usuario_id=" . $_SESSION['user_id']);
                $prov['professor_id'] = $professor[0]->getId();
                $prov['titulo'] = $_POST['titulo'];
                $prov['disciplina'] = $_POST['disciplina'];
                $prov['data_prova'] = $_POST['data_prova'];
                $prov['horario_inicio'] = $_POST['inicio'];
                $prov['horario_fim'] = $_POST['fim'];
                $prov['status'] = 0;

                $prova = new Prova($prov);
                $prova->save();


                if (isset($_POST['id'])) {
                    $data['questoes'] = Questao::selecionar("prova_id='" . $prova->getId() . "'");
                }

                if (isset($_POST['id'])) {
                    $msg = 'Prova atualizada com sucesso.';
                } else {
                    $msg = 'Prova cadastrada com sucesso.';
                }

                $retorno[0] = 'success';
                $retorno[1] = $msg;
                $retorno[2] = $prova->getId();
                echo json_encode($retorno);
            }

        } else {
            echo json_encode($valid->getErrors());
        }
    }

    public function cadastrarQuestao()
    {
        if (!empty($_POST['resposta'])) {
            $existe = Questao::selecionar("prova_id=" . $_POST['prova_id'] . " and ordem=" . $_POST['ordem']);
            if (!empty($existe) && empty($_POST['questao_id'])) {
                $resposta[0] = 'danger';
                $resposta[1] = 'Ordem já cadastrada escolha outra numeração!';
            } else {
                if (!empty($_POST['questao_id'])) {
                    $quest['id'] = $_POST['questao_id'];
                }
                $quest['prova_id'] = $_POST['prova_id'];
                $quest['enunciado'] = $_POST['enunciado'];
                $quest['valor'] = $_POST['valor'];
                $quest['ordem'] = $_POST['ordem'];
                $quest['status'] = true;
                $questao = new Questao($quest);
                if ($questao->save()) {

                    foreach ($_POST as $key => $value) {
                        if (substr($key, 0, 11) == 'alternativa') {
                            $id = substr($key, 16);
                            if (!empty($_POST["id_alternativa" . $id])) {
                                $alter['id'] = $_POST["id_alternativa" . $id];
                            }
                            $alter['enunciado_alter'] = $_POST[$key];
                            $alter['questao_id'] = $questao->getId();

                            if ($id == $_POST['resposta']) {
                                $alternativa = new Alternativa($alter);
                                $alternativa->save();
                                $questao->setResposta($alternativa->getId());
                            } else {
                                $alternativa = new Alternativa($alter);
                                $alternativa->save();
                            }
                            unset($alter);
                        }
                    }
                    $questao->save();
                    if (empty($_POST['questao_id'])) {
                        $resposta[2] = "
					<tr id='j_" . $questao->getId() . "'>
						<th scope='row'>" . $questao->getOrdem() . "</th>
						<td>" . $questao->getEnunciado() . "</td>
						<td>
							<a id='" . $questao->getId() . "' href='acao=editarQuestao&modulo=professor&id=" . $questao->getId() . "' class='badge badge-primary j_editar'>Editar</a>
							<a id='" . $questao->getId() . "' href='acao=anularQuestao&modulo=professor&id=" . $questao->getId() . "' class='badge badge-secondary j_anular'>Anular</a>
							<a id='" . $questao->getId() . "' href='acao=excluirQuestao&modulo=professor&id=" . $questao->getId() . "' class='badge badge-danger j_excluir'>Excluir</a>
							<i  class='fa fa-check' aria-hidden='true'></i>
						</td>
					</tr>";
                    } else {

                        $resposta[2] = "

					<th scope='row'>" . $questao->getOrdem() . "</th>
					<td>" . $questao->getEnunciado() . "</td>
					<td>
						<a id='" . $questao->getId() . "' href='acao=editarQuestao&modulo=professor&id=" . $questao->getId() . "' class='badge badge-primary j_editar'>Editar</a>
						<a id='" . $questao->getId() . "' href='acao=anularQuestao&modulo=professor&id=" . $questao->getId() . "' class='badge badge-secondary j_anular'>Anular</a>
						<a id='" . $questao->getId() . "' href='acao=excluirQuestao&modulo=professor&id=" . $questao->getId() . "' class='badge badge-danger j_excluir'>Excluir</a>
						<span class='j_carregando'><i  class='fa fa-spinner fa-spin' aria-hidden='true'></i></span>
					</td>";
                    }

                } else {
                    $resposta[0] = 'danger';
                    $resposta[1] = 'Error ao salvar a questão, verifique as campos!';
                }
            }
        } else {
            $resposta[0] = 'info';
            $resposta[1] = 'Defina a resposta correta!';
        }
        echo json_encode($resposta);
    }

    public function excluirQuestao()
    {
        $questao = Questao::selecionarUm($_POST['id']);
        $alternativas = Alternativa::selecionar("questao_id='" . $questao->getId() . "'");

        foreach ($alternativas as $alternativa) {
            $alternativa->deletar();
        }
        if ($questao->deletar()) {
            //VALOR ENVIAR PARA O AJAX
            echo "1";
        } else {
            //VALOR ENVIAR PARA O AJAX
            echo "0";
        }
    }

    public function anularQuestao()
    {
        $questao = Questao::selecionarUm($_POST['id']);
        if ($questao->getStatus() == 1) {
            $questao->setStatus(0);
            $questao->save();
            echo "1";
        } else {
            $questao->setStatus(1);
            $questao->save();
            echo "2";
        }
    }

    public function editarQuestao()
    {
        $questao = Questao::selecionarUm($_POST['id']);
        if ($questao->getStatus()) {
            $data['questao'] = $questao;
            $data['alternativas'] = Alternativa::selecionar("questao_id='" . $questao->getId() . "'");
            Template::exibir('professor/modalQuestao', $data);
        } else {
            echo "0";
        }
    }

    public function excluirAlternativa()
    {
        $alternativa = Alternativa::selecionarUm($_POST['id']);
        if ($alternativa->deletar()) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function alunosProva()
    {
        $prova = Prova::getProvas(" provas.id=" . $_GET['id']);
        $data['prova'] = $prova[0];
        $acertProva = Estudante::getEstProva(" resultados.prova_id=" . $prova[0]->getId());
        $zeroProva =  Resultado::getEstZero(" resultados.prova_id=" . $prova[0]->getId(), $prova[0]->getQtd_questoes());
        $data['estProva'] = array_merge($acertProva, $zeroProva);

        $this->render("professor/alunos", $data, []);
    }

    public function cancelarProva()
    {
        $professor = Professor::selecionar("usuario_id=" . $_SESSION['user_id']);
        if (isset($_GET['id'])) {
            $prova = Prova::selecionarUm($_GET['id']);
            if (!empty($prova)) {
                if ($prova->getData_prova() <= date('Y-m-d') && $prova->getHorario_inicio() < date('H:i:s')) {

                    $data['provas'] = Prova::getProvas("provas.professor_id=" . $professor[0]->getId() . " and provas.status <= 1");
                    $this->render("professor/provas", $data, array('msg' => array(
                        'info',
                        'Prova não cancelada',
                        'Prova já iniciada ou finalizada'
                    )));
                } else {
                    $prova->setStatus(0);
                    $prova->save();
                    $this->redirectTo('professor/provas');
                }
            } else {
                $data['provas'] = Prova::getProvas("provas.professor_id=" . $professor[0]->getId() . " and provas.status <= 1");
                $this->render("professor/provas", $data, array('msg' => array(
                    'danger',
                    'Prova não encontrada',
                    'Atualize a página e tente novamente!'
                )));
            }
        } else {
            $data['provas'] = Prova::getProvas("provas.professor_id=" . $professor[0]->getId() . " and provas.status <= 1");
            $this->render("professor/provas", $data, array('msg' => array(
                'info',
                'Prova não encontrada',
                ''
            )));
        }
    }
}