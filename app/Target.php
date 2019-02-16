<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
	protected $fillable = [
		'status',
		'link',
	];

	public $statuses = [
		'pending',
		'downloading',
		'complete',
		'error',
	];

	public function __call($method, $parameters)
	{
		if (in_array($method, $this->statuses)) {
			return $this->update(['status' => $method]);
		}

		return parent::__call($method, $parameters);
	}

	public function status()
	{
		return ucfirst($this->status);
	}

	public function filename(): string
	{
		$pathInfo = pathinfo($this->link);
		$extension = $pathInfo['extension'];
		$fileName = 'target_' . $this->id;
		if($extension){
			$fileName .= '.' . $extension;
		}
		return $fileName;
	}

	public function filePath()
	{
		return 'downloads/'.$this->filename();
	}

	public function completed()
	{
		return 'complete' === $this->status;
	}
}