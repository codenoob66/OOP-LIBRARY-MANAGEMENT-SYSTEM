<h2>Add a Book</h2>

<form method="POST" action="?action=add_book" class="card" style="margin: 0 0 2rem 0;">
    <label for="title">Title</label>
    <input type="text" id="title" name="title" required>

    <label for="author">Author</label>
    <input type="text" id="author" name="author" required>

    <label for="available_copies">Available Copies</label>
    <input type="number" id="available_copies" name="available_copies" min="1" value="1" required>

    <button type="submit">Add Book</button>
</form>

<h2>All Books</h2>

<?php if (empty($books)): ?>
    <p>No books in the library yet. Add one above!</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Available</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= $book->getId() ?></td>
                    <td><?= htmlspecialchars($book->getTitle()) ?></td>
                    <td><?= htmlspecialchars($book->getAuthor()) ?></td>
                    <td><?= $book->getAvailableCopies() ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
