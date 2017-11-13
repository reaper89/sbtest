<?php
/**
 * Created by PhpStorm.
 * User: KevinPC
 * Date: 12-11-2017
 * Time: 02:27
 */
namespace Tests\Unit;

use App\Shoe;
use App\User;
use Tests\TestCase;


class ShoesTest extends TestCase
{

    protected $falseAuth = ['Authorization' => 'Bearer JIFOJEWBNgvNgoqbgoG4EWBofgn'];

    public function test_it_returns_the_index_of_shoes()
    {
        $this->actAsApiUser();
        $result = $this->getJson('/api/v1/shoes');
        $cont = json_decode($result->getContent());

        $this->assertObjectHasAttribute('data', $cont);
        $this->assertGreaterThanOrEqual(1, $cont->data);

    }

    public function test_it_returns_a_single_shoe()
    {
        $this->actAsApiUser();
        $result = $this->getJson('/api/v1/shoes/1');
        $cont = json_decode($result->getContent());

        $this->assertObjectHasAttribute('data', $cont);
        $this->assertObjectHasAttribute('Brand', $cont->data);
    }

    public function test_its_returns_a_404_not_found_message_when_a_shoe_is_not_found()
    {
        $this->actAsApiUser();
        $result = $this->getJson('/api/v1/shoes/99999');
        $cont = json_decode($result->getContent());

        $this->assertObjectHasAttribute('error', $cont);
        $this->assertEquals(404, $cont->error->status_code);

    }
    public function test_it_returns_an_unauthorized_error_when_the_wrong_token_is_passed()
    {
        $result = $this->getJson('/api/v1/shoes', $this->falseAuth);
        $cont = json_decode($result->getContent());

        $this->assertObjectHasAttribute('message', $cont);
        $this->assertEquals('Unauthenticated.', $cont->message);

    }

    public function test_it_returns_an_unauthorized_error_when_no_token_is_passed()
    {
        $result = $this->getJson('/api/v1/shoes');
        $cont = json_decode($result->getContent());

        $this->assertObjectHasAttribute('message', $cont);
        $this->assertEquals('Unauthenticated.', $cont->message);
    }

    public function test_it_doesnt_add_shoe_when_parameters_are_incorrect()
    {
        $this->actAsApiUser();
        $shoe1 = ['brand' => 'Nike', 'model' => 'Air', 'size' => '42'];
        $shoe2 = ['brand' => 'Nike', 'model' => 'Air', 'price' => 'testPrice', 'size' => '42'];

        $result1 = $this->postJson('/api/v1/shoes', $shoe1);
        $result2 = $this->postJson('/api/v1/shoes', $shoe2);
        $cont1 = json_decode($result1->getContent());
        $cont2 = json_decode($result2->getContent());

        $this->assertEquals('Invalid parameters', $cont1->error->message);
        $this->assertEquals('Invalid parameters', $cont2->error->message);

    }

    public function test_it_doesnt_add_shoe_when_authentication_is_incorrect()
    {
        $shoe = ['brand' => 'Nike', 'model' => 'Air', 'size' => '42', 'price' => '150'];

        $result = $this->postJson('/api/v1/shoes', $shoe);
        $cont = json_decode($result->getContent());
        $this->assertEquals('Unauthenticated.', $cont->message);

        $shoe = Shoe::where('brand', 'Nike')->get();
        $this->assertEquals(0, count($shoe));
    }

        public function test_it_adds_a_new_shoe()
    {
        $this->actAsApiUser();
        $shoe = ['brand' => 'Nike', 'model' => 'Air', 'size' => '42', 'price' => '150'];

        $result = $this->postJson('/api/v1/shoes', $shoe);
        $cont = json_decode($result->getContent());

        $this->assertEquals('Shoe added!', $cont->data->message);
        $shoe = Shoe::where('brand', 'Nike')->get();
        $this->assertEquals(1, count($shoe));
    }

    public function actAsApiUser()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api');
    }

    public function tearDown(){
        $shoes = Shoe::where('brand', 'Nike')->get();
        foreach($shoes as $shoe){
            $shoe->delete();
        }
        parent::tearDown();

    }

}
