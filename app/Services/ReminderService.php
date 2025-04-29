<?php
namespace App\Services;

use App\Models\Reminder;
use Carbon\Carbon;
class ReminderService {

    public function __construct(protected NotificationService $notificationService){}
    public function all($user,$data =[], $paginated = true){

        $rem = Reminder::where('user_id', '=', $user->id)
        ->when(isset($data['after']),function ($query) use ($data) {
            $query->whereTime('time', '>=', $data['after']);
        })->when(isset($data['before']),function ($query) use ($data) {
            $query->whereTime('time', '<=', $data['before']);
        });

        if($paginated){
            return $rem->paginate();
        }else{
            return $rem->get();
        }
    }
    public function storeReminder($data){

        
        $rem = Reminder::create(array_merge($data,['user_id' => auth()->id()]));

        return $rem;

    }
    public function sendReminders(){
        $reminders =Reminder::where('time', '<=',  Carbon::now())->get();
       foreach($reminders as $reminder){
            $user = $reminder->user;
        $this->notificationService->send($user->fcm_token, [
            __('notif.reminder_title'), __('notif.reminder_body', $reminder->text),
            ['reminder_id' => $reminder->id]
        ]);
        $reminder->delete();
    
       } 
    }
}