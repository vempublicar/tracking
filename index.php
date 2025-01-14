<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
include_once "conn/connect.php";
include_once "function/tools.php";

?>
<?php
 
$url = $_GET['pg']; //RECEBE O VALOR DA URL PARA TRATAMENTO. Valores esperados [1] track/https://sitecliente.com/,C-XXXX... ou [2] C-XXXX.. (Id da campanha). Fora isso o sistema da exit.
$valida = substr($url,0,5); //VERIFICA SE O ACESSO ESTÁ CHEGANDO DA PÁGINA DE UM CLIENTE. Valor esperado "track" ou rever

if($valida == "track" || $valida == "whats" || $valida == "rever"){
    $montaTag = substr($url,6); // Aqui vai pegar o site do cliente + tag da campanha. Valor esperado: https://sitecliente.com/,C-XXXX...
    $decode = base64_decode($montaTag); //desmonta a criptografia base64 para pegar as informações
    $info = explode(",",$decode); //cria um Array com duas informações [0] site do cliente [1] tag da campanha [2] primeira campanha

    //VALIDAR O SITE DO CLIENTE
    $siteId = explode("//",$info[0]);
    if(!isset($siteId[1])){exit;}
    $dominioCliente = explode("/",$siteId[1]);
    $dominio = $valida;
    $dominioCliente = $siteId[0].'//'.$dominioCliente[0];
    $verificaCliente = readBusiness($dominioCliente);
    
    if(isset($verificaCliente['business_code']) && $verificaCliente['business_code'] > ""){
        if($info[1] == 'undefined' || $info[1] == 'null' || $info[1] == 'off' || $info[1] == 'no' || $info[1] == ''|| $info[1] == 'sem_campanha'){
            $campanhaAtual = 'I-'.$verificaCliente['business_code'];
        }else{
            $campanhaAtual = explode("?", $info[1]);
            $isbase = isbase64($campanhaAtual[0]);
            if($isbase == 'sim'){$campanhaAtual = base64_decode($campanhaAtual[0]);}else{$campanhaAtual = $campanhaAtual[0];};
        }
        if($info[2] == 'undefined' ||$info[2] == 'null' || $info[2] == 'off' || $info[2] == 'no' || $info[2] == ''|| $info[2] == 'sem_campanha' ){
            $campanhaAntiga = 'null';
        }else{
            $isbase = isbase64($info[2]);
            if($isbase == 'sim'){$campanhaAntiga = base64_decode($info[2]);}else{$campanhaAntiga = $info[2];};
        }
        if($info[3] == 'undefined' ||$info[3] == 'null' || $info[3] == 'off' || $info[3] == 'no' || $info[3] == ''|| $info[3] == 'sem_campanha'){
            $ultimaCampanha = 'null';
        }else{
            $ultimaCampanha = explode("?", $info[3]);
            $isbase = isbase64($ultimaCampanha[0]);
            if($isbase == 'sim'){$ultimaCampanha = base64_decode($ultimaCampanha[0]);}else{$ultimaCampanha = $ultimaCampanha[0];};
        }
        if($info[4] == 'undefined' || $info[4] == 'null' || $info[4] == 'off' || $info[4] == ''){
            $keyTrack = 'null';
        }else{
            $keyTrack = $info[4];
        }
        $painelTrack = $verificaCliente['business_code'];
        $gestorPainel = $verificaCliente['business_gestor'];
        $urlTrack = explode("?",$info[0]);
        $urlTrack = $urlTrack[0];
        $data = date("Y-m-d");
        $hora = date("H");

        $isbase = isbase64($info[1]);
        
        if($isbase == 'nao'){
           // $condicao = explode('-',$info[1]);
            $condicao = $info[1];
            $campanhaAtual = $info[1];
            
            if(isset($condicao)){
                //consultar no banco a chave informada
                if($condicao[1] == 'whatsapp'){
                    $caminho = $verificaCliente['business_whatsapp']; 
                    
                    $retorno = salvarTrack($painelTrack, $gestorPainel, $dominio, $urlTrack, $campanhaAtual, $campanhaAntiga, $ultimaCampanha, $keyTrack, $data, $hora);
                    ?>
                        <script type="text/javascript"> 
                            var caminho = '<?php echo $caminho ?>';
                            setTimeout(function() {
                                window.open(caminho, '_blank');
                            }, 200);
                        </script>
                    <?php
                    exit;
                }else{

                    $retorno = salvarTrack($painelTrack, $gestorPainel, $dominio, $urlTrack, $campanhaAtual, $campanhaAntiga, $ultimaCampanha, $keyTrack, $data, $hora);
                    //echo $retorno;
                }

            }else{
                
                    $retorno = salvarTrack($painelTrack, $gestorPainel, $dominio, $urlTrack, $campanhaAtual, $campanhaAntiga, $ultimaCampanha, $keyTrack, $data, $hora);
                    
                    if($valida != 'whats'){
                        exit;
                    }
                    
            }
        }else{
            
            $retorno = salvarTrack($painelTrack, $gestorPainel, $dominio, $urlTrack, $campanhaAtual, $campanhaAntiga, $ultimaCampanha, $keyTrack, $data, $hora);
        }

         if($retorno == '1'){
            if($valida == 'whats'){
                $caminho = $verificaCliente['business_whatsapp']; 
                
                $verificaTexto = explode('&text=',$caminho);
                if(isset($verificaTexto[1])){
                    header("location:".$caminho.'%0a'.$info[0]);
                }else{
                    header("location:".$caminho.'&text='.$info[0]);
                }

            }else{
                echo '<img style="height: 20px; position: absolute; left: 90%;" src="https://tracking.vempublicar.com/valido_track.png"></img>';
            }
             
         }else{
            if($valida == 'whats'){
                $caminho = $verificaCliente['business_whatsapp'];  

                $verificaTexto = explode('&text=',$caminho);
                if(isset($verificaTexto[1])){
                    header("location:".$caminho.'%0a'.$info[0]);
                }else{
                    header("location:".$caminho.'&text='.$info[0]);
                }
                
            }else{
                echo '<img style="height: 20px; position: absolute; left: 90%;" src="https://tracking.vempublicar.com/valido_no_track.png"></img>';
            }
         }
    }else{
        if($valida == 'whats'){ 
            header("location:".$info[0]);
        }else{
            echo '<img style="height: 20px; position: absolute; left: 90%;" src="https://tracking.vempublicar.com/invalido_no_track.png"></img>';
        }
    }

}else{
    if($_GET['pg'] > ""){
        $verifica = explode("/",$_GET['pg']);
        $data = date("Y-m-d");
        $hora = date("H");
               // print_r($verifica);
                if($verifica[0] == 'meu_whatsapp'){
                    if(isset($verifica[1])){
                        $cliente = $verifica[1];
                            //busca a campanha                 
                            $caminho = consultaPainel($cliente);
                          //  print_r($caminho);
                                if(isset($caminho) && $caminho > ""){
                                    $painelTrack = $caminho['business_code'];
                                    $gestorPainel = $caminho['business_whatsapp'];
                                    $dominio = $verifica[0];
                                    $urlTrack = explode('?',$caminho['business_whatsapp']);
                                    $urlTrack = $urlTrack[0];
                                    if(isset($verifica[2])){
                                        $campanhaAtual = $verifica[2];
                                    }else{
                                        $campanhaAtual = 'null';
                                    }
                                    $campanhaAntiga = 'null';
                                    $campanhaUltima = 'null';
                                    $keyTrack = rand(1,999999).$data.$hora;
                                    $retorno = salvarTrack($painelTrack, $gestorPainel, $dominio, $urlTrack, $campanhaAtual, $campanhaAntiga, $campanhaUltima, $keyTrack, $data, $hora);
                                    $destino = $caminho['business_whatsapp'];
                                     header("location:".$destino);
                                }else{
                                    if(isset($verifica[3])){
                                        if(is_numeric($verifica[3])){
                                            header("location:https://api.whatsapp.com/send/?phone=".$verifica[3]);
                                        }else{
                                            header("location:https://api.whatsapp.com/send/?phone=551922108117");
                                        }
                                    }
                                }
                        }
                }
        
            }
            
    }
    function isbase64($str){
        $decode1 = base64_decode($str);
        $decode = substr($decode1, 2, 2);
        if(ctype_alpha($decode)){
            return 'sim';
        } else {
            return 'nao';
        }
    }

?>