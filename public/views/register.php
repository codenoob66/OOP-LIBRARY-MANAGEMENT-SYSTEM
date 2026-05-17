<h2>Register</h2>

<form method="POST" action="?action=register" class="card">
    <label for="name">Username</label>
    <input type="text" id="name" name="name" required autofocus>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Register</button>
</form>

<p class="text-center mt-2">
    Already have an account? <a href="?action=login">Login here</a>.
</p>
