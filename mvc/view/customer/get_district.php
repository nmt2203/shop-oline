<select class="form-control" name="district" id="district">
    <option value="">---Choose district---</option>
    <?php
    foreach ($this->data["all_districts"] as $district) {
        echo "<option value='" . $district->district_id . "'>" . $district->name . "</option>";
    }
    ?>
</select>