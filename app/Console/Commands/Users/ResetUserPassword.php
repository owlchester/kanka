<?php

namespace App\Console\Commands\Users;

use App\Models\User;
use App\Models\UserLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:reset-password {user} {password=auto}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset a user password';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userID = $this->argument('user');
        $user = User::find($userID);
        if (empty($user)) {
            $this->error('Invalid user id ' . $userID);
            return 0;
        }

        $password = $this->argument('password');
        if ($password == 'auto') {
            $password = Str::random();
        }

        $hash = Hash::make($password);
        $user->update(['password' => $hash]);
        $user->log(UserLog::TYPE_PASSWORD_ADMIN_UPDATE);

        $this->info('User ' . $userID . ' updated to new password ' . $password);
        return 0;
    }
}
