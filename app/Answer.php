<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    use VotableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['body', 'user_id'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['created_date', 'body_html', 'is_best'];

    /**
     * Relationships
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Accessors
     */

    public function getBodyHtmlAttribute()
    {
        return clean(\Parsedown::instance()->text($this->body));
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        return $this->isBest() ? 'vote-accepted' : '';
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

    /**
     * Methods
     */

    public function isBest()
    {
        return $this->id === $this->question->best_answer_id;
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($answer) {
            $answer->question->increment('answers_count');
        });

        static::deleted(function ($answer) {
            $question = $answer->question;
            $question->decrement('answers_count');

            if ($question->best_answer_id === $answer->id) {
                $question->best_answer_id = null;
                $question->save();
            }
        });
    }
}
