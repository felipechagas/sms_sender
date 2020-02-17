<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Repository\MessageRepositoryInterface;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Response;

class MessageControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * /messages [GET]
     * 200
     */
    public function testShouldGetMessages()
    {
        $data = [
            'body' => 'Teste',
            'status' => 'delivered',
        ];

        $mockRepository = $this->createMock(MessageRepositoryInterface::class);
        $mockRepository->method("index")->willReturn($data);

        $mockRequest = new \Illuminate\Http\Request();
        $mockRequest->setMethod('GET');
        $mockRequest->request->add($data);

        $messageController = new MessageController($mockRepository);

        $result = $messageController->index($mockRequest);

        $this->assertEquals(
            $data,
            $result,
        );
    }

    /**
     * /messages/id [GET]
     * 200
     */
    public function testShouldGetMessage()
    {
        $data = [
            'id' => 1,
            'body' => 'Teste',
            'status' => 'delivered',
            'restaurant_id' => 1,
            'phone_number' => '+8898837970000',
            'type' => 'before',
            'created_at' => "0",
            'updated_at' => "0"
        ];

        $mockRepository = $this->createMock(MessageRepositoryInterface::class);
        $mockRepository->method("findOrFail")->willReturn($data);

        $messageController = new MessageController($mockRepository);

        $result = $messageController->show(3);

        $this->assertEquals(
            $data,
            $result,
        );
    }

    /**
     * /messages [POST]
     * 201
     */
    public function testShouldPostMessage()
    {
        $data = [
            'body' => 'Teste',
            'status' => 'delivered',
            'restaurant_id' => 1,
            'phone_number' => '+8898837970000',
            'type' => 'before',
        ];

        $mockRequest = new \Illuminate\Http\Request();
        $mockRequest->setMethod('POST');
        $mockRequest->request->add($data);

        $mockRepository = $this->createMock(MessageRepositoryInterface::class);
        $mockRepository->method("create")->willReturn($data);

        $messageController = new MessageController($mockRepository);

        $result = $messageController->store($mockRequest);

        $this->assertEquals(
            $data,
            $result,
        );
    }

    /**
     * /messages/id [PATCH/PUT]
     * 200
     */
    public function testShouldPatchMessage()
    {
        $data = [
            'body' => 'Teste',
            'status' => 'delivered',
            'type' => 'before',
        ];

        $mockRequest = new \Illuminate\Http\Request();
        $mockRequest->setMethod('PATCH');
        $mockRequest->request->add($data);

        $mockRepository = $this->createMock(MessageRepositoryInterface::class);
        $mockRepository->method("update")->willReturn($data);

        $messageController = new MessageController($mockRepository);

        $result = $messageController->update($mockRequest, 1);

        $this->assertEquals(
            $data,
            $result,
        );
    }

    /**
     * /messages/id [PATCH/PUT]
     * 422
     */
    public function testPatchShouldReturnEmptyEntity()
    {
        $data = [];

        $mockRequest = new \Illuminate\Http\Request();
        $mockRequest->setMethod('PATCH');
        $mockRequest->request->add($data);

        $mockRepository = $this->createMock(MessageRepositoryInterface::class);
        $mockRepository->method("update")->willReturn($data);

        $messageController = new MessageController($mockRepository);

        $result = $messageController->update($mockRequest, 1);

        $this->assertEquals(
            $data,
            $result,
        );
    }

    /**
     * /messages/id [DELETE]
     * 200
     */
    public function testShouldDeleteMessage()
    {
        $data = [
            'id' => 1,
            'body' => 'Teste',
            'status' => 'delivered',
            'restaurant_id' => 1,
            'phone_number' => '+8898837970000',
            'type' => 'before',
            'created_at' => "0",
            'updated_at' => "0"
        ];

        $mockRepository = $this->createMock(MessageRepositoryInterface::class);
        $mockRepository->method("delete")->willReturn($data);

        $messageController = new MessageController($mockRepository);

        $result = $messageController->destroy(3);

        $this->assertEquals(
            $data,
            $result,
        );
    }
}
