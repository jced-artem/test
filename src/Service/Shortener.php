<?php

namespace App\Service;

/**
 * Class Shortener.
 */
class Shortener
{
	/** @var string  */
	private $list = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

	/**
	 * @param string $list
	 * @return Shortener
	 */
	public function setList(string $list): Shortener
	{
		$this->list = $list;
		return $this;
	}

	/**
	 * @param int $id
	 * @return string
	 */
	public function create(int $id): string
	{
		$result = '';
		$bitness = strlen($this->list);
		while ($id > $bitness) {
			$result .= $this->list[$id % $bitness];
			$id = floor($id / $bitness);
		}
		return $result . $this->list[$id % $bitness];
	}
}