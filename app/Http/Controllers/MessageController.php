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
    public function create(): Renderable
    {
        return view('create');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        return view('show')
            ->with([
                'message' => $message
            ]);
    }
}
