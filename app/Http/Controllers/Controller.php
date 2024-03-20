<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
// $user = User::find($id)->toArray();
// $file = $avatar->file('avatars');

// if ($user['avatar']) {
//     $filename = $user['avatar'];
//     Storage::disk('local')->delete($filename);
//     $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
//     Storage::disk('local')->put('avatars/' . $filename, file_get_contents($file));
//     $fileurl = 'avatars/' . $filename;
//     $user['avatar'] = $fileurl;
//     return $this->userRepository->update($user, $user['id']);
// }
// $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();



// $fileurl = 'avatars/' . $filename;
// $user['avatar'] = $fileurl;
// return $this->userRepository->update($user, $user['id']);