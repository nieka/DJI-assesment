<?php

namespace App\Models;

use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Str;

class Message extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'message',
        'colleague_id'
    ];

    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Str::uuid());
        });
    }

    /**
     * @param string $password
     * @return string
     */
    public function getDecryptedMessage(string $password): string
    {
        try {
            $encrypter = new Encrypter($password);
            return $encrypter->decrypt($this->message);
        }
        catch (Exception $exception) {
            abort('401');
        }
    }
}
