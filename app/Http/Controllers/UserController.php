<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePFPRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;
use Storage;
class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function storeFcmToken($request)
    {
        $data = Validator::make($request->all, [
            'fcm_token' => 'required'
        ])->valiated();
        $user = auth()->user();
        $this->userService->setFcmToken($user, $data);

        return $this->res();

    }

    public function showPfp($userId){
        $user = $this->userService->getUser($userId);
        $url = $this->userService->getPfp($user);

        return $this->res(['pfp' => $url]);

    }
    public function indexPfp(){
        return $this->showPfp(auth()->user()->id);
    }
    public function updatePfp(UpdatePFPRequest $request)
    {

        $user = auth()->user();
        $path = $request->file('pfp')->store('pfp', 'public');

        // Optionally delete old photo
        if ($user->pfp_path) {
            Storage::disk('public')->delete(auth()->user()->pfp_path);
        }

        $user->update([
            'pfp_path' => $path
        ]);

        return $this->res([], 'Profile picture updated.');
    }

    public function deletePfp(){
        $user = auth()->user();
        if ($user->pfp_path) {
            Storage::disk('public')->delete(auth()->user()->profile_photo_path);
            $user->update([
                'pfp_path' => null
            ]);
            
        }
     
        return $this->res([],'Pfp deteled successfully');
    }
}