<?php
	header('Access-Control-Allow-Origin: *');
	$ok=1;
	if(!isset($_POST['sourceCode']))$ok=0;
	if(!isset($_POST['language']))$ok=0;
	
	if(!isset($_POST['expectedOutput']))$ok=0;
	

	$response = array();

	if($ok==0){
		$response['error'] = "all parameter are not correct.";
	}

	else{

		$data = array();
		$data['sourceCode']=base64_decode($_POST['sourceCode']);
		$data['input']=isset($_POST['input'])?base64_decode($_POST['input']):"";
		$data['expectedOutput']=base64_decode($_POST['expectedOutput']);
		$data['timeLimit']=isset($_POST['timeLimit'])?$_POST['timeLimit']:2;
		$data['language']=$_POST['language'];

		$data['timeLimit'] = min($data['timeLimit'],5);
		if(trim($data['input'])=="")$data['timeLimit']=1;//for infinite loop problem


		include "compiler/compiler.php";
		include "compiler/cpp.php";
		$CompilerEnjin = new CompilerEnjin($data);
		$CompilerEnjin->compile();
		$response = $CompilerEnjin->getData();
	}

	$response = json_encode($response,true);
	echo "$response";

?>
