<?php

    function salvarTrack ($painelTrack, $gestorPainel, $urlId, $urlTrack, $campanhaAtual, $campanhaAntiga, $ultimaCampanha, $keyTrack,  $data, $hora){
			
			$c['painel_cod'] = $painelTrack;
			$c['gestor_track'] = $gestorPainel;
			$c['url_id'] = $urlId;			
			$c['url_track'] = $urlTrack;
			$c['camp_track'] = $campanhaAtual;
			$c['camp_primeira'] = $campanhaAntiga;
			$c['camp_ultima'] = $ultimaCampanha;
			$c['ip_track'] = $keyTrack;
			$c['data_track'] = $data;
			$c['hora_track'] = date("H:i:s");

			$tabela = 'vf_tracking';
				if($keyTrack == 'undefined' || $keyTrack == 'null' || $keyTrack == 'off'){
					$consulta = '';
				}else{
					if($urlId == 'track' || $urlId == 'rever'){
						$consulta = consultaTrack($urlTrack,$keyTrack);
					}else{
						$consulta = "";
					}
					
				}
				if($consulta > ""){
					$salva = '0';
				}else{
					$salva = addTrack($tabela, $c);
				}
			
			return $salva;
	}

    function addTrack ($tabela, $array){

		$campos = array_keys($array); //separa o indice das Arrays que é o mesmo da coluna no banco de dados
		$valores = array_values($array); //separa os valores das Arrays que chegou do POST
		$sqlCampos = implode(", ", $campos); //converte as arrays em uma string com valores separados por virgula
		$in = rtrim(str_repeat('?,', count($array)), ','); //Conta e cria uma Arrey com os valor '?'
	
		try {
		$PDO = db_connect(); //conecta o banco
		$sql = "INSERT INTO $tabela ($sqlCampos) VALUES ($in) "; //monta o SQL
		$stmt = $PDO->prepare($sql); // Prepara o registro
						
		if ($stmt->execute($valores)){ //executa o registro com os valores das arrays
			return true;
		}
		// }else{
		//     return $stmt->errorInfo();
		// }
		throw new Exception();
		} catch (Exception $e) {
			//retornaErro('Problema para salvar no banco de dados | ' .date("d/m/y - H:i:s"). ' | '.$tabela.' | ', 'error');
			return false;
		}

    }
	function consultaTrack($urlTrack,$keyTrack){
        $PDO = db_connect();
        $sql = "SELECT id_tracking FROM vf_tracking where url_track = '$urlTrack' AND ip_track = '$keyTrack'  ";
        $usu = $PDO->prepare($sql);
        $usu->execute();
        $stm = $usu->fetch(PDO::FETCH_ASSOC);
        return $stm;
    
    }

	function consultaCampanha($codigo){
        $PDO = db_connect();
        $sql = "SELECT campaign_destino, campaign_code_painel FROM vf_campaign where campaign_code = '$codigo'";
        $usu = $PDO->prepare($sql);
        $usu->execute();
        $stm = $usu->fetch(PDO::FETCH_ASSOC);
        return $stm;
    
    }
	function consultaPainel($codigo){
		$PDO = db_connect();
		$sql = "SELECT business_code, business_whatsapp, business_gestor FROM vf_business where business_code = '$codigo' ";
		$usu = $PDO->prepare($sql);
		$usu->execute();
        $stm = $usu->fetch(PDO::FETCH_ASSOC);
        return $stm;
	}

	function readBusiness($site){
		$PDO = db_connect();
		$sql = "SELECT business_code, business_whatsapp, business_gestor FROM vf_business where business_site = '$site' ";
		$usu = $PDO->prepare($sql);
		$usu->execute();
        $stm = $usu->fetch(PDO::FETCH_ASSOC);
        return $stm;
	}

?>