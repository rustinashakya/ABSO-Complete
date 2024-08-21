<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueEmailsIgnoringCurrentRecords implements Rule
{
    protected $table;
    protected $userIdKey;
    protected $emailKey;

    public function __construct($table, $userIdKey, $emailKey)
    {
        $this->table = $table;
        $this->userIdKey = $userIdKey;
        $this->emailKey = $emailKey;
    }

    public function passes($attribute, $values)
    {
        // dd($this->userIdKey);
        $count = DB::table($this->table)
            ->where(function ($query) use ($values) {
                foreach ($values as $key => $user) {
                    $query->orWhere(function ($subQuery) use ($user, $key) {
                        $subQuery
                            ->where('id', '!=', $user[$this->userIdKey])
                            ->where('email', $user[$this->emailKey]);

                        // Exclude the current email being checked
                        if ($key !== null) {
                            $subQuery->where('email', '!=', $user[$this->emailKey]);
                        }
                    });
                }
            })
            ->count();

        return $count === 0;
    }

    public function message()
    {
        return 'The :attribute has already been taken.';
    }
}