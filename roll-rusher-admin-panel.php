<?php
session_start();
require 'db.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        // Add app
        $name = $_POST['name'];
        $desc = $_POST['description'];
        $icon = $_POST['icon'];
        $file = $_POST['file'];
        $pdo->prepare("INSERT INTO apps (name, description, icon, file) VALUES (?, ?, ?, ?)")
            ->execute([$name, $desc, $icon, $file]);
    } elseif (isset($_POST['edit'])) {
        // Edit app
        $id = $_POST['id'];
        $name = $_POST['name'];
        $desc = $_POST['description'];
        $icon = $_POST['icon'];
        $file = $_POST['file'];
        $pdo->prepare("UPDATE apps SET name=?, description=?, icon=?, file=? WHERE id=?")
            ->execute([$name, $desc, $icon, $file, $id]);
    } elseif (isset($_POST['delete'])) {
        // Delete app
        $id = $_POST['id'];
        $pdo->prepare("DELETE FROM apps WHERE id=?")->execute([$id]);
    }
}

// Fetch all apps
$apps = $pdo->query("SELECT * FROM apps")->fetchAll(PDO::FETCH_ASSOC);

// Fetch specific app for editing
$editApp = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editApp = $pdo->prepare("SELECT * FROM apps WHERE id=?")->execute([$id])->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Panel - Manage Apps</title>
<style>
body { font-family: Arial, sans-serif; margin: 20px; background:#f0f0f0; }
h1 { text-align: center; }
form { background: #fff; padding: 20px; margin-bottom:20px; border-radius:8px; }
input[type=text], textarea { width: 100%; padding:8px; margin-top:5px; border-radius:4px; border:1px solid #ccc; }
button { margin-top:10px; padding:10px 20px; border:none; border-radius:4px; background:#6200ea; color:#fff; cursor:pointer; }
button:hover { background:#3700b3; }
table { width:100%; border-collapse:collapse; margin-top:20px; }
th, td { padding:10px; border:1px solid #ccc; text-align:left; }
</style>
</head>
<body>
<h1>Admin Panel - Manage Apps</h1>

<h2><?php echo $editApp ? 'Edit App' : 'Add New App'; ?></h2>
<form method="POST">
    <?php if ($editApp): ?>
        <input type="hidden" name="id" value="<?php echo $editApp['id']; ?>">
    <?php endif; ?>
    <label>Name:</label>
    <input type="text" name="name" value="<?php echo $editApp ? htmlspecialchars($editApp['name']) : ''; ?>" required>
    <label>Description:</label>
    <textarea name="description" required><?php echo $editApp ? htmlspecialchars($editApp['description']) : ''; ?></textarea>
    <label>Icon URL:</label>
    <input type="text" name="icon" value="<?php echo $editApp ? htmlspecialchars($editApp['icon']) : ''; ?>" required>
    <label>File URL:</label>
    <input type="text" name="file" value="<?php echo $editApp ? htmlspecialchars($editApp['file']) : ''; ?>" required>
    <button type="submit" name="<?php echo $editApp ? 'edit' : 'add'; ?>">
        <?php echo $editApp ? 'Update' : 'Add'; ?>
    </button>
</form>

<h2>Existing Apps</h2>
<table>
<tr><th>ID</th><th>Name</th><th>Description</th><th>Icon</th><th>File</th><th>Actions</th></tr>
<?php foreach ($apps as $app): ?>
<tr>
    <td><?php echo $app['id']; ?></td>
    <td><?php echo htmlspecialchars($app['name']); ?></td>
    <td><?php echo htmlspecialchars($app['description']); ?></td>
    <td><img src="<?php echo $app['icon']; ?>" width="50"></td>
    <td><?php echo htmlspecialchars($app['file']); ?></td>
    <td>
        <a href="?edit=<?php echo $app['id']; ?>">Edit</a> | 
        <form method="POST" style="display:inline;">
            <input type="hidden" name="id" value="<?php echo $app['id']; ?>">
            <button type="submit" name="delete" onclick="return confirm('Delete this app?');" style="background:none; border:none; color:red; cursor:pointer;">Delete</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>
