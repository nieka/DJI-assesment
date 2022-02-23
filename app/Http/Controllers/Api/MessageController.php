<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\JsonResponse;

class MessageController extends Controller
{
    /**
     * @param Request $request
     * @param MessageRepository $messageRepository
     * @return JsonResponse
     */
    public function store(Request $request, MessageRepository $messageRepository): JsonResponse
    {
        $password = Str::random(16);
        $message = $messageRepository->store($request->all(), $password);

        return response()->json([
            'password' => $password,
            'uuid' => $message->id
        ]);
    }

    /**
     * @param Request $request
     * @param Message $message
     * @return JsonResponse
     */
    public function getMessage(Request $request, Message $message): JsonResponse
    {
        return response()->json([
            'message' => $message->getDecryptedMessage($request->password),
        ]);
    }
}
