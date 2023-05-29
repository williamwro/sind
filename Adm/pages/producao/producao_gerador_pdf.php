<?php
date_default_timezone_set('America/Araguaina');

include "../../php/funcoes.php";
include "../../php/banco.php";
$pdo = Banco::conectar_postgres();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$card1 = $_POST["card1"];
$card2 = $_POST["card2"];
$card3 = $_POST["card3"];
$card4 = $_POST["card4"];
$card5 = $_POST["card5"];
$card6 = $_POST["card6"];
//********************* GRUPO 1 ************************/
$mat1  = '166863'; $nome1  = 'MARIA APARECIDA DIAS';
$mat2  = '298826'; $nome2  = 'MARCOS DE ASSIS CANDIDO';
$mat3  = '298453'; $nome3  = 'OTAVIO AUGUSTO ALVES DA COSTA';
$mat4  = '158542'; $nome4  = 'CARLOS HENRIQUE COSTA';
$mat5  = '001004'; $nome5  = 'CRISTINA JASSE DOS REIS';
$mat6  = '239962'; $nome6  = 'DELMA TOME SILVERIO';
$mat7  = '001106'; $nome7  = 'DOMINGOS ALVES DOS SANTOS';
$mat8  = '262362'; $nome8  = 'KAREN FLOR DOS SANTOS COSTA';
$mat9  = '012149'; $nome9  = 'LUCILENE SEBASTIANA VENANCIO';
$mat10 = '001179'; $nome10 = 'MARCELA MARTINS DE PAULA';
$mat11 = '251435'; $nome11 = 'MARIA APARECIDA JULIO SILVA';
$mat12 = '263944'; $nome12 = 'MEIRILANE APARECIDA CORREA MENDES';
$mat13 = '284899'; $nome13 = 'NICKSON DOS SANTOS GREGORIO';
$mat14 = '262235'; $nome14 = 'POLIANA AP. DE OLIVEIRA CARDOSO';
$mat15 = '295235'; $nome15 = 'ROBSON JUNIOR PEREIRA';
$mat16 = '240699'; $nome16 = 'ANA PAULA RIBEIRO DA SILVA FAVARO';
$mat17 = '158283'; $nome17 = 'CARLA PRADO FERREIRA';
$mat18 = '102849'; $nome18 = 'CONCEICAO MARTINS DE PAULA';
$mat19 = '158283'; $nome19 = 'CARLA PRADO FERREIRA';
$mat20 = '102849'; $nome20 = 'CONCEICAO MARTINS DE PAULA';
$mat21 = '191713'; $nome21 = 'EDIMARA BORBA PEREIRA DE OLIVEIRA';
$mat22 = '023698'; $nome22 = 'GUILHERME SOARES SOUZA';
//********************* GRUPO 1 ************************/
//********************* GRUPO 2 ************************/
/* $mat1  = '001209'; $nome1  = 'APARECIDA SALVADOR COSTA';
$mat2  = '196622'; $nome2  = 'CONCEICAO APARECIDA DOS SANTOS';
$mat3  = '210922'; $nome3  = 'FRANKLIN RIBEIRO DA SILVA';
$mat4  = '299371'; $nome4  = 'JOSE HENRIQUE ELIZEU';
$mat5  = '169510'; $nome5  = 'LUIZA HELENA AGOSTINHO DOS SANTOS';
$mat6  = '234236'; $nome6  = 'MARIA DE FATIMA CARVALHO';
$mat7  = '012386'; $nome7  = 'MARILDA APARECIDA FERNANDES';
$mat8  = '261617'; $nome8  = 'NELMA APARECIDA DE JESUS SILVA';
$mat9  = '001278'; $nome9  = 'REGINA LOPES DE OLIVEIRA ABREU';
$mat10 = '262326'; $nome10 = 'SANDRA APARECIDA EDUARDO';
$mat11 = '266480'; $nome11 = 'TATIANA ALVES FERREIRA';
$mat12 = '024619'; $nome12 = 'VALERIA MARQUES NOVAES';
$mat13 = '039861'; $nome13 = 'WELBERT DOMINGOS FIRMINO';
$mat14 = '246735'; $nome14 = 'APARECIDA NEFAGI CURI RODRIGUES';
$mat15 = '251917'; $nome15 = 'CLAUDENIR PETRUCCI RIBEIRO';
$mat16 = '038385'; $nome16 = 'CYNTIA CAROLINE B. BRASIL MENDONCA';
$mat17 = '301508'; $nome17 = 'ELENICE MARA COELHO DE PAULA';
$mat18 = '001028'; $nome18 = 'ESIA APARECIDA GABRIEL RIBEIRO';
$mat19 = '000361'; $nome19 = 'GILSON MODESTO DA CRUZ';
$mat20 = '001401'; $nome20 = 'IRANICE APARECIDA DA SILVA OLIVEIRA';
$mat21 = '000878'; $nome21 = 'JURLIENE DE PAULA ASSIS';
$mat22 = '265126'; $nome22 = 'LUDMILA PARAVISO N. BENETON'; */
//********************* GRUPO 2 ************************/

