<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Contact;

class ContactsTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function ContactStore()
    {
        $this->withoutExceptionHandling();
        $this->post('/api/contacts', $this->data());

            $contact = Contact::first();

        $this->assertEquals('Test name', $contact->name);
        $this->assertEquals('test@email.com',$contact->email);
        $this->assertEquals('01/05/1996',$contact->birthday);
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

    private function data()
    {
        return array(
            'name' => 'Test name',
            'email' => 'test@email.com',
            'birthday' => '01/05/1996',
            'company' => 'ABC string'
        );
    }
}
