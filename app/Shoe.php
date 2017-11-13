<?php
/**
 * Created by PhpStorm.
 * User: KevinPC
 * Date: 12-11-2017
 * Time: 02:27
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shoe extends Model
{
    protected $fillable = ['brand', 'model', 'size', 'price'];

    /**
     * @return mixed
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag')->getResults();
    }
}