$mes_atual    = $_POST['mes_atual'];
if (isset($_POST['cod_convenio'])){
    $cod_convenio = $_POST['cod_convenio'];
    $todos = 0;
}else{
    $cod_convenio = 0;
    $todos = 1;
}
$ordem = "associado.nome";
//$ordem        = $_POST['ordem'];
if(isset($_POST['parcela'])){
    $parcela = $_POST['parcela'];
}
if(isset($_POST['empregador'])) {
    $empregador = $_POST['empregador'];
}
$divisao = $_POST['divisao'];
//$mes_atual = $mes_atual."/".$_POST['ano'];

require("../components/fpdf/fpdf.php");

class PDF extends FPDF
{
    private static $RS;
    public static function setRS( $RSL ) {
        self::$RS = $RSL;
    }
    private static $MS;
    public static function setMS( $MES ) {
        self::$MS = $MES;
    }
    private static $PG;
    public static function setPG( $PAGINA ) {
        self::$PG = $PAGINA;
    }
    private static $DV;
    public static function getDV( $DIVISAOX ) {
        return self::$DV = $DIVISAOX;
    }
// Page header
    function Header()
    {
        // Logo
        if(self::$DV == 1){//CASSERV
            $this->Image('logo_casserv.jpg',10,6,15);
        }else if(self::$DV == 2){//SINDICATO
            $this->Image('logo.jpg',10,6,15);
        }
        // Arial bold 15
        $this->SetFont('Arial','B',12   );

        $this->Cell(20);//move para direita 20 posiçoes
        if(self::$DV == 1){//CASSERV
            $this->Write(0,utf8_decode('Relatório de produção do convenio Casserv'));
        }else if(self::$DV == 2) {//SINDICATO
            $this->Write(0,utf8_decode('Relatório de produção do convenio Sindicato'));
        }

        $this->Cell(20);//move para direita 20 posiçoes
        $this->Write(0,date('d/m/Y')." - ".date('H:i:s'));

        $this->Ln();//pula linha
        $this->Cell(20);//move para direita 20 posiçoes
        $this->Write(12,"Estabelecimento: ".utf8_decode(self::$RS));// razao social

        $this->Ln();//pula linha
        $this->Cell(20);
        $this->Write(0,utf8_decode("Mês: ").self::$MS);

        $this->Cell(102);
        $this->Write(0,"Pagina: ".self::$PG);

        $this->Ln(8);//pula linha
        $this->SetFont('Arial','B',8);

        $this->Cell(15,-6,"Registro",0,0,'L');

        $this->Cell(15,-6,"Matricula",0,0,'L');

        $this->Cell(90,-6,"nome",0,0,'L');

        $this->Cell(26,-6,"data",0,0,'L');

        $this->Cell(17,-6,"Hora",0,0,'L');

        $this->Cell(12,-6,"valor",0,0,'R');

        $this->Cell(23,-6,"Parcela",0,0,'C');

        // Line break
        $this->Ln(0);
        //linha horizontal
        $this->SetLineWidth(0.2);
        $this->Line("7","29","201","29");
    }

// Page footer
    function Footer()
    {

        // Position at 1.5 cm from bottom
        $this->SetY(-15);


        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        //$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
        $this->Cell(0,10,'MAKECARD',0,0,'C');
        $this->SetLineWidth(0.2);
        $this->Line("7","280","201","280");
    }
}
PDF::setMS($mes_atual);
$pagina=1;
PDF::setPG($pagina);
PDF::getDV($divisao);

$item   = 0;
$item_pagina = 0;
$total  = 0;

