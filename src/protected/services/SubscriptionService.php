<?php

class SubscriptionService
{
    public static function subscripion(int $id): Subscription
    {
        $subscription = new Subscription();
        $subscription->author_id = $id;

        if (isset($_POST['Subscription'])) {
            if (!Yii::app()->user->isGuest) {
                throw new CHttpException(403, 'Subscription is available for guests only.');
            }
            $subscription->attributes = $_POST['Subscription'];
            $subscription->author_id = $id;
            if ($subscription->save()) {
                Yii::app()->user->setFlash('success', 'Subscription created.');
                $this->refresh();
            }
        }

        return $subscription;
    }
}

