<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use App\Repository\MessageRepository;

class MessageRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * /messages [GET]
     * 200
     */
    public function testShouldGetMessages()
    {
        $repository = new MessageRepository();

        $result = $repository->index();

        $this->assertArrayNotHasKey(
            'error',
            json_decode($result->content(), true),
        );
    }
}
