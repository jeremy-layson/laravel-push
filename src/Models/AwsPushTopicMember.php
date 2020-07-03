<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @author Jeremy Layson<jeremy.b.layson@gmail.com>
 * @since 03.07.2020
 * @version 1.0
 */
class AwsPushTopicMember extends Model
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
        'aws_push_topic_id',
        'owner_id',
    ];

    public function topic()
    {
        return $this->belongsTo('App\Models\AwsPushTopic', 'aws_push_topic_id');
    }
    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id');
    }
}
