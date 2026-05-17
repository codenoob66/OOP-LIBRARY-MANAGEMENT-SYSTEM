<h2>Login</h2>

<form method="POST" action="?action=login" class="card">
    <label for="name">Username</label>
    <input type="text" id="name" name="name" required autofocus>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Login</button>
</form>

<p class="text-center mt-2">
    Don&rsquo;t have an account? <a href="?action=register">Register here</a>.
</p>
