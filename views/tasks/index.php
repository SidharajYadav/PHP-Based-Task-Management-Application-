<?php ob_start(); ?>
<div class="mb-3">
    <a href="/tasks/create" class="btn btn-primary">Create New Task</a>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Priority</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($task = $tasks->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($task['title']); ?></td>
                    <td><?php echo htmlspecialchars($task['description']); ?></td>
                    <td>
                        <span class="badge bg-<?php 
                            echo $task['priority'] === 'High' ? 'danger' : 
                                 ($task['priority'] === 'Medium' ? 'warning' : 'success'); 
                        ?>">
                            <?php echo htmlspecialchars($task['priority']); ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($task['due_date']); ?></td>
                    <td>
                        <span class="badge bg-<?php echo $task['status'] === 'Completed' ? 'success' : 'secondary'; ?>">
                            <?php echo htmlspecialchars($task['status']); ?>
                        </span>
                    </td>
                    <td>
                        <a href="/tasks/edit/<?php echo $task['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <form action="/tasks/delete/<?php echo $task['id']; ?>" method="POST" class="d-inline">
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<nav aria-label="Page navigation">
    <ul class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>

<div id="api-section" class="mt-5">
    <h2>API Documentation</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Endpoints</h5>
            <ul>
                <li><strong>GET /api/tasks</strong> - List all tasks (paginated)</li>
                <li><strong>GET /api/tasks/{id}</strong> - Get a single task</li>
                <li><strong>POST /api/tasks</strong> - Create a new task</li>
                <li><strong>PUT /api/tasks/{id}</strong> - Update a task</li>
                <li><strong>DELETE /api/tasks/{id}</strong> - Delete a task</li>
            </ul>
            <button id="test-api" class="btn btn-info">Test API</button>
            <div id="api-response" class="mt-3"></div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../layout.php'; ?>