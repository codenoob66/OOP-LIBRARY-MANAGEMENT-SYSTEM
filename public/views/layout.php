<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> &mdash; Library</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f4f4f9;
            color: #222;
            line-height: 1.6;
        }
        nav {
            background: #2c3e50;
            color: #fff;
            padding: 0.75rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav a, nav button {
            color: #fff;
            text-decoration: none;
            margin-left: 1rem;
            font-size: 0.95rem;
        }
        nav a:hover { text-decoration: underline; }
        nav .brand { font-weight: 700; font-size: 1.1rem; }
        nav button {
            background: none;
            border: 1px solid #fff;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            cursor: pointer;
        }
        nav button:hover { background: #fff; color: #2c3e50; }
        main {
            max-width: 820px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .flash {
            padding: 0.75rem 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
        }
        .flash.error { background: #fdecea; color: #b71c1c; border: 1px solid #f5c6cb; }
        .flash.message { background: #e8f5e9; color: #1b5e20; border: 1px solid #c8e6c9; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            background: #fff;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }
        th, td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        th { background: #ecf0f1; font-weight: 600; }
        form.card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            max-width: 400px;
            margin: 2rem auto;
        }
        form.card label { display: block; margin-bottom: 0.35rem; font-weight: 600; }
        form.card input {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }
        form.card button, .btn {
            display: inline-block;
            background: #2c3e50;
            color: #fff;
            padding: 0.5rem 1.25rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
        }
        form.card button:hover, .btn:hover { background: #34495e; }
        .btn-sm { padding: 0.3rem 0.75rem; font-size: 0.85rem; }
        .btn-danger { background: #c0392b; }
        .btn-danger:hover { background: #a93226; }
        .text-center { text-align: center; }
        .mt-2 { margin-top: 1rem; }
    </style>
</head>
<body>
    <nav>
        <span class="brand">📚 Library</span>
        <span>
            <?php $currentUser = $authService->getCurrentUser(); ?>
            <?php if ($currentUser): ?>
                Welcome, <?= htmlspecialchars($currentUser->getName()) ?>
                (<?= htmlspecialchars($currentUser->getRole()) ?>)
                <a href="index.php">Dashboard</a>
                <form method="POST" action="?action=logout" style="display:inline;">
                    <button type="submit">Logout</button>
                </form>
            <?php else: ?>
                <a href="?action=login">Login</a>
                <a href="?action=register">Register</a>
            <?php endif; ?>
        </span>
    </nav>

    <main>
        <?php if (!empty($error)): ?>
            <div class="flash error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($message)): ?>
            <div class="flash message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <?= $content ?>
    </main>
</body>
</html>
