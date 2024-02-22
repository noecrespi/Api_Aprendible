<?php

namespace Tests;


use Illuminate\Testing\TestResponse;


trait MakesJsonApiRequests
{
    public function json($method, $uri, array $data = [], array $headers = [], $options = 0 ): TestResponse
    {
        $headers['accept'] = 'application/vnd.api+json';

        return parent::json($method, $uri, $data, $headers);
    }
    
    public function getJson($uri, array $headers = [],  $options = 0 )
    {
        $headers['accept'] = 'application/vnd.api+json';
        return $this->json('GET', $uri, [], $headers);
    }

    public function postJson($uri, array $data = [], array $headers = [],  $options = 0 ): TestResponse
    {
        $headers['content-type'] = 'application/vnd.api+json';

        return parent::postJson($uri, $data, $headers);
    }

    public function patchJson($uri, array $data = [], array $headers = [],  $options = 0 ): TestResponse
    {
        $headers['content-type'] = 'application/vnd.api+json';

        return parent::patchJson($uri, $data, $headers);
    }

}