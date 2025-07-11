<?php 
header('Content-Type:application/json'); // cabeçalho que a Gabee passou no primeiro enncontro

$dataDeNascimento = $_GET['data_nascimento'] ?? null; // data de nascimento do servidor


// primeira validação
if (empty($dataDeNascimento)) {
    echo json_encode([
        'status' => 'error',
        'mensagem' => 'Data de nascimento não fornecida'
    ]);
    exit();
}

// formato da data usando expressão regular (usei o gemini, único jeito que consegui pensar nessa parte)
if (!preg_match("/^\d{2}-\d{2}-\d{4}$/", $dataDeNascimento)) {
    echo json_encode([
        'status' => 'error',
        'mensagem' => 'Formato de data de nascimento inválido. Use DD-MM-YYYY'
    ]);
    exit();
}


// aqui eu atrelo os valores de um array as 3 variáveis que preciso, o explode eu consigo separar a string em um array usando o - do formato da data
list($diaNascimento, $mesNascimento, $anoNascimento) = explode('-', $dataDeNascimento);


// ano, dia e mês atuais
$anoAtual = date('Y');
$mesAtual = date('m');
$diaAtual = date('d');


$idade = $anoAtual - $anoNascimento;

//ajuste de idade se o aniversário ainda não aconteceu neste ano
if ((int)$mesAtual < (int)$mesNascimento || ((int)$mesAtual === (int)$mesNascimento && (int)$diaAtual < (int)$diaNascimento)) {
    $idade--; // diminui 1 da idade pois o niver não chegou
}

//Resposta
if ($idade >= 18) {
    echo json_encode([
        'status' => 'success',
        'mensagem' => 'Cadastro realizado com sucesso! Usuario maior de 18 anos.',
        'idade' => $idade
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'mensagem' => 'Usuario menor de 18 anos. Cadastro nao permitido.',
        'idade' => $idade
    ]);
}

// exemplo para testar http://localhost/trilha-php/trilha-ex-php/validacao_idade_ddmmyyyy.php?data_nascimento=08-07-1994

?>