<?php
/**
 * Created by PhpStorm.
 * User: KevinPC
 * Date: 12-11-2017
 * Time: 14:58
 */

namespace App\Http\Controllers;

use App\Shoe;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\TagsTransformer;

/**
 * Class TagsController
 * @package App\Http\Controllers
 */
class TagsController extends ApiController
{
    protected $tagsTransformer;

    /**
     * TagsController constructor.
     * @param \App\Http\Controllers\TagsTransformer $tagsTransformer
     */
    function __construct(TagsTransformer $tagsTransformer)
    {
        $this->tagsTransformer = $tagsTransformer;
    }

    /**
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id = null)
    {
        $tags = $this->getTags($id);
        return $this->respond(['data' => $this->tagsTransformer->transformCollection($tags->all())]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $tag = Tag::find($id);
        if(! $tag){
            return $this->respondNotFound('Tag not found!');
        }
        return $this->respond(['data' => $this->tagsTransformer->transform($tag)]);

    }
    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getTags($id)
    {
        $tags = $id ? Shoe::findOrFail($id)->tags() : Tag::all();
        return $tags;
    }
}
