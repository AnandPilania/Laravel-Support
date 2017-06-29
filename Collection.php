<?php

namespace AP\Support;

class Collection {
	protected $table;
	protected $column;
	protected $items = [];

	public function __construct(array $items, $column, $table) {
		$this->items = $items;
		$this->column = $column;
		$this->table = $table;
	}

	public function get($key) {
		return array_get($this->items, $key);
	}

	public function set($key, $value) {
		$this->items[$key] = $value;
		$this->persist();
	}

	public function has($key) {
		return array_key_exists($key, $this->items);
	}

	public function all() {
		return $this->items;
	}

	public function merge(array $attributes) {
		$this->items = array_merge(
			$this->items,
			array_only($attributes, array_keys($this->items))
		);

		return $this->persist();
	}

	protected function persist() {
		return $this->table->update([$this->column => $this->items]);
	}

	public function __get($key) {
		if ($this->has($key)) {
			return $this->get($key);
		}

		throw new Exception("The {$key} does not exist!");
	}
}