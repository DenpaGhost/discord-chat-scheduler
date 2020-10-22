<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Task
 * @package App\Models
 *
 * @property-read string $id
 * @property-read int $user_id
 * @property string $message
 * @property $executes_in
 * @property ?string $repeat
 */
class Task extends Model
{
    use HasFactory;
}
