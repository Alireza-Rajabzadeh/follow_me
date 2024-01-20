<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPage extends Model
{
    use HasFactory;



    /**
     * The roles that belong to the UserPage
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function following()
    {
        return $this->belongsToMany(UserPage::class, 'pages_followers', 'user_page_id', 'follow_page_id');
    }    
    
    /**
     * The roles that belong to the UserPage
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followedBy()
    {
        return $this->belongsToMany(UserPage::class, 'pages_followers', 'follow_page_id', 'user_page_id');
    }


}
