<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public $incrementing = true;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstName',
        'surname',
        'email',
        'phoneNumber',
        'address1',
        'address2',
        'city',
        'state',
        'country',
        'postcode'
    ];


    public static $rules = [
        'firstName' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'email' => 'required|string|max:255',
        'phoneNumber' => 'required|integer|max:255',
        'address1' => 'required|string|max:255',
        'address2' => 'nullable|string|max:255',
        'city' => 'required|string|max:255',
        'state' => 'nullable|string|max:255' ,
        'country' => 'required|string|max:255',
        'postcode'=> 'nullable|string|max:255'
    ];
}

// • First Name (string) << Mandatory
// • Surname (string) << Mandatory
// • Email (string) << Mandatory
// • Phone Number (longint) << Mandatory
// • Address 1 (string) << Mandatory
// • Address 2 (optional) (string)
// • City << Mandatory (string)
// • State (optional) (string) << If US is selected it populated US States in the dropdown
// • Country (string) << From dropdown
// • Postcode (optional) (string)
