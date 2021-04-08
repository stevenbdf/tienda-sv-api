<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'name' => $this->name,
            'img' => $this->img,
            'description' => $this->description,
            'regular_price' => $this->regular_price,
            'sale_price' => $this->sale_price,
            'stock_qty' => $this->stock_qty,
        ];
    }
}
