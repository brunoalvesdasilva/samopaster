<?PHP

// GET route Home
$app->get('/:code_hash', function ($code_hash) use ($app) {

	// Salva as informações
	$PDO = getConnection();

	// Preparação
	$string_sql = "
	SELECT
		code.code_title,
		code.code_text,
		code.code_create
		
	FROM
		samopaster_codes code 
		
	WHERE
		code.code_visible = 'Y'
		AND
		code.code_hash = :code_hash
		
	LIMIT 1
	";
	$o_prepare = $PDO->prepare($string_sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

	// Popula as informações e executa
	$o_prepare->bindValue(':code_hash', $code_hash);
	$o_prepare->execute();
	
	// Recupera as informações
	$o_informations = $o_prepare->fetchObject();

    // Mostra o código
	if( $o_informations )
		$app->render('code.phtml', array('o_informations'=>$o_informations) );
	else
		$app->render('error.phtml');
		
	
})->conditions(array('code_hash' => '[a-z0-9]{13,}'));
