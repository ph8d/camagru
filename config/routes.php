<?php

    return array (
        '^gallery/user/([a-zA-Z0-9]*)/([0-9]+)$' => 'gallery/user/$1/$2',
        '^gallery/user/([a-zA-Z0-9]*)$' => 'gallery/user/$1',
        '^gallery/post/([0-9]+)$' => 'gallery/view/$1',
        '^gallery/([0-9]+)$' => 'gallery/index/$1',
        '^gallery/camera$' => 'gallery/camera',
        '^gallery$' => 'gallery/index',

        '^user/reset/([a-zA-Z0-9-]*)$' => 'user/reset/$1',
        '^user/confirm/([0-9]+)/(.*)$' => 'user/confirm/$1/$2',
        '^user/register$' => 'user/register',
        '^user/recovery$' => 'user/recovery',
        '^user/logout$' => 'user/logout',
        '^user/login$' => 'user/login',

        '^post/create$' => 'post/create',
        '^post/delete$' => 'post/delete',

        '^comment/remove$' => 'comment/remove',
        '^comment/load$' => 'comment/load',
        '^comment/add$' => 'comment/add',

        '^like/toggle$' => 'like/toggle',
        '^like/remove$' => 'like/remove',
        '^like/count$' => 'like/count',
        '^like/add$' => 'like/add',

        '^settings/notifications$' => 'settings/notifications',
        '^settings/validation$' => 'settings/validation',
        '^settings/password$' => 'settings/password',
        '^settings/account$' => 'settings/account',
        '^settings/save$' => 'settings/save',

        '^$' => 'gallery/index/1'
    );