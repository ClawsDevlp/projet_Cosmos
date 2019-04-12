<?php
final class MyPDO {
	/**
	 * @var MyPDO $pdoInstance Instance unique
	 */
	private static $pdoInstance = null;
	/**
	 * @var string $dsn DSN pour la connexion à la bdd
	 */
	private static $dsn = null;
	/**
	 * @var string $login Nom d'utilisateur pour la connexion à la bdd
	 */
	private static $login = null;
	/**
	 * @var string $password Mot de passe pour la connexion à la bdd
	 */
	private static $password = null;
	/**
	 * @var array $driverOptions Options du pilote de la bdd
	 */
	private static $driverOptions = array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	);

	/**
	 * Constructeur privé pour empêcher de constuire
	 * des instances de MyPDO (inutile)
	 */
	private function __construct() {}

	/**
	 * Getter sur l'instance unique.
	 * L'instance est créée au premier appel et réurilisée aux appels suivants.
	 * @throws Exception si la configuration n'a pas été effectuée.
	 * @return MyPDO instance unique
	 */
	public static function getInstance() {
		if (is_null(self::$pdoInstance)) {
			if (self::hasConfiguration()) {
				self::$pdoInstance = new PDO(
					self::$dsn, 
					self::$login, 
					self::$password,
					self::$driverOptions
				);
			}
			else {
				throw new Exception(__CLASS__ ." : Configuration not set");
			}
		}
		return self::$pdoInstance;
	}

	/**
	 * Configure la connexion à la bdd
	 * @param string $dsn DSN pour la connexion à la bdd
	 * @param string $login Login pour la connexion à la bdd
	 * @param string $password Mot de passe pour la connexion à la bdd
	 * @param array $driverOptions Options du pilote de la bdd
	 */
	public static function setConfiguration($dsn, $login='', $password='', array $driverOptions=array()){
		self::$dsn = $dsn;
		self::$login = $login;
		self::$password = $password;
		self::$driverOptions = $driverOptions + self::$driverOptions;
	}

	/**
	 * Vérifie si la configuration de la connexion à la bdd a été effectuée
	 * @return bool
	 */
	private static function hasConfiguration(){
		return self::$dsn !== null;
	}
}