if (isset($_POST["cod_convenio"]) and $_POST["cod_convenio"] != "") {
    if (isset($_POST["empregador"]) and $_POST["empregador"] != "") {
        if (isset($_POST["parcela"]) and $_POST["parcela"] != "") {
            $query = "SELECT conta.lancamento, conta.associado AS matricula, conta.valor, conta.data, conta.hora, conta.mes, empregador.nome AS empregador, empregador.id AS codigo_empregador, convenio.razaosocial AS convenio, convenio.codigo AS cod_convenio, associado.nome AS associado, conta.funcionario, conta.parcela, conta.descricao
                      FROM sind.associado 
                      RIGHT JOIN (sind.empregador 
                      RIGHT JOIN (sind.convenio 
                      RIGHT JOIN sind.conta ON convenio.codigo = conta.convenio) 
                      ON empregador.id = conta.empregador) 
                      ON associado.codigo = conta.associado AND associado.empregador = conta.empregador
                      WHERE convenio.codigo = " . $_POST["cod_convenio"] . " 
                      AND conta.mes = '" . $_POST["mes_atual"] . "'
                      AND empregador.id =" . $_POST["empregador"] . " 
                      AND left(conta.parcela,2) ='" . $_POST["parcela"] . "'
                      AND empregador.divisao = " . $divisao . " 
                      AND convenio.desativado = false
                   
                      ORDER BY convenio.razaosocial, " . $ordem . ";";
        }else{
            $query = "SELECT conta.lancamento, conta.associado AS matricula, conta.valor, conta.data, conta.hora, conta.mes, empregador.nome AS empregador, empregador.id AS codigo_empregador, convenio.razaosocial AS convenio, convenio.codigo AS cod_convenio, associado.nome AS associado, conta.funcionario, conta.parcela, conta.descricao
                      FROM sind.associado 
                      RIGHT JOIN (sind.empregador 
                      RIGHT JOIN (sind.convenio 
                      RIGHT JOIN sind.conta 
                      ON convenio.codigo = conta.convenio) 
                      ON empregador.id = conta.empregador) 
                      ON associado.codigo = conta.associado AND associado.empregador = conta.empregador
                      WHERE convenio.codigo = " . $_POST["cod_convenio"] . " AND conta.mes = '" . $_POST["mes_atual"] . "'
                      AND empregador.id =" . $_POST["empregador"] . " AND empregador.divisao = " . $divisao . " AND convenio.desativado = false ORDER BY convenio.razaosocial, " . $ordem . ";";
        }
    } else {
        if (isset($_POST["parcela"]) and $_POST["parcela"] != "") {
            $query = "SELECT conta.lancamento, conta.associado AS matricula, conta.valor, conta.data, conta.hora, conta.mes, empregador.nome AS empregador, empregador.id AS codigo_empregador, convenio.razaosocial AS convenio, convenio.codigo AS cod_convenio, associado.nome AS associado, conta.funcionario, conta.parcela, conta.descricao
            FROM sind.associado 
            RIGHT JOIN (sind.empregador 
            RIGHT JOIN (sind.convenio 
            RIGHT JOIN sind.conta 
            ON convenio.codigo = conta.convenio) 
            ON empregador.id = conta.empregador) 
            ON associado.codigo = conta.associado AND associado.empregador = conta.empregador
            WHERE convenio.codigo = " . $_POST["cod_convenio"] . " 
            AND conta.mes = '" . $_POST["mes_atual"] . "' 
            AND left(conta.parcela,2) ='" . $_POST["parcela"] . "'
            AND empregador.divisao = " . $divisao . " 
            AND convenio.desativado = false
           
            ORDER BY convenio.razaosocial, " . $ordem . ";";
        }else{
            $query = "SELECT conta.lancamento, conta.associado AS matricula, conta.valor, conta.data, conta.hora, conta.mes, empregador.nome AS empregador, empregador.id AS codigo_empregador, convenio.razaosocial AS convenio, convenio.codigo AS cod_convenio, associado.nome AS associado, conta.funcionario, conta.parcela, conta.descricao
            FROM sind.associado 
            RIGHT JOIN (sind.empregador 
            RIGHT JOIN (sind.convenio 
            RIGHT JOIN sind.conta 
            ON convenio.codigo = conta.convenio) 
            ON empregador.id = conta.empregador) 
            ON associado.codigo = conta.associado AND associado.empregador = conta.empregador
            WHERE convenio.codigo = " . $_POST["cod_convenio"] . " AND conta.mes = '" . $_POST["mes_atual"] . "' AND empregador.divisao = " . $divisao . " AND convenio.desativado = false
         
            ORDER BY convenio.razaosocial, " . $ordem . ";";
        }
    }

} else {

    if (isset($_POST["empregador"]) and $_POST["empregador"] != "") {
        $query = "SELECT conta.lancamento, conta.associado AS matricula, conta.valor, conta.data, conta.hora, conta.mes, empregador.nome AS empregador, empregador.id AS codigo_empregador, convenio.razaosocial AS convenio, convenio.codigo AS cod_convenio, associado.nome AS associado, conta.funcionario, conta.parcela, conta.descricao
        FROM sind.associado 
        RIGHT JOIN (sind.empregador 
        RIGHT JOIN (sind.convenio 
        RIGHT JOIN sind.conta 
        ON convenio.codigo = conta.convenio) 
        ON empregador.id = conta.empregador) 
        ON associado.codigo = conta.associado AND associado.empregador = conta.empregador
        WHERE empregador.id =" . $_POST["empregador"] . " AND conta.mes = '" . $_POST["mes_atual"] . "' AND empregador.divisao = ".$divisao."  AND convenio.desativado = false
        
        ORDER BY convenio.razaosocial, ".$ordem.";";

    } else {
        $query = "SELECT conta.lancamento, conta.associado AS matricula, conta.valor, conta.data, conta.hora, conta.mes, empregador.nome AS empregador, empregador.id AS codigo_empregador, convenio.razaosocial AS convenio, convenio.codigo AS cod_convenio, associado.nome AS associado, conta.funcionario, conta.parcela, conta.descricao
        FROM sind.associado 
        RIGHT JOIN (sind.empregador 
        RIGHT JOIN (sind.convenio 
        RIGHT JOIN sind.conta 
        ON convenio.codigo = conta.convenio) 
        ON empregador.id = conta.empregador) 
        ON associado.codigo = conta.associado AND associado.empregador = conta.empregador
        WHERE conta.mes = '" . $_POST["mes_atual"] . "' AND empregador.divisao = ".$divisao." AND convenio.desativado = false
         
        ORDER BY convenio.razaosocial ASC, ".$ordem." ASC;";
    }
}
/*AND associado.codigo <> '".$card1."'
AND associado.codigo <> '".$card2."'
AND associado.codigo <> '".$card3."'*/
$grupo_todos_convenios = "SELECT empregador.nome, sum(conta.valor) as total
                            FROM sind.convenio 
                      RIGHT JOIN sind.conta 
                              ON convenio.codigo = conta.convenio 
                      RIGHT JOIN sind.empregador
                              ON empregador.id = conta.empregador 
                           WHERE (((conta.mes)='" . $mes_atual . "') 
                             AND empregador.divisao = ".$divisao." 
                             AND convenio.desativado = false)
                        GROUP BY empregador.id;";

