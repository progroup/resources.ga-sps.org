<div role="tabpanel" class="tabpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#state" aria-controls="state" role="tab" data-toggle="tab">State</a></li>
        <li role="presentation"><a href="#national" aria-controls="national" role="tab" data-toggle="tab">National</a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <?php $index = 0 ?>
        <?php foreach($page->children() as $subpage) : ?>
            <div role="tabpanel" class="tab-pane <?php echo ($index == 1) ? 'active' : '' ?>" id="<?php echo $subpage->uid() ?>">
                <?php foreach($subpage->trainings()->toStructure() as $training) : ?>
                    <table class="training-table">
                        <caption></caption>
                        <thead>
                            <tr>
                                <th class="training-table-date">Date</th>
                                <th class="training-table-training" colspan="2">Training</th>
                                <th class="training-table-modality">Modality</th>
                                <th class="training-table-ceus">CEUs</th>
                                <th class="training-table-archived">Archived</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?php echo $training->date()->html() ?>
                                </td>
                                <td colspan="2">
                                    <?php echo $training->training()->html() ?>
                                </td>
                                <td>
                                    <?php echo $training->modality()->html() ?>
                                </td>
                                <td class="training-table-ceus">
                                    <?php
                                        if ($training->ceus()) {
                                            echo "Yes";
                                        } else {
                                            echo "N/A";
                                        }

                                    ?>
                                </td>
                                <td class="training-table-archived">

                                    <?php
                                        if($training->archived()) {
                                            echo "Yes";
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <p>
                                        <b>Description:</b>
                                        <br>
                                        <?php echo $training->description()->kirbytext() ?>
                                    </p>
                                    <p>
                                        <b>Logistics</b>
                                        <br>
                                        <?php echo $training->logistics()->kirbytext() ?>
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <?php endforeach ?>
            </div>
            <?php $index++ ?>
        <?php endforeach ?>
    </div>
</div>
