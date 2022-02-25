<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Message;
use App\Repositories\MessageRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    /**
     * @return Renderable
     */
    public function create(): Renderable
    {
        return view('create');
    }


    /**
     * @param Message $message
     * @return Renderable
     */
    public function show(Message $message): Renderable
    {
        return view('show')
            ->with([
                'message' => $message
            ]);
    }
}
