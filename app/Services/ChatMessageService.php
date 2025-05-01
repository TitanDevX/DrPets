<?php

namespace App\Services;

use App\Models\ChatMessage;


class ChatMessageService
{

    public function all($data,$withes = [], $paginated= true){

        $msgs = ChatMessage::where('chat_id', '=', $data['chat_id'])->with($withes);

        if($paginated){
            return $msgs->paginate();
        }else{
            return $msgs->get();
        }

    }

    public function store($data){

        $msg = ChatMessage::create($data);

        // TODO notify provider.
        return $msg;

    }
}