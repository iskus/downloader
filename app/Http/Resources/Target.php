<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Target extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return array
	 */
	public function toArray($request)
	{
		return [
			'id'         => $this->id,
			'link'       => $this->link,
			'status'     => $this->status,
//			'created_at' => $this->created_at,
//			'updated_at' => $this->updated_at,
		];
	}
}
