<h1>Add New Document File To Knowledge Vault</h1>
<?php if (isset($error) && !empty($error)): ?>
    <div class="error-message"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<form action="index.php?action=add" method="post" enctype="multipart/form-data">
    <label for="category">Section:</label>
    <select name="category" id="category" required onchange="toggleCustomCategory()">
        <option value="">--Select Section--</option>
        <option value="Mechanical">Mechanical</option>
        <option value="E&I">E&I</option>
        <option value="Raw Material">Raw Material</option>
        <option value="Business Consulting">Business Consulting</option>
        <option value="Roads and Highway">Roads and Highway</option>
        <option value="Project">Project</option>
        <option value="Power">Power</option>
        <option value="Process">Process</option>
        <option value="Other">Other</option>
    </select>

    <div id="custom-category-field" style="display:none;">
        <label for="custom_category">Custom Section:</label>
        <input type="text" name="custom_category" id="custom_category">
    </div>

    <label for="type_of_document">Type of Document:</label>
    <select name="type_of_document" id="type_of_document" required>
        <option value="">--Select Document Type--</option>
        <option value="Word">Word</option>
        <option value="Excel">Excel</option>
        <option value="JPG">JPG</option>
        <option value="PDF">PDF</option>
        <option value="AutoCAD">AutoCAD</option>
        <option value="PPT">PPT</option>
    </select>

    <label for="source_of_information">Source of Information:</label>
    <input type="text" name="source_of_information" id="source_of_information">

    <!-- "Uploaded By" is auto-filled from session -->


    <label for="description">Description:</label>
    <textarea name="description" id="description"></textarea>

    <!-- No comments field -->

    <!-- Allow only one file upload -->
    <label for="file">Upload Document File:</label>
    <input type="file" name="file" id="file" required>

    <label for="published">
        <input type="checkbox" name="published" id="published" checked> Publish Document
    </label>

    <button type="submit">Submit</button>
</form>

<script>
function toggleCustomCategory() {
    var categorySelect = document.getElementById('category');
    var customField = document.getElementById('custom-category-field');
    if (categorySelect.value === 'Other') {
        customField.style.display = 'block';
    } else {
        customField.style.display = 'none';
    }
}
</script>
