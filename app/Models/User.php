<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWallets;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable implements Wallet,MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasApiTokens,HasWallet, HasWallets;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active_session'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    function data(){
        return $this->hasOne(DataUser::class);
    }
    function isSupplier(){
        return $this->supplier->count();
    }
    function isAffiliator(){
        // return $this->supplier->exists();
    }
    function supplier(){
        return $this->hasOne(Supplier::class);
    }
    function affiliator(){
        // return $this->hasOne(Supplier::class);
    }
    function activeToken(){
        return $this->tokens->where('expires_at','==',null)->sortByDesc('id')->first();
    }
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function cart()
    {
        return $this->belongsToMany(Product::class, 'carts')
            ->withPivot(['quantity', 'saved_for_later'])
            ->withTimestamps()
            ->using(Cart::class);
    }

    public function whishlist()
    {
        return $this->belongsToMany(Product::class, 'whishlists')
            ->withTimestamps()
            ->using(Whishlist::class);
    }
    public function isAdmin()
    {
        return $this->role =='admin';
    }
    public function scopeMember($query)
    {
        return $query->where('role','member');
    }
    public function isMember()
    {
        return $this->role =='member';
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
