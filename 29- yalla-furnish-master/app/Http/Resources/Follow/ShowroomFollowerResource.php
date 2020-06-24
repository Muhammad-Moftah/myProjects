<?php

namespace App\Http\Resources\Follow;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowroomFollowerResource extends JsonResource
{
    protected $follow;

    public function __construct($follow)
    {
        $this->follow = $follow;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->follow[0]) {
            return [
                'message' => 'You Followed Showroom Successfully',
                'follows_count' => $this->follow[1]
            ];
        }

        return [
            'message' => 'You Unfollowed Showroom Successfully',
            'follows_count' => $this->follow[1]
        ];
    }
}
