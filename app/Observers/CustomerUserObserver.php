<?php

namespace App\Observers;

use App\Models\CustomerUser;
use Illuminate\Support\Facades\Auth;

class CustomerUserObserver
{
    /**
     * Handle the CustomerUser "created" event.
     */
    public function created(CustomerUser $customerUser): void
    {
        //
    }

    public function creating(CustomerUser $customerUser): void
    {
        $customerUser->created_by = Auth::id() ? Auth::id() : $customerUser->created_by;
    }

    /**
     * Handle the CustomerUser "updated" event.
     */
    public function updated(CustomerUser $customerUser): void
    {
        //
    }

    public function updating(CustomerUser $customerUser): void
    {
        if (Auth::check()) {
            $customerUser->updated_by = $customerUser->id;
        }
    }

    /**
     * Handle the CustomerUser "deleted" event.
     */
    public function deleted(CustomerUser $customerUser): void
    {
        //
    }

    public function deleting(CustomerUser $customerUser): void
    {
        $customerUser->updated_by = Auth::id() ? Auth::id() : $customerUser->updated_by;
    }

    /**
     * Handle the CustomerUser "restored" event.
     */
    public function restored(CustomerUser $customerUser): void
    {
        //
    }

    /**
     * Handle the CustomerUser "force deleted" event.
     */
    public function forceDeleted(CustomerUser $customerUser): void
    {
        //
    }
}
