<?php use_stylesheet('/sfPropelRevisitedGeneratorPlugin/css/global.css', 'first') ?>
<?php use_stylesheet('/sfPropelRevisitedGeneratorPlugin/css/extended.css', 'first') ?>


<div id="sf_admin_container">
    <h1><?php echo __('Choose student to calificate without numerical mark from %course%', array('%course%' => $course)) ?></h1>


    <div id="sf_admin_content">
        <form action="<?php echo url_for('@save_calificate_non_numerical_mark') ?>" method="post">

            <input type="hidden" id="id" name="id" value="<?php echo $course->getId() ?>"/>
            <ul class="sf_admin_actions">
                <li class ="sf_admin_action_list"><?php echo link_to(__('Back'), $back_url); ?></li>
                <li ><input type="submit" value="<?php echo __('Save', array(), 'sf_admin') ?>" /></li>
            </ul>

            <div>

                <?php $first = true ?>
                <?php foreach ($course_subjects as $course_subject): ?>
                    <a class="tab<?php $first and print ' tab-selected' ?>" href="#marks_fieldset_<?php echo $course_subject->getId() ?>" onclick="jQuery('fieldset').hide(); jQuery(jQuery(this).attr('href')).show(); jQuery('.tab').removeClass('tab-selected'); jQuery(this).addClass('tab-selected'); return false;"><?php echo $course_subject->getCareerSubject()->toStringWithCareer() ?></a>
                    <?php $first = false ?>
                <?php endforeach; ?>
            </div>

            <?php foreach ($course_subjects as $course_subject): ?>

                <fieldset id="marks_fieldset_<?php echo $course_subject->getId() ?>" class="marks-fieldset">
                    <h2><?php echo $course_subject->getCareerSubject() ?></h2>

                    <?php $form = $forms[$course_subject->getId()] ?>
                    <?php foreach ($course_subject->getCourseSubjectStudents() as $course_subject_student): ?>

                        <div class="sf_admin_form_row">
                            <label for="<?php echo $course_subject_student->getId() ?>" class="required">
                                <?php echo strval($course_subject_student->getStudent()) ?>
                            </label>
                            <div>
                                <?php $field = $form['course_subject_non_numerical_califications_' . $course_subject->getId() . '_'. $course_subject_student->getId()]; ?>

                                <?php echo $field->render(array('class' => 'mark' . ($field->hasError() ? ' with-error' : ''), 'value' => ((isset($request_value) && $request_value) ? $request_value : $field->getValue()))); ?>
                                <?php if ($field->hasError()): ?>
                                    <?php echo $field->renderError(); ?>
                                <?php endif; ?>

                                <div style="clear: both; font-size: 1px; height: 1px;">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </fieldset>
            <?php endforeach; ?>

            <ul class="sf_admin_actions">
                <li class ="sf_admin_action_list"><?php echo link_to(__('Back'), $back_url); ?></li>
                <li ><input type="submit" value="<?php echo __('Save', array(), 'sf_admin') ?>" /></li>
            </ul>
        </form>
    </div>
</div>

<script type="text/javascript">
    jQuery('fieldset:gt(0)').hide();
</script>