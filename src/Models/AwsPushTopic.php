<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @author Jeremy Layson<jeremy.b.layson@gmail.com>
 * @since 03.07.2020
 * @version 1.0
 */
class AwsPushTopic extends Model
{
    use SoftDeletes;
    /**
     * Relationships that gets loaded by default
     */
    protected $with = [];

    /**
     * fillable
     */
    protected $fillable = [
        'arn',
        'name',
        'description',
    ];

    public function members()
    {
        return $this->hasMany('App\Models\AwsPushTopicMember', 'aws_push_topic_id');
    }
}
