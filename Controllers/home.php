<?PHP
// GET route
$app->get('/', function () use ($app) {

    // Home
    $app->render('home.phtml');

});

// GET route Home
$app->get('/home.html', function () use ($app) {

    // Home
    $app->render('home.phtml');

});

// GET route save
$app->post('/home.html', function () use ($app) {

	// Informações
	$request		= $app->request();
	$code_title 	= $request->post('s_title');
	$code_hash 		= uniqid();
	$code_text		= $request->post('s_text');
	$code_create	= date('Y-m-d H:i:s');
	$code_visible	= 'Y';

	// Salva as informações
	$PDO = getConnection();

	// Inicia a transação
	$PDO->beginTransaction();

	// Preparação
	$string_sql = "
	INSERT INTO 
		samopaster_codes 
		(code_title, code_hash, code_text, code_create, code_visible)

	VALUES
		(:code_title, :code_hash, :code_text, :code_create, :code_visible)
	";
	$o_prepare = $PDO->prepare($string_sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

	// Popula as informações
	$o_prepare->bindValue(':code_title', $code_title);
	$o_prepare->bindValue(':code_hash', $code_hash);
	$o_prepare->bindValue(':code_text', $code_text );
	$o_prepare->bindValue(':code_create', $code_create);
	$o_prepare->bindValue(':code_visible', $code_visible);

	// Salva
	try {
		$o_prepare->execute();
        $PDO->commit();
	}
	catch (PDOException $e)
	{
		// Recupera as informações de erro
		$a_error = $o_prepare->errorInfo();
		$PDO->rollback();

		// Exibe a mensagem de erro
		exit($a_error[2] .' - '. $e->getMessage());
	}

	// Redireciona
	$app->redirect( "{$code_hash}" );
});