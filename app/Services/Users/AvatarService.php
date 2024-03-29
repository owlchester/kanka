<?php

namespace App\Services\Users;

use App\Traits\RequestAware;
use App\Traits\UserAware;
use Illuminate\Support\Facades\Storage;

class AvatarService
{
    use RequestAware;
    use UserAware;

    public function upload(): void
    {
        $this->cleanup();

        $path = $this->request
            ->file('avatar')
            ->storePubliclyAs($this->folderName(), $this->fileName());

        $this->user->avatar = $path;
        $this->user->save();
    }

    protected function folderName(): string
    {
        $folderNo = (int) floor($this->user->id / 1000);
        return $this->user->getTable() . '/' . $folderNo;
    }

    protected function fileName(): string
    {
        $file = $this->request->file('avatar');
        $filename = uniqid();
        if ($extension = $file->guessExtension()) {
            $filename .= '.' . $extension;
        }
        return $filename;
    }

    /**
     * Remove the old image
     */
    protected function cleanup(): self
    {
        if (empty($this->user->avatar)) {
            return $this;
        }

        if (Storage::exists($this->user->avatar)) {
            Storage::delete($this->user->avatar);
        }
        return $this;
    }
}
