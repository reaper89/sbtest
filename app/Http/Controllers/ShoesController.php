<?php
/**
 * Created by PhpStorm.
 * User: KevinPC
 * Date: 12-11-2017
 * Time: 02:38
 */

namespace App\Http\Controllers;

use App\Shoe;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use ShoeTransformer;

/**
 * Class ShoesController
 * @package App\Http\Controllers
 */
class ShoesController extends ApiController
{

    /**
     * @var ShoeTransformer
     */
    private $shoeTransformer;

    /**
     * ShoesController constructor.
     * @param ShoeTransformer $shoeTransformer
     */
    public function __construct(ShoeTransformer $shoeTransformer)
    {
        $this->shoeTransformer = $shoeTransformer;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $limit = 5;
        if ($request->input('limit') && $request->input('limit') < 1000){
            $limit = $request->input('limit');
        }

        $shoes = Shoe::paginate($limit);

        return $this->respondWithPaginator($shoes, [
            'data' => $this->shoeTransformer->transformCollection($shoes->all())
        ]);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $shoe = Shoe::find($id);

        if(!$shoe){
            return $this->respondNotFound('Shoe not found.');
        }

        return $this->respond(['data' => $this->shoeTransformer->transform($shoe)]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (!$request->input('model') or !$request->input('brand') or !$request->input('price')){
            return $this->respondInvalid();
        }

        Shoe::create($request->all());

        return $this->respond(['data' => ['message' => 'Shoe added.']]);
    }

    public function destroy($id)
    {
        $shoe = Shoe::find($id);

        if(!$shoe){
            return $this->respondNotFound('Shoe not found!');
        }
        $shoe->delete();
        return $this->respond(['data' => ['message' => 'Shoe removed.']]);
    }


}
