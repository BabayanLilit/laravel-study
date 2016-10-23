<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Employee
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Department[] $departments
 * @mixin \Eloquent
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property string $lastname
 * @property string $patronymic
 * @property string $gender
 * @property integer $created_by
 * @property integer $updated_by
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee wherePatronymic($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereUpdatedBy($value)
 */
class Employee extends Model
{
    const GENDER_MAN = 'm';
    const GENDER_WOMAN = 'w';

    protected $fillable = [
        'name',
        'lastname',
        'patronymic',
        'gender',
        'pay'
    ];

    public static function boot()
    {
        parent::boot();

        if (Auth::user()) {
            static::updating(function($table)  {
                $table->updated_by = Auth::user()->id;
            });

            static::saving(function($table)  {
                $table->created_by = Auth::user()->id;
            });
        }
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function getDepartmentsNames()
    {
        return implode(', ', $this->departments->pluck('name')->toArray());
    }

    public function getGenderLabel()
    {
        return $this->getGenderLabels()[$this->gender] ?: '';
    }

    protected static function getGenderLabels()
    {
        return [
            static::GENDER_MAN => 'Мужской',
            static::GENDER_WOMAN => 'Женский',
        ];
    }
}
