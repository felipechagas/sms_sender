<?php

namespace App\Repository;

interface MessageRepositoryInterface
{
    public function index($query);
    public function checkScheduledSms();
    public function findOrFail($message);
    public function create($query);
    public function update($query, $message);
    public function delete($message);
}
