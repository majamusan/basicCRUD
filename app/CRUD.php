<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CRUD extends Model
{
	protected $table = 'crud';
	protected $primaryKey = 'id';
	protected $fillable = ['name', 'surname', 'ID_Number', 'mobile', 'email', 'birth', 'language', 'interests'];
}
