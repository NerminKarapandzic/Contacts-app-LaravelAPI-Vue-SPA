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
        $this->post('/api/contacts', [
            'name' => 'Test name',
            'email' => 'test@email.com',
            'birthday' => '01/05/1996',
            'company' => 'ABC string'
            ]);

            $contact = Contact::first();

        $this->assertEquals('Test name', $contact->name);
        $this->assertEquals('test@email.com',$contact->email);
        $this->assertEquals('01/05/1996',$contact->birthday);
        $this->assertEquals('ABC string', $contact->company);

    }

    /** @test */
    public function a_name_is_required()
    {
        $response = $this->post('/api/contacts', [
            'email' => 'test@email.com',
            'birthday' => '01/05/1996',
            'company' => 'ABC string'
            ]);

        $response->assertSessionHasErrors('name');
        $this->assertCount(0,Contact::all());
    }

    /** @test */
    public function email_is_required()
    {
        $response = $this->post('/api/contacts', [
            'name' => 'Test Name',
            'birthday' => '01/05/1996',
            'company' => 'ABC string'
            ]);

        $response->assertSessionHasErrors('email');
        $this->assertCount(0,Contact::all());
    }
}
