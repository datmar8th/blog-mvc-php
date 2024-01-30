<?php
class main_repository {
	private static $instance = [];

	public static function getInstance() {
		$called_class = get_called_class();
		if (!array_key_exists($called_class, self::$instance)) {
			self::$instance[$called_class] = new $called_class();
		}
		return self::$instance[$called_class];
	}
}