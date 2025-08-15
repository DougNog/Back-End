<?php

$modelo_carro1 = "Versa";
$marca_carro1 = "Nissan";
$ano_carro1 = "2020";
$revisao_carro1 = true;

$modelo_carro2 = "M5";
$marca_carro2 = "BMW";
$ano_carro2 = "2018";
$revisao_carro2 = false;

$modelo_carro3 = "911";
$marca_carro3 = "Porsche";
$ano_carro3 = "2026";
$revisao_carro3 = false;

$modelo_carro4 = "Dolphin";
$marca_carro4 = "BYD";
$ano_carro4 = "2023";
$revisao_carro4 = false;

function passouRevisao($revisaoF)
{
    echo false;
}

$revisao_carro4 = passouRevisao($revisao_carro4);

function novoDono($donos) 
{
    echo $donos + 1;
}

function exibirCarro($modelo, $marca, $ano, $revisao, $Ndonos) {
    echo "Modelo: " . $modelo;
    echo "Marca: " . $marca;
    echo "Ano: " . $ano;
    if ($revisao) {
        echo "Revisão: Em dia";
    } else {
        echo "Revisão: Pendente";
    }
    echo "Número de donos: " . $Ndonos;
}

function ehSeminovo($ano) {
    $ano_atual = date("Y");
    return ($ano_atual - $ano) <= 1;
}

function precisaRevisao($revisao, $ano)  {
    if ($revisao) {
        echo "O carro está em dia com a revisão.";
    } else {
        if (ehSeminovo($ano)) {
            echo "O carro é seminovo e não precisa de revisão.";
        } else {
            echo "O carro precisa de revisão.";
        }
    }
}

function calcularValor($marca, $ano, $Ndonos) {
    $ano_atual = date("Y");
    $valorBase = 0;

    if ($marca == 'BMW' || $marca == 'Porsche') {
        $valorBase = 300000;
    } elseif ($marca == 'Nissan') {
        $valorBase = 70000;
    } elseif ($marca == 'BYD') {
        $valorBase = 150000;
    } else {
        return "Marca não reconhecida.";
    }

    if ($Ndonos > 1) {
        $depreciacaoDonos = ($Ndonos - 1) * 0.05 * $valorBase;
        $valorBase -= $depreciacaoDonos;
    }

    $anosDeUso = $ano_atual - $ano;
    if ($anosDeUso > 0) {
        $depreciacaoAno = $anosDeUso * 3000;
        $valorBase -= $depreciacaoAno;
    }

    return max($valorBase, 0);
}

?>