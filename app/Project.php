<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    /**
     * Get the comments for the project.
     */
    public function comments()
    {
        return $this->hasMany('App\ProjectComment');
    }

    /**
     * Get the proposal record associated with the project.
     */
    public function proposal()
    {
        return $this->hasOne('App\Proposal');
    }

    /**
     * Get the timeline record associated with the project.
     */
    public function timeline()
    {
        return $this->hasOne('App\Timeline');
    }

    /**
     * The users that belong to (are assigned to) the project.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

}
