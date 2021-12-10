<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use App\Helpers\Filters\Filterable;

class UserRole extends Model
{
    use HasFactory, Notifiable, Filterable;

    protected $table = 'user_roles';
    protected $primaryKey = 'id';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'role_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public static function FindAccessRoles($user_id){
        return DB::table('roles')
            ->join('user_roles','roles.id','user_roles.role_id')
            ->where('user_roles.user_id',$user_id)
            ->select(
                'roles.name',
                'roles.description'
            )->get();

    }

    public static function FindAccessPermissions($user_id){
        return DB::table('permissions')
            ->join('permission_role','permissions.id','permission_role.permission_id')
            ->join('roles','permission_role.role_id','roles.id')
            ->join('user_roles','roles.id','user_roles.role_id')
            ->where('user_roles.user_id',$user_id)
            ->select(
                'permissions.name',
                'permissions.description'
            )->get();
    }

    public function user() {
        return $this->belongsTo(User::class,"user_id", 'id');
    }

    public function role() {
        return $this->belongsTo(Role::class,"role_id", 'id');
    }

}
