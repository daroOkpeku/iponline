<?php

namespace App\Http\Resources;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class purchaseresource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "ref"=>$this->ref,
             "title"=>Order::where(["id"=>$this->orderid])->first()->title,
             "category"=>Order::where(["id"=>$this->orderid])->first()->category,
             "price"=>Order::where(["id"=>$this->orderid])->first()->price,
             "image"=>Order::where(["id"=>$this->orderid])->first()->image,
             "username"=>User::where(['id'=>$this->userid])->first()->name,
             "email"=>User::where(['id'=>$this->userid])->first()->email,
            "status"=>$this->status
        ];
    }
}
