<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReminderRequest;
use App\Http\Requests\UpdateReminderRequest;
use App\Http\Resources\ReminderResource;
use App\Models\Reminder;
use App\Services\ReminderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReminderController extends Controller
{
    public function __construct(protected ReminderService $reminderService){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $rem = $this->reminderService->all($user, request()->all());

        return $this->res(
            ReminderResource::collection($rem));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReminderRequest $request)
    {
        $data = $request->validated();
        

        $rem =$this->reminderService->storeReminder($data);

        return $this->res(ReminderResource::make($rem));

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $rem = Reminder::find($id);

        Gate::authorize('view',[$rem]);

        return $this->res(ReminderResource::make($rem));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReminderRequest $request, $id)
    {
        $data = $request->validated();

        $rem = Reminder::find($id);
        Gate::authorize('update',[$rem]);

        $rem->update($data);

        return $this->res(ReminderResource::make($rem));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $rem = Reminder::find($id);
        Gate::authorize('delete',[$rem]);

        $rem->delete();

        return $this->res();
    }
}
