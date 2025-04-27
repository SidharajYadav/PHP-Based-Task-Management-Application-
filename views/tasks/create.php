<?php ob_start(); ?>
<h2>Create New Task</h2>

<form method="POST">
    <div class="mb-3">
        <label for="title" class="form-label">Title *</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
    </div>
    
    <div class="mb-3">
        <label for="priority" class="form-label">Priority</label>
        <select class="form-select" id="priority" name="priority">
            <option value="Low">Low</option>
            <option value="Medium" selected>Medium</option>
            <option value="High">High</option>
        </select>
    </div>
    
    <div class="mb-3">
        <label for="due_date" class="form-label">Due Date *</label>
        <input type="date" class="form-control" id="due_date" name="due_date" required min="<?php echo date('Y-m-d'); ?>">
    </div>
    
    <button type="submit" class="btn btn-primary">Create Task</button>
    <a href="/" class="btn btn-secondary">Cancel</a>
</form>

<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../layout.php'; ?>