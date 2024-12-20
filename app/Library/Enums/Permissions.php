<?php

namespace App\Library\Enums;

enum Permissions
{
    public const VIEW_USER = 'view-user';
    public const EDIT_USER = 'edit-user';
    public const VIEW_ROLE = 'view-role';
    public const EDIT_ROLE = 'edit-role';
    public const VIEW_PERMISSION = 'view-permission';
    public const EDIT_PERMISSION = 'edit-permission';
    public const VIEW_AD = 'view-ad';
    public const EDIT_AD = 'edit-ad';
    public const VIEW_AD_TEMPLATE = 'view-ad-template';
    public const EDIT_AD_TEMPLATE = 'edit-ad-template';
    public const VIEW_CHURN_WIDGET = 'view-churn-widget';
}
