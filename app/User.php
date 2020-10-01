<?php

namespace App;

use App\Models\Bio;
use App\Models\Favorit;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\QnA;
use App\Models\SocialProvider;
use App\Models\Ulasan;
use App\Models\Alamat;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function scopeByActivationColumns(Builder $builder, $useremail, $verifyToken)
    {
        return $builder->where('email', $useremail)->orwhere('username', $useremail)
            ->where('verifyToken', $verifyToken);
    }

    public function socialProviders()
    {
        return $this->hasMany(SocialProvider::class, 'user_id');
    }

    public function getBio()
    {
        return $this->hasOne(Bio::class, 'user_id');
    }

    public function getTestimoni()
    {
        return $this->hasOne(Testimoni::class, 'user_id');
    }

    public function getAlamat()
    {
        return $this->hasMany(Alamat::class, 'user_id');
    }

    public function getWishlist()
    {
        return $this->hasMany(Favorit::class, 'user_id');
    }

    public function getKeranjang()
    {
        return $this->hasMany(Keranjang::class, 'user_id');
    }

    public function getPesanan()
    {
        return $this->hasMany(Pesanan::class, 'user_id');
    }

    public function getUlasan()
    {
        return $this->hasMany(Ulasan::class, 'user_id');
    }

    public function getQnA()
    {
        return $this->hasMany(QnA::class, 'user_id');
    }

    /**
     * Sends the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomPassword($token));
    }
}

class CustomPassword extends ResetPassword
{
    public function toMail($notifiable)
    {
        $token = $this->token;
        $email = $notifiable->getEmailForPasswordReset();
        return (new MailMessage)
            ->from(env('MAIL_USERNAME'), env('APP_TITLE'))
            ->subject("Akun " . env('APP_NAME') . ": Reset Kata Sandi")
            ->view('emails.auth.reset', compact('token', 'email'));
    }
}
