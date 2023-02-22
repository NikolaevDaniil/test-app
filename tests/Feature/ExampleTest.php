<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $test = new UploadedFile(storage_path('app/book1.xlsx'), 'book1.xlsx');

        $response = $this->withHeaders([
                'callback_url' => 'test url',
        ])->post('/', ['file_upload' => $test]);


        $response->assertStatus(200)->assertJson(
            [
                'status' => 'success',
            ]
        );
    }
}
