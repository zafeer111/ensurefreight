<?php

namespace App\Observers;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;


class CustomerObserver
{
    /**
     * Handle the Customer "created" event.
     */
    public function created(Customer $customer): void
    {
        //
    }
    public function creating(Customer $customer): void
    {
        $customer->created_by = Auth::id() ? Auth::id() : $customer->created_by;
    }

    /**
     * Handle the Customer "updated" event.
     */
    public function updated(Customer $customer): void
    {
        //
    
    }
    public function updating(Customer $customer): void
    {
        $customer->updated_by = Auth::id() ? Auth::id() : $customer->updated_by;
    }

    /**
     * Handle the Customer "deleted" event.
     */
    public function deleted(Customer $customer): void
    {
        //
    }

    public function deleting(Customer $customer): void
    {
        $customer->updated_by = Auth::id() ? Auth::id() : $customer->updated_by;
    }

    /**
     * Handle the Customer "restored" event.
     */
    public function restored(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "force deleted" event.
     */
    public function forceDeleted(Customer $customer): void
    {
        //
    }
}
