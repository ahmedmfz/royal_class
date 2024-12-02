<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;


class GlobalCollection extends ResourceCollection
{
    public $resourceName;
    
    public function __construct($resource , $resourceName)
    {
        parent::__construct($resource);
        $this->resourceName = 'App\Http\Resources\\' . ucfirst($resourceName) . 'Resource';
    }
    
    public function paginationInformation($request, $paginated, $default)
    {
        unset($default['links']);
        unset($default['meta']);
        return $default;
    }
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
    */
    public function toArray($request)
    {
        return [
            'data'                => $this->resourceName::collection($this->collection),
            'pagination'          => [
                "current_page"    => $this->currentPage(),
                "total_pages"     => $this->lastPage(),
                "per_page"        => $this->perPage(),
                "total_items"     => $this->total(),
            ],
        ];
    }

}
