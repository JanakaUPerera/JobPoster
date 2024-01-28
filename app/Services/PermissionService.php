<?php


namespace App\Services;


use App\Models\Application;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PermissionService
{
    public static function postPermissions()
    {
        return [
            'create' => Auth::user()->can('create',Post::class),
        ];
    }

    public static function applicationPermissions()
    {
        return [
            'create' => Auth::user()->can('create',Application::class),
        ];
    }
}
