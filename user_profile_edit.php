<?php
// public/user_edit.php
require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/config/db.php';

// if($_SESSION['user_role'] !== 'admin'){
//     echo "Access denied.";
//     exit;
// }

$id = (int) ($_GET['id'] ?? 0);
if (!$id) {
  header('Location: settings.php');
  exit;
}

$user = $db->where('id', $id)->getOne('users');
if (!$user) {
  header('Location: settings.php');
  exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $role = in_array($_POST['role'] ?? '', ['admin', 'agent']) ? $_POST['role'] : 'agent';
  $status = isset($_POST['status']) ? 1 : 0;

  if (!$name || !$email)
    $errors[] = 'Name and email required.';

  // check email unique excluding current user
  $db->where('email', $email);
  $db->where('id', $id, '!=');
  if ($db->getValue('users', 'COUNT(*)') > 0)
    $errors[] = 'Email already exists.';

  if (empty($errors)) {
    $update = ['name' => $name, 'email' => $email, 'role' => $role, 'status' => $status];
    if ($password) {
      if (strlen($password) < 6)
        $errors[] = 'Password min 6 chars.';
      else
        $update['password'] = password_hash($password, PASSWORD_DEFAULT);
    }
    if (empty($errors)) {
      $db->where('id', $id);
      $db->update('users', $update);
      $_SESSION['successmsg'] = 'User updated';
      header('Location: user_profile_edit.php');
      exit;
    }
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
            <div class="card-header center">
              <h3>Profile Settings</h3>
              <?php if ($errors): ?>
                <div class="alert alert-danger"><?= implode('<br>', array_map('htmlspecialchars', $errors)) ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="card-body">
              <div class="container mt-3">
                <div class="row justify-content-center">
                  <div class="col-md-10 col-lg-8">
                    <form method="post">
                      <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input name="name" class="form-control"
                          value="<?= htmlspecialchars($_POST['name'] ?? $user['name']) ?>">
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input name="email" type="email" class="form-control"
                          value="<?= htmlspecialchars($_POST['email'] ?? $user['email']) ?>">
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Password <small class="text-muted">(leave blank to keep
                            current)</small></label>
                        <input name="password" type="password" class="form-control">
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-control">
                          <option value="agent" <?= ($user['role'] == 'agent') ? 'selected' : '' ?>>Agent</option>
                          <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                        </select>
                      </div>
                      <div class="mb-3 form-check">
                        <input type="checkbox" name="status" class="form-check-input" id="status"
                          <?= $user['status'] ? 'checked' : '' ?>>
                        <label class="form-check-label" for="status">Active</label>
                      </div>
                      <button class="btn ad-brand">Save</button>
                      <a href="settings.php" class="btn btn-secondary">Cancel</a>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php include 'includes/footer.php'; ?>
  </div>