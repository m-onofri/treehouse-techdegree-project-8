<?php
require_once __DIR__ . '/../inc/bootstrap.php';

//Get data from the task form
$action = request()->get('action');
$task_id = request()->get('task_id');
$task = request()->get('task');
$status = request()->get('status');
$user_id = decodeAuthCookie('auth_user_id');

//Set the url for redirect
$url="../task_list.php";
if (request()->get('filter')) {
    $url.="?filter=".request()->get('filter');
}

switch ($action) {
//Add a new task
case "add":
    if (empty($task)) {
        $session->getFlashBag()->add('error', 'Please enter a task');
    } else {
        if (createTask(['task'=>$task, 'status'=>$status, 'user_id'=>$user_id])) {
            $session->getFlashBag()->add('success', 'New Task Added');
        }
    }
    break;
//Update an existing task
case "update":
    $data = ['task_id'=>$task_id, 'task'=>$task, 'status'=>$status];
    if (updateTask($data)) {
        $session->getFlashBag()->add('success', 'Task Updated');
    } else {
        $session->getFlashBag()->add('error', 'Could NOT update task');
    }
    break;
//Update the status of an existing task
case "status":
    if (updateStatus(['task_id'=>$task_id, 'status'=>$status])) {
        if ($status == 1) $session->getFlashBag()->add('success', 'Task Complete');
    }
    break;
//Delete a specific task
case "delete":
    if (deleteTask($task_id)) {
        $session->getFlashBag()->add('success', 'Task Deleted');
    } else {
        $session->getFlashBag()->add('error', 'Could NOT Delete Task');
    }
    break;
}
header("Location: ".$url);