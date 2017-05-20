<?php

    class LabOrderController extends RController
    {
        public $breadcrumbs;
        public $menu;
        /**
         * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
         * using two-column layout. See 'protected/views/layouts/column2.php'.
         */
        public $layout = 'main';

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
            $this->render('view', array(
                'model' => $this->loadModel($id),
            ));
        }

        public function actionAutoComplete()
        {
            $res = array();
            if (isset($_GET['term']))
            {
                $qry = "SELECT * from icd10 WHERE icd10details LIKE :icd10details";
//                $qry .= 'ORDER BY icd10no ASC';
                $data = Yii::app()->db->createCommand($qry);
                $qterm = $_GET['term'].'%';
                $data->bindValue(":icd10details", $qterm, PDO::PARAM_STR);
                $res = $data->queryAll();
            }
            echo CJSON::encode($res);
            Yii::app()->end();
        }

        /**
         * Creates a new model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         */
        public function actionCreate()
        {
            $model = new LabOrder;
            $model1 = new Assessment;

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if (isset($_POST['LabOrder'])) {
                $model->attributes = $_POST['LabOrder'];
                if ($model->save())
                    $this->redirect(array('view', 'id' => $model->loid));
            }

            if (isset($_POST['Assessment']))
            {
                $model1->attributes = $_POST['Assessment'];
                if($model1->save())
                {
                    Yii::app()->user->setFlash;
                    $msg = 'Successfully Saved';
                }
                    $this->redirect(array('view', 'id' => $model->loid));
            }

            $this->render('create', array(
                'model' => $model,
                'model1' => $model1,
            ));
        }

        //lab order

        public function actionLaborderr()
        {
            $model = new LabOrder();
            $model1 = new Assessment;

            $session = Yii::app()->session;
            $pid     = $session['PCID'];

            $current_user = Yii::app()->user->id;
           // var_dump($pid); exit();
            Yii::app()->session['userView'.$current_user.'returnURL']=Yii::app()->request->Url;

            if(isset($_POST['Assessment']))
            {
                $model1->attributes = $_POST['Assessment'];
                if($model1->save())
                {
                    $user = Yii::app()->getComponent('user');
                    $user->setFlash('success','<strong>ICD-10 Code successfully Submitted</strong>');
                }
            }

            $data = $model->mlaborder();
            $this->render('manylaborder', array(
                'model'=>$model,
                'model1'=>$model1,
                'data' => $data,
               'pid' =>  $pid));
//        }
        }

        //to save multiple lab
        public function actionSavelab()
        {
            $session = Yii::app()->session;
            $sid = $session['sid'];
            $cnt = $_POST['cntt'];
            $pid = $_POST['ppid'];


            $rpt = 0;
            $tim = 0;
            $ram = array();
            $eid = Yii::app()->user->id;
            for ($i = 1; $i <= $cnt; $i++) {
                if (isset($_POST["$i"])) {
                    $tim++;
                    array_push($ram, array('typee' => $_POST["$i"]));
                }

            }
            foreach ($ram as $da) {
                $p     = $da['typee'];
                $dat   = date("Y-m-d");
                $model = new LabOrder();
                $res   = $model->slaborder("insert into lab_order(lid,sid,pid,eid,datetime,status) values($p,$sid,$pid,$eid,'$dat',1)");
                //$res=sqlStatement("insert into lab_order(lid,pid,eid,datetime) values($p,$pid,$eid,'$dat')");
                if ($res > 0) {
                    $rpt++;
                    $this->redirect(array('/Plan/create'));
                }
            }
        }

        /**
         * Updates a particular model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id the ID of the model to be updated
         */
        public function actionUpdate($id)
        {
            $model = $this->loadModel($id);

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if (isset($_POST['LabOrder'])) {
                $model->attributes = $_POST['LabOrder'];
                if ($model->save())
                    $this->redirect(array('view', 'id' => $model->loid));
            }

            $this->render('update', array(
                'model' => $model,
            ));
        }

        /**
         * Deletes a particular model.
         * If deletion is successful, the browser will be redirected to the 'admin' page.
         * @param integer $id the ID of the model to be deleted
         */
        public function actionDelete($id)
        {
            if (Yii::app()->request->isPostRequest) {
                // we only allow deletion via POST request
                $this->loadModel($id)->delete();

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            } else
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }

        /**
         * Lists all models.
         */
        public function actionIndex()
        {
            $session = new CHttpSession;
            $session->open();
            $criteria = new CDbCriteria();

            $model = new LabOrder('search');
            $model->unsetAttributes(); // clear any default values

            if (isset($_GET['LabOrder'])) {
                $model->attributes = $_GET['LabOrder'];


                if (!empty($model->loid)) $criteria->addCondition('loid = "' . $model->loid . '"');


                if (!empty($model->lid)) $criteria->addCondition('lid = "' . $model->lid . '"');


                if (!empty($model->pid)) $criteria->addCondition('pid = "' . $model->pid . '"');


                if (!empty($model->eid)) $criteria->addCondition('eid = "' . $model->eid . '"');


                if (!empty($model->datetime)) $criteria->addCondition('datetime = "' . $model->datetime . '"');


                if (!empty($model->status)) $criteria->addCondition('status = "' . $model->status . '"');


                if (!empty($model->billstatus)) $criteria->addCondition('billstatus = "' . $model->billstatus . '"');


            }
            $session['LabOrder_records'] = LabOrder::model()->findAll($criteria);


            $this->render('index', array(
                'model' => $model,
            ));

        }

        /**
         * Manages all models.
         */
        public function actionAdmin()
        {
            $model = new LabOrder('search');
            $model->unsetAttributes(); // clear any default values
            if (isset($_GET['LabOrder']))
                $model->attributes = $_GET['LabOrder'];

            $this->render('admin', array(
                'model' => $model,
            ));
        }

        /**
         * Returns the data model based on the primary key given in the GET variable.
         * If the data model is not found, an HTTP exception will be raised.
         * @param integer the ID of the model to be loaded
         */
        public function loadModel($id)
        {
            $model = LabOrder::model()->findByPk($id);
            if ($model === NULL)
                throw new CHttpException(404, 'The requested page does not exist.');
            return $model;
        }

        /**
         * Performs the AJAX validation.
         * @param CModel the model to be validated
         */
        protected function performAjaxValidation($model)
        {
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'lab-order-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
        }

        public function actionGenerateExcel()
        {
            $session = new CHttpSession;
            $session->open();

            if (isset($session['LabOrder_records'])) {
                $model = $session['LabOrder_records'];
            } else
                $model = LabOrder::model()->findAll();


            Yii::app()->request->sendFile(date('YmdHis') . '.xls',
                $this->renderPartial('excelReport', array(
                    'model' => $model
                ), true)
            );
        }

        public function actionGeneratePdf()
        {
            $session = new CHttpSession;
            $session->open();
            Yii::import('application.modules.admin.extensions.giiplus.bootstrap.*');
            require_once('tcpdf/tcpdf.php');
            require_once('tcpdf/config/lang/eng.php');

            if (isset($session['LabOrder_records'])) {
                $model = $session['LabOrder_records'];
            } else
                $model = LabOrder::model()->findAll();


            $html = $this->renderPartial('expenseGridtoReport', array(
                'model' => $model
            ), true);

            //die($html);

            $pdf = new TCPDF();
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor(Yii::app()->name);
            $pdf->SetTitle('LabOrder Report');
            $pdf->SetSubject('LabOrder Report');
            //$pdf->SetKeywords('example, text, report');
            $pdf->SetHeaderData('', 0, "Report", '');
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Example Report by " . Yii::app()->name, "");
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
            $pdf->Output("LabOrder_002.pdf", "I");
        }
    }
