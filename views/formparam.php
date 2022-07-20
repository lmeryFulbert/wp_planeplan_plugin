<div class="wrap">

    <?php
    $url = esc_url( $_SERVER['REQUEST_URI']);
    ?>

    <form method="post" action="<?php echo $url?>">

        <div id="universal-message-container">
            <h2>Paramètres généraux de PlanePlan</h2>

            <div class="options">
                <p>
                    <label>Nombre de rotations</label>
                    <input type="number" name="data[nb_rotations]" value="<?php echo $parameters->nb_rotations?>" />
                </p>
                <p>
                    <label>Nombre de sauteurs par rotations</label>
                    <input type="number" name="data[nb_sauteurs_by_rotation]" value="<?php echo $parameters->nb_sauteurs_by_rotation?>" />
                </p>
            </div>

            <?php
            submit_button();
            ?>


    </form>

</div>