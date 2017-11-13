<?php

/**
 * Created by PhpStorm.
 * User: KevinPC
 * Date: 12-11-2017
 * Time: 02:44
 */
class ShoeTransformer extends Transformer
{
    /**
     * @param $item
     * @return array
     */
    public function transform($item)
    {
        return [
            'Brand' => $item['brand'],
            'Model' => ucfirst($item['model']),
            'Size' => $item['size'],
            'Price' => (double) $item['price'],
        ];
    }

}