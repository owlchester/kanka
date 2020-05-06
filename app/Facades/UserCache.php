<?php

namespace App\Facades;

use App\Services\Caches\UserCacheService;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * Class UserCache
 * @package App\Facades
 *
 * @method static self|UserCacheService user(User $user)
 * @method static Collection roles()
 * @method static self|UserCacheService clearRoles()
 * @method static Collection campaigns()
 * @method static self|UserCacheService clearCampaigns()
 * @method static Collection follows()
 * @method static self|UserCacheService clearFollows()
 * @method static bool admin()
 * @method static string name(int $userId)
 * @method static self|UserCacheService clearName()
 *
 * @see \App\Services\Caches\UserCacheService
 */
class UserCache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'usercache';
    }
}
