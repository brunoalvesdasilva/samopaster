<?PHP

// GET route Contact
$app->get('/contact.html', function () use ($app) {

	// 
	$samo_message = $app->request()->get('success') == 'true';

    // Home
    $app->render('contact.phtml', array('samo_message' => $samo_message) );

});

// GET route save
$app->post('/contact.html', function () use ($app) {

	// Informações
	$request		= $app->request();
	$conc_name		= $request->post('s_name');
	$conc_email		= $request->post('s_email');
	$conc_message	= $request->post('s_message');
	$conc_create	= date('Y-m-d H:i:s');
	$conc_read		= 'N';


	// Salva as informações
	$PDO = getConnection();

	// Inicia a transação
	$PDO->beginTransaction();
	
	// UTF8
	$PDO->query('SET NAMES UNICODE');

	// Preparação
	$string_sql = "
	INSERT INTO 
		samopaster_contact 
		(conc_name, conc_email, conc_message, conc_create, conc_read)

	VALUES
		(:conc_name, :conc_email, :conc_message, :conc_create, :conc_read)
	";
	$o_prepare = $PDO->prepare($string_sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

	// Popula as informações
	$o_prepare->bindValue(':conc_name', $conc_name);
	$o_prepare->bindValue(':conc_email', $conc_email);
	$o_prepare->bindValue(':conc_message', $conc_message);
	$o_prepare->bindValue(':conc_create', $conc_create);
	$o_prepare->bindValue(':conc_read', $conc_read);

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
	$app->redirect('contact.html?success=true');
});