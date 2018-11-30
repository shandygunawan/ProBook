<?php
	class Book {
		private $data = Array();

		public function __get($key) {
			return $this->data[$key];
		}

		public function __set($key, $value) {
			$this->data[$key] = $value;
		}
	}
?>