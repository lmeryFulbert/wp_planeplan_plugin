<tbody >

<?php
$url = esc_url( $_SERVER['REQUEST_URI']);
?>
<form method="post" action="<?php echo $url?>">

<div class="formdatabc">
        <div class="form2bc">
            <p>
                <label for="name">Nom de l'aerodrome</label>
                <br>
                <input id="name" name="data[name]" type="text" value="<?php if(isset($data)) echo $data["name"]?>" required>
            </p>
            <p>
                <label for="adresse">adresse </label>
                <br>
                <input id="adresse" name="data[adresse]" type="text" value="<?php if(isset($data)) echo $data["address"]?>">
            </p>
            <p>
                <label for="cp">code postal</label>
                <br>
                <input id="cp" name="data[cp]" type="number" value="<?php if(isset($data)) echo $data["cp"]?>">
            </p>
            <p>
                <label for="ville">ville</label>
                <br>
                <input id="ville" name="data[ville]" type="text" value="<?php if(isset($data)) echo $data["city"]?>">
            </p>
            <p>
                <label for="lattitude">Lattitude</label>
                <br>
                <input id="lattitude" name="data[lattitude]" type="text" value="<?php if(isset($data)) echo $data["gpslat"]?>">
            </p>
            <p>
                <label for="longitude">longitude</label>
                <br>
                <input id="longitude" name="data[longitude]" type="text" value="<?php if(isset($data)) echo $data["gpslong"]?>">
            </p>
        </div>

        <?php
        submit_button();
        ?>

    </form>
</div>
</tbody>