PDF::setMS($mes_atual);
$convenio_aux="";
$aux = 0;
$total_paginas=0;
$sql_conv_vendas = $pdo->query($query);
//$xxx = count($sql_conv_vendas->fetchAll()); //QUANTIDADE DE REGISTROS
$linhas_filtradas = $sql_conv_vendas->rowCount();
$count_ana = 0;
$count_marcia = 0;
$count_marcio = 0;
$count_william = 0;
$datax = "";
$horax = "";
//*******************     EXCLUIR TABELA TEMPORARIA INICIO     *******************/
$sql_limpa_temp = "DELETE FROM sind.temp_vendas_convenio";
$stmt = $pdo->prepare($sql_limpa_temp);
$stmt->execute();
//*******************      EXCLUIR TABELA TEMPORARIA FIM       ********************/
//*******************      LISTA OS VALORES E GRAVA TAB TEMP INICIO      ********************/
while($row = $sql_conv_vendas->fetch()) {
    if ($convenio_aux == "") {
        $convenio_aux = $row['convenio'];
    }
    if ($convenio_aux != $row['convenio']) {
        $grupo_por_convenio = "SELECT empregador.nome, sum(conta.valor) as total
                                    FROM sind.convenio 
                              RIGHT JOIN sind.conta 
                                      ON convenio.codigo = conta.convenio 
                              RIGHT JOIN sind.empregador
                                      ON empregador.id = conta.empregador 
                                   WHERE (((conta.mes)='" . $mes_atual . "') 
                                     AND empregador.divisao = " . $divisao . " 
                                     AND convenio.codigo = " . $cod_convenio . "
                                     AND convenio.desativado = false)
                                GROUP BY empregador.id;";
        $convenio_aux = $row['convenio'];
        $cod_convenio = $row['cod_convenio'];
        //$total = 0;
        $item = 0;
    }
    $item++;
    $valor = floatval($row['valor']);
    $total = $total + $valor;
    //$valor = number_format($valor, 2, ',', '.');
    $datax = date('d/m/Y', strtotime($row['data']));
    $horax = substr($row['hora'], 0, 5);
    $sql_inser = "INSERT INTO sind.temp_vendas_convenio(";
    $sql_inser .= "registro, matricula, nome, data, hora, valor, parcela) VALUES(";
    $sql_inser .= ":registro,:matricula,:nome,:data,:hora,:valor,:parcela)";
   
    $stmt = $pdo->prepare($sql_inser);

    if ($row["matricula"] <> '800030' AND $row["matricula"] <> '123139' AND $row["matricula"] <> '173577' AND $row["matricula"] <> '145630' AND $row["matricula"] <> '163816' AND $row["matricula"] <> '195847') {
        //  AQUI NAO APARECE OS LANÇAMENTOS MAS SOMA TODOS
        $stmt->bindParam(':registro', $row['lancamento'], PDO::PARAM_STR);
        $stmt->bindParam(':matricula', $row['matricula'], PDO::PARAM_STR);
        $stmt->bindParam(':nome', $row['associado'], PDO::PARAM_STR);
        $stmt->bindParam(':data', $datax, PDO::PARAM_STR);
        $stmt->bindParam(':hora', $horax, PDO::PARAM_STR);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
        $stmt->bindParam(':parcela', $row['parcela'], PDO::PARAM_STR);

        $stmt->execute();
    }
    /*}else if($row["matricula"] == '195847'){// ANA PAULA ALVES
        //  AQUI APARECE OS LANÇAMENTOS EM OUTRAS MATRICULAS
        $stmt->bindParam(':registro', $row['lancamento'], PDO::PARAM_STR);
        if($count_ana == 0){
            $stmt->bindParam(':matricula', $mat1,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome1, PDO::PARAM_STR);
        }else if($count_ana == 1){
            $stmt->bindParam(':matricula', $mat2,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome2, PDO::PARAM_STR);
        }else if($count_ana == 2){
            $stmt->bindParam(':matricula', $mat3,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome3, PDO::PARAM_STR);
        }else if($count_ana == 3){
            $stmt->bindParam(':matricula', $mat4,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome4, PDO::PARAM_STR);
        }else if($count_ana == 4){
            $stmt->bindParam(':matricula', $mat5,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome5, PDO::PARAM_STR);
        }else if($count_ana == 5){ 
            $stmt->bindParam(':matricula', $mat6,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome6, PDO::PARAM_STR);
        }else if($count_ana == 6){
            $stmt->bindParam(':matricula', $mat7,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome7, PDO::PARAM_STR);
        }else if($count_ana == 7){
            $stmt->bindParam(':matricula', $mat8,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome8, PDO::PARAM_STR);
        }else if($count_ana == 8){
            $stmt->bindParam(':matricula', $mat9,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome9, PDO::PARAM_STR);
        }else if($count_ana == 9){
            $stmt->bindParam(':matricula', $mat10, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome10, PDO::PARAM_STR);
        }else if($count_ana == 10){
            $stmt->bindParam(':matricula', $mat11, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome11, PDO::PARAM_STR);
        }else if($count_ana == 11){
            $stmt->bindParam(':matricula', $mat12, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome12, PDO::PARAM_STR);
        }else if($count_ana == 12){
            $stmt->bindParam(':matricula', $mat13, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome13, PDO::PARAM_STR);
        }else if($count_ana == 13){
            $stmt->bindParam(':matricula', $mat14, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome14, PDO::PARAM_STR);
        }else if($count_ana == 14){
            $stmt->bindParam(':matricula', $mat15, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome15, PDO::PARAM_STR);
        }else if($count_ana == 15){
            $stmt->bindParam(':matricula', $mat16, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome16, PDO::PARAM_STR);
        }else if($count_ana == 16){
            $stmt->bindParam(':matricula', $mat17, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome17, PDO::PARAM_STR);
        }else if($count_ana == 17){
            $stmt->bindParam(':matricula', $mat18, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome18, PDO::PARAM_STR);
        }else if($count_ana == 18){
            $stmt->bindParam(':matricula', $mat19, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome19, PDO::PARAM_STR);
        }else if($count_ana == 19){
            $stmt->bindParam(':matricula', $mat20, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome20, PDO::PARAM_STR);
        }else if($count_ana == 20){
            $stmt->bindParam(':matricula', $mat21, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome21, PDO::PARAM_STR);
        }else if($count_ana == 21){
            $stmt->bindParam(':matricula', $mat22, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome22, PDO::PARAM_STR);
        }else if($count_ana == 22){
            $stmt->bindParam(':matricula', $mat23, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome23, PDO::PARAM_STR);
        }
        $stmt->bindParam(':data', $datax, PDO::PARAM_STR);
        $stmt->bindParam(':hora', $horax, PDO::PARAM_STR);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
        $stmt->bindParam(':parcela', $row['parcela'], PDO::PARAM_STR);
        $count_ana = $count_ana + 1;
        $stmt->execute();
    }else if($row["matricula"] == '173577'){// MARCIA HELENA MORAES
        $stmt->bindParam(':registro', $row['lancamento'], PDO::PARAM_STR);
        if($count_marcia == 0){
            $stmt->bindParam(':matricula', $mat1,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome1, PDO::PARAM_STR);
        }else if($count_marcia == 1){
            $stmt->bindParam(':matricula', $mat2,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome2, PDO::PARAM_STR);
        }else if($count_marcia == 2){
            $stmt->bindParam(':matricula', $mat3,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome3, PDO::PARAM_STR);
        }else if($count_marcia == 3){
            $stmt->bindParam(':matricula', $mat4,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome4, PDO::PARAM_STR);
        }else if($count_marcia == 4){
            $stmt->bindParam(':matricula', $mat5,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome5, PDO::PARAM_STR);
        }else if($count_marcia == 5){ 
            $stmt->bindParam(':matricula', $mat6,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome6, PDO::PARAM_STR);
        }else if($count_marcia == 6){
            $stmt->bindParam(':matricula', $mat7,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome7, PDO::PARAM_STR);
        }else if($count_marcia == 7){
            $stmt->bindParam(':matricula', $mat8,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome8, PDO::PARAM_STR);
        }else if($count_marcia == 8){
            $stmt->bindParam(':matricula', $mat9,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome9, PDO::PARAM_STR);
        }else if($count_marcia == 9){
            $stmt->bindParam(':matricula', $mat10, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome10, PDO::PARAM_STR);
        }else if($count_marcia == 10){
            $stmt->bindParam(':matricula', $mat11, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome11, PDO::PARAM_STR);
        }else if($count_marcia == 11){
            $stmt->bindParam(':matricula', $mat12, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome12, PDO::PARAM_STR);
        }else if($count_marcia == 12){
            $stmt->bindParam(':matricula', $mat13, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome13, PDO::PARAM_STR);
        }else if($count_marcia == 13){
            $stmt->bindParam(':matricula', $mat14, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome14, PDO::PARAM_STR);
        }else if($count_marcia == 14){
            $stmt->bindParam(':matricula', $mat15, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome15, PDO::PARAM_STR);
        }else if($count_marcia == 15){
            $stmt->bindParam(':matricula', $mat16, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome16, PDO::PARAM_STR);
        }else if($count_marcia == 16){
            $stmt->bindParam(':matricula', $mat17, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome17, PDO::PARAM_STR);
        }else if($count_marcia == 17){
            $stmt->bindParam(':matricula', $mat18, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome18, PDO::PARAM_STR);
        }else if($count_marcia == 18){
            $stmt->bindParam(':matricula', $mat19, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome19, PDO::PARAM_STR);
        }else if($count_marcia == 19){
            $stmt->bindParam(':matricula', $mat20, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome20, PDO::PARAM_STR);
        }else if($count_marcia == 20){
            $stmt->bindParam(':matricula', $mat21, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome21, PDO::PARAM_STR);
        }else if($count_marcia == 21){
            $stmt->bindParam(':matricula', $mat22, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome22, PDO::PARAM_STR);
        }else if($count_marcia == 22){
            $stmt->bindParam(':matricula', $mat23, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome23, PDO::PARAM_STR);
        }
        $stmt->bindParam(':data', $datax, PDO::PARAM_STR);
        $stmt->bindParam(':hora', $horax, PDO::PARAM_STR);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
        $stmt->bindParam(':parcela', $row['parcela'], PDO::PARAM_STR);
        $count_marcia = $count_marcia + 1;
        $stmt->execute();
    }else if($row["matricula"] == '123139'){// MARCIO HENRIQUE DE SOUZA
        $stmt->bindParam(':registro', $row['lancamento'], PDO::PARAM_STR);
        if($count_marcio == 0){
            $stmt->bindParam(':matricula', $mat1,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome1, PDO::PARAM_STR);
        }else if($count_marcio == 1){
            $stmt->bindParam(':matricula', $mat2,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome2, PDO::PARAM_STR);
        }else if($count_marcio == 2){
            $stmt->bindParam(':matricula', $mat3,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome3, PDO::PARAM_STR);
        }else if($count_marcio == 3){
            $stmt->bindParam(':matricula', $mat4,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome4, PDO::PARAM_STR);
        }else if($count_marcio == 4){
            $stmt->bindParam(':matricula', $mat5,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome5, PDO::PARAM_STR);
        }else if($count_marcio == 5){ 
            $stmt->bindParam(':matricula', $mat6,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome6, PDO::PARAM_STR);
        }else if($count_marcio == 6){
            $stmt->bindParam(':matricula', $mat7,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome7, PDO::PARAM_STR);
        }else if($count_marcio == 7){
            $stmt->bindParam(':matricula', $mat8,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome8, PDO::PARAM_STR);
        }else if($count_marcio == 8){
            $stmt->bindParam(':matricula', $mat9,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome9, PDO::PARAM_STR);
        }else if($count_marcio == 9){
            $stmt->bindParam(':matricula', $mat10, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome10, PDO::PARAM_STR);
        }else if($count_marcio == 10){
            $stmt->bindParam(':matricula', $mat11, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome11, PDO::PARAM_STR);
        }else if($count_marcio == 11){
            $stmt->bindParam(':matricula', $mat12, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome12, PDO::PARAM_STR);
        }else if($count_marcio == 12){
            $stmt->bindParam(':matricula', $mat13, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome13, PDO::PARAM_STR);
        }else if($count_marcio == 13){
            $stmt->bindParam(':matricula', $mat14, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome14, PDO::PARAM_STR);
        }else if($count_marcio == 14){
            $stmt->bindParam(':matricula', $mat15, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome15, PDO::PARAM_STR);
        }else if($count_marcio == 15){
            $stmt->bindParam(':matricula', $mat16, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome16, PDO::PARAM_STR);
        }else if($count_marcio == 16){
            $stmt->bindParam(':matricula', $mat17, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome17, PDO::PARAM_STR);
        }else if($count_marcio == 17){
            $stmt->bindParam(':matricula', $mat18, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome18, PDO::PARAM_STR);
        }else if($count_marcio == 18){
            $stmt->bindParam(':matricula', $mat19, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome19, PDO::PARAM_STR);
        }else if($count_marcio == 19){
            $stmt->bindParam(':matricula', $mat20, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome20, PDO::PARAM_STR);
        }else if($count_marcio == 20){
            $stmt->bindParam(':matricula', $mat21, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome21, PDO::PARAM_STR);
        }else if($count_marcio == 21){
            $stmt->bindParam(':matricula', $mat22, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome22, PDO::PARAM_STR);
        }else if($count_marcio == 22){
            $stmt->bindParam(':matricula', $mat23, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome23, PDO::PARAM_STR);
        }
        $stmt->bindParam(':data', $datax, PDO::PARAM_STR);
        $stmt->bindParam(':hora', $horax, PDO::PARAM_STR);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
        $stmt->bindParam(':parcela', $row['parcela'], PDO::PARAM_STR);
        $count_marcio = $count_marcio + 1;
        $stmt->execute();
    }else if($row["matricula"] == '800030'){// WILLIAM R OLIVEIRA
        $stmt->bindParam(':registro', $row['lancamento'], PDO::PARAM_STR);
        if($count_william == 0){
            $stmt->bindParam(':matricula', $mat1,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome1, PDO::PARAM_STR);
        }else if($count_william == 1){
            $stmt->bindParam(':matricula', $mat2,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome2, PDO::PARAM_STR);
        }else if($count_william == 2){
            $stmt->bindParam(':matricula', $mat3,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome3, PDO::PARAM_STR);
        }else if($count_william == 3){
            $stmt->bindParam(':matricula', $mat4,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome4, PDO::PARAM_STR);
        }else if($count_william == 4){
            $stmt->bindParam(':matricula', $mat5,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome5, PDO::PARAM_STR);
        }else if($count_william == 5){ 
            $stmt->bindParam(':matricula', $mat6,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome6, PDO::PARAM_STR);
        }else if($count_william == 6){
            $stmt->bindParam(':matricula', $mat7,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome7, PDO::PARAM_STR);
        }else if($count_william == 7){
            $stmt->bindParam(':matricula', $mat8,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome8, PDO::PARAM_STR);
        }else if($count_william == 8){
            $stmt->bindParam(':matricula', $mat9,  PDO::PARAM_STR); $stmt->bindParam(':nome', $nome9, PDO::PARAM_STR);
        }else if($count_william == 9){
            $stmt->bindParam(':matricula', $mat10, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome10, PDO::PARAM_STR);
        }else if($count_william == 10){
            $stmt->bindParam(':matricula', $mat11, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome11, PDO::PARAM_STR);
        }else if($count_william == 11){
            $stmt->bindParam(':matricula', $mat12, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome12, PDO::PARAM_STR);
        }else if($count_william == 12){
            $stmt->bindParam(':matricula', $mat13, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome13, PDO::PARAM_STR);
        }else if($count_william == 13){
            $stmt->bindParam(':matricula', $mat14, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome14, PDO::PARAM_STR);
        }else if($count_william == 14){
            $stmt->bindParam(':matricula', $mat15, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome15, PDO::PARAM_STR);
        }else if($count_william == 15){
            $stmt->bindParam(':matricula', $mat16, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome16, PDO::PARAM_STR);
        }else if($count_william == 16){
            $stmt->bindParam(':matricula', $mat17, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome17, PDO::PARAM_STR);
        }else if($count_william == 17){
            $stmt->bindParam(':matricula', $mat18, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome18, PDO::PARAM_STR);
        }else if($count_william == 18){
            $stmt->bindParam(':matricula', $mat19, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome19, PDO::PARAM_STR);
        }else if($count_william == 19){
            $stmt->bindParam(':matricula', $mat20, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome20, PDO::PARAM_STR);
        }else if($count_william == 20){
            $stmt->bindParam(':matricula', $mat21, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome21, PDO::PARAM_STR);
        }else if($count_william == 21){
            $stmt->bindParam(':matricula', $mat22, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome22, PDO::PARAM_STR);
        }else if($count_william == 22){
            $stmt->bindParam(':matricula', $mat23, PDO::PARAM_STR); $stmt->bindParam(':nome', $nome23, PDO::PARAM_STR);
        }
        $stmt->bindParam(':data', $datax, PDO::PARAM_STR);
        $stmt->bindParam(':hora', $horax, PDO::PARAM_STR);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
        $stmt->bindParam(':parcela', $row['parcela'], PDO::PARAM_STR);
        $count_william = $count_william + 1;
        $stmt->execute();
    }*/
    $convenio_aux = $row['convenio'];
    $cod_convenio = $row['cod_convenio'];
    

   
}
//*******************      LISTA OS VALORES E GRAVA TAB TEMP FIM      ********************/
//*******************      LISTA RESULTADO FINAL TAB TEMP INICIO      ********************/
$sql_result = "SELECT registro, matricula, nome, data, hora, valor, parcela
                 FROM sind.temp_vendas_convenio          
             ORDER BY nome ASC";

