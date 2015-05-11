<?php

use frontend\assets\BacklogAsset;

/* @var $tickets common\models\Ticket */

BacklogAsset::register($this);

$this->params['breadcrumbs'][] = 'Backlog';

echo $this->render('@frontend/views/ticket/_ticketSearchFilter');
echo $this->render('@frontend/views/ticket/_ticketList', ['tickets' => $tickets]);
?>