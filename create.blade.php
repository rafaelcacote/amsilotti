<div>
    <select id="propertyType" name="propertyType" onchange="loadFields()">
        <option value="">Select Property Type</option>
        @foreach($propertyTypes as $type)
            <option value="{{ $type->id }}" {{ old('propertyType') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
        @endforeach
    </select>
</div>

<div id="loadingSpinner" style="display: none;">
    <i class="fa fa-spinner fa-spin"></i> Loading...
</div>

<div id="formFields" style="display: none;">
    <!-- Other form fields will go here -->
</div>

<script>
function loadFields() {
    const propertyType = document.getElementById('propertyType').value;
    if (propertyType) {
        document.getElementById('loadingSpinner').style.display = 'block';
        
        // Simulate AJAX call to fetch fields
        setTimeout(() => {
            document.getElementById('loadingSpinner').style.display = 'none';
            document.getElementById('formFields').style.display = 'block';
        }, 1000);
    }
}
</script>