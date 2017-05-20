<?php

class UserController extends RController
{
    public $breadcrumbs;
    public $menu;
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='main';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'rights', // perform access control for CRUD operations
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($eid)
    {

        //$user=User::model()->findByAttributes(array('emp_id'=>$eid));
        //$uid=$user->id;


        $model=new User('create');
        $val = User::model()->findByAttributes(array('emp_id'=>$eid));


        if($val == null)
        {
            if(isset($_POST['User']))
            {
                $model->attributes=$_POST['User'];
                if($model->save())
                {
                    if($model->profession == 'doctor')
                    {
                        $user = Yii::app()->getComponent('user');
                        $user->setFlash(
                            'success',
                            "<strong>User Has Been Successfully Assigned Role !</strong><br> Now Set Examination Charge For The Doctor."
                        );

                        $val = User::model()->findByAttributes(array('emp_id'=>$eid));
                        $uid=$val->id;


                        $qry = "CREATE TABLE ".$uid."_calendar (
                              Id int(11) NOT NULL AUTO_INCREMENT,
                              Subject varchar(1000) DEFAULT NULL,
                              Location varchar(200) DEFAULT NULL,
                              Description varchar(255) DEFAULT NULL,
                              StartTime datetime DEFAULT NULL,
                              EndTime datetime DEFAULT NULL,
                              IsAllDayEvent smallint(6) NOT NULL,
                              Color varchar(200) DEFAULT NULL,
                              RecurringRule varchar(500) DEFAULT NULL,
                              stat int(11) DEFAULT NULL,
                              PRIMARY KEY (Id)
                            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8";
                        Yii::app()->db->createCommand($qry)->execute();
                        $this->redirect(array('/DoctorCharge/create1','eid'=>$model->emp_id));;
                    }
                    else
                    {
                        $user = Yii::app()->getComponent('user');
                        $user->setFlash(
                            'success',
                            "<strong>User Has Been Successfully Assigned Roles</strong>"
                        );
                        /*$qry = "CREATE TABLE ".$eid."_calendar (
                              Id int(11) NOT NULL AUTO_INCREMENT,
                              Subject varchar(1000) DEFAULT NULL,
                              Location varchar(200) DEFAULT NULL,
                              Description varchar(255) DEFAULT NULL,
                              StartTime datetime DEFAULT NULL,
                              EndTime datetime DEFAULT NULL,
                              IsAllDayEvent smallint(6) NOT NULL,
                              Color varchar(200) DEFAULT NULL,
                              RecurringRule varchar(500) DEFAULT NULL,
                              PRIMARY KEY (Id)
                            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8";
                        Yii::app()->db->createCommand($qry)->execute();*/
                        $this->redirect(array('/Employee/index'));
                    }
                }
            }

            $this->render('create',array(
                'model'=>$model,
                'eid'=>$eid,
            ));
        }

        else
        {
            $user = Yii::app()->getComponent('user');
            $user->setFlash(
                'info',
                "<strong>User Has Been Already Assigned Roles</strong>"
            );
            $this->redirect(array('/Employee/index'));
        }
    }

    /*public function actionCreate1($eid)
    {
        $model=new User;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['User']))
        {
            $model->attributes=$_POST['User'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $this->render('create',array(
            'model'=>$model,
            'eid'=>$eid,
        ));
    }*/

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['User']))
        {
            $model->attributes=$_POST['User'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $session=new CHttpSession;
        $session->open();
        $criteria = new CDbCriteria();

        $model=new User('search');
        $model->unsetAttributes();  // clear any default values

        if(isset($_GET['User']))
        {
            $model->attributes=$_GET['User'];



            if (!empty($model->id)) $criteria->addCondition('id = "'.$model->id.'"');


            if (!empty($model->emp_id)) $criteria->addCondition('emp_id = "'.$model->emp_id.'"');


            if (!empty($model->uName)) $criteria->addCondition('uName = "'.$model->uName.'"');


            if (!empty($model->uPass)) $criteria->addCondition('uPass = "'.$model->uPass.'"');


            if (!empty($model->sQuestion)) $criteria->addCondition('sQuestion = "'.$model->sQuestion.'"');


            if (!empty($model->sAnswer)) $criteria->addCondition('sAnswer = "'.$model->sAnswer.'"');


            if (!empty($model->role)) $criteria->addCondition('role = "'.$model->role.'"');


            if (!empty($model->stat)) $criteria->addCondition('stat = "'.$model->stat.'"');


        }
        $session['User_records']=User::model()->findAll($criteria);


        $this->render('index',array(
            'model'=>$model,
        ));

    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new User('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['User']))
            $model->attributes=$_GET['User'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model=User::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    public function actionGenerateExcel()
    {
        $session=new CHttpSession;
        $session->open();

        if(isset($session['User_records']))
        {
            $model=$session['User_records'];
        }
        else
            $model = User::model()->findAll();


        Yii::app()->request->sendFile(date('YmdHis').'.xls',
            $this->renderPartial('excelReport', array(
                'model'=>$model
            ), true)
        );
    }
    public function actionGeneratePdf()
    {
        $session=new CHttpSession;
        $session->open();
        Yii::import('application.modules.admin.extensions.giiplus.bootstrap.*');
        require_once('tcpdf/tcpdf.php');
        require_once('tcpdf/config/lang/eng.php');

        if(isset($session['User_records']))
        {
            $model=$session['User_records'];
        }
        else
            $model = User::model()->findAll();



        $html = $this->renderPartial('expenseGridtoReport', array(
            'model'=>$model
        ), true);

        //die($html);

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(Yii::app()->name);
        $pdf->SetTitle('User Report');
        $pdf->SetSubject('User Report');
        //$pdf->SetKeywords('example, text, report');
        $pdf->SetHeaderData('', 0, "Report", '');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Example Report by ".Yii::app()->name, "");
        $pdf->setHeaderFont(Array('helvetica', '', 8));
        $pdf->setFooterFont(Array('helvetica', '', 6));
        $pdf->SetMargins(15, 18, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 0);
        $pdf->SetFont('dejavusans', '', 7);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->LastPage();
        $pdf->Output("User_002.pdf", "I");
    }
}
