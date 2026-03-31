<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

function havePermission($permission) {
    try{
        $CI =& get_instance();
        $session_permissions = $CI->auth->get_session_permissions();
        $current_module = $CI->auth->get_current_module();


        return (isset($session_permissions)
            && is_array($session_permissions)
            && isset($session_permissions[$current_module->id])
            && is_array($session_permissions[$current_module->id])
            && in_array($permission, $session_permissions[$current_module->id])
        );
    } catch(Exception $e) {
        die('Ocorreu um erro na função havePermission do permission_helper');
    }
}

function deleteButton($id) {
    $CI =& get_instance();
    $current_module = $CI->auth->get_current_module();

    if(!havePermission('deletar') && !havePermission('excluir')) return;

    $url = site_url($current_module->slug.'/delete/'.$id);
    $title = T_('Apagar');

    $button = "<a href='$url' title='$title' class='btn btn-outline-danger delete-button'>
        <i class='fal fa-trash'></i>
    </a>";

    return $button;
}

function editButton($id, $page_number = 1) {
    $CI =& get_instance();
    $current_module = $CI->auth->get_current_module();

    if(!havePermission('editar')) return;

    $url = site_url($current_module->slug.'/editar/'.$id.'?page='.$page_number);
    $title = T_('Editar');

    $button = "<a href='$url' title='$title' class='btn btn-outline-primary'>
        <i class='fal fa-pencil-alt'></i>
    </a>";

    return $button;
}

function visualizeButton($id, $page_number = 1) {
    $CI =& get_instance();
    $current_module = $CI->auth->get_current_module();

    if(!havePermission('visualizar')) return;

    $url = site_url($current_module->slug.'/visualizar/'.$id.'?page='.$page_number);
    $title = T_('Editar');

    $button = "<a href='$url' title='$title' class='btn btn-outline-primary'>
        <i class='fal fa-eye'></i>
    </a>";

    return $button;
}

function buttonWithPermission($url, $title, $icon, $permission, $text = NULL) {
    $CI =& get_instance();
    $current_module = $CI->auth->get_current_module();

    if(!havePermission($permission)) return;

    $button = "<a href='$url' title='$title' class='btn btn-outline-dark'>
        <i class='$icon'></i> <span class='d-none d-sm-inline'>$text</span>
    </a>";

    return $button;
}

function statusLabel($status = 0, $id) {
    $CI =& get_instance();
    $current_module = $CI->auth->get_current_module();

    if(!havePermission('editar')) {
        return $status == 1 ? '<span class="badge badge-success">'.T_('Ativo').'</span>' : '<span class="badge badge-danger">'.T_('Inativo').'</span>';
    }

    if($status == 1) {
        return '<input type="checkbox"
                        data-toggle="switch-status"
                        data-id="'.$id.'"
                        name="status"
                        id="inputStatus"
                        value="1"
                        checked/>';
    } else {
        return '<input type="checkbox"
                    data-toggle="switch-status"
                    data-id="'.$id.'"
                    name="status"
                    value="1"
                    id="inputStatus"/>';
    }
}