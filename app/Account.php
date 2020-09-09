<?php

namespace App;

use App\Settings\AccountType;

class Account extends MyModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'logo', 'slugan', 'account_type_id', 'money_format_id'
    ];

    public function getCurrentStatusAttribute()
    {
      return $this->status == 1 ? 'Active' : 'Not Active';
    }

    public function getProfileUrlAttribute()
    {
        return route('accounts.profile', $this->slug);
    }
    public function getLogoMediumAttribute()
    {
        return "/storage/accounts/thumbnail/medium/$this->logo";
    }
    public function getLogoSmallAttribute()
    {
        return "/storage/accounts/thumbnail/small/$this->logo";
    }
    public function getLogoOriginalAttribute()
    {
        return "/storage/accounts/thumbnail/$this->logo";
    }

    protected $appends = [
        'current_status',
        'last_updated',
        'profile_url',
        'logo_small',
        'logo_medium',
        'logo_original',
    ];

    public function scopeJoinAccount($query)
    {
        $accountType = AccountType::where('name', 'Join')->first();
        return $query->where('account_type_id', $accountType->id);
    }

    public  function account_type() {
        return $this->belongsTo("App\Settings\AccountType");
    }

    public  function money_format() {
        return $this->belongsTo("App\Settings\MoneyFormat");
    }

    public  function users() {
        return $this->belongsToMany("App\User", "user_account")->withTimestamps();
    }

    public  function transactions() {
        return $this->hasMany("App\Transaction");
    }
}
