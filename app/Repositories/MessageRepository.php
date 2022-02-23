<?php

namespace App\Repositories;

use App\Models\Colleague;
use App\Models\Message;
use App\Services\ColleagueApiHandler;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Str;

class MessageRepository
{
    /**
     * @var ColleagueApiHandler
     */
    private ColleagueApiHandler $colleagueApiHandler;

    /**
     * @param ColleagueApiHandler $colleagueApiHandler
     */
    public function __construct(ColleagueApiHandler  $colleagueApiHandler)
    {
        $this->colleagueApiHandler = $colleagueApiHandler;
    }

    /**
     * @param array $data
     * @param string $password
     * @return Message
     */
    public function store(array $data, string $password): Message
    {
        $encrypter = new Encrypter($password);
        return Message::create([
            'colleague_id' => $this->getColleagueId($data['email']),
            'message' => $encrypter->encrypt($data['message'])
        ]);
    }

    /**
     * @param string|null $email
     * @return int|null
     */
    private function getColleagueId(?string $email): ?int
    {
        if ($email === null) {
            return null;
        }

        $colleague = Colleague::query()
            ->where('email', $email)
            ->first();

        if ($colleague !== null) {
            return $colleague->id;
        }

        $colleague = $this->colleagueApiHandler->getColleague($email);

        if ($colleague === null) {
            return null;
        }

        $colleague->save();

        return $colleague->id;
    }


}
