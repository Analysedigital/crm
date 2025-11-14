<?php
require 'includes/auth_check.php';
require 'config/db.php';

// Only admin can access
$user_role = $_SESSION['user_role'] ?? '';
if ($user_role !== 'admin') {
    die('Access denied');
}

$user_id = $_SESSION['user_id'];
$u = $db->where('id', $user_id)->getOne('users');

$errors = [];

$db->where('options_name', 'round_robin');
$currentSetting = $db->getOne('options');
$round_robin_enabled = $currentSetting && $currentSetting['options_value'] === 'on';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $round_robin = isset($_POST['round_robin']) ? 'on' : 'off';

    $db->where('options_name', 'round_robin');
    $exists = $db->getValue('options', 'COUNT(*)');

    if ($exists) {
        $db->where('options_name', 'round_robin');
        $ok = $db->update('options', ['options_value' => $round_robin]);
    } else {
        $ok = $db->insert('options', ['options_name' => 'round_robin', 'settings_value' => $round_robin]);
    }
    if ($ok) {
        $_SESSION['successmsg'] = 'Settings updated successfully.';
        header('Location: settings.php');
        exit;
    } else {
        $errors[] = 'Failed to update settings: ' . htmlspecialchars($db->getLastError());
    }
}
?>

<?php include 'includes/header.php'; ?>
<div class="page-wrapper">
    <?php include 'includes/top_nav.php'; ?>
    <div class="content-wrapper">
        <div class="content">
                <div class="row">
                    <div class="col-xl-3">
                        <div class="card card-default">
                            <div class="card-header">
                                <h2>Settings</h2>
                            </div>
                            <div class="card-body pt-0">
                                <ul class="nav nav-settings">
                                    <li class="nav-item">
                                        <a class="nav-link" href="user_profile_edit.php?id=<?= $u['id'] ?>">
                                            <i class="mdi mdi-account-outline mr-1"></i> Profile
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="settings.php">
                                            <i class="mdi mdi-settings-outline mr-1"></i> Account
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9">
                        <div class="card card-default">
                            <div class="card-header">
                                <h2 class="mb-5">CRM Settings</h2>
                            </div>
                            <div class="card-body">
                                <div class="container mt-2">
                                    <div class="row ">
                                        <div class="col-md-10 col-lg-8">
                                            <?php if (!empty($errors)): ?>
                                                <div class="alert alert-danger"><?= implode('<br>', $errors) ?></div>
                                            <?php endif; ?>
                                            <form method="post">
                                                <div class="form-check form-switch mb-4">
                                                    <span class="ms-2"><strong>Auto Assignment :</strong></span>
                                                    <label
                                                        class="switch switch-text switch-outline-alt-warning switch-pill form-control-label mr-2 ">
                                                        <input type="checkbox" name="round_robin"
                                                            class="switch-input form-check-input" value="on"
                                                            <?= $round_robin_enabled ? 'checked' : '' ?>>
                                                        <span class="switch-label" data-on="On" data-off="Off"></span>
                                                        <span class="switch-handle"></span>
                                                    </label>
                                                </div>
                                                <div class="col-md-10 text-center">
                                                    <button type="submit" class="btn ad-brand">Save Setting</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <?php include 'includes/footer.php'; ?>