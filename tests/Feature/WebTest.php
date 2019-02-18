<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use URL;

class WebTest extends TestCase
{
	use RefreshDatabase;

	public function testIndex()
	{
		$response = $this->get('/');
		$response->assertStatus(200);
	}

	public function testDownloadTarget()
	{
		$downloadUrl = URL::current().'/test.txt';

		$response = $this->post(
			'/targets',
			[
				'link' => $downloadUrl,
			]
		);
		$response->assertStatus(302);
		$response->assertRedirect('/targets');

		$this->refreshApplication();

		$response = $this->get('/targets/1/download');
		$response->assertStatus(200);
		$this->assertEquals($response->streamedContent(), 'test');
	}

	public function testDownloadNoFileTarget()
	{
		$response = $this->get('/targets/999/download');
		$response->assertStatus(404);
	}

	public function testCreateTarget()
	{
		$response = $this->get('/targets/add');
		$response->assertStatus(200);

		$response = $this->post(
			'/targets',
			[
				'link' => 'http://codear.ru/',
			]
		);
		$response->assertStatus(302);
		$response->assertRedirect('/targets');
	}

	public function testCreateTargetBugEmpty()
	{
		$response = $this->post(
			'/targets',
			[
				'link' => '',
			]
		);
		$response->assertStatus(302); //redirect with error
		$response->assertRedirect('/targets/add');
	}

	public function testCreateTargetBugWrong()
	{
		$response = $this->post(
			'/targets',
			[
				'link' => 'this_is_wrong_link',
			]
		);
		$response->assertStatus(302);
		$response->assertRedirect('/targets/add');
	}

}
