<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Contact;
use App\User;
use Carbon\Carbon;

class ContactsTest extends TestCase
{
    use RefreshDatabase;
    protected $user;
    protected function setup() : void
    {
        parent::setup();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function user_must_be_authenticated()
    {
        $response = $this->post('/api/contacts', array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0,Contact::all());

    }

    /** @test */
    public function ContactStore()
    {
        $user = factory(User::class)->create();

        $this->post('/api/contacts', $this->data());

        $contact = Contact::first();

        $this->assertEquals('Test name', $contact->name);
        $this->assertEquals('test@email.com',$contact->email);
        $this->assertEquals('ABC string', $contact->company);

    }

    /** @test */
    public function required_fields()
    {
        collect(['name','email','birthday','company'])
        ->each(function($field){
            $response = $this->post('/api/contacts',array_merge($this->data(), [$field => '']));

            $response->assertSessionHasErrors($field);
            $this->assertCount(0,Contact::all());
        });
    }

    /** @test */
    public function must_be_email()
    {
        $response = $this->post('/api/contacts',array_merge($this->data(), ['email' => 'NOT AN EMAIL']));

        $response->assertSessionHasErrors('email');
        $this->assertCount(0,Contact::all());
    }

    /** @test */
    public function date_is_date()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/api/contacts',$this->data());

        $this->assertCount(1,Contact::all());
        $this->assertInstanceOf(Carbon::class,Contact::first()->birthday);
        $this->assertEquals('01-05-1996',Contact::first()->birthday->format('d-m-Y'));
    }

    /** @test */
    public function a_contact_can_be_retrieved()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);

        $response = $this->get('/api/contacts/'. $contact->id . '?api_token=' . $this->user->api_token);

        $response->assertJson([
            'data' => [
                'name' => $contact->name,
                'email' => $contact->email,
                'birthday' => $contact->birthday->format('d-m-Y'),
                'company' => $contact->company
            ]
        ]);
    }

    /** @test */
    public function contacts_belong_to_user()
    {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $contact = factory(Contact::class)->create(['user_id' => $user->id]);
        $contact2 = factory(Contact::class)->create(['user_id' => $user2->id]);

        $response = $this->get('/api/contacts?api_token='.$user->api_token);

        $response->assertJsonCount(1)->assertJson([
            'data' => [
                ['contact_id' => $contact->id]
            ]
        ]);
    }

    /** @test */
    public function a_contact_can_be_patched()
    {
        $this->withoutExceptionHandling();
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);

        $response = $this->patch('/api/contacts/'.$contact->id, $this->data());

        $contact = $contact->fresh();

        $this->assertEquals('Test name', $contact->name);
        $this->assertEquals('test@email.com',$contact->email);
        $this->assertEquals('ABC string', $contact->company);
    }

    /** @test */
    public function a_contact_can_be_deleted()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);
        
        $response = $this->delete('/api/contacts/'. $contact->id, ['api_token'  => $this->user->api_token]);  

        $this->assertCount(0,Contact::all());
    }

    private function data()
    {
        return array(
            'name' => 'Test name',
            'email' => 'test@email.com',
            'birthday' => '05/01/1996',
            'company' => 'ABC string',
            'api_token' => $this->user->api_token
        );
    }
}
