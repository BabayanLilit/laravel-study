<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Department
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Employee[] $employees
 * @mixin \Eloquent
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property integer $created_by
 * @property integer $updated_by
 * @method static \Illuminate\Database\Query\Builder|\App\Department whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Department whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Department whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Department whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Department whereUpdatedBy($value)
 */
class Department extends Model
{
    const FIELD_NAME = 'name';

    protected $fillable = [
        self::FIELD_NAME,
    ];

    public static function boot()
    {
        parent::boot();

        static::updating(function($table)  {
            $table->updated_by = Auth::user()->id;
        });

        static::saving(function($table)  {
            $table->created_by = Auth::user()->id;
        });
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }
}
