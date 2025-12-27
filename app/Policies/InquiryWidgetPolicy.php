<?php

namespace App\Policies;

use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Chiiya\Roles\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;


class InquiryWidgetPolicy
{
    use HandlesAuthorization;
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view($user)
    {
        return $user->hasPermissionTo('widget.inquiry.view');
    }
}
