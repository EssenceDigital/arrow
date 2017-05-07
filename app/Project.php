<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * Get the proposal record associated with the project.
     */
    public function proposal()
    {
        return $this->hasOne('App\Proposal');
    }
}