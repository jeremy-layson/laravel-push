<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @author Jeremy Layson<jeremy.b.layson@gmail.com>
 * @since 03.07.2020
 * @version 1.0
 */
class AwsPushDevice extends Model
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
        'platform',
        'model',
        'os_version',
        'owner_id',
    ];

    /**
     * Override to connect to other tables
     * @return App\Models\AwsPushDevice
     */
    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id');
    }
}