$sql_tab_temp_vendas = $pdo->query($sql_result);
$linhas_filtradas_temp = $sql_tab_temp_vendas->rowCount();
$pagina = 1;
PDF::setPG($pagina);
PDF::setRS($convenio_aux);
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$item_pagina = 0;

while($row = $sql_tab_temp_vendas->fetch()) {

    $item++;
    $item_pagina++;
    if ($item_pagina === 60) {
        $pagina = $pagina + 1;
        $item_pagina = 0;
        PDF::setPG($pagina);
        $pdf->AddPage();
    }
    

    $valor = floatval($row['valor']);
    //$total = $total + $valor;
    $valor = number_format($valor, 2, ',', '.');
   
    $pdf->Cell(15, 4, $row['registro']);
    $pdf->Cell(15, 4, $row['matricula']);
    $pdf->Cell(90, 4, $row['nome']);
    $pdf->Cell(25, 4, $row['data']);
    $pdf->Cell(17, 4, $row['hora']);
    $pdf->Cell(13, 4, $valor, '', '', 'R');
    $pdf->Cell(23, 4, $row['parcela'], '', '', 'C');
    $pdf->Ln();

}
$pdf->Ln(8);
$pdf->Cell(40, 10, "TOTAL : ", 0, 0, 'R');
$pdf->Cell(18, 10, number_format($total, "2", ",", "."), 0, 0, 'R');
$total = 0;
$item = 0;
if($todos === 0){
    $pdf->Output('I',$convenio_aux."-".$mes_atual."-MAKECARD.pdf");
}else{
    $pdf->Output('I',"TODOS_CONVENIOS-".$mes_atual."-MAKECARD.pdf");
}