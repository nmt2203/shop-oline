<select class="form-control" name="ward" id="ward">
    <option value="">---Choose ward---</option>
    <?php
    foreach ($this->data["all_wards"] as $ward) {
        echo "<option value='" . $ward->ward_id . "'>" . $ward->name . "</option>";
    }
    ?>
</select>