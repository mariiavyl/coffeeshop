<?php

require_once "db_config.php";
require_once("view.php");
require_once("model.php");

$action = $_GET['action'] ?? 'list';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if ($action == 'edit') {
            if (isset($_GET['id'])) {
                $user = User::get_user_by_id($db_connection, $_GET['id']);
                if ($user) {
                    View::edit_page($user);
                } else {
                    echo "User is not found";
                }
            }
        } elseif ($action == 'delete') {
            if (isset($_GET['id'])) {
                User::delete($db_connection, $_GET['id']);
                header("Location: index.php");
                exit;
            }
        } elseif ($action == 'add') {
            View::new_page();
            
        } elseif ($action == 'list' || empty($action)) {
            $users = User::get_all_users($db_connection);
            View::show_all($users);
        }
        break;

    case 'POST':
        if (isset($_POST['action'])) {
            $action = $_POST['action'];
            if ($action == 'add') {
                $user = new User(NULL, $_POST['first_name'], $_POST['last_name']);
                $user->add($db_connection);
                header("Location: index.php");
                exit;
            } elseif ($action == 'update') {
                if (isset($_POST['id'])) {
                    $user = new User($_POST['id'], $_POST['first_name'], $_POST['last_name']);
                    $user->update($db_connection);
                    header("Location: index.php");
                    exit;
                }
            }
        }
        break;

    default:
        echo "Invalid request";
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
