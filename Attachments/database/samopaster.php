<?PHP
/***
 * Cria uma conexão caso não esteja aberta e retorna um objeto PDO
 **
 * Author: Bruno Alves da Silva
 * Contact: buno.sierra@gmail.com
 **/
function getConnection () 
{
	// Torna a váriavel estática
	static $PDO;
	
	// Informações de conexão
	$data_host = "(Host)";
	$data_user = "(User)";
	$data_pass = "(Password)";
	$data_base = "(Database)";

	// String de Conexão
	$string_pdo = "mysql:dbname=$data_base;host=$data_host;charset=utf8";
	
	// Opções PDO
	$array_options = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
	);

	// Caso já se tenha sido conectado
	if( false === is_null($PDO) ) return $PDO;

	// Abre a conexão
	try {
    	$PDO = new PDO($string_pdo, $data_user, $data_pass, $array_options);
	}
	catch (PDOException $e)
	{
    	exit('Connection failed: ' . $e->getMessage() );
	}
	
	// Charset da conexão
	$PDO->query("SET NAMES 'utf8'");
	$PDO->query('SET character_set_connection=utf8');
	$PDO->query('SET character_set_client=utf8');
	$PDO->query('SET character_set_results=utf8');
	

	// Retorna o Objeto
	return $PDO;
}
