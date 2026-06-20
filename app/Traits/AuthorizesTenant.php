<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

trait AuthorizesTenant
{
    /**
     * Ensure the authenticated user owns the requested model.
     *
     * @param Model $model
     * @param string $message
     */
    protected function authorizeOwnership(Model $model, string $message = 'Hành động không hợp lệ.'): void
    {
        abort_if(
            $model->user_id !== auth()->id(),
            Response::HTTP_FORBIDDEN,
            $message
        );
    }
}
