<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model {

    protected $fillable = ['title', 'body'];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function acceptBestAnswer($answer)
    {
        $this->best_answer_id = $answer;
        $this->save();
    }

    /**
     * Mutators
     *
     * @param [type] $value
     * @return void
     */
    public function setTitleAttribute($value) 
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    /**
     * Accessors
     *
     * @return void
     */
    public function getUrlAttribute()
    {
        return route("questions.show", $this->slug);
    }

    public function getCreatedDateAttribute() 
    {
        return $this->created_at->diffForHumans();
    } 
    
    public function getStatusAttribute()
    {
        if($this->answers_count > 0) {
            if($this->best_answered_id) {
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function getBodyHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }
    
}
