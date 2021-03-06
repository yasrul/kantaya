<?php

namespace app\models;

use Yii;
use app\models\Role;
use app\models\StatusUser;
use app\models\User;


/**
 * Description of ValueHelpers
 *
 * @author yasrul
 */
class ValueHelpers {
    //put your code here
    public static function roleMatch($role_name) {
        $userHasRoleName = Yii::$app->user->identity->role->role_name;
        return $userHasRoleName == $role_name ? true : false;
    }
    
    public static function getUsersRoleValue($userId=null) {
        if ($userId==null) {
            $usersRoleValue = Yii::$app->user->identity->role->role_value;
            return isset($usersRoleValue) ? $usersRoleValue : FALSE;
        } else {
            $user = User::findOne($userId);
            $usersRoleValue = $user->role->role_value;
            return isset($usersRoleValue) ? $usersRoleValue : FALSE;
        }
    }
    
    public static function getRoleValue($role_name) {
        $role = Role::find('role_value')
                ->where(['role_name' => $role_name])
                ->one();
        return isset($role->role_value) ? $role->role_value : false;
    }
    
    public static function isRoleNameValid($role_name) {
        $role = Role::find('role_name')
                ->where(['role_name' => $role_name])
                ->one();
        return isset($role) ? true : false;
    }
    
    public static function statusMatch($status_name) {
        $userHasStatusName = Yii::$app->user->identity->status->status_name;
        return $userHasStatusName == $status_name ? true : false;
    }
    
    public static function getStatusId($status_name) {
        $status = StatusUser::find('id')
                ->where(['status_name' => $status_name])
                ->one();
        return isset($status->id) ? $status->id : false;
    }
}
