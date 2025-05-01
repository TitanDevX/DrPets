<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatResource;
use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct(protected ChatService $chatService){}

    public function index(){

        $user = auth()->user();

        $chats = $this->chatService->all($user->id);

        return $this->res(['chats' => ChatResource::collection($chats)]);
    }
    public function show($id){
    
        $chat = $this->chatService->getChat($id);
        if(!$chat){
            abort(404);
        }

        $user = auth()->user();
        if($user->cannot('view',$chat)){
            return $this->res([],'You may not access this chat.',403);
        }
        return $this->res(['chat' => ChatResource::make($this->chatService->show($id))]);
    }
    public function destroy($id){
        $chat = $this->chatService->getChat($id);
        if(!$chat){
            abort(404);
        }

        $user = auth()->user();
        if($user->cannot('delete',$chat)){
            return $this->res([],'You may not access this chat.',403);
        }
        $this->chatService->delete($chat);

        return $this->res();
    }
}
