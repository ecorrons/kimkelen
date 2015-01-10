<?php

/**
 * CourseSubjectNonNumericalCalificationsForm
 *
 */
class CourseSubjectNonNumericalCalificationsForm extends sfFormPropel
{
  public function getModelName()
  {
    return 'CourseSubject';
  }

  public function configure()
  {
    $widgets    = array();
    $validators = array();

    $this->disableCSRFProtection();

     $criteria = new Criteria();

      $criteria->addJoin(CourseSubjectStudentPeer::STUDENT_ID, StudentPeer::ID);
      $criteria->add(CourseSubjectStudentPeer::COURSE_SUBJECT_ID, $this->getObject()->getId());
      $criteria->addJoin(StudentPeer::PERSON_ID, PersonPeer::ID);
      $criteria->add(PersonPeer::IS_ACTIVE, true);
      $criteria->addAscendingOrderByColumn(PersonPeer::LASTNAME);

      $css = CourseSubjectStudentPeer::doSelect($criteria);

    foreach ($css as $course_subject_student)

    {
      $widget_name = $course_subject_student->getId();

      $name = 'course_subject_non_numerical_califications_'. $this->getObject()->getId() . '_' . $widget_name;

      $widgets[$name] = new sfWidgetFormInputCheckbox(array('default' => $course_subject_student->getIsNotAverageable()));

      $validators[$name] = new sfValidatorBoolean();

    }

    $this->setWidgets($widgets);
    $this->setValidators($validators);

    $this->widgetSchema->setNameFormat('course_subject_non_numerical_califications['.$this->object->getId().'][%s]');
    }


    public function getJavaScripts()
    {
      return array_merge(parent::getJavaScripts(),array('course_subject_student_mark.js'));
    }

    protected function doSave($con = null)
    {
      $values = $this->getValues();

      $c = new Criteria();
      $c->add(CourseSubjectStudentMarkPeer::IS_CLOSED, false);

      try
      {
        $con->beginTransaction();

        foreach ($this->object->getCourseSubjectStudents() as $course_subject_student)
        {
          $exempt_value = $values['course_subject_non_numerical_califications_' . $course_subject_student->getCourseSubject()->getId() . '_' . $course_subject_student->getId()];

          if (!is_null($exempt_value))
          {
            if ($exempt_value)
            {
              if (!$course_subject_student->getIsNotAverageable()){
                $course_subject_student->exempt($con);
              }
            }
            else {
              $course_subject_student->undoExempt($con);
            }
          }
        }

        $con->commit();
      }
      catch (Exception $e)
      {
        throw $e;
        $con->rollBack();
      }
    }
}