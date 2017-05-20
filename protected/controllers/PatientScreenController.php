<?php

class PatientScreenController extends RController
{
    public $layout='main1';

	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
            'rights', // perform access control for CRUD operations
			);
	}

    
    public function actionView($id)
    {
        $this->render('view',array(
            'model'=>Patient::model()->findByPk($id),
        ));
    }

    public function actionIndex()
    {
        $session=new CHttpSession;
        $session->open();
        $criteria = new CDbCriteria();

        $model=new Patient('search');
        $model->unsetAttributes();  // clear any default values

        if(isset($_GET['Patient']))
        {
            $model->attributes=$_GET['Patient'];

            if (!empty($model->id)) $criteria->addCondition('id = "'.$model->id.'"');
            if (!empty($model->title)) $criteria->addCondition('title = "'.$model->title.'"');
            if (!empty($model->fName)) $criteria->addCondition('fName = "'.$model->fName.'"');
            if (!empty($model->mName)) $criteria->addCondition('mName = "'.$model->mName.'"');
            if (!empty($model->lName)) $criteria->addCondition('lName = "'.$model->lName.'"');
            if (!empty($model->dob)) $criteria->addCondition('dob = "'.$model->dob.'"');
            if (!empty($model->gender)) $criteria->addCondition('gender = "'.$model->gender.'"');
            if (!empty($model->marital_status)) $criteria->addCondition('marital_status = "'.$model->marital_status.'"');
            if (!empty($model->sStreet)) $criteria->addCondition('sStreet = "'.$model->sStreet.'"');
            if (!empty($model->sWardNo)) $criteria->addCondition('sWardNo = "'.$model->sWardNo.'"');
            if (!empty($model->sCity)) $criteria->addCondition('sCity = "'.$model->sCity.'"');
            if (!empty($model->sDistrict)) $criteria->addCondition('sDistrict = "'.$model->sDistrict.'"');
            if (!empty($model->sZone)) $criteria->addCondition('sZone = "'.$model->sZone.'"');
            if (!empty($model->pStreet)) $criteria->addCondition('pStreet = "'.$model->pStreet.'"');
            if (!empty($model->pWardNo)) $criteria->addCondition('pWardNo = "'.$model->pWardNo.'"');
            if (!empty($model->pCity)) $criteria->addCondition('pCity = "'.$model->pCity.'"');
            if (!empty($model->pDistrict)) $criteria->addCondition('pDistrict = "'.$model->pDistrict.'"');
            if (!empty($model->pZone)) $criteria->addCondition('pZone = "'.$model->pZone.'"');
            if (!empty($model->country)) $criteria->addCondition('country = "'.$model->country.'"');
            if (!empty($model->motherName)) $criteria->addCondition('motherName = "'.$model->motherName.'"');
            if (!empty($model->guardianName)) $criteria->addCondition('guardianName = "'.$model->guardianName.'"');
            if (!empty($model->relation)) $criteria->addCondition('relation = "'.$model->relation.'"');
            if (!empty($model->eContact)) $criteria->addCondition('eContact = "'.$model->eContact.'"');
            if (!empty($model->ePhone)) $criteria->addCondition('ePhone = "'.$model->ePhone.'"');
            if (!empty($model->homePhone)) $criteria->addCondition('homePhone = "'.$model->homePhone.'"');
            if (!empty($model->workPhone)) $criteria->addCondition('workPhone = "'.$model->workPhone.'"');
            if (!empty($model->mobilePhone)) $criteria->addCondition('mobilePhone = "'.$model->mobilePhone.'"');
            if (!empty($model->email)) $criteria->addCondition('email = "'.$model->email.'"');
            if (!empty($model->stat)) $criteria->addCondition('stat = "'.$model->stat.'"');
            if (!empty($model->dID)) $criteria->addCondition('dID = "'.$model->dID.'"');
            if (!empty($model->clerk)) $criteria->addCondition('clerk = "'.$model->clerk.'"');
            if (!empty($model->date)) $criteria->addCondition('date = "'.$model->date.'"');
            if (!empty($model->time)) $criteria->addCondition('time = "'.$model->time.'"');
            if (!empty($model->card_id)) $criteria->addCondition('card_id = "'.$model->card_id.'"');
        }
        $session['Patient_records']=Patient::model()->findAll($criteria);

        $this->render('index',array(
            'model'=>$model,
        ));
    }
}