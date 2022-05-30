<?php

namespace App\Models\Database;

use Illuminate\Database\Eloquent\Model;
use Exception;
use DB;

class AdoptionApplication extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token',
        'user_id',
        'adoptable_animal_id',
        'type',
        'animal_name',
        'is_old_enough',
        'government_id',
        'government_id_expires_at',
        'address_1',
        'address_2',
        'city',
        'state',
        'zip_code',
        'phone_1',
        'phone_2',
        'object_data',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'user_id',
        'adoptable_animal_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                       => 'integer',
        'token'                    => 'string',
        'user_id'                  => 'integer',
        'adoptable_animal_id'      => 'integer',
        'type'                     => 'string',
        'animal_name'              => 'string',
        'is_old_enough'            => 'bool',
        'government_id'            => 'string',
        'government_id_expires_at' => 'date',
        'address_1'                => 'string',
        'address_2'                => 'string',
        'city'                     => 'string',
        'state'                    => 'string',
        'zip_code'                 => 'string',
        'phone_1'                  => 'string',
        'phone_2'                  => 'string',
        'object_data'              => 'string',
        'created_at'               => 'timestamp',
        'updated_at'               => 'timestamp',
        'submitted_at'             => 'timestamp',
        'archived_at'              => 'timestamp',
    ];

    // substr(md5('AdoptionApplication'), 0, 6)
    private $error_prefix = 'f4029f';

    private $max_date_for_query_comparison = '1970-01-01 00:00:02';

    /**
     * Get the user associated with this adoption application
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @param User $user
     * @param string $application_type
     * @return mixed
     */
    public function add(User $user, $application_type)
    {
        // hard-code to 1 for now, since there is only 1 entry in the table as ID 1
        // later on, if i ever get to it, add AdoptableAnimal $adoptable_animal to the function signature
        $adoptable_animal_id = 1;

        $adoption_application = self::create([
            'token'               => DB::raw('UUID()'),
            'user_id'             => $user->id,
            'adoptable_animal_id' => $adoptable_animal_id,
            'type'                => $application_type,
            'object_data'         => '',
        ]);

        return self::find($adoption_application->id);
    }

    /**
     * Find an existing application for the specified user and animal type,
     * that hasn't been submitted or archived,
     * and has some key fields empty so we know it's "new".
     * This will help prevent someone from creating a whole bunch of new applications
     * and filling up the database.
     * Grab the first one created so if there are multiples,
     * we can at least get the oldest one cycled through.
     *
     * @param User $user
     * @param string $application_type
     * @return mixed
     */
    public function emptyApplicationForUserByType(User $user, $application_type)
    {
        return self::where('user_id', $user->id)
            ->where('type', $application_type)
            ->where('animal_name', '')
            ->where('submitted_at', '<=', $this->max_date_for_query_comparison)
            ->where('archived_at', '<=', $this->max_date_for_query_comparison)
            ->orderBy('id')
            ->firstOr(function () {
                return null;
            });
    }

    /**
     * Get all applications whose status would be "Submitted" for the specified type(s)
     *
     * @param array $application_types
     * @return array
     */
    public function submittedApplications(array $application_types)
    {
        return self::where('submitted_at', '>', $this->max_date_for_query_comparison)
            ->where('archived_at', '<=', $this->max_date_for_query_comparison)
            ->whereIn('type', $application_types)
            ->orderByDesc('submitted_at')
            ->get();
    }

    /**
     * @return string
     */
    public function status()
    {
        if ($this->archived_at > 100000) {
            return 'Archived';
        }
        if ($this->submitted_at > 100000) {
            return 'Submitted';
        }

        return 'Active';
    }

    /**
     * Return list of valid values for the `type` field
     *
     * @return array
     */
    public static function applicationTypes()
    {
        return config('bas.adoption.application.types');
    }

}
