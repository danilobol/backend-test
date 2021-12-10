<?php

namespace App\Models;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Helpers\Filters\Filterable;

class Role extends Model
{
    use HasFactory, Notifiable, SoftDeletes, Filterable;

    protected $table = 'roles';
    protected $primaryKey = 'id';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'description'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function addPermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', '=', $permission)->firstOrFail();
        }
        if ($this->existPermission($permission)) {
            return;
        }
        return $this->permissions()->attach($permission);
    }

    public function existPermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', '=', $permission)->firstOrFail();
        }
        return (boolean)$this->permissions()->find($permission->id);
    }

    public function removePermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', '=', $permission)->firstOrFail();
        }
        return $this->permissions()->detach($permission);
    }
}
