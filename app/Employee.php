<?php

namespace App;

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
    const FIELD_NAME = 'name';
    const FIELD_LAST_NAME = 'lastname';
    const FIELD_PATRONYMIC = 'patronymic';
    const FIELD_GENDER = 'gender';

    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_LAST_NAME,
        self::FIELD_PATRONYMIC,
        self::FIELD_GENDER
    ];

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }
}
