<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    /**
     * Get the project that owns the proposal.
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
