<?php
namespace App\Etrack\Transformers\Notifications;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class NotificationTransformer extends TransformerAbstract
{

    public function transform($model)
    {
        Carbon::setLocale('es');
        $profilePictureThumb = $model->createdBy->getFirstMediaUrl('profile', 'thumbnail');
        return [
            'body'           => $model->data,
            'created_by'     => $model->createdBy->first_name . ' ' . $model->createdBy->last_name,
            'created_by_img' => $profilePictureThumb ? env('APP_URL') . $profilePictureThumb : null,
            'time'           => Carbon::parse($model->data['notification_date'])->diffForHumans(),
            'read_at'        => $model->read_at,
            'read'           => $model->read_at ? true : false
        ];
    }
}