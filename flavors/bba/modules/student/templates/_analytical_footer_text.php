<?php /*
 * Kimkëlen - School Management Software
 * Copyright (C) 2013 CeSPI - UNLP <desarrollo@cespi.unlp.edu.ar>
 *
 * This file is part of Kimkëlen.
 *
 * Kimkëlen is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License v2.0 as published by
 * the Free Software Foundation.
 *
 * Kimkëlen is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Kimkëlen.  If not, see <http://www.gnu.org/licenses/gpl-2.0.html>.
 */ ?>
<?php use_helper('Date') ?>

<div class="header-text">
    <p>Año de ingreso: <?php echo $student->getInitialSchoolYear()->getYear(); ?>.</p>
    <?php if ($analytical->has_completed_career()): ?>
        <p>Fecha de egreso: <?php echo format_datetime($analytical->get_last_exam_date()->format('U'), "D"); ?>.</p>
        <p>Habiendo terminado sus estudios secundarios el día <?php echo format_datetime($analytical->get_last_exam_date()->format('U'), "D"); ?>, se le extiende el certificado de <strong><?php echo $analytical->get_career_name(); ?> - <?php echo $analytical->get_plan_name(); ?></strong> con orientación en <strong><?php echo $analytical->get_orientation(); ?></strong>.</p>
    <?php else: ?>
        <p>Para terminar sus estudios secundarios deberá aprobar:
            <?php if ($analytical->has_missing_subjects() ): ?>
                <?php $missing_subjects = $analytical->get_missing_subjects(); end($missing_subjects); $last_key = key($missing_subjects);?>
                <?php foreach ($analytical->get_missing_subjects() as $key => $subject): ?> <?php if (0!=$key): if ($key === $last_key): ?>y<?php else: ?>,<?php endif;endif; ?>
                    <?php echo $subject->getSubjectName(); ?> de <?php echo __('Year '. $subject->getYear()); ?><?php if ($key === $last_key): ?>.<?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if ($analytical->has_remaining_years() ): ?>
                Todo <?php echo implode(', ', array_map('__', $analytical->get_remaining_years_string())); ?>.
            <?php endif; ?>
        </p>
        <?php if (count($analytical->get_years_in_career()) != 1 ): ?>
            <p>Se deja constancia que su último examen lo rindió el <?php echo format_datetime($analytical->get_last_exam_date()->format('U'), "D"); ?>.</p>
        <?php endif; ?>
        <p>Certificado de Estudios Incompleto.</p>
    <?php endif; ?>
    <p>Para que conste y a pedido del interesado, se expide el presente certificado confrontado con los registros y actas originales por el Secretario Administrativo y Jefe de la Oficina de Alumnos, en la ciudad de <?php echo __('escuela_ciudad'); ?>, a los <?php echo date('d'); ?> días del mes de <?php echo format_date(time(), 'MMMM'); ?> de <?php echo date('Y'); ?>.</p>
</div>