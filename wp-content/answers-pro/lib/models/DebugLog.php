<?php

class CMA_DebugLog {
	
	const DEBUG = 1;
	const PREFIX = '[CMA]';
	
	static function log() {
		
		if (!static::DEBUG) return;
		
		$args = func_get_args();
		$backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
		$file = $backtrace[0]['file'];
		$line = $backtrace[0]['line'];
		$function = $backtrace[1]['function'] . '()';
		$class = (isset($backtrace[1]['class']) ? $backtrace[1]['class'] : '');
		$type = (isset($backtrace[1]['type']) ? $backtrace[1]['type'] : '');
		
		$method = $class . $type . $function;
		
		$msg = static::PREFIX . ' ' . $method . ' in ' . $file . ' ('. $line .') --- ' . implode(' ', array_map(function($arg) {
			if (is_string($arg)) return $arg;
			else if (is_scalar($arg)) {
				ob_start();
				var_dump($arg);
				return ob_get_clean();
			}
			else if (is_object($arg)) return 'instanceof ' . get_class($arg);
			else return print_r($arg, true);
		}, $args));
		
		error_log($msg);
		
	}
	
}