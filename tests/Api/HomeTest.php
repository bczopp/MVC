<?php

namespace Tornado\Tests\Api;

use PHPUnit\Framework\TestCase;

class HomeTest extends TestCase
{
    public function testShowAll(): void
    {
        $ch = curl_init(); // Initialize cURL

        curl_setopt($ch, CURLOPT_URL, "http://localhost:8080/home");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string

        $response = curl_exec($ch); // Execute the request
        curl_close($ch); // Close the handle

        $expectation = "<h1>Benutzerliste</h1>
<ul>
    <li>
            <ul>user1</ul>
            <ul>user1@example.com</ul>
    </li>
    <li>
            <ul>user2</ul>
            <ul>user2@example.com</ul>
    </li>
</ul>
";
        $this->assertEquals($expectation, $response);
    }
}