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
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;


class TagsTest extends TestCase
{


    protected $falseAuth = ['Authorization' => 'Bearer JIFOJEWBNgvNgoqbgoG4EWBofgn', 'Accept' => 'application/json'];

    public function test_it_returns_a_single_tag()
    {
        $this->actAsApiUser();
        $result = $this->getJson('/api/v1/tags/1');
        $cont = json_decode($result->getContent());

        $this->assertObjectHasAttribute('data', $cont);
        $this->assertObjectHasAttribute('tag_name', $cont->data);
    }

    public function test_its_returns_a_404_not_found_message_when_a_tag_is_not_found()
    {
        $this->actAsApiUser();
        $result = $this->getJson('/api/v1/tags/9999999999');
        $cont = json_decode($result->getContent());

        $this->assertObjectHasAttribute('error', $cont);
        $this->assertEquals(404, $cont->error->status_code);

    }

    public function test_it_gets_the_tags_for_a_specific_shoe()
    {
        $this->actAsApiUser();
        $shoe = Shoe::first();
        $result = $this->getJson('/api/v1/shoes/'.$shoe->id.'/tags');
        $cont = json_decode($result->getContent());

        $this->assertObjectHasAttribute('data', $cont);

    }

    public function actAsApiUser()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api');
    }

}
