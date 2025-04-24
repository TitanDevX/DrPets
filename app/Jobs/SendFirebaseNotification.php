<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;

class SendFirebaseNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $token;
    protected $notif;
    protected $data;

    public function __construct(User $token, array $notif, array $data = [])
    {
        $this->user = $token;
        $this->notif = $notif;
        $this->data = $data;
    }

    public function handle()
    {
        if (!$this->token) {
            return;
        }

        $messaging = Firebase::messaging();

        $message = CloudMessage::new()->toToken( $this->token)
            ->withNotification($this->notif)
            ->withData($this->data);
        $messaging->send($message);
    }
}
