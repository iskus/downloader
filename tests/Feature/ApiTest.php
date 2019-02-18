<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use URL;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get('/api/targets');
        $response->assertStatus(200);
    }

    public function testCreateTarget()
    {
        $response = $this->post('/api/targets', [
            'link' => 'https://habrastorage.org/getpro/habr/post_images/299/22b/75c/29922b75cf2c3faf8b3e036c9db49297.gif'
        ]);
        $response->assertStatus(201);
        $response->assertExactJson(
            [
                'id' => 1,
                'status' => 'pending',
                'link' => 'https://habrastorage.org/getpro/habr/post_images/299/22b/75c/29922b75cf2c3faf8b3e036c9db49297.gif'
            ]
        );

        $response = $this->get('/api/targets');
        $response->assertStatus(200);
        $response->assertExactJson(
            [
                [
                    'id' => 1,
                    'link' => 'https://habrastorage.org/getpro/habr/post_images/299/22b/75c/29922b75cf2c3faf8b3e036c9db49297.gif',
                    'status' => 'pending'
                ]
            ]
        );
    }

    public function testCreateTargetErrorEmpty()
    {
        $response = $this->post('/api/targets', [
            'url' => ''
        ]);
        $response->assertStatus(406);
        $response->assertExactJson(
            [
                'errors' => ['The url field is required.'],
            ]
        );
    }

    public function testCreateTargetErrorWrong()
    {
        $response = $this->post('/api/targets', [
            'link' => 'thisisawrongurl'
        ]);
        $response->assertStatus(406);
        $response->assertExactJson(
            [
                'errors' => ['The url format is invalid.'],
            ]
        );
    }

    public function testDownloadTarget()
    {
        $downloadUrl = URL::current() . '/test.txt';

        $response = $this->post('/api/targets', [
            'url' => $downloadUrl
        ]);
        $response->assertStatus(201);
        $contentDecoded = json_decode($response->content());
        $id = $contentDecoded->id;

        $this->refreshApplication();

        $response = $this->get('/api/targets/' . $id . '/download');
        $response->assertStatus(200);
        $this->assertEquals($response->streamedContent(), 'This is a test file');
    }

    public function testDownloadNotExistingTarget()
    {
        $response = $this->get('/api/targets/1000/download');
        $response->assertStatus(404);
        $response->assertExactJson(
            [
                'errors' => 'This target is not found!',
            ]
        );
    }
}
