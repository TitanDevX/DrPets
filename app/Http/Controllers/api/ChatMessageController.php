<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChatMessageRequest;
use App\Http\Resources\ChatMessageResource;
use App\Services\ChatMessageService;
use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatMessageController extends Controller
{

    public function __construct(protected ChatMessageService $chatMessageService,
    protected ChatService $chatService){}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(!$request->has('chat_id')){
            return $this->res([],'chat_id is required.',400);
        }
        $chatId = $request->get('chat_id');
        $user = auth()->user();
        $chat = $this->chatService->getChat($chatId);
        if(!$chat){
           return $this->res([],'Invalid chat id.',403);
        }

        if($user->cannot('view',$chat)){
            return $this->res([],'You may not access this chat.',403);
        }
    
        return $this->res(['messages' =>
         ChatMessageResource::collection($this->chatMessageService->all($request->all()))]);
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChatMessageRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user();
        $chat = $this->chatService->getChat($data['chat_id']);

        if($user->cannot('update',$chat)){
            return $this->res([],'You may not access this chat.',403);
        }

        $msg = $this->chatMessageService->store($data);

        return $this->res(['chat_message' => ChatMessageResource::make($msg)],'Message sent.');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
