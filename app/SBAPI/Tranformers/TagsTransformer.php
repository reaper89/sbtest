<?php
/**
 * Created by PhpStorm.
 * User: KevinPC
 * Date: 12-11-2017
 * Time: 15:28
 */

namespace App\Http\Controllers;
use Transformer;


class TagsTransformer extends Transformer
{
    /**
     * @param $tag
     * @return array
     */
    public function transform($tag)
    {
        return [
            'tag_name' => $tag['name'],
        ];
    }
}