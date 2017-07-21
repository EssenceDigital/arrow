<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    /**
     * Get the work jobs for the timesheet.
     */
    public function workJobs()
    {
        return $this->hasMany('App\WorkJob');
    }

    /**
     * Get the travel jobs for the timesheet.
     */
    public function travelJobs()
    {
        return $this->hasMany('App\TravelJob');
    }    

    /**
     * Get the equipment rentals for the timesheet.
     */
    public function equipmentRentals()
    {
        return $this->hasMany('App\EquipmentRental');
    }    

    /**
     * Get the other costs for the timesheet.
     */
    public function otherCosts()
    {
        return $this->hasMany('App\OtherCost');
    }    
}
