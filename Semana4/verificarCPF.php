<?php
function verificaDigitoCPF($cpf,$inicioLoop,$digitoVerificador){
	/* Checa se um dos digitos verificadores de um CPF é valido */
	$somatoria = 0;
	for($i=$inicioLoop; $i>=2; $i--){
		$somatoria += intval($cpf[$inicioLoop-$i]) * $i;
	}
	$somatoria = $somatoria * 10 % 11;

	if($somatoria == 10)
		$somatoria = 0;
	
	if($somatoria != $digitoVerificador) // verifica se o resultado é o digito verificador
		return false;
	return true;
}

function validarCPF($cpf){
	/*
		Valida se um cpf está no formato correto ou não 
		OBS: formato do $cpf: 000.000.000-00
	*/
	if(strlen($cpf) != 14) return false; // 11 digitos + 2 ponto e 1 traço (mascara do cpf)
	
	// tira a mascara do cpf, deixando apenas os digitos
	$cpfStr = str_replace('-', '', str_replace('.','',$cpf)); 
	
	// checa se o primeiro e o segundo digito verificador estão válidos, se sim o cpf é valido.
	return verificaDigitoCPF($cpfStr,10,$cpfStr[-2]) && verificaDigitoCPF($cpfStr,11,$cpfStr[-1]); 
}