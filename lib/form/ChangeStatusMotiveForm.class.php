<?php 
/*
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
<?php

/**
 * ChangeStatusMotive form.
 *
 * @package    sistema de alumnos
 * @subpackage form
 * @author     Your name here
 */
class ChangeStatusMotiveForm extends BaseChangeStatusMotiveForm
{
  public function configure()
  {
	$sf_formatter_revisited = new sfWidgetFormSchemaFormatterRevisited($this);
    $this->getWidgetSchema()->addFormFormatter('Revisited', $sf_formatter_revisited);
    $this->getWidgetSchema()->setFormFormatterName('Revisited');
    
     unset($this['id']);
    
    $status = BaseCustomOptionsHolder::getInstance('StudentCareerSchoolYearStatus')->getOptionsSelect();
	$this->setWidget('status_id',  new sfWidgetFormSelect(array('choices'  => $status)));
	
	$this->setValidators(array(
	  'name'			 => new sfValidatorString(array('max_length' => 50)),
      'status_id'   	 => new sfValidatorChoice(array('choices' => array_keys($status))),
    ));
  }
}