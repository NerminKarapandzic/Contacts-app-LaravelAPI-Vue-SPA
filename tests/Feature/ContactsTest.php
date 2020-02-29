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
        $this->post('/api/contacts', ['name' => 'Test name']);

        $this->assertCount(1, Contact::all());
    }
}
